<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Attendance;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::all();
        $attendanceData = null;
        $summary = null;

        if ($request->has(['class_id', 'section_id', 'date'])) {
            $classId = $request->class_id;
            $sectionId = $request->section_id;
            $date = $request->date;

            // Fetch students in the class/section
            $students = Student::with('user')->where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->get();

            // Fetch attendance records for the date
            $attendanceRecords = Attendance::where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id');

            $attendanceData = $students->map(function ($student) use ($attendanceRecords) {
                $record = $attendanceRecords->get($student->id);
                return [
                    'student' => $student,
                    'status' => $record ? $record->status : 'not_marked',
                    'remark' => $record ? $record->remark : null,
                ];
            });

            // Calculate Summary
            $summary = [
                'total' => $students->count(),
                'present' => $attendanceRecords->where('status', 'present')->count(),
                'absent' => $attendanceRecords->where('status', 'absent')->count(),
                'late' => $attendanceRecords->where('status', 'late')->count(),
                'half_day' => $attendanceRecords->where('status', 'half_day')->count(),
                'not_marked' => $students->count() - $attendanceRecords->count(),
            ];
        }

        return view('admin.attendance.index', compact('classes', 'attendanceData', 'summary'));
    }

    public function report(Request $request)
    {
        $classes = SchoolClass::all();
        $reportData = null;
        $month = $request->month ?? date('Y-m');

        if ($request->has(['class_id', 'section_id', 'month'])) {
            $classId = $request->class_id;
            $sectionId = $request->section_id;
            $month = $request->month;

            [$year, $monthNum] = explode('-', $month);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNum, $year);

            // Fetch students
            $students = Student::with('user')->where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->get();

            // Fetch attendance for the month
            $attendances = Attendance::where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->whereYear('date', $year)
                ->whereMonth('date', $monthNum)
                ->get()
                ->groupBy('student_id');

            $reportData = $students->map(function ($student) use ($attendances, $daysInMonth) {
                $studentAttendance = $attendances->get($student->id, collect());

                $present = $studentAttendance->where('status', 'present')->count();
                $absent = $studentAttendance->where('status', 'absent')->count();
                $late = $studentAttendance->where('status', 'late')->count();
                $halfDay = $studentAttendance->where('status', 'half_day')->count();

                // Assuming Late counts as Present (or half? - sticking to basic count for now)
                // Assuming Half Day counts as 0.5? Let's just count them for now.
                // Simple Perentage: (Present + Late + HalfDay) / Total Working Days * 100 ??
                // For now, let's just calculate based on Total Records vs Present.
                // Or better: (Present + Late + 0.5 * HalfDay) / Total Days in Month (excluding weekends?)
                // Let's stick to simple Stats display for now.

                $totalAttended = $present + $late + ($halfDay * 0.5);
                // Total working days is technically not known without a holiday calendar. 
                // We will use the count of days attendance was taken for this class/section as the denominator if possible,
                // or just show the counts.

                // Let's try to find max attendance days taken for this class to get "Total Working Days" estimate
                // But specifically for this student, let's just return the counts.

                return [
                    'student' => $student,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'half_day' => $halfDay,
                ];
            });
        }

        return view('admin.attendance.report', compact('classes', 'reportData', 'month'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $reportData = $this->getReportData($request->class_id, $request->section_id, $request->month);
        $monthName = \Carbon\Carbon::createFromFormat('Y-m', $request->month)->format('F Y');
        $fileName = 'attendance_report_' . $request->month . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($reportData, $monthName) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['Monthly Attendance Report']);
            fputcsv($file, ['Month', $monthName]);
            fputcsv($file, []);

            // Columns
            fputcsv($file, ['Roll No', 'Student Name', 'Present', 'Absent', 'Late', 'Half Day']);

            foreach ($reportData as $data) {
                fputcsv($file, [
                    $data['student']->roll_no,
                    $data['student']->user->name,
                    $data['present'],
                    $data['absent'],
                    $data['late'],
                    $data['half_day']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $reportData = $this->getReportData($request->class_id, $request->section_id, $request->month);
        $month = $request->month;
        $class = SchoolClass::find($request->class_id);
        $section = Section::find($request->section_id);

        $pdf = Pdf::loadView('admin.attendance.report_pdf', compact('reportData', 'month', 'class', 'section'));
        return $pdf->download('attendance_report_' . $month . '.pdf');
    }

    private function getReportData($classId, $sectionId, $month)
    {
        [$year, $monthNum] = explode('-', $month);

        // Fetch students
        $students = Student::with('user')->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();

        // Fetch attendance for the month
        $attendances = Attendance::where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->get()
            ->groupBy('student_id');

        return $students->map(function ($student) use ($attendances) {
            $studentAttendance = $attendances->get($student->id, collect());

            return [
                'student' => $student,
                'present' => $studentAttendance->where('status', 'present')->count(),
                'absent' => $studentAttendance->where('status', 'absent')->count(),
                'late' => $studentAttendance->where('status', 'late')->count(),
                'half_day' => $studentAttendance->where('status', 'half_day')->count(),
            ];
        });
    }
}
