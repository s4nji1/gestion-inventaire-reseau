<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipment</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Issue Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->equipment->name }}</td>
                <td>{{ $record->maintenance_type }}</td>
                <td>{{ $record->start_date ? $record->start_date->format('Y-m-d') : 'N/A' }}</td>
                <td>{{ $record->end_date ? $record->end_date->format('Y-m-d') : 'N/A' }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ Str::limit($record->issue_description, 50) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} UM6P Network Inventory System</p>
    </div>
</body>
</html>