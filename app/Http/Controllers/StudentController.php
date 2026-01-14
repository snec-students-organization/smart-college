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

        return view('student.dashboard', compact('student', 'attendancePercentage', 'pendingBooks', 'recentMarks'));
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
}
