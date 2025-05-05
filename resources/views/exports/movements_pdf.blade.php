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
                <th>Movement Type</th>
                <th>From Status</th>
                <th>To Status</th>
                <th>Date</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $movement)
            <tr>
                <td>{{ $movement->id }}</td>
                <td>{{ $movement->equipment->name }}</td>
                <td>{{ ucfirst($movement->type) }}</td>
                <td>{{ $movement->fromStatus ? $movement->fromStatus->name : 'Initial Entry' }}</td>
                <td>{{ $movement->toStatus->name }}</td>
                <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ Str::limit($movement->notes, 30) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} UM6P Network Inventory System</p>
    </div>
</body>
</html>