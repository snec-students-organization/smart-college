<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TeacherNotification;
use App\Models\Section;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeController extends Controller
{
    // Fee Structure Management
    public function index()
    {
        $fees = Fee::with('school_class')->orderBy('due_date', 'desc')->paginate(20);
        $classes = SchoolClass::all();
        return view('admin.fees.index', compact('fees', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $fee = Fee::create($request->all());

        // Notify Class Mentors (Teachers of sections in this class)
        $sections = Section::where('class_id', $request->class_id)->whereNotNull('class_teacher_id')->get();

        foreach ($sections as $section) {
            TeacherNotification::create([
                'teacher_id' => $section->class_teacher_id,
                'type' => 'fee_created',
                'message' => "New Fee Notification: {$fee->type} of amount {$fee->amount} has been created for Class {$section->school_class->name}.",
                'data' => [
                    'fee_id' => $fee->id,
                    'section_id' => $section->id,
                    'class_id' => $fee->class_id
                ],
            ]);
        }

        return redirect()->back()->with('success', 'Fee structure added successfully.');
    }

    public function status(Fee $fee)
    {
        $fee->load('school_class.sections');

        $students = Student::where('class_id', $fee->class_id)
            ->with(['section', 'user'])
            ->get()
            ->sortBy(function ($student) {
                return $student->section->name . '-' . $student->roll_no;
            });

        // Get paid student IDs for this fee
        $paidStudentIds = FeePayment::where('fee_id', $fee->id)
            ->where('status', 'paid')
            ->pluck('student_id')
            ->toArray();

        return view('admin.fees.status', compact('fee', 'students', 'paidStudentIds'));
    }

    public function destroy(Fee $fee)
    {
        // Delete associated notifications for mentors
        TeacherNotification::where('type', 'fee_created')
            ->where('data->fee_id', $fee->id)
            ->delete();

        $fee->delete();
        return redirect()->back()->with('success', 'Fee structure deleted successfully.');
    }

    // Fee Collection
    public function collectionIndex(Request $request)
    {
        $classes = SchoolClass::with('sections')->get();
        return view('admin.fees.collect_search', compact('classes'));
    }

    // Show fees for a specific student
    public function collectShow(Request $request)
    {
        $request->validate([
            'admin_student_id' => 'required|exists:students,id', // 'admin_student_id' to differentiate from generic 'student_id' if needed
        ]);

        $student = Student::with(['school_class', 'section', 'user'])->findOrFail($request->admin_student_id);

        // Get fees applicable to this student's class
        $fees = Fee::where('class_id', $student->class_id)->get();

        // Get existing payments
        $payments = FeePayment::where('student_id', $student->id)->get()->keyBy('fee_id');

        return view('admin.fees.collect_payment', compact('student', 'fees', 'payments'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_id' => 'required|exists:fees,id',
            'amount_paid' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        FeePayment::create([
            'student_id' => $request->student_id,
            'fee_id' => $request->fee_id,
            'amount_paid' => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'status' => 'paid',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }
    public function exportExcel(Fee $fee)
    {
        $fileName = 'fee_status_' . $fee->id . '.csv';
        $students = Student::where('class_id', $fee->class_id)
            ->with(['section', 'user'])
            ->get()
            ->sortBy(function ($student) {
                return $student->section->name . '-' . $student->roll_no;
            });

        $paidStudentIds = FeePayment::where('fee_id', $fee->id)
            ->where('status', 'paid')
            ->pluck('student_id')
            ->toArray();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($students, $paidStudentIds, $fee) {
            $file = fopen('php://output', 'w');

            // Fee Details Header
            fputcsv($file, ['Fee Details']);
            fputcsv($file, ['Class', $fee->school_class->name]);
            fputcsv($file, ['Type', $fee->type]);
            fputcsv($file, ['Amount', $fee->amount]);
            fputcsv($file, ['Due Date', $fee->due_date->format('Y-m-d')]);
            fputcsv($file, []); // Empty line

            // Columns
            fputcsv($file, ['Roll No', 'Name', 'Section', 'Parent Phone', 'Status']);

            foreach ($students as $student) {
                $status = in_array($student->id, $paidStudentIds) ? 'Paid' : 'Unpaid';
                fputcsv($file, [
                    $student->roll_no,
                    $student->user->name,
                    $student->section->name,
                    $student->phone,
                    $status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Fee $fee)
    {
        $students = Student::where('class_id', $fee->class_id)
            ->with(['section', 'user'])
            ->get()
            ->sortBy(function ($student) {
                return $student->section->name . '-' . $student->roll_no;
            });

        $paidStudentIds = FeePayment::where('fee_id', $fee->id)
            ->where('status', 'paid')
            ->pluck('student_id')
            ->toArray();

        $pdf = Pdf::loadView('admin.fees.pdf_status', compact('fee', 'students', 'paidStudentIds'));
        return $pdf->download('fee_status_' . $fee->id . '.pdf');
    }
}
