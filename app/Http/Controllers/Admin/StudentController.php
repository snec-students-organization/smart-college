<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'school_class', 'section'])
            ->latest()
            ->paginate(10);
            
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        // Sections can be loaded via AJAX or load all if manageable. 
        // For simplicity, let's pass all sections or user might rely on JS to filter.
        // Or if sections are strictly tied, we might just pass all for dynamic filtering.
        $sections = Section::all();
        
        return view('admin.students.create', compact('classes', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            
            // Student fields
            'class_id' => ['required', 'exists:classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'admission_no' => ['required', 'string', 'unique:students'],
            'dob' => ['required', 'date'],
        ]);

        try {
            DB::beginTransaction();

            // Auto-generate password from DOB (DDMMYYYY)
            // Use Carbon to ensuring formatting.
            $password = \Carbon\Carbon::parse($request->dob)->format('dmY');

            // Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password),
                'role' => 'student',
                'is_active' => true,
            ]);

            // Create Student Profile
            Student::create([
                'user_id' => $user->id,
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'admission_no' => $request->admission_no,
                'dob' => $request->dob,
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create student. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        $sections = Section::all();
        
        return view('admin.students.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            // User fields
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($student->user_id)],
            // Password only if provided
            'password' => ['nullable', 'confirmed', 'min:8'],
            
            // Student fields
            'class_id' => ['required', 'exists:classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'admission_no' => ['required', 'string', Rule::unique(Student::class)->ignore($student->id)],
            'dob' => ['required', 'date'],
        ]);

        try {
            DB::beginTransaction();

            // Update User
            $user = $student->user;
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // Update Student Profile
            $student->update([
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'admission_no' => $request->admission_no,
                'dob' => $request->dob,
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Student updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student update failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to update student.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            DB::beginTransaction();
            
            $user = $student->user;
            $student->delete();
            $user->delete(); // Or keep user and just deactivate? Usually full delete for test/simple apps.
            
            DB::commit();
            
            return redirect()->route('admin.students.index')
                ->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete student.');
        }
    }
}
