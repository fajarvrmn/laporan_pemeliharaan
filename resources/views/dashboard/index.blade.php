@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    <h3>Dashboard</h3>
    <div>
        <hr>
    </div>

    <div class="row">

        <div class="col-lg-4 col-6">

            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_data['total_peralatan'] }}</h3>
                    <p>Total Peralatan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $total_data['total_laporan'] }}</h3>
                    <p>Total Laporan</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-lg-4 col-6">

            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $total_data['total_berkas'] }}</h3>
                    <p>Total File</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
            </div>
        </div>

        <div class="col-12">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peralatan</th>
                        <th>NIP</th>
                        <th>Status Pekerjaan</th>
                        <th>Alasan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Gardu Induk</th>
                        <th>Busbar</th>
                        <th>Kapasitas</th>
                        <th>Pengujian Kontak</th>
                        <th>Pengujian Isolasi</th>
                        <th>Arus Motor Open</th>
                        <th>Arus Motor Close</th>
                        <th>Waktu Open</th>
                        <th>Waktu Close</th>
                        <th>Kondisi Visual</th>
                        <th>Dokumentasi</th>
                        <th>Pengawas</th>
                        <th>Keterangan</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/

            var table = $('.data-table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                bFilter: false,
                ajax: {
                    url: "{{ route('dashboard.index') }}",
                    data: function ( d ) {
                        // d.form_search = $('form#form_filter').serializeArray();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'serial_number', name: 'serial_number'},
                    {data: 'nip', name: 'nip'},
                    {data: 'status_text', name: 'status_text'},
                    {data: 'alasan_ditolak', name: 'alasan_ditolak'},
                    {data: 'tgl_pelaksanaan', name: 'tgl_pelaksanaan'},
                    {data: 'nama_gardu', name: 'nama_gardu'},
                    {data: 'busbar', name: 'busbar'},
                    {data: 'kapasitas', name: 'kapasitas'},
                    {data: 'hasil_pengujian_tahanan_kontak', name: 'hasil_pengujian_tahanan_kontak'},
                    {data: 'hasil_pengujian_tahanan_isolasi', name: 'hasil_pengujian_tahanan_isolasi'},
                    {data: 'arus_motor_open', name: 'arus_motor_open'},
                    {data: 'arus_motor_close', name: 'arus_motor_close'},
                    {data: 'waktu_open', name: 'waktu_open'},
                    {data: 'waktu_close', name: 'waktu_close'},
                    {data: 'kondisi_visual', name: 'kondisi_visual'},
                    {data: 'dokumentasi', name: 'dokumentasi'},
                    {data: 'pengawas_pekerjaan', name: 'pengawas_pekerjaan'},
                    {data: 'keterangan', name: 'keterangan'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            new $.fn.dataTable.FixedHeader( table );

        })

    </script>
@endsection