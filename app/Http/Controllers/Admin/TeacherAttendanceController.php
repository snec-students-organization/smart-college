<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\TeacherAttendance;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');

        $teachers = Teacher::with([
            'user',
            'attendances' => function ($query) use ($date) {
                $query->where('date', $date);
            }
        ])->get();

        $isMarked = TeacherAttendance::where('date', $date)->exists();

        return view('admin.attendance.teachers', compact('teachers', 'date', 'isMarked'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,leave',
            'attendance.*.remark' => 'nullable|string',
        ]);

        $date = $request->date;

        foreach ($request->attendance as $teacherId => $data) {
            TeacherAttendance::updateOrCreate(
                ['teacher_id' => $teacherId, 'date' => $date],
                ['status' => $data['status'], 'remark' => $data['remark'] ?? null]
            );
        }

        return redirect()->route('admin.attendance.teachers.index', ['date' => $date])
            ->with('success', 'Teacher attendance updated successfully.');
    }

    public function report(Request $request)
    {
        $month = $request->month ?? date('Y-m');
        $data = $this->getReportData($month);

        return view('admin.attendance.teachers_report', [
            'reportData' => $data['reportData'],
            'dates' => $data['dates'],
            'month' => $month
        ]);
    }

    public function exportExcel(Request $request)
    {
        $request->validate(['month' => 'required|date_format:Y-m']);

        $month = $request->month;
        $data = $this->getReportData($month);
        $monthName = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
        $fileName = 'teacher_attendance_report_' . $month . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($data, $monthName) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Teacher Monthly Attendance Report']);
            fputcsv($file, ['Month', $monthName]);
            fputcsv($file, []);

            // Header Row
            $dateHeaders = array_map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d');
            }, $data['dates']);

            $csvHeaders = array_merge(['Teacher Name'], $dateHeaders, ['Present', 'Absent', 'Late', 'Leave']);
            fputcsv($file, $csvHeaders);

            foreach ($data['reportData'] as $row) {
                $statusColumns = [];
                foreach ($data['dates'] as $date) {
                    $statusColumns[] = $row['attendance_by_date'][$date];
                }

                $csvRow = array_merge(
                    [$row['teacher']->user->name],
                    $statusColumns,
                    [
                        $row['present'],
                        $row['absent'],
                        $row['late'],
                        $row['leave']
                    ]
                );
                fputcsv($file, $csvRow);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $request->validate(['month' => 'required|date_format:Y-m']);

        $month = $request->month;
        $data = $this->getReportData($month);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.attendance.teachers_report_pdf', [
            'reportData' => $data['reportData'],
            'dates' => $data['dates'],
            'month' => $month
        ])->setPaper('a4', 'landscape');

        return $pdf->download('teacher_attendance_report_' . $month . '.pdf');
    }

    private function getReportData($month)
    {
        [$year, $monthNum] = explode('-', $month);
        $daysInMonth = \Carbon\Carbon::parse($month)->daysInMonth;

        $dates = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dates[] = sprintf('%s-%02d-%02d', $year, $monthNum, $i);
        }

        $teachers = Teacher::with('user')->get();

        $attendances = TeacherAttendance::whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->get()
            ->groupBy('teacher_id');

        $reportData = $teachers->map(function ($teacher) use ($attendances, $dates) {
            $records = $attendances->get($teacher->id, collect());

            $attendanceByDate = [];
            foreach ($dates as $date) {
                $record = $records->first(function ($item) use ($date) {
                    return \Carbon\Carbon::parse($item->date)->format('Y-m-d') === $date;
                });

                $status = $record ? $record->status : '-';
                $shortStatus = match ($status) {
                    'present' => 'P',
                    'absent' => 'A',
                    'late' => 'L',
                    'leave' => 'Le',
                    default => '-',
                };
                $attendanceByDate[$date] = $shortStatus;
            }

            return [
                'teacher' => $teacher,
                'attendance_by_date' => $attendanceByDate,
                'present' => $records->where('status', 'present')->count(),
                'absent' => $records->where('status', 'absent')->count(),
                'late' => $records->where('status', 'late')->count(),
                'leave' => $records->where('status', 'leave')->count(),
            ];
        });

        return [
            'dates' => $dates,
            'reportData' => $reportData
        ];
    }
}
