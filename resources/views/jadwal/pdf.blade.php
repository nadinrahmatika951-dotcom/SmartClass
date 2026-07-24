<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jadwal Kuliah</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #B24B4B;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #B24B4B;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #B24B4B;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SmartClass - Jadwal Perkuliahan</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
        @if(Auth::user()->role === 'mahasiswa')
            <p>Mahasiswa: {{ Auth::user()->name }} ({{ Auth::user()->nim }})</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Ruangan</th>
                <th>Dosen</th>
                @if(Auth::user()->role === 'admin')
                    <th>Mahasiswa</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $index => $jadwal)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $jadwal->mata_kuliah }}</td>
                    <td>{{ $jadwal->hari }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
                    <td>{{ $jadwal->ruangan }}</td>
                    <td>{{ $jadwal->dosen }}</td>
                    @if(Auth::user()->role === 'admin')
                        <td>{{ $jadwal->user->name }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>