<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEHADIRAN GURU</h2>
        <p>Periode: {{ $month }} {{ $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Guru</th>
                <th>Hadir</th>
                <th>Telat</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $teacher)
            <tr>
                <td style="text-align: left;">{{ $teacher->name }}</td>
                <td>{{ $teacher->attendances->where('status', 'Hadir')->count() }}</td>
                <td>{{ $teacher->attendances->where('status', 'Terlambat')->count() }}</td>
                <td>{{ $teacher->attendances->where('status', 'Izin')->count() }}</td>
                <td>{{ $teacher->attendances->where('status', 'Sakit')->count() }}</td>
                <td>{{ $teacher->attendances->where('status', 'Alfa')->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>