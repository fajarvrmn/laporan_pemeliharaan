@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <h3>Master Data Personil</h3><br>
    <a class="btn btn-success" href="javascript:void(0)" id="createNew"> Tambah</a>
    <br><br>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Pendidikan</th>
                <th>Jabatan</th>
                <th>Unit Kerja</th>
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
                   <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="email" class="col-sm-6 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nip" class="col-sm-6 control-label">NIP</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukan NIP" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan Nama" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pendidikan" class="col-sm-6 control-label">Pendidikan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukan Pendidikan" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="col-sm-6 control-label">Jabatan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukan Jabatan" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit_kerja" class="col-sm-6 control-label">Unit Kerja</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" placeholder="Masukan Unit Kerja" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-6 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" value="" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                     </button>
                     <input type="hidden" id="valAction">
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
        ajax: "{{ route('personil.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'email', name: 'email'},
            {data: 'nip', name: 'nip'},
            {data: 'name', name: 'name'},
            {data: 'pendidikan', name: 'pendidikan'},
            {data: 'jabatan', name: 'jabatan'},
            {data: 'unit_kerja', name: 'unit_kerja'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNew').click(function () {
        $('#valAction').val('create');
        $('#id').val("");
        $('#formCRUD').trigger("reset");
        $('#modelHeading').html("Tambah Data");
        $('#ajaxModel').modal('show');

        $('#email').prop('readonly', false);
        $('#nip').prop('readonly', false);
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.edit', function () {
      var id = $(this).data('id');
      $.get("{{ route('personil.index') }}" +'/' + id +'/edit', function (data) {

            $('#modelHeading').html("Edit Data");
            $('#valAction').val("edit");
            $('#ajaxModel').modal('show');
            $.each(data, function(k, v) {
                $('input#'+k).val(v);
                $('textarea#'+k).text(v);
            });
            $('#email').prop('readonly', true);
            $('#nip').prop('readonly', true);
          
      })
    });
      
    /*------------------------------------------
    --------------------------------------------
    Create Product Code
    --------------------------------------------
    --------------------------------------------*/
    $('#saveBtn').click(function (e) {

        // console.log('action is', $("#valAction").val());
        // return false;
        e.preventDefault();
        $(this).html('Sending..');

        var id = ($('#id').val() !== "") ? $('#id').val() : "";

        var actionIs = $("#valAction").val();
        var url = (actionIs == 'create') ? "personil/create" : "personil/"+id;

        var method = (actionIs == 'create') ? "GET" : "PATCH";
      
        $.ajax({
          data: $('#formCRUD').serialize(),
          url: url,
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
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('personil.store') }}"+'/'+id,
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