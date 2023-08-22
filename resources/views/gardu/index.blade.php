@extends('layouts.app')
 
@section('content')
    <div class="container-fluid">
    <div>
        <hr>
    </div>
        <div class="row mb-3">
        <div class="col-11">
            <h4>Data Gardu Induk</h4>
        </div>
        <div class="col-1">
            <a class="btn btn-success btn-sm" href="javascript:void(0)" id="createNewGardu"> Tambah</a>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gardu Induk</th>
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
                <form id="garduForm" name="garduForm" class="form-horizontal">
                   <input type="hidden" name="gardu_id" id="gardu_id">
                    <div class="form-group">
                        <label for="nama_gardu" class="col-sm-6 control-label">Gardu Induk</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_gardu" name="nama_gardu" placeholder="Masukan Gardu" value="" maxlength="50" required="">
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
        ajax: "{{ route('garduinduk.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_gardu', name: 'nama_gardu'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Button
    --------------------------------------------
    --------------------------------------------*/
    $('#createNewGardu').click(function () {
        $('#saveBtn').val("create-gardu");
        $('#gardu_id').val('');
        $('#garduForm').trigger("reset");
        $('#modelHeading').html("Tambah Gardu Induk");
        $('#ajaxModel').modal('show');
    });
      
    /*------------------------------------------
    --------------------------------------------
    Click to Edit Button
    --------------------------------------------
    --------------------------------------------*/
    $('body').on('click', '.editGardu', function () {
      var gardu_id = $(this).data('id');
      $.get("{{ route('garduinduk.index') }}" +'/' + gardu_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Gardu");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#gardu_id').val(data.id);
          $('#nama_gardu').val(data.nama_gardu);
          
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
          data: $('#garduForm').serialize(),
          url: "{{ route('garduinduk.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
       
              $('#garduForm').trigger("reset");
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
    $('body').on('click', '.deleteGardu', function () {
     
        var gardu_id = $(this).data("id");
        
         if(!confirm("Are You sure want to delete !")){
            return false;
        }
        
        $.ajax({
            type: "DELETE",
            url: "{{ route('garduinduk.store') }}"+'/'+gardu_id,
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