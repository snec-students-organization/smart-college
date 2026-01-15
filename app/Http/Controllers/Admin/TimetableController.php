<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::with('sections')->get();
        $sections = [];
        $timetables = [];
        $selected_section = null;

        if ($request->filled('section_id')) {
            $selected_section = Section::with(['school_class', 'class_teacher.user'])->findOrFail($request->section_id);
            $timetables = Timetable::with(['subject', 'teacher.user'])
                ->where('section_id', $request->section_id)
                ->orderBy('day')
                ->orderBy('period_number')
                ->get()
                ->groupBy('day');
        }

        return view('admin.timetable.index', compact('classes', 'selected_section', 'timetables'));
    }

    public function create(Request $request)
    {
        $request->validate(['section_id' => 'required|exists:sections,id']);
        
        $section = Section::with('school_class')->findOrFail($request->section_id);
        $subjects = Subject::where('class_id', $section->class_id)->get();
        $teachers = Teacher::with('user')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('admin.timetable.create', compact('section', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string',
            'period_number' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        Timetable::create($validated);

        return redirect()->route('admin.timetable.index', ['section_id' => $request->section_id])
            ->with('success', 'Period added successfully.');
    }

    public function edit(Timetable $timetable)
    {
        $section = Section::with('school_class')->findOrFail($timetable->section_id);
        $subjects = Subject::where('class_id', $section->class_id)->get();
        $teachers = Teacher::with('user')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('admin.timetable.edit', compact('timetable', 'section', 'subjects', 'teachers', 'days'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string',
            'period_number' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $timetable->update($validated);

        return redirect()->route('admin.timetable.index', ['section_id' => $timetable->section_id])
            ->with('success', 'Period updated successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $section_id = $timetable->section_id;
        $timetable->delete();

        return redirect()->route('admin.timetable.index', ['section_id' => $section_id])
            ->with('success', 'Period deleted successfully.');
    }

    public function assignClassTeacher(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $section = Section::findOrFail($request->section_id);
        $section->update(['class_teacher_id' => $request->teacher_id]);

        return back()->with('success', 'Class teacher assigned successfully.');
    }
}
