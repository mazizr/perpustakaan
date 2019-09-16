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
            <th width="90px">Alamat</th>
            <th width="75px">Aksi</th>

        </tr>

    </thead>

    <tbody>

    </tbody>

</table>

</div>

   

<div class="modal fade" id="ajaxModel" aria-hidden="true">

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title" id="modelHeading"></h4>
            <button type="button" class="close" data-dismiss="modal"><ion-icon name="close-circle"></ion-icon></button>

        </div>
        <div class="modal-body">

            <div id="result"></div>
            <div class="alert alert-danger" style="display:none">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            </div>
            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="anggota_id" id="anggota_id">

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Anggota</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control @error('kode_anggota') is-invalid @enderror" 
                        id="kode_anggota" name="kode_anggota" placeholder="Masukkan Kode Anggota" value="" maxlength="50" required="">
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

                            <div class="form-group">
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input jk" type="radio" id="customRadio1" value="Laki - Laki" name="jk">
                                      <label for="customRadio1" class="custom-control-label">Laki - Laki</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input jk" type="radio" value="Perempuan" id="customRadio2" name="jk">
                                        <label for="customRadio2" class="custom-control-label">Perempuan</label>
                                    </div>
                            </div>

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Jurusan</label>

                    <div class="col-sm-12">

                        <select class="form-control" name="jurusan" id="jurusan">
                                
                            <option selected disabled>-- Pilih Jurusan --</option>
                            <option value="RPL">RPL</option>
                            <option value="TKR">TKR</option>
                            <option value="TSM">TSM</option>
                            
                        </select>

                    </div>

                </div>

                <div class="form-group">

                        <label class="col-sm-2 control-label">Alamat</label>

                        <div class="col-sm-12">

                            <textarea id="alamat" name="alamat" required="" placeholder="Masukkan Alamat" class="form-control"></textarea>

                        </div>

                    </div>

            </form>

        </div>

        <div class="modal-footer">
            <button data-dismiss="modal" type="button" class="btn btn-outline-danger btn-flat" id="reset">Batal
            </button>

            <button align="right" type="submit" class="btn btn-outline-primary btn-flat" id="saveBtn" value="create">Simpan
            </button>

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
            $('#saveBtn').html("Simpan");
            $('#anggota_id').val('');
            $('#productForm').trigger("reset");
            $('#modelHeading').html("Create New");
            $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
            $('#ajaxModel').modal('show');
            $('.alert-danger').html('');
            $('.alert-danger').css('display','none');
            $("input").keypress(function(){
                $('.alert-danger').css('display','none');
            });
        });
    
        
    
        $('body').on('click', '.editProduct', function () {
    
          var anggota_id = $(this).data('id');
    
          $.get("{{ url('anggota') }}" +'/' + anggota_id +'/edit', function (data) {
              $('#modelHeading').html("Edit Product");
              $('#saveBtn').val("edit-user");
              $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
              $('#ajaxModel').modal('show');
              $('#anggota_id').val(data.id);
              $('#kode_anggota').val(data.kode_anggota);
              $('#nama').val(data.nama);
              if(data.jk == 'Laki - Laki'){
                  $("input[name='jk'][value='Laki - Laki']").prop('checked', true);
              }else{
                $("input[name='jk'][value='Perempuan']").prop('checked', true);
              }
              $('#jurusan').val(data.jurusan);
              $('#alamat').val(data.alamat);
              $('.alert-danger').html('');
              $('.alert-danger').css('display','none');
              $("input").keypress(function(){
                  $('.alert-danger').css('display','none');
              });
          })
    
       });
    
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Menyimpan..');
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
    
              error: function (request, status, error) {
                $('.alert-danger').html('');
                json = $.parseJSON(request.responseText);
                $.each(json.errors, function(key, value){
                    $('.alert-danger').show();
                    $('.alert-danger').append('<p>'+value+'</p>');
                });
                $("#result").html('');
                $('#saveBtn').html('Simpan');
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
