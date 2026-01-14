<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('sections')->get();
        return view('admin.academic.classes', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:classes,name',
        ]);

        SchoolClass::create($request->all());

        return redirect()->back()->with('success', 'Class created successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->back()->with('success', 'Class deleted successfully.');
    }

    public function storeSection(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $class->sections()->create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Section added successfully.');
    }

    public function destroySection(Section $section)
    {
        $section->delete();
        return redirect()->back()->with('success', 'Section deleted successfully.');
    }

    public function getSections(SchoolClass $class)
    {
        return response()->json($class->sections);
    }

    public function getSubjects(SchoolClass $class)
    {
        return response()->json($class->subjects);
    }
}
