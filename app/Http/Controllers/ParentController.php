<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\BookIssue;

class ParentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $parent = $user->parent;

        if (!$parent) {
            return view('parent.dashboard', ['error' => 'Parent profile not found.']);
        }

        $children = $parent->students()->with(['school_class', 'section'])->get();

        if ($children->isEmpty()) {
            return view('parent.dashboard', ['error' => 'No student profiles linked to your account.']);
        }

        // Determine which child to show (default to first or selected via query param)
        $selectedChildId = $request->query('child_id');
        $student = $selectedChildId 
                    ? $children->firstWhere('id', $selectedChildId) 
                    : $children->first();
        
        if (!$student) {
             $student = $children->first();
        }

        // Stats for the selected child
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
        
        // Attendance History (Last 5)
        $recentAttendance = Attendance::where('student_id', $student->id)
                                      ->latest('date')
                                      ->take(5)
                                      ->get();

        return view('parent.dashboard', compact('children', 'student', 'attendancePercentage', 'pendingBooks', 'recentMarks', 'recentAttendance'));
    }
}
