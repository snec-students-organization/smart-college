<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        Fee::create($request->all());

        return redirect()->back()->with('success', 'Fee structure added successfully.');
    }

    public function destroy(Fee $fee)
    {
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
}
