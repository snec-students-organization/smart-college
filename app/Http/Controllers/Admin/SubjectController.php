<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('school_class')->paginate(10);
        $classes = \App\Models\SchoolClass::all();
        return view('admin.academic.subjects', compact('subjects', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:subjects,code',
            'type' => 'required|in:theory,practical',
            'class_id' => 'required|exists:classes,id',
        ]);

        Subject::create($request->all());

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }
}
