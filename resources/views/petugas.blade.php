    @extends('layouts.backend')
    
    @section('content')
    <!-- Main content -->
    <div class="container">
            
        <a class="btn btn-dark btn-sm" href="javascript:void(0)" id="createNewProduct">
             Create New
        </a>
        <br/>
        <br/>
        <table class="table table-bordered data-table" width="100%">

            <thead class="thead-dark">
    
                <tr>
    
                    <th width="10px">No</th>
    
                    <th width="20px">Kode Petugas</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jabatan</th>
                    <th>Telepon</th>
                    <th width="180px">Alamat</th>
                    <th width="75px">Aksi</th>
    
                </tr>
    
            </thead>
    
            <tbody>
    
            </tbody>
    
        </table>
    
    </div>
    
       
    
    <div class="modal fade" id="ajaxModel" aria-hidden="true">

        <div class="modal-dialog">
    
            <div class="modal-content bg-dark">
    
                <div class="modal-header">
    
                    <h4 class="modal-title" id="modelHeading"></h4>
    
                </div>
    
                <div class="modal-body">
    
                    <form id="productForm" name="productForm" class="form-horizontal">
    
                       <input type="hidden" name="petugas_id" id="petugas_id">
    
                        <div class="form-group">
    
                            <label for="name" class="col-sm-2 control-label">Kode Petugas</label>
    
                            <div class="col-sm-12">
    
                                <input type="text" class="form-control" id="kode_petugas" name="kode_petugas" placeholder="Masukkan Kode Petugas" value="" maxlength="50" required="">
    
                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                            <label for="name" class="col-sm-2 control-label">Nama</label>
    
                            <div class="col-sm-12">
    
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
    
                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                            <label for="name" class="col-sm-2 control-label">Jenis Kelamin</label>
    
                            <div class="col-sm-12">
    
                                <select id="jk" class="form-control" placeholder="Pilih Jenis Kelamin" name="jk">
                                    <option value="Laki - Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
        
                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                            <label for="name" class="col-sm-2 control-label">Jabatan</label>
    
                            <div class="col-sm-12">
    
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Jabatan Petugas" value="" maxlength="50" required="">
    
                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                                <label for="name" class="col-sm-2 control-label">Telepon</label>
        
                                <div class="col-sm-12">
        
                                    <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan Telepon Petugas" value="" maxlength="50" required="">
        
                                </div>
        
                        </div>
    
                        <div class="form-group">
    
                                <label class="col-sm-2 control-label">Alamat</label>
        
                                <div class="col-sm-12">
        
                                    <textarea id="alamat" name="alamat" required="" placeholder="Masukkan Alamat" class="form-control"></textarea>
        
                                </div>
        
                        </div>
          
    
                        <div class="col-sm-offset-2 col-sm-10">
    
                         <button type="submit" class="btn btn-outline-primary btn-flat" id="saveBtn" value="create"><ion-icon name="paper-plane"></ion-icon> Save changes
    
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
  
          ajax: "{{ url('petugas') }}",
  
          columns: [
  
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
  
              {data: 'kode_petugas', name: 'kode_petugas'},
  
              {data: 'nama', name: 'nama'},
  
              {data: 'jk', name: 'jk'},
  
              {data: 'jabatan', name: 'jabatan'},
  
              {data: 'telepon', name: 'telepon'},
  
              {data: 'alamat', name: 'alamat'},
  
              {data: 'action', name: 'action', orderable: false, searchable: false},
              
  
          ]
  
      });
  
       
  
      $('#createNewProduct').click(function () {
  
          $('#saveBtn').val("create-product");
  
          $('#petugas_id').val('');
  
          $('#productForm').trigger("reset");
  
          $('#modelHeading').html("Create New");
  
          $('#ajaxModel').modal('show');
  
      });
  
      
  
      $('body').on('click', '.editProduct', function () {
  
        var petugas_id = $(this).data('id');
  
        $.get("{{ url('petugas') }}" +'/' + petugas_id +'/edit', function (data) {
  
            $('#modelHeading').html("Edit Product");
  
            $('#saveBtn').val("edit-user");
  
            $('#ajaxModel').modal('show');
  
            $('#petugas_id').val(data.id);
  
            $('#kode_petugas').val(data.kode_petugas);
  
            $('#nama').val(data.nama);
  
            $('#jk').val(data.jk);
  
            $('#jabatan').val(data.jabatan);
  
            $('#telepon').val(data.telepon);
  
            $('#alamat').val(data.alamat);
  
        })
  
     });
  
      
  
      $('#saveBtn').click(function (e) {
  
          e.preventDefault();
  
          $(this).html('Save Changes');
  
      
  
          $.ajax({
  
            data: $('#productForm').serialize(),
  
            url: "{{ url('petugas-store') }}",
  
            type: "POST",
  
            dataType: 'json',
  
            success: function (data) {
  
       
  
                $('#productForm').trigger("reset");
  
                $('#ajaxModel').modal('hide');
  
                table.draw();
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    animation: false,
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000,
                    customClass: {
                        popup: 'animated bounceOut'
                      }
                  })
  
           
  
            },
  
            error: function (data) {
  
                console.log('Error:', data);
  
                $('#saveBtn').html('Save Changes');
  
            }
  
        });
  
      });
  
      
  
      $('body').on('click', '.deletePetugas', function () {
  
          var petugas_id = $(this).data("id");
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
                $.ajax({

                    type: "DELETE",
        
                    url: "{{ url('petugas-destroy') }}"+'/'+petugas_id,
        
                    success: function (data) {
        
                        table.draw();
        
                    },
        
                    error: function (data) {
        
                        console.log('Error:', data);
        
                    }
        
                });
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
            }
          })
      });
  
       
  
    });
  
</script>
   @endsection
</body>
</html>
