<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'teachers' => User::where('role', 'teacher')->count(),
            'parents' => User::where('role', 'parent')->count(),
            'classes' => SchoolClass::count(),
            'subjects' => Subject::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
