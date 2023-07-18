@extends('layouts.app')
 
@section('content')
<div class="container-fluid">
    <h3>Master Data Laporan</h3><br>
    <div>
        <hr>
    </div>
    <a class="btn btn-success" href="javascript:void(0)" id="createNew"> Tambah</a>
    <br><br>
    <!-- <div class="table-responsive"> -->

        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peralatan</th>
                    <th>NIP</th>
                    <th>Status Pekerjaan</th>
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
                                <input type="number" class="form-control" name="nip" id="nip" required>
                            </div>
                        </div>

                        <div class="form-group col-6">
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
                        </div>

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
                            <label for="keterangan" class="col-sm-12 control-label">Pengawas Pekerjaan</label>
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
    var table = $('.data-table').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('laporan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'serial_number', name: 'serial_number'},
            {data: 'nip', name: 'nip'},
            {data: 'status_pekerjaan_name', name: 'status_pekerjaan_name'},
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
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
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

        // var param = [];

        var id = $(this).data('id');
        var id_peralatan = $(this).data('idperalatan');
        var nip = $(this).data('idnip');
        var id_status_pekerjaan = $(this).data('idstatus');

        // console.log(param);
        $.ajax({
            type: 'GET',
            url: '{{ route("laporan.index") }}/'+id+'/edit',
            data: {
                id: id,
                id_peralatan : id_peralatan,
                nip : nip,
                id_status_pekerjaan: id_status_pekerjaan
            },
            success: function(data){
                console.log(data);
                $('#modelHeading').html("Edit Data");
                $('#saveBtn').val("edit");
                $('#ajaxModel').modal('show');

                $.each(data, function(k, v) {
                    $('input#'+k).val(v);
                    $('textarea#'+k).text(v);
                    $('select#'+k).val(v).trigger('change');
                });

                $('#id_peralatan_select').val(data.id_peralatan).trigger('change');
                $('#id_status_pekerjaan_select').val(data.id_status_pekerjaan).trigger('change');

                $('#id_peralatan_select').prop('disabled', true);
                $('#nip').prop('readonly', true);
                $('#id_status_pekerjaan_select').prop('disabled', true);

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