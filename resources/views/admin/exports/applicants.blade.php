<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants</title>
    <style>
        body {
            font-size: 15px; /* Reduce the font size for the entire document */
        }
    
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px; /* Reduce font size for table content */
        }
    
        table,
        th,
        td {
            border: 1px solid black;
        }
    
        th,
        td {
            padding: 4px 6px; /* Adjust padding to create more space */
            text-align: left;
        }
    
        /* Ensure tables break properly */
        table {
            page-break-inside: auto;
        }
    
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    
        thead {
            display: table-header-group;
        }
    
        tfoot {
            display: table-footer-group;
        }
    
        /* Optional: Adjust the page size for smaller pages */
        @page {
            size: A4;
            margin: 10mm; /* Reduce page margins */
        }
    </style>
    

</head>

<body>
    <h1>Applicant List</h1>
    <table>
        <thead>
            <tr>
                <th>S.N:</th>
                <th>Name</th>
                <th>Reg No.</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Exam Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if (count($students) > 0)
                @foreach ($students as $key => $student)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->slug }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->exam_date->exam_date }}</td>
                        <td>{{ $student->status?'Approved':'Pending' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
