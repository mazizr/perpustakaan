@extends('layouts.backend')

@section('content')
<!-- Main content -->
<div class="container">

    <a class="btn btn-dark btn-sm" href="javascript:void(0)" id="createNewProduct"> Create New</a>
    <br/>
    <br/>
    <table class="table table-bordered data-table" width="100%">

    <thead class="thead-dark">

        <tr>

            <th>No</th>

            <th>Kode Anggota</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Jurusan</th>
            <th width="280px">Alamat</th>
            <th width="75px">Aksi</th>

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

            @if ($errors->any())
            <div class="toastrDefaultError">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="anggota_id" id="anggota_id">

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Anggota</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control @error('kode_anggota') is-invalid @enderror" 
                        id="kode_anggota" name="kode_anggota" placeholder="Masukkan Kode Anggota" value="" maxlength="50" required="">
                        @error('kode_anggota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                        @enderror
                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anggota" value="" maxlength="50" required="">

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

                    <label for="name" class="col-sm-2 control-label">Jurusan</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukkan Jurusan" value="" maxlength="50" required="">

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
    <script>
        $("#productForm").validate({
            rules: {
                kode_anggota: {
                    required:true,
                    maxlength : 4
                },
                nama: {
                    required:true
                },
                jurusan: {
                    required:true
                },
                alamat: {
                    required:true
                }
            },
            messages:{
                kode_anggota:{
                    required:"Harap diisi",
                    maxlength:"Tidak bisa lebih dari 4"
                },
                nama:{
                    required:"Harap diisi"
                },
                jurusan:{
                    required:"Harap diisi"
                },
                alamat:{
                    required:"Harap diisi"
                }
            }
        })
    </script>
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
    
            ajax: "{{ url('anggota') }}",
    
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
    
            $('#modelHeading').html("Create New");
    
            $('#ajaxModel').modal('show');
    
        });
    
        
    
        $('body').on('click', '.editProduct', function () {
    
          var anggota_id = $(this).data('id');
    
          $.get("{{ url('anggota') }}" +'/' + anggota_id +'/edit', function (data) {
    
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
    
              url: "{{ url('anggota-store') }}",
    
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
    
        
    
        $('body').on('click', '.deleteAnggota', function () {
    
            var anggota_id = $(this).data("id");
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
            
                        url: "{{ url('anggota-destroy') }}"+'/'+anggota_id,
            
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
