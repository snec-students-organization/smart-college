<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Teacher Attendance Report - {{ $month }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
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
        <h2>Teacher Monthly Attendance Report</h2>
        <p>Month: {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Teacher Name</th>
                @foreach($dates as $date)
                    <th class="text-center" style="font-size: 8px; width: 15px;">
                        {{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                @endforeach
                <th class="text-center">P</th>
                <th class="text-center">A</th>
                <th class="text-center">L</th>
                <th class="text-center">Le</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $data)
                <tr>
                    <td style="white-space: nowrap;">{{ $data['teacher']->user->name }}</td>
                    @foreach($dates as $date)
                        @php
                            $status = $data['attendance_by_date'][$date];
                            $color = match ($status) {
                                'P' => '#dcfce7', // green-100
                                'A' => '#fee2e2', // red-100
                                'L' => '#fef9c3', // yellow-100
                                'Le' => '#dbeafe', // blue-100
                                default => 'transparent'
                            };
                        @endphp
                        <td class="text-center" style="background-color: {{ $color }}; font-size: 8px;">{{ $status }}</td>
                    @endforeach
                    <td class="text-center">{{ $data['present'] }}</td>
                    <td class="text-center">{{ $data['absent'] }}</td>
                    <td class="text-center">{{ $data['late'] }}</td>
                    <td class="text-center">{{ $data['leave'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>