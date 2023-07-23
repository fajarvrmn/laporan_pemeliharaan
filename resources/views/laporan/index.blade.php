@extends('layouts.app')
 
@section('content')
<div class="container-fluid">
    
    <div>
        <hr>
    </div>
    <div class="row mb-3">
        <div class="col-10">
            <h4>Data Laporan Pemeliharaan</h4>
        </div>
        <div class="col-2">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNew"> Tambah Laporan</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
        <form id="form_filter">
            <div class="row">
                <div class="col-3">
                    <select name="id_peralatan" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Peralatan</option>
                        @foreach(getPeralatan() as $peralatan)
                            <option value="{{ $peralatan->id_alat }}">{{ $peralatan->serial_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="id_gardu_induk" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Gardu Induk</option>
                        @foreach(getGarduInduk() as $gardu)
                            <option value="{{ $gardu->id }}">{{ $gardu->nama_gardu }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="nip" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Nama</option>
                        @foreach(getAllUsers() as $users)
                            <option value="{{ $users->nip }}">{{ $users->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="status" class="form-control form-control-sm filter_datatable_search">
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="0">Diterima</option>
                        <option value="1">Ditolak</option>
                    </select>
                </div>
                <br><br>
                <div class="col-3">
                    <input type="text" placeholder="Tanggal Dari" name="tgl_pelaksanaan_dari" class="form-control form-control-sm filter_datatable_search datepicker" value="">
                </div>
                <div class="col-3">
                    <input type="text" placeholder="Tanggal Sampai" name="tgl_pelaksanaan_sampai" class="form-control form-control-sm filter_datatable_search datepicker" value="">
                </div>
                <div class="col-6">
                     <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                    <button id="clearFilter" type="button" class="btn btn-warning btn-sm text-white">Clear</button> 
                    <a class="btn btn-danger btn-sm text-white" href="laporan/pdf/0" id="export-pdf"> Export PDF</a>
                    <a class="btn btn-success btn-sm" href="laporan/excel/0" id="export-excel"> Export Excel</a>


                </div>
                <div class="col-12">
                    <hr>
                </div>
                
            </div>  
        </form>
        
    </div>
    <!-- <br><br> -->
    <!-- <div class="table-responsive"> -->

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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    <!-- </div> -->
    
</div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formCRUD" name="formCRUD" class="form-horizontal">
                   <input type="hidden" name="id" id="id">

                   <div class="row">

                        <div class="form-group col-6">
                            <label for="id_peralatan" class="col-sm-12 control-label">Peralatan</label>
                            <div class="col-sm-12">
                                <select id="id_peralatan_select" class="form-control" required>
                                    <option value="" disabled selected>Pilih Peralatan</option>
                                    @foreach(getPeralatan() as $peralatan)
                                        <option value="{{ $peralatan->id_alat }}">{{ $peralatan->serial_number }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="id_peralatan" id="id_peralatan">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="nip" class="col-sm-12 control-label">NIP</label>
                            <div class="col-sm-12">
                                <!-- <input type="number" class="form-control" name="nip" id="nip" required> -->
                                <select id="nip" name="nip" class="form-control" required>
                                    <option value="" disabled selected>Pilih NIP</option>
                                    @foreach(getAllUsers() as $users)
                                        <option value="{{ $users->nip }}">{{ $users->nip }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group col-6">
                            <label for="id_status_pekerjaan" class="col-sm-12 control-label">Status Pekerjaan</label>
                            <div class="col-sm-12">
                                <select id="id_status_pekerjaan_select" class="form-control" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach(getStatusPekerjaan() as $status)
                                        <option value="{{ $status->id }}">{{ $status->nama }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="id_status_pekerjaan" id="id_status_pekerjaan">
                            </div>
                        </div> -->

                        <div class="form-group col-6">
                            <label for="tgl_pelaksanaan" class="col-sm-12 control-label">Tanggal Pelaksanaan</label>
                            <div class="col-sm-12">
                                <input type="text" name="tgl_pelaksanaan" id="tgl_pelaksanaan" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="id_gardu_induk" class="col-sm-12 control-label">Gardu Induk</label>
                            <div class="col-sm-12">
                                <select id="id_gardu_induk" name="id_gardu_induk" class="form-control">
                                    <option value="" disabled selected>Pilih Gardu Induk</option>
                                    @foreach(getGarduInduk() as $gardu)
                                        <option value="{{ $gardu->id }}">{{ $gardu->nama_gardu }}</option>
                                    @endforeach
                                </select>
                                <!-- <input type="hidden" name="id_merk_peralatan" id="id_merk_peralatan"> -->
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label for="busbar" class="col-sm-12 control-label">Busbar</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="busbar" id="busbar">
                            </div>
                        </div>
                        
                        <div class="form-group col-6">
                            <label for="kapasitas" class="col-sm-12 control-label">Kapasitas</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="kapasitas" id="kapasitas">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="hasil_pengujian_tahanan_kontak" class="col-sm-12 control-label">Hasil Uji Tahanan Kontak</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="hasil_pengujian_tahanan_kontak" id="hasil_pengujian_tahanan_kontak">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="hasil_pengujian_tahanan_isolasi" class="col-sm-12 control-label">Hasil Uji Tahanan Isolasi</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="hasil_pengujian_tahanan_isolasi" id="hasil_pengujian_tahanan_isolasi">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="arus_motor_open" class="col-sm-12 control-label">Arus Motor Open</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="arus_motor_open" id="arus_motor_open">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="arus_motor_close" class="col-sm-12 control-label">Arus Motor Close</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="arus_motor_close" id="arus_motor_close">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="waktu_open" class="col-sm-12 control-label">Waktu Open</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="waktu_open" id="waktu_open">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="waktu_close" class="col-sm-12 control-label">Waktu Close</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="waktu_close" id="waktu_close">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="kondisi_visual" class="col-sm-12 control-label">Kondisi Visual</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="kondisi_visual" id="kondisi_visual">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="dokumentasi" class="col-sm-12 control-label">Dokumentasi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="dokumentasi" id="dokumentasi">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="pengawas_pekerjaan" class="col-sm-12 control-label">Pengawas Pekerjaan</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="pengawas_pekerjaan" id="pengawas_pekerjaan">
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="keterangan" class="col-sm-12 control-label">Keterangan</label>
                            <div class="col-sm-12">
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>

                   </div>
                   
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!--  -->
<!-- Preview Modal -->
<!--  -->
<div class="modal fade" id="ajaxModelPreview" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading_preview"></h5>
            </div>
            <div class="modal-body">
                <form id="formPreview" name="formPreview" class="form-horizontal">
                    
                   <input type="hidden" name="id_preview" id="id_preview">
                   <input type="hidden" name="id_status_pekerjaan_preview" id="id_status_pekerjaan_preview">
                   <input type="hidden" name="status_preview" id="status_preview">

                   <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Peralatan</th>
                                <th class="serial_number_preview"></th>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <th class="nip_preview"></th>
                            </tr>
                            <tr>
                                <th>Tanggal Pelaksanaan</th>
                                <th class="tgl_pelaksanaan_preview"></th>
                            </tr>
                            <tr>
                                <th>Gardu Induk</th>
                                <th class="nama_gardu_preview"></th>
                            </tr>
                            <tr>
                                <th>Busbar</th>
                                <th class="busbar_preview"></th>
                            </tr>
                            <tr>
                                <th>Kapasitas</th>
                                <th class="kapasitas_preview"></th>
                            </tr>
                            <tr>
                                <th>Pengujian Tahan Kontak</th>
                                <th class="hasil_pengujian_tahanan_kontak_preview"></th>
                            </tr>
                            <tr>
                                <th>Pengujian Tahan Isolasi</th>
                                <th class="hasil_pengujian_tahanan_isolasi_preview"></th>
                            </tr>
                            <tr>
                                <th>Arus Motor Open</th>
                                <th class="arus_motor_open_preview"></th>
                            </tr>
                            <tr>
                                <th>Arus Motor Close</th>
                                <th class="arus_motor_close_preview"></th>
                            </tr>
                            <tr>
                                <th>Waktu Open</th>
                                <th class="waktu_open_preview"></th>
                            </tr>
                            <tr>
                                <th>Waktu Close</th>
                                <th class="waktu_close_preview"></th>
                            </tr>
                            <tr>
                                <th>Kondisi Visual</th>
                                <th class="kondisi_visual_preview"></th>
                            </tr>
                            <tr>
                                <th>Dokumentasi</th>
                                <th class="dokumentasi_preview"></th>
                            </tr>
                            <tr>
                                <th>Pengawas Pekerjaan</th>
                                <th class="pengawas_pekerjaan_preview"></th>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th class="keterangan_preview"></th>
                            </tr>
                        </thead>
                   </table>

                   <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-12">
                       <h5 align="center">Status Persetujuan</h5>
                    </div>

                   <div class="col-12">
                        <hr>
                    </div>

                    <div class="col-12">
                        <input type="hidden" id="id_prev">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Admin</td>
                                    <td>
                                        <button type="button" class="btn btn-success" id="admin-belum-kirim">
                                            <i class="fa fa-envelope"></i> Kirim
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="admin-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supervisor</td>
                                    <td>
                                        <button type="button" class="btn btn-success d-none spv-approval" id="spv_setuju">
                                            <i class="fa fa-check"></i> Setuju
                                        </button>
                                        <button type="button" class="btn btn-danger d-none spv-approval" id="spv_tolak">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="spv-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                        <button type="button" class="btn btn-danger d-none" id="spv-tolak-kirim">
                                            <i class="fa fa-times"> Ditolak</i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Manager</td>
                                    <td>
                                        <button type="button" class="btn btn-success d-none manager-approval" id="manager_setuju">
                                            <i class="fa fa-check"></i> Setuju
                                        </button>
                                        <button type="button" class="btn btn-danger d-none manager-approval" id="manager_tolak">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                        <button type="button" class="btn btn-success d-none" id="manager-sudah-kirim">
                                            <i class="fa fa-check"> Disetujui</i>
                                        </button>
                                        <button type="button" class="btn btn-danger d-none" id="manager-tolak-kirim">
                                            <i class="fa fa-times"> Ditolak</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>
                   
                    <div class="col-sm-offset-2 col-sm-10">
                     <!-- <button type="submit" class="btn btn-primary" id="previewBtn">Simpan</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ajaxModelTolak" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id=""></h4>
            </div>
            <div class="modal-body text-center">
                <form id="formTolak" name="formTolak" class="form-horizontal">

                    <div class="col-12">
                        <h5>Tolak Laporan Ini ?</h5>
                    </div>

                    <div class="form-group col-12">
                        <label for="keterangan" class="col-sm-12 control-label">Alasan Penolakan</label>
                        <div class="col-sm-12">
                            <textarea name="alasan_ditolaknya" id="alasan_ditolaknya" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger" id="tolakBtn">Tolak</button>
                    </div> -->

                </form>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" id="tolakBtn"><i class="fa fa-ban"></i> Tolak</button>
            </div>
        </div>
    </div>
</div>


      
</body>
      
<script type="text/javascript">
  $(function () {
    /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
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

    // var a = $('form#form_filter').serializeArray();
    // console.log(a);

    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        bFilter: false,
        ajax: {
            url: "{{ route('laporan.index') }}",
            data: function ( d ) {
                // return $.extend( {}, d, {
                // "search_keywords": $("#searchInput").val().toLowerCase(),
                // "filter_option": $("#sortBy").val().toLowerCase()
                    d.form_search = $('form#form_filter').serializeArray();
                // });
            }
        },
        // ajax: "{{ route('laporan.index') }}",
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
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    new $.fn.dataTable.FixedHeader( table );

    $('form#form_filter').submit(function(){
        // var data = table.$('form#form_filter').serialize();
        var sa = $('form#form_filter').serialize();
        $('#export-pdf').attr('href', 'laporan/pdf/1?'+sa);
        $('#export-excel').attr('href', 'laporan/excel/1?'+sa);
        // console.log(sa);
        // return false;
        table.draw();
        return false;
    });

    $('#clearFilter').click(function(){
        $('form#form_filter')[0].reset();
        $('#export-pdf').attr('href', 'laporan/pdf/0');
        $('#export-excel').attr('href', 'laporan/excel/0');
        table.draw();
    })
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/


    // $('input[type="search"]').keyup(function(){
    //     var search = $(this).val();
    //     $('#export-pdf').attr('href', 'laporan/pdf/'+search);
    //     $('#export-excel').attr('href', 'laporan/excel/'+search);
    // })

    $('body').on('click', '.preview', function () {

        var id = $(this).data('id');
        var id_peralatan = $(this).data('idperalatan');
        var nip = $(this).data('idnip');
        var id_status_pekerjaan = $(this).data('idstatus');
        // var status = $('#status_preview').val();
        // alert(status);

        // console.log(param);
        $.ajax({
            type: 'GET',
            url: '{{ route("laporan.index") }}/'+id+'/edit',
            data: {
                id: id,
                // id_peralatan : id_peralatan,
                // nip : nip,
                // id_status_pekerjaan: id_status_pekerjaan
            },
            success: function(data){
                
                var status = data[0].status;
                
                console.log(status);

                $.each(data[0], function(k, v) {
                    console.log(k, v);
                    $('th.'+k+"_preview").text(v);
                    $('input#'+k+"_preview").val(v);
                });

                if(data[0].id_status_pekerjaan == '1' && status == '0'){

                    if(role == '1'){
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '2' && status == '0'){

                    if(role == '2'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').removeClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '2' && status == '1'){

                    if(role == '2'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').removeClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').addClass('d-none');
                        $('#spv-tolak-kirim').removeClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }

                }else if(data[0].id_status_pekerjaan == '3' && status == '0'){

                    if(role == '3'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').removeClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }else{
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').addClass('d-none');
                    }
                }else if(data[0].id_status_pekerjaan == '3' && status == '1'){

                    if(role == '3'){
                        $('#admin-belum-kirim').addClass('d-none');
                        $('#admin-sudah-kirim').removeClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').removeClass('d-none');
                    }else{
                        $('#admin-belum-kirim').removeClass('d-none');
                        $('#admin-sudah-kirim').addClass('d-none');
                        $('.spv-approval').addClass('d-none');
                        $('#spv-sudah-kirim').removeClass('d-none');
                        $('#spv-tolak-kirim').addClass('d-none');
                        $('.manager-approval').addClass('d-none');
                        $('#manager-sudah-kirim').addClass('d-none');
                        $('#manager-tolak-kirim').removeClass('d-none');
                    }
                }else if(data[0].id_status_pekerjaan == '4' && status == '0'){
                    $('#admin-belum-kirim').addClass('d-none');
                    $('#admin-sudah-kirim').removeClass('d-none');
                    $('.spv-approval').addClass('d-none');
                    $('#spv-sudah-kirim').removeClass('d-none');
                    $('#spv-tolak-kirim').addClass('d-none');
                    $('.manager-approval').addClass('d-none');
                    $('#manager-sudah-kirim').removeClass('d-none');
                    $('#manager-tolak-kirim').addClass('d-none');
                }

                $('#modelHeading_preview').html("Detail Laporan");
                $('#previewBtn').val("preview");
                $('#ajaxModelPreview').modal('show');

            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    });

    $('#admin-belum-kirim').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 2, status: 0, alasan_ditolak: null},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#spv_setuju').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 3, status: 0},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#manager_setuju').click(function(){
        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        $.ajax({
            data: {id: id, id_status_pekerjaan: 4, status: 0},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
        
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    });

    $('#spv_tolak, #manager_tolak').click(function(){
        $('#ajaxModelTolak').modal('show');
    });

    $('#tolakBtn').click(function(){

        var id = $('#id_preview').val();
        // var id_peralatan = $("#id_peralatan_preview").val();
        // var nip = $("#nip_preview").val();
        var id_status_pekerjaan = $('#id_status_pekerjaan_preview').val();
        var alasan = $('#alasan_ditolaknya').val();

        $.ajax({
            data: {id: id, id_status_pekerjaan: id_status_pekerjaan, alasan_ditolak: alasan, status: 1},
            url: "{{ route('laporan.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#formTolak').trigger("reset");
                $('#ajaxModelTolak').modal('hide');
                $('#formPreview').trigger("reset");
                $('#ajaxModelPreview').modal('hide');
                table.draw();
            
            },
            error: function (data) {
                console.log('Error:', data);
                // $('#saveBtn').html('Simpan');
            }
        });
    })

    $('#createNew').click(function () {
        $('#id_peralatan').val("");
        $('#id_status_pekerjaan').val("");
        $('#saveBtn').val("create");
        $('#id').val('');
        $('#formCRUD').trigger("reset");
        $('#modelHeading').html("Tambah Data");
        $('#ajaxModel').modal('show');
        
        $('#id_peralatan_select').prop('disabled', false);
        $('#nip').prop('readonly', false);
        $('#id_status_pekerjaan_select').prop('disabled', false);
    });

    $('select#id_peralatan_select').change(function(){
        $('#id_peralatan').val($(this).val());
    })

    $('select#id_status_pekerjaan_select').change(function(){
        $('#id_status_pekerjaan').val($(this).val());
    })
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.edit', function () {

        var id = $(this).data('id');

        $.ajax({
            type: 'GET',
            url: '{{ route("laporan.index") }}/'+id+'/edit',
            data: {
                id: id,
                // id_peralatan : id_peralatan,
                // nip : nip,
                // id_status_pekerjaan: id_status_pekerjaan
            },
            success: function(data){
                // console.log(data);
                $('#modelHeading').html("Edit Data");
                $('#saveBtn').val("edit");
                $('#ajaxModel').modal('show');

                $.each(data[0], function(k, v) {
                    console.log(k, v);
                    $('input#'+k).val(v);
                    $('textarea#'+k).text(v);
                    $('select#'+k).val(v).trigger('change');
                });

                $('#id_peralatan_select').val(data[0].id_peralatan).trigger('change');
                $('#id_status_pekerjaan_select').val(data[0].id_status_pekerjaan).trigger('change');

                $('#id_peralatan_select').prop('disabled', true);
                $('#nip').prop('readonly', true);
                $('#id_status_pekerjaan_select').prop('disabled', true);

                table.draw();

            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });
    });
      
    /*------------------------------------------
    --------------------------------------------
    Create Product Code
    --------------------------------------------
    --------------------------------------------*/
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
      
        $.ajax({
          data: $('#formCRUD').serialize(),
          url: "{{ route('laporan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#formCRUD').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
           
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Simpan');
          }
      });
    });
      
    /*------------------------------------------
    --------------------------------------------
    Delete Product Code
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.delete', function () {
     
        // var id = $(this).data("id");
        confirm("Are You sure want to delete !");

        var id = $(this).data('id');
        var id_peralatan = $(this).data('idperalatan');
        var nip = $(this).data('idnip');
        var id_status_pekerjaan = $(this).data('idstatus');
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('laporan.store') }}"+'/'+id,
            data: {
                id: id,
                id_peralatan : id_peralatan,
                nip : nip,
                id_status_pekerjaan: id_status_pekerjaan
            },
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
       
  });
</script>
      
@endsection