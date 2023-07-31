<!DOCTYPE html>
<html>

<head>
    <title>Internship Journals PDF</title>
</head>

<body>
    <h1>Internship Journals</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Activity</th>
                <th>Competency ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journals as $journal)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $journal->date }}</td>
                <td>{{ $journal->activity }}</td>
                <td>{{ $journal->competency->competency }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>Nama : {{ $journal->internship->student->name }}</p>

</body>

</html>
