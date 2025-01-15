<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <h2 class="title">Laporan Penilaian Siswa</h2>
    <p>Nama     : {{ $studentClassroom->student->user->name }}</p>
    <p>Kelas  : {{ $studentClassroom->classroom->name }} - {{ $studentClassroom->classroom->school->name }}</p>
    <p>Peminatan: {{ $studentClassroom->classroom->division->name }}</p>
    <br><br>
    <h3>Penilaian Sikap</h3>
    <table>
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assementFormAttitudes as $assessment)
                <tr>
                    <td>{{ $assessment->assessmentForm->indicator }}</td>
                    <td>{{ $assessment->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Penilaian Keterampilan</h3>
    <table>
        <thead>
            <tr>
                <th>Indikator</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assementFormSkills as $assessment)
                <tr>
                    <td>{{ $assessment->assessmentForm->indicator }}</td>
                    <td>{{ $assessment->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total penilaian: {{ $totalAssesment }}</h4>
</body>
</html>
