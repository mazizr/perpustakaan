@extends('layouts.backend-baru')

@section('content')
<!-- Main content -->
<div class="box box-widget">
        <div class="box-header with-border">
          <div class="user-block">
                <br/>
                <a class="btn btn-primary btn-flat btn-sm" href="javascript:void(0)" id="createNewProduct">
                        Create New
                </a>
                <br/>
                <br/>
          </div>
          <!-- /.user-block -->
          <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                <table class="table table-bordered data-table" width="100%">

                        <thead class="thead-dark bg-primary">
                    
                            <tr>
                    
                                <th>No</th>
                                <th>Kode Rak</th>
                                <th>Nama Rak</th>
                                <th>Judul Buku</th>
                                <th>Aksi</th>
                    
                            </tr>
                    
                        </thead>
                    
                        <tbody>
                    
                        </tbody>
                    
                </table> 
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer -->
      </div>
   

<div class="modal fade" id="ajaxModel" aria-hidden="true">

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title" id="modelHeading"></h4>
            <button type="button" class="close" data-dismiss="modal"><ion-icon name="close-circle"></ion-icon></button>
        </div>

        <div class="modal-body">
            <div class="alert alert-danger" style="display:none">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>  
            <form id="productForm" name="productForm" class="form-horizontal">

                <input type="hidden" name="rak_id" id="rak_id">
                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Rak</label>

                    <div class="col-sm-10">

                        <input type="text" class="form-control" id="kode_rak" name="kode_rak" placeholder="Masukkan Kode Rak" value="" maxlength="50" required="">
                        
                    </div>
                    

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Nama Rak</label>

                    <div class="col-sm-10">

                        <input type="text" class="form-control" id="nama_rak" name="nama_rak" placeholder="Masukkan Nama Rak" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Judul Buku</label>

                    <div class="col-sm-10">

                          <select id="buku" class="form-control buku select2" multiple="multiple"
                           name="buku[]" style="width: 100%;"></select>
        
                    </div>

                </div>

            </form>
        </div>
        <div class="modal-footer">
    
                <button data-dismiss="modal" type="button" class="btn btn-default btn-flat pull-left" id="reset">Batal
                </button>

                <button align="right" type="submit" class="btn btn-primary btn-flat" id="saveBtn" value="create">Simpan
                </button>

        </div>
    </div>

</div>

</div>

<!-- /.content -->
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">

  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    $('.select2').select2({
        placeholder: "Pilih Judul Buku",
        maximumSelectionLength: 4,
        tags: true
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('rak') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'kode_rak', name: 'kode_rak'},
            {data: 'nama_rak', name: 'nama_rak'},
            { data: 'buku[].judul', render :  function(judul){
                return `${judul}`;
                }
            },
            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });
     

    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#rak_id').val('');
        $('#productForm').trigger("reset");
        $('#buku').val('').trigger('change');
        $('#modelHeading').html("Create New");
        $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
        $('#ajaxModel').modal('show');
        $('.alert-danger').html('');
        $('.alert-danger').css('display','none');
        $("input").keypress(function(){
            $('.alert-danger').css('display','none');
        });
    });
    
    $.ajax({
        url: "{{ url('buku') }}",
        method: "GET",
        dataType: "json",      
        success: function (berhasil) {
            // console.log(berhasil)
            $.each(berhasil.data, function (key, value) {
                $(".buku").append(
                    `
                    <option value="${value.id}">
                        ${value.judul}
                    </option>        
                    `
                )
            }) 
        }
    })

    $('body').on('click', '.editProduct', function () {
      var rak_id = $(this).data('id');
      $.get("{{ url('rak') }}" +'/' + rak_id +'/edit', function (data) {
            $('#modelHeading').html("Edit Product");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
            $('#ajaxModel').modal('show');
            $('#rak_id').val(data.rak.id);
            $('#kode_rak').val(data.rak.kode_rak);
            $('#nama_rak').val(data.rak.nama_rak);
            $('#buku').html('');
            $('#buku').html(data.buku);
            $('.alert-danger').html('');
            $('.alert-danger').css('display','none');
            $("input").keypress(function(){
                $('.alert-danger').css('display','none');
            });
            

      })

   });

    

   $('#saveBtn').click(function (e) {
    var formData    = new FormData($('#productForm')[0]);
    e.preventDefault();
    $(this).html('Menyimpan..');

    $.ajax({
      data: formData,
      url: "{{ url('rak-store') }}",
      type: "POST",
      cache: true,
        contentType: false,
        processData: false,
        async:false,

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

    

    $('body').on('click', '.deleteRak', function () {
  
        var rak_id = $(this).data("id");

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
        
                    url: "{{ url('rak-destroy') }}"+'/'+rak_id,
        
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
