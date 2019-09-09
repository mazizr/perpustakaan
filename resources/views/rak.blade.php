@extends('layouts.backend')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@endsection

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

    <div class="modal-content bg-dark">

        <div class="modal-header">

            <h4 class="modal-title" id="modelHeading"></h4>

        </div>

        <div class="modal-body">

            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="rak_id" id="rak_id">

               <div class="form-group">

                <div class="col-sm-12">

                        <button align="right" type="submit" class="btn btn-outline-primary btn-flat" id="saveBtn" value="create">Save changes
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

                    <label for="name" class="col-sm-2 control-label">Kode Buku</label>

                    <div class="col-sm-12">

                        <select id="kode_buku" class="form-control js-example-basic-single isi-tag" name="kode_buku">
                          </select>
        
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
    $(document).ready(function() {
        placeholder: 'Pilih Judul Buku'
        $('.js-example-basic-single').select2();
    });
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

        ajax: "{{ url('rak') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'kode_rak', name: 'kode_rak'},

            {data: 'nama_rak', name: 'nama_rak'},

            {data: 'buku.judul', name: 'judul', searchable: true},

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
                $(".isi-tag").append(
                    `
                    <option value="${value.id}">
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

          $('#kode_buku').val(data.kode_buku);

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
