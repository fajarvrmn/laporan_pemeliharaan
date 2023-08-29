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
            <div class="col-12">
                <h3 style ="text-align: center;">Pencarian Algoritma Sequential Search</h3>
            </div>
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
                        <th>Status Laporan</th>
                        <th>Alasan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Gardu Induk</th>
                        <th>Peralatan</th>
                        <th>Rel</th>
                        <th>Merek</th>
                        <th>Tipe</th>
                        <th>Kapasitas</th>
                        <th>Tahanan Kontak (R S T)</th>
                        <th>Tahanan Isolasi (R S T)</th>
                        <th>Arus Motor</th>
                        <th>Waktu Open</th>
                        <th>Waktu Close</th>
                        <th>Kondisi Visual</th>
                        <th>Dokumentasi</th>
                        <th>Pengawas Pekerjaan</th>
                        <th>Pelaksana Uji</th>
                        <!-- <th>Status Pekerjaan</th> -->
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody id="fetch_response">
                </tbody>
            </table>
        </div>

        <div>
            <hr>
        </div>

        <div class="col-12">
            <h3 align="center">Grafik Laporan Berdasarkan Gardu Induk</h3>
            <canvas id="chartGarduInduk"></canvas>
        </div>
        <div><hr></div>
        <div class="col-12">
            <h3 align="center">Grafik Laporan Berdasarkan BAY</h3>
            <canvas id="chartBay"></canvas>
        </div>
        <div><hr></div>
        <div class="col-12">
            <h3 align="center">Grafik Laporan Berdasarkan Pengawas Pekerjaan</h3>
            <canvas id="chartPengawas"></canvas>
        </div>

    </div>

    <script>
        $(document).ready(function(){

            countGardu();
            countBay();
            countPengawas();

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
                        var alasanDitolak = (value.alasan_ditolak === null) ? "" : value.alasan_ditolak;

                        $('#fetch_response').append('<tr>'+
                            '<td>'+i+'</td>'+
                            '<td>'+value.status_pekerjaan_text+'</td>'+
                            '<td>'+alasanDitolak+'</td>'+
                            '<td>'+value.tgl_pelaksanaan+'</td>'+
                            '<td>'+value.nama_gardu+'</td>'+
                            '<td>'+value.nama_bay+'</td>'+
                            '<td>'+value.rel+'</td>'+
                            '<td>'+value.nama_merk+'</td>'+
                            '<td>'+value.nama_type+'</td>'+
                            '<td>'+value.kapasitas+'</td>'+
                            '<td>'+value.hasil_pengujian_tahanan_kontak+'</td>'+
                            '<td>'+value.hasil_pengujian_tahanan_isolasi+'</td>'+
                            '<td>'+value.arus_motor+'</td>'+
                            '<td>'+value.waktu_open+'</td>'+
                            '<td>'+value.waktu_close+'</td>'+
                            '<td>'+value.kondisi_visual+'</td>'+
                            '<td><img src="{{ URL::asset("uploads") }}/images/'+value.dokumentasi+'" style="width: 100%;height: 100%;" alt="No Image Set"></img>'+'</td>'+
                            '<td>'+value.user_name+'</td>'+
                            '<td>'+value.pelaksana_uji+'</td>'+
                            // '<td>'+value.status_laporan+'</td>'+
                            '<td>'+value.keterangan+'</td>'+
                        '</tr>');

                        i++;

                    });
                }
            });

            $('#search').click(function(){

                $('#fetch_response').html("");

                $.ajax({
                    startTime: performance.now(),
                    url: "{{ route('dashboard.index') }}",
                    data: {search: $('#search_dashboard').val()},
                    type: 'GET',
                    dataType: 'json',
                    success: function(data, status, xhr) {

                        var time = performance.now() - this.startTime;

                        //Convert milliseconds to seconds.
                        var seconds = time / 1000;

                        //Round to 3 decimal places.
                        seconds = seconds.toFixed(3);

                        if(data.data.result === true){

                            Swal.fire(
                                'Data Ditemukan',
                                'waktu yang dibutuhkan '+seconds+' detik',
                                'success'
                            )

                            var i = 1;
                            var x = 0;
                            $.each(data.data.data, function( index, value ) {

                                if(!$.isEmptyObject(data.data.data[x])){

                                    var alasanDitolak = (value.alasan_ditolak === null) ? "" : value.alasan_ditolak;

                                    $('#fetch_response').append('<tr>'+
                                        '<td>'+i+'</td>'+
                                        '<td>'+value.status_pekerjaan_text+'</td>'+
                                        '<td>'+alasanDitolak+'</td>'+
                                        '<td>'+value.tgl_pelaksanaan+'</td>'+
                                        '<td>'+value.nama_gardu+'</td>'+
                                        '<td>'+value.nama_bay+'</td>'+
                                        '<td>'+value.rel+'</td>'+
                                        '<td>'+value.nama_merk+'</td>'+
                                        '<td>'+value.nama_type+'</td>'+
                                        '<td>'+value.kapasitas+'</td>'+
                                        '<td>'+value.hasil_pengujian_tahanan_kontak+'</td>'+
                                        '<td>'+value.hasil_pengujian_tahanan_isolasi+'</td>'+
                                        '<td>'+value.arus_motor+'</td>'+
                                        '<td>'+value.waktu_open+'</td>'+
                                        '<td>'+value.waktu_close+'</td>'+
                                        '<td>'+value.kondisi_visual+'</td>'+
                                        '<td><img src="{{ URL::asset("uploads") }}/images/'+value.dokumentasi+'" style="width: 100%;height: 100%;" alt="No Image Set"></img>'+'</td>'+
                                        '<td>'+value.user_name+'</td>'+
                                        '<td>'+value.pelaksana_uji+'</td>'+
                                        // '<td>'+value.status_laporan+'</td>'+
                                        '<td>'+value.keterangan+'</td>'+
                                    '</tr>');

                                }

                                i++;
                                x++;
                            });

                        }else{

                            Swal.fire(
                                'Data tidak Ditemukan',
                                'waktu yang dibutuhkan '+seconds+' detik',
                                'error'
                            )

                        }
                    }
                });

            });

        });

        function countGardu(){
            $.ajax({
                url: "dashboard/gardu/chart",
                data: {},
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var nama_gardu = [];
                    var total_gardu = [];
                    var bColor = [];
                    for (let index = 0; index < data.data.length; index++) {
                        // const element = array[index];
                        $.each(data.data[index], function(k, v) {
                            console.log(k, v);
                            if(k == 'nama_gardu'){
                                nama_gardu[index] = v;
                            }else if(k == 'total_gardu'){
                                total_gardu[index] = v;
                                bColor[index] = 'rgb(51, 73, 242)';
                            }
                        });
                    }
                    
                    var ctx = document.getElementById("chartGarduInduk").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nama_gardu,
                            datasets: [{
                                label: 'Gardu Induk',
                                data: total_gardu,
                                backgroundColor: bColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

        function countBay(){
            $.ajax({
                url: "dashboard/bay/chart",
                data: {},
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var nama = [];
                    var total = [];
                    var bColor = [];
                    for (let index = 0; index < data.data.length; index++) {
                        // const element = array[index];
                        $.each(data.data[index], function(k, v) {
                            console.log(k, v);
                            if(k == 'nama'){
                                nama[index] = v;
                            }else if(k == 'total'){
                                total[index] = v;
                                bColor[index] = 'rgb(0, 128, 0)';
                            }
                        });
                    }
                    
                    var ctx = document.getElementById("chartBay").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nama,
                            datasets: [{
                                label: 'Bay',
                                data: total,
                                backgroundColor: bColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

        function countPengawas(){
            $.ajax({
                url: "dashboard/pengawas/chart",
                data: {},
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    var nama = [];
                    var total = [];
                    var bColor = [];
                    for (let index = 0; index < data.data.length; index++) {
                        // const element = array[index];
                        $.each(data.data[index], function(k, v) {
                            console.log(k, v);
                            if(k == 'nama'){
                                nama[index] = v;
                            }else if(k == 'total'){
                                total[index] = v;
                                bColor[index] = 'rgb(100, 0, 0)';
                            }
                        });
                    }
                    
                    var ctx = document.getElementById("chartPengawas").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nama,
                            datasets: [{
                                label: 'Pengawas',
                                data: total,
                                backgroundColor: bColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

    </script>
@endsection