<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Attendance Report - {{ $month }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .meta {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Monthly Attendance Report</h2>
        <p>Month: {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
    </div>

    <div class="meta">
        <strong>Class:</strong> {{ $class->name }} <br>
        <strong>Section:</strong> {{ $section->name }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Roll No</th>
                <th>Student Name</th>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Late</th>
                <th class="text-center">Half Day</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
                <tr>
                    <td>{{ $data['student']->roll_no ?? '-' }}</td>
                    <td>{{ $data['student']->user->name }}</td>
                    <td class="text-center">{{ $data['present'] }}</td>
                    <td class="text-center">{{ $data['absent'] }}</td>
                    <td class="text-center">{{ $data['late'] }}</td>
                    <td class="text-center">{{ $data['half_day'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>