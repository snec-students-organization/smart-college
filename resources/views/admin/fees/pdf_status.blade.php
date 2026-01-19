<!DOCTYPE html>
<html>

<head>
    <title>Fee Status Report</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 20px;
        }

        .paid {
            color: green;
            font-weight: bold;
        }

        .unpaid {
            color: red;
            font-weight: bold;
        }

        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Fee Status Report</h2>
        <p><strong>Class:</strong> {{ $fee->school_class->name }}</p>
        <p><strong>Fee Type:</strong> {{ $fee->type }}</p>
        <p><strong>Amount:</strong> ${{ number_format($fee->amount, 2) }}</p>
        <p><strong>Due Date:</strong> {{ $fee->due_date->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Roll No</th>
                <th>Name</th>
                <th>Section</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $currentSection = null; @endphp
            @foreach($students as $student)
                @if($currentSection !== $student->section->name)
                    @php $currentSection = $student->section->name; @endphp
                    <tr>
                        <td colspan="4" class="section-header">Section: {{ $currentSection }}</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $student->roll_no ?? '-' }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->section->name }}</td>
                    <td class="{{ in_array($student->id, $paidStudentIds) ? 'paid' : 'unpaid' }}">
                        {{ in_array($student->id, $paidStudentIds) ? 'Paid' : 'Unpaid' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>