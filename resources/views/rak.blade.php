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

   

<div class="modal fade" id="ajaxModel" aria-hidden="true">

<div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title" id="modelHeading"></h4>

        </div>

        <div class="modal-body">

            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="rak_id" id="rak_id">

               <div class="form-group">

                <div class="col-sm-12">

                        <button align="right" type="submit" class="btn btn-outline-primary btn-flat" id="saveBtn" value="create"><ion-icon name="paper-plane"></ion-icon> Save changes
                            </button>    

                </div>

            </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Rak</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="kode_rak" name="kode_rak" placeholder="Masukkan Kode Rak" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Nama Rak</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="nama_rak" name="nama_rak" placeholder="Masukkan Nama Rak" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Judul Buku</label>

                    <div class="col-sm-12">

                          <select id="buku" class="form-control buku select2" multiple="multiple" data-placeholder="Select a State"
                          style="width: 100%;" name="buku[]">
        
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

<!-- /.content -->
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script>
    $("#productForm").validate({
        rules: {
            kode_rak:{
                required: true,
                maxlength: 4
            },
            nama_rak: {
                required:true
            }
        },
        messages:{
            kode_rak:{
                required:"Harap diisi",
                maxlength : "Tidak bisa lebih dari 4"
            },
            nama_rak:{
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

    $('.select2').select2();

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

    $.ajax({
        
        url: "{{ url('buku') }}",
        method: "GET",
        dataType: "json",
        
        success: function (berhasil) {
            // console.log(berhasil)
            $.each(berhasil.data, function (key, value) {
                $(".buku").append(
                    `
                    <option value="${value.id}" (buku_id[key]==value.id?'selected':'')>
                        ${value.judul}
                    </option>        
                    `
                )
            }) 
        }
    })
     

    $('#createNewProduct').click(function () {

        $('#saveBtn').val("create-product");

        $('#rak_id').val('');

        $('#productForm').trigger("reset");

        $('#modelHeading').html("Create New");

        $('#ajaxModel').modal('show');

    });
    

    $('body').on('click', '.editProduct', function () {

      var rak_id = $(this).data('id');

      $.get("{{ url('rak') }}" +'/' + rak_id +'/edit', function (data) {

          $('#modelHeading').html("Edit Product");

          $('#saveBtn').val("edit-user");

          $('#ajaxModel').modal('show');

          $('#rak_id').val(data.id);

          $('#kode_rak').val(data.kode_rak);

          $('#nama_rak').val(data.nama_rak);

            $('#buku').select2(data.buku.judul);

          
        

      })

   });

    

    $('#saveBtn').click(function (e) {

        var formData    = new FormData($('#productForm')[0]);

        e.preventDefault();

        $(this).html('Sending..');

    

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

          error: function (data) {

              console.log('Error:', data);

              $('#saveBtn').html('Save Changes');

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
