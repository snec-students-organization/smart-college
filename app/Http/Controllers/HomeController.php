<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Timetable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $dayToday = date('l');
        
        // Fetch all sections with their classes, class teacher, and today's periods
        $sections = Section::with([
            'school_class',
            'class_teacher.user',
            'timetables' => function($query) use ($dayToday) {
                $query->where('day', $dayToday)
                      ->with(['subject', 'teacher.user'])
                      ->orderBy('period_number');
            }
        ])->get();

        return view('welcome', compact('sections', 'dayToday'));
    }
}
