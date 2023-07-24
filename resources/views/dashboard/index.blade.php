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

        <div>
            <hr>
        </div>

        <form id="form_filter" class="col-12 row">
            <div class="col-10">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="search_dashboard" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-2">
                <button type="button" id="search" name="search" class="btn btn-primary" style="width:100%;">Search</button>
            </div>
        </form>

        <div class="col-12 table-responsive">
            <table class="table table-bordered">
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
                <tbody id="fetch_response">
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function(){

            $.ajax({
                url: "{{ route('dashboard.index') }}",
                data: {search: $('#search_dashboard').val()},
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    // console.log(data.data.data);
                    var i = 1;
                    $.each(data.data.data, function( index, value ) {
                        // alert( index + ": " + value );
                        // console.log(index, value);
                        $('#fetch_response').append('<tr>'+
                            '<td>'+i+'</td>'+
                            '<td>'+value.nama_bay+'</td>'+
                            '<td>'+value.nip+'</td>'+
                            '<td>'+value.status_pekerjaan_text+'</td>'+
                            '<td>'+value.alasan_ditolak+'</td>'+
                            '<td>'+value.tgl_pelaksanaan+'</td>'+
                            '<td>'+value.nama_gardu+'</td>'+
                            '<td>'+value.busbar+'</td>'+
                            '<td>'+value.kapasitas+'</td>'+
                            '<td>'+value.hasil_pengujian_tahanan_kontak+'</td>'+
                            '<td>'+value.hasil_pengujian_tahanan_isolasi+'</td>'+
                            '<td>'+value.arus_motor_open+'</td>'+
                            '<td>'+value.arus_motor_close+'</td>'+
                            '<td>'+value.waktu_open+'</td>'+
                            '<td>'+value.waktu_close+'</td>'+
                            '<td>'+value.kondisi_visual+'</td>'+
                            '<td>'+value.dokumentasi+'</td>'+
                            '<td>'+value.pengawas_pekerjaan+'</td>'+
                            '<td>'+value.keterangan+'</td>'+
                        '</tr>');

                        i++;
                    });
                }
            });

            $('#search').click(function(){

                $('#fetch_response').html("");

                $.ajax({
                    url: "{{ route('dashboard.index') }}",
                    data: {search: $('#search_dashboard').val()},
                    type: 'GET',
                    dataType: 'json',
                    success: function(data, status, xhr) {

                        if(data.data.result === true){

                            Swal.fire(
                                'Data Ditemukan',
                                data.data.time,
                                'success'
                            )

                            var i = 1;
                            var x = 0;
                            $.each(data.data.data, function( index, value ) {

                                if(!$.isEmptyObject(data.data.data[x])){

                                    $('#fetch_response').append('<tr>'+
                                        '<td>'+i+'</td>'+
                                        '<td>'+value.nama_bay+'</td>'+
                                        '<td>'+value.nip+'</td>'+
                                        '<td>'+value.status_pekerjaan_text+'</td>'+
                                        '<td>'+value.alasan_ditolak+'</td>'+
                                        '<td>'+value.tgl_pelaksanaan+'</td>'+
                                        '<td>'+value.nama_gardu+'</td>'+
                                        '<td>'+value.busbar+'</td>'+
                                        '<td>'+value.kapasitas+'</td>'+
                                        '<td>'+value.hasil_pengujian_tahanan_kontak+'</td>'+
                                        '<td>'+value.hasil_pengujian_tahanan_isolasi+'</td>'+
                                        '<td>'+value.arus_motor_open+'</td>'+
                                        '<td>'+value.arus_motor_close+'</td>'+
                                        '<td>'+value.waktu_open+'</td>'+
                                        '<td>'+value.waktu_close+'</td>'+
                                        '<td>'+value.kondisi_visual+'</td>'+
                                        '<td>'+value.dokumentasi+'</td>'+
                                        '<td>'+value.pengawas_pekerjaan+'</td>'+
                                        '<td>'+value.keterangan+'</td>'+
                                    '</tr>');

                                }

                                i++;
                                x++;
                            });

                        }else{

                            Swal.fire(
                                'Data tidak Ditemukan',
                                data.data.time,
                                'error'
                            )

                        }
                    }
                });

            })

        })

    </script>
@endsection