@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <div>
        <hr>
    </div>
        <div class="row mb-3">
        <div class="col-11">
            <h4>Data Tipe Peralatan</h4>
        </div>
        <div class="col-1">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewTipe"> Tambah</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Type Peralatan</th>
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
                <form id="tipeForm" name="tipeForm" class="form-horizontal">
                   <input type="hidden" name="tipe_id" id="tipe_id">
                    <div class="form-group">
                        <label for="nama_type" class="col-sm-6 control-label">Type Peralatan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_type" name="nama_type" placeholder="Masukan Type" value="" maxlength="50" required="">
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
        ajax: "{{ route('tipeperalatan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_type', name: 'nama_type'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNewTipe').click(function () {
        $('#saveBtn').val("create-tipe");
        $('#tipe_id').val('');
        $('#tipeForm').trigger("reset");
        $('#modelHeading').html("Tambah Tipe Peralatan");
        $('#ajaxModel').modal('show');
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.editTipe', function () {
      var tipe_id = $(this).data('id');
      $.get("{{ route('tipeperalatan.index') }}" +'/' + tipe_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Tipe");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#tipe_id').val(data.id);
          $('#nama_type').val(data.nama_type);
          
      })
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
          data: $('#tipeForm').serialize(),
          url: "{{ route('tipeperalatan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#tipeForm').trigger("reset");
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
    $('body').on('click', '.deleteTipe', function () {
     
        var tipe_id = $(this).data("id");
        confirm("Are You sure want to delete !");
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('tipeperalatan.store') }}"+'/'+tipe_id,
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