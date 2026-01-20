<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\BookIssue;
use App\Models\FeePayment;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('student.dashboard', ['error' => 'Student profile not found.']);
        }

        // Stats
        $attendanceDays = Attendance::where('student_id', $student->id)->count();
        $presentDays = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $attendancePercentage = $attendanceDays > 0 ? round(($presentDays / $attendanceDays) * 100, 1) : 0;

        $pendingBooks = BookIssue::where('student_id', $student->id)->whereNull('return_date')->count();

        // Recent Marks
        $recentMarks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();

        // Fetch Today's Timetable
        $dayToday = date('l');
        $timetable = \App\Models\Timetable::with(['subject', 'teacher.user'])
            ->where('section_id', $student->section_id)
            ->where('day', $dayToday)
            ->orderBy('period_number')
            ->get();

        // Book Recommendations
        $bookRecommendations = \App\Models\BookRecommendation::with(['book', 'teacher.user'])
            ->where(function ($q) use ($student) {
                $q->where('student_id', $student->id)
                    ->orWhere('section_id', $student->section_id);
            })
            ->latest()
            ->get();

        // Load class teacher
        $student->load(['school_class', 'section.class_teacher.user']);

        return view('student.dashboard', compact('student', 'attendancePercentage', 'pendingBooks', 'recentMarks', 'bookRecommendations', 'timetable'));
    }

    public function attendance()
    {
        $student = Auth::user()->student;
        $attendance = Attendance::where('student_id', $student->id)->orderBy('date', 'desc')->paginate(20);

        // Calculate stats
        $total = Attendance::where('student_id', $student->id)->count();
        $present = Attendance::where('student_id', $student->id)->where('status', 'present')->count();
        $percentage = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        return view('student.attendance', compact('attendance', 'percentage'));
    }

    public function marks()
    {
        $student = Auth::user()->student;
        // Group marks by Exam Type
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->get()
            ->groupBy('exam_type');

        return view('student.marks', compact('marks'));
    }

    public function fees()
    {
        // Placeholder for Fees
        return view('student.fees');
    }

    public function storeParent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
        ]);

        try {
            \DB::beginTransaction();

            // Create User account for Parent
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->phone),
                'role' => 'parent',
                'is_active' => true,
            ]);

            // Create Parent record
            $parent = \App\Models\ParentModel::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
            ]);

            // Link to Student
            $student = Auth::user()->student;
            $student->update(['parent_id' => $parent->id]);

            \DB::commit();

            return back()->with('success', 'Parent registered successfully! They can now log in with their email and phone number.');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Failed to register parent. ' . $e->getMessage());
        }
    }
}
