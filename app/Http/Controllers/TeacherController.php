<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Subject;

class TeacherController extends Controller
{
    public function dashboard()
    {
        // For simplicity, we assume a teacher sees global stats or could be linked to specific classes.
        // In a real app, we'd filter by $user->teacher->classes
        
        $stats = [
            'students' => Student::count(),
            'classes' => SchoolClass::count(),
            'attendance_today' => Attendance::where('date', date('Y-m-d'))
                                    ->where('status', 'present')->count(),
            'subjects' => Subject::count(),
        ];

        return view('teacher.dashboard', compact('stats'));
    }

    public function attendanceIndex()
    {
        $classes = SchoolClass::with('sections')->get();
        return view('teacher.attendance.index', compact('classes'));
    }

    public function attendanceCreate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
        ]);

        $class = SchoolClass::findOrFail($request->class_id);
        $section = \App\Models\Section::findOrFail($request->section_id);
        $date = $request->date;

        $students = Student::where('class_id', $class->id)
                            ->where('section_id', $section->id)
                            ->get();

        // Check if attendance already exists
        $attendance = Attendance::where('class_id', $class->id)
                                ->where('section_id', $section->id)
                                ->where('date', $date)
                                ->get()
                                ->keyBy('student_id');

        return view('teacher.attendance.create', compact('class', 'section', 'date', 'students', 'attendance'));
    }

    public function attendanceStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,half_day',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId, 
                    'date' => $request->date
                ],
                [
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'status' => $status,
                    'remark' => $request->remarks[$studentId] ?? null,
                ]
            );
        }

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance marked successfully.');
    }

    public function marksIndex()
    {
        $classes = SchoolClass::with('sections')->get();
        return view('teacher.marks.index', compact('classes'));
    }

    public function marksCreate(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|string',
        ]);

        $class = SchoolClass::findOrFail($request->class_id);
        $section = \App\Models\Section::findOrFail($request->section_id);
        $subject = Subject::findOrFail($request->subject_id);
        $examType = $request->exam_type;

        $students = Student::where('class_id', $class->id)
                            ->where('section_id', $section->id)
                            ->get();

        $marks = \App\Models\Mark::where('subject_id', $subject->id)
                                ->where('exam_type', $examType)
                                ->whereIn('student_id', $students->pluck('id'))
                                ->get()
                                ->keyBy('student_id');

        return view('teacher.marks.create', compact('class', 'section', 'subject', 'examType', 'students', 'marks'));
    }

    public function marksStore(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|string',
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:100', // Assuming 100 is max
            'total_marks' => 'required|numeric|min:1',
        ]);

        foreach ($request->marks as $studentId => $obtained) {
            if ($obtained !== null) {
                \App\Models\Mark::updateOrCreate(
                    [
                        'student_id' => $studentId, 
                        'subject_id' => $request->subject_id,
                        'exam_type' => $request->exam_type,
                    ],
                    [
                        'marks_obtained' => $obtained,
                        'total_marks' => $request->total_marks,
                        'remarks' => $request->remarks[$studentId] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('teacher.marks.index')->with('success', 'Marks entered successfully.');
    }
    public function marksList(Request $request)
    {
        $classes = SchoolClass::with('sections')->get();
        
        $query = \App\Models\Mark::with(['student.user', 'subject', 'student.school_class', 'student.section']);

        if ($request->filled('class_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('class_id', $request->class_id);
            });
        }

        if ($request->filled('section_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('section_id', $request->section_id);
            });
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        $marks = $query->latest()->paginate(20);

        return view('teacher.marks.list', compact('marks', 'classes'));
    }
}
