<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Civil Status</th>
                <th>Spouse</th>
                <th>Contact Person</th>
                <th>Source of Income</th>
                <th>Monthly Income</th>
                <th>Personal Properties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
                <tr>
                    <td>{{ Str::limit($application->name, 20, '...') }}</td>
                    <td>{{ Str::limit($application->date_of_birth, 20, '...') }}</td>
                    <td>{{ Str::limit($application->age, 20, '...') }}</td>
                    <td>{{ Str::limit($application->civil_status, 20, '...') }}</td>
                    <td>{{ Str::limit($application->spouse, 20, '...') }}</td>
                    <td>{{ Str::limit($application->contact_person, 20, '...') }}</td>
                    <td>{{ Str::limit($application->source_of_Income, 20, '...') }}</td>
                    <td>{{ Str::limit($application->monthly_income, 20, '...') }}</td>
                    <td>{{ Str::limit($application->personal_properties, 20, '...') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html> 