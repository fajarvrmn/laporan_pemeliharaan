@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <div>
        <hr>
    </div>
        <div class="row mb-3">
        <div class="col-11">
            <h4>Data Peralatan</h4>
        </div>
        <div class="col-1">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNew"> Tambah</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>

    <table class="table table-bordered data-table">
        <thead align="center">
            <tr>
                <th>No</th>
                <th>Bay</th>
                <th>ID</th>
                <th>Lokasi</th>
                <th>Serial Number</th>
                <th>Merk Peralatan</th>
                <th>Tipe Peralatan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
     
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="formCRUD" name="formCRUD" class="form-horizontal">
                   <input type="hidden" name="id_alat" id="id_alat">
                    <div class="form-group">
                        <label for="nama" class="col-sm-6 control-label">Merk Peralatan</label>
                        <div class="col-sm-12">
                            <select id="id_merk_peralatan" name="id_merk_peralatan" class="form-control">
                                <option value="" disabled selected>Pilih Merk Peralatan</option>
                                @foreach(getMerkPeralatan() as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->nama_merk }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="hidden" name="id_merk_peralatan" id="id_merk_peralatan"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-sm-6 control-label">Tipe Peralatan</label>
                        <div class="col-sm-12">
                            <select id="id_type_peralatan" name="id_type_peralatan" class="form-control">
                                <option value="" disabled selected>Pilih Tipe Peralatan</option>
                                @foreach(getTypePeralatan() as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_type }}</option>
                                @endforeach
                            </select>
                            <!-- <input type="hidden" name="id_type_peralatan" id="id_type_peralatan"> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_bay" class="col-sm-6 control-label">Bay</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="nama_bay" id="nama_bay">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kode_alat" class="col-sm-6 control-label">ID</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="kode_alat" id="kode_alat">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="serial_number" class="col-sm-6 control-label">Serial Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="serial_number" id="serial_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="col-sm-6 control-label">Lokasi</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="lokasi" id="lokasi">
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
        processing: true,
        serverSide: true,
        ajax: "{{ route('peralatan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_bay', name: 'nama_bay'},
            {data: 'kode_alat', name: 'kode_alat'},
            {data: 'lokasi', name: 'lokasi'},
            {data: 'serial_number', name: 'serial_number'},
            {data: 'nama_merk', name: 'nama_merk'},
            {data: 'nama_type', name: 'nama_type'},            
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNew').click(function () {
        $('#saveBtn').val("create");
        $('#id_alat').val('');
        $('#formCRUD').trigger("reset");
        $('#modelHeading').html("Tambah Data");
        $('#ajaxModel').modal('show');
        $('select#select_id_merk_peralatan').prop('disabled', false);
        $('select#select_id_type_peralatan').prop('disabled', false);
    });

    // $('select#select_id_type_peralatan').change(function(){
    //     $('#id_type_peralatan').val($(this).val());
    // })

    // $('select#select_id_merk_peralatan').change(function(){
    //     $('#id_merk_peralatan').val($(this).val());
    // })
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.edit', function () {

        // var param = [];

        var id_alat = $(this).data('id');
        var id_type_peralatan = $(this).data('idtipe');
        var id_merk_peralatan = $(this).data('idmerk');

        // console.log(param);
        $.ajax({
            type: 'GET',
            url: '{{ route("peralatan.index") }}/'+id_alat+'/edit',
            data: {
                id_alat: id_alat,
                id_type_peralatan : id_type_peralatan,
                id_merk_peralatan : id_merk_peralatan
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

                // $('select#select_id_merk_peralatan').val(data.id_merk_peralatan).trigger('change');
                // $('select#select_id_type_peralatan').val(data.id_merk_peralatan).trigger('change');

                // $('select#select_id_merk_peralatan').prop('disabled', true);
                // $('select#select_id_type_peralatan').prop('disabled', true);
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

        var id_alat = $('#id_alat').val();
        var actionIs = $('#saveBtn').val();

        var myUrl = (actionIs == 'create') ? "peralatan/create" : "peralatan/"+id_alat;
        var method = (actionIs == 'create') ? "GET" : "PATCH";
      
        $.ajax({
          data: $('#formCRUD').serialize(),
          url: myUrl,
          type: method,
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
     
        var id = $(this).data("id");
        confirm("Are You sure want to delete !");

        var id_alat = $(this).data('id');
        var id_type_peralatan = $(this).data('idtipe');
        var id_merk_peralatan = $(this).data('idmerk');
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('peralatan.store') }}"+'/'+id,
            data: {
                id_alat: id_alat,
                // id_type_peralatan : id_type_peralatan,
                // id_merk_peralatan : id_merk_peralatan
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