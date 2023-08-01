<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ public_path('css/app.css') }}" rel="stylesheet">
</head>

<style>
    @page { margin: 37px; }
    body { margin: 37px; }
</style>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-3" style="text-align:center;">Laporan</h2>
        <div class="col-2">            
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('theme/dist/img/pln.png'))) }}" height="100" width="80">
            <h3>Laporan</h3>
        </div>
        <div class="col-12">
            <hr>
        </div>
        <!-- <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-primary" href="{{ URL::to('#') }}">Export to PDF</a>
        </div> -->
        <table border='1' class="table table-bordered mb-5" style="width:100%;font-size:10px;">
            <thead style="border:1px solid black;width:100%;">
                <tr class="table-danger" align="center" style="text-align:center;">
                    <th>No</th>
                    <th>Status Laporan</th>
                    <th>Alasan Penolakan</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Gardu Induk</th>
                    <th>Bay</th>
                    <th>Rel</th>
                    <th>Pengawas Pekerjaan</th>
                    <th>Pelaksana Uji</th>
                </tr>
            </thead>
            <tbody style="border:1px solid black;width:100%;text-align:center;">
                @php $i=1 @endphp
				@foreach($laporan as $row)
                @php
                    $status_laporan = "Unknown";
                    if($row->id_status_pekerjaan == '1' && $row->status == '0'){ //belum dikirim admin
                        $status_laporan = 'Belum Dikirim Oleh Admin';   
                    }elseif($row->id_status_pekerjaan == '2' && $row->status == '0'){
                        $status_laporan = 'Sudah Dikirim Oleh Admin';
                    }elseif($row->id_status_pekerjaan == '2' && $row->status == '1'){
                        $status_laporan = 'Ditolak Oleh Supervisor';
                    }elseif($row->id_status_pekerjaan == '3' && $row->status == '0'){
                        $status_laporan = 'Sudah Disetujui Oleh Supervisor';
                    }elseif($row->id_status_pekerjaan == '3' && $row->status == '1'){
                        $status_laporan = 'Ditolak Oleh Manager';
                    }elseif($row->id_status_pekerjaan == '4' && $row->status == '0'){
                        $status_laporan = 'Sudah Disetujui Oleh Manager';
                    }
                @endphp
				<tr>
					<td>{{ $i++ }}</td>
                    <td>{{$status_laporan}}</td>
                    <td>{{$row->alasan_ditolak}}</td>
                    <td>{{$row->tgl_pelaksanaan }}</td>
                    <td>{{$row->nama_gardu}}</td>
                    <td>{{$row['nama_bay']}}</td>
                    <td>{{$row['rel']}}</td>
                    <td>{{$row->pengawas_pekerjaan}}</td>
                    <td>{{$row->pelaksana_uji}}</td>
				</tr>
				@endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ public_path('js/app.js') }}" type="text/js"></script>
</body>
</html>