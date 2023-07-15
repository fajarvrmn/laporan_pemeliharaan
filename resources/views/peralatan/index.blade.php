@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <h3>Master Data Peralatan</h3><br>
    <div>
        <hr>
    </div>
    <a class="btn btn-success" href="javascript:void(0)" id="createNew"> Tambah</a>
    <br><br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Merk Peralatan</th>
                <th>Tipe Peralatan</th>
                <th>Serial Number</th>
                <th width="280px">Action</th>
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
                            <select id="select_id_merk_peralatan" class="form-control">
                                <option value="" disabled selected>Pilih Merk Peralatan</option>
                                @foreach(getMerkPeralatan() as $merk)
                                    <option value="{{ $merk->id }}">{{ $merk->nama_merk }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id_merk_peralatan" id="id_merk_peralatan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-sm-6 control-label">Tipe Peralatan</label>
                        <div class="col-sm-12">
                            <select id="select_id_type_peralatan" class="form-control">
                                <option value="" disabled selected>Pilih Tipe Peralatan</option>
                                @foreach(getTypePeralatan() as $tipe)
                                    <option value="{{ $tipe->id }}">{{ $tipe->nama_type }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="id_type_peralatan" id="id_type_peralatan">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-sm-6 control-label">Serial Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="serial_number" id="serial_number">
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
            {data: 'id_merk_peralatan', name: 'id_merk_peralatan'},
            {data: 'id_type_peralatan', name: 'id_type_peralatan'},
            {data: 'serial_number', name: 'serial_number'},
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

    $('select#select_id_type_peralatan').change(function(){
        $('#id_type_peralatan').val($(this).val());
    })

    $('select#select_id_merk_peralatan').change(function(){
        $('#id_merk_peralatan').val($(this).val());
    })
      
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
                });

                $('select#select_id_merk_peralatan').val(data.id_merk_peralatan).trigger('change');
                $('select#select_id_type_peralatan').val(data.id_merk_peralatan).trigger('change');

                $('select#select_id_merk_peralatan').prop('disabled', true);
                $('select#select_id_type_peralatan').prop('disabled', true);
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
          url: "{{ route('peralatan.store') }}",
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
                id_type_peralatan : id_type_peralatan,
                id_merk_peralatan : id_merk_peralatan
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