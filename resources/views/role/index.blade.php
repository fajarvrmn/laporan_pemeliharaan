@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <div>
        <hr>
    </div>
        <div class="row mb-3">
        <div class="col-11">
            <h4>Kelola Role</h4>
        </div>
        <div class="col-1">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewRole"> Tambah</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Role User</th>
                <th>Description</th>
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
                <form id="roleForm" name="roleForm" class="form-horizontal">
                   <input type="hidden" name="role_id" id="role_id">
                    <div class="form-group">
                        <label for="nama_role" class="col-sm-6 control-label">Role User</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_role" name="nama_role" placeholder="Masukan Role" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_role" class="col-sm-6 control-label">Deskripsi</label>
                        <div class="col-sm-12">
                            <textarea type="text" class="form-control" id="deskripsi_role" name="deskripsi_role" placeholder="Masukan Deskripsi" value="" maxlength="50" required=""></textarea>
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
        ajax: "{{ route('role.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNewRole').click(function () {
        $('#saveBtn').val("create-role");
        $('#role_id').val('');
        $('#roleForm').trigger("reset");
        $('#modelHeading').html("Tambah Role Baru");
        $('#ajaxModel').modal('show');
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
   $('body').on('click', '.editRole', function () {
      var role_id = $(this).data('id');
      $.get("{{ route('role.index') }}" +'/' + role_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Merek");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#role_id').val(data.id);
          $('#nama_role').val(data.nama_role);
          
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
          data: $('#roleForm').serialize(),
          url: "{{ route('role.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#roleForm').trigger("reset");
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
    $('body').on('click', '.deleteRole', function () {
     
        var role_id = $(this).data("id");
        confirm("Yakin akan menghapus ?");
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('role.store') }}"+'/'+role_id,
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