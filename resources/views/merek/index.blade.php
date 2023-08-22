@extends('layouts.app')
 
@section('content')

    <div class="container-fluid">
    <div>
        <hr>
    </div>
        <div class="row mb-3">
        <div class="col-11">
            <h4>Data Merek Peralatan</h4>
        </div>
        <div class="col-1">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewMerek"> Tambah</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Merek Peralatan</th>
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
                <form id="merekForm" name="merekForm" class="form-horizontal">
                   <input type="hidden" name="merek_id" id="merek_id">
                    <div class="form-group">
                        <label for="nama_merk" class="col-sm-12 control-label">Merek Peralatan</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_merk" name="nama_merk" placeholder="Masukan Merek" value="" maxlength="50" required="">
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
        ajax: "{{ route('merekperalatan.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_merk', name: 'nama_merk'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNewMerek').click(function () {
        $('#saveBtn').val("create-merek");
        $('#merek_id').val('');
        $('#merekForm').trigger("reset");
        $('#modelHeading').html("Tambah Merek Peralatan");
        $('#ajaxModel').modal('show');
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.editMerek', function () {
      var merek_id = $(this).data('id');
      $.get("{{ route('merekperalatan.index') }}" +'/' + merek_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Merek");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#merek_id').val(data.id);
          $('#nama_merk').val(data.nama_merk);
          
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
          data: $('#merekForm').serialize(),
          url: "{{ route('merekperalatan.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#merekForm').trigger("reset");
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
    $('body').on('click', '.deleteMerek', function () {
     
        var merek_id = $(this).data("id");
         if(!confirm("Are You sure want to delete !")){
            return false;
        }
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('merekperalatan.store') }}"+'/'+merek_id,
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