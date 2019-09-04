@extends('layouts.backend')

@section('content')
<!-- Main content -->
<div class="container">

    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New</a>
    <br/>
    <br/>
    <table class="table table-bordered data-table">

    <thead class="thead-dark">

        <tr>

            <th>No</th>

            <th>Kode Anggota</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Jurusan</th>
            <th width="280px">Alamat</th>
            <th width="75px">Action</th>

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

            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="anggota_id" id="anggota_id">

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Anggota</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="kode_anggota" name="kode_anggota" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Jenis Kelamin</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="jk" name="jk" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Jurusan</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                        <label class="col-sm-2 control-label">Alamat</label>

                        <div class="col-sm-12">

                            <textarea id="alamat" name="alamat" required="" placeholder="Enter Details" class="form-control"></textarea>

                        </div>

                    </div>
  

                <div class="col-sm-offset-2 col-sm-10">

                 <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes

                 </button>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

<!-- /.content -->
@endsection

    @section('js')
    <script type="text/javascript">

      $(function () {
    
         
    
          $.ajaxSetup({
    
              headers: {
    
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    
              }
    
        });
    
        
    
        var table = $('.data-table').DataTable({
    
            processing: true,
    
            serverSide: true,
    
            ajax: "{{ route('anggota.index') }}",
    
            columns: [
    
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    
                {data: 'kode_anggota', name: 'kode_anggota'},
    
                {data: 'nama', name: 'nama'},
    
                {data: 'jk', name: 'jk'},
    
                {data: 'jurusan', name: 'jurusan'},
    
                {data: 'alamat', name: 'alamat'},
    
                {data: 'action', name: 'action', orderable: false, searchable: false},
    
            ]
    
        });
    
         
    
        $('#createNewProduct').click(function () {
    
            $('#saveBtn').val("create-product");
    
            $('#anggota_id').val('');
    
            $('#productForm').trigger("reset");
    
            $('#modelHeading').html("Create New Product");
    
            $('#ajaxModel').modal('show');
    
        });
    
        
    
        $('body').on('click', '.editProduct', function () {
    
          var anggota_id = $(this).data('id');
    
          $.get("{{ route('anggota.index') }}" +'/' + anggota_id +'/edit', function (data) {
    
              $('#modelHeading').html("Edit Product");
    
              $('#saveBtn').val("edit-user");
    
              $('#ajaxModel').modal('show');
    
              $('#anggota_id').val(data.id);
    
              $('#kode_anggota').val(data.kode_anggota);
    
              $('#nama').val(data.nama);
    
              $('#jk').val(data.jk);
    
              $('#jurusan').val(data.jurusan);
    
              $('#alamat').val(data.alamat);
    
          })
    
       });
    
        
    
        $('#saveBtn').click(function (e) {
    
            e.preventDefault();
    
            $(this).html('Sending..');
    
        
    
            $.ajax({
    
              data: $('#productForm').serialize(),
    
              url: "{{ route('anggota.store') }}",
    
              type: "POST",
    
              dataType: 'json',
    
              success: function (data) {
    
         
    
                  $('#productForm').trigger("reset");
    
                  $('#ajaxModel').modal('hide');
    
                  table.draw();
    
             
    
              },
    
              error: function (data) {
    
                  console.log('Error:', data);
    
                  $('#saveBtn').html('Save Changes');
    
              }
    
          });
    
        });
    
        
    
        $('body').on('click', '.deleteProduct', function () {
    
            var anggota_id = $(this).data("id");
            var del=confirm("Are you sure you want to delete this record?");
            if (del==true){
                $.ajax({
    
                    type: "DELETE",
        
                    url: "{{ route('anggota.store') }}"+'/'+anggota_id,
        
                    success: function (data) {
        
                        table.draw();
        
                    },
        
                    error: function (data) {
        
                        console.log('Error:', data);
        
                    }
        
                });
                alert ("record deleted")
            }else{
                alert("Record Not Deleted")
            }
            return del;
        });
    
         
    
      });
    
    </script> 
    @endsection

</body>
</html>
