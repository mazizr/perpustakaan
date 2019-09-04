@extends('layouts.backend')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@endsection

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
            <th>Kode Rak</th>
            <th>Nama Rak</th>
            <th>Kode Buku</th>
            <th>Action</th>

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

                            <button align="right" type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                </button>    

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Rak</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="kode_rak" name="kode_rak" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Nama Rak</label>

                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="nama_rak" name="nama_rak" placeholder="Enter Name Category" value="" maxlength="50" required="">

                    </div>

                </div>

                <div class="form-group">

                    <label for="name" class="col-sm-2 control-label">Kode Buku</label>

                    <div class="col-sm-12">

                            <select id="kode_buku" class="form-control isi-tag" name="kode_buku">
        
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
            $("#e1").select2();
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

        ajax: "{{ route('rak.index') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'kode_rak', name: 'kode_rak'},

            {data: 'nama_rak', name: 'nama_rak'},

            {data: 'buku.kode_buku', name: 'kode_buku'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

    $.ajax({
        url: "{{ route('buku.index') }}",
        method: "GET",
        dataType: "json",
        
        success: function (berhasil) {
            // console.log(berhasil)
            $.each(berhasil.data, function (key, value) {
                $(".isi-tag").append(
                    `
                    <option value="${value.id}">
                        ${value.kode_buku}
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

      $.get("{{ route('rak.index') }}" +'/' + rak_id +'/edit', function (data) {

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

        e.preventDefault();

        $(this).html('Sending..');

    

        $.ajax({

          data: $('#productForm').serialize(),

          url: "{{ route('rak.store') }}",

          type: "POST",

          dataType: 'json',

          success: function (data) {

     

              $('#productForm').trigger("reset");

              $('#ajaxModel').modal('hide');

              table.draw();

              Swal.fire(
                'Success!',
                'Your file has been added.',
                'success'
              )

         

          },

          error: function (data) {

              console.log('Error:', data);

              $('#saveBtn').html('Save Changes');

          }

      });

    });

    

    $('body').on('click', '.deleteProduct', function () {
  
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
        
                    url: "{{ route('rak.store') }}"+'/'+rak_id,
        
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
