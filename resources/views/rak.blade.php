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

<div class="modal-dialog">

    <div class="modal-content">

        <div class="modal-header">

            <h4 class="modal-title" id="modelHeading"></h4>

        </div>

        <div class="modal-body">

            <form id="productForm" name="productForm" class="form-horizontal">

               <input type="hidden" name="rak_id" id="rak_id">

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

                        <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Enter Name Category" value="" maxlength="50" required="">

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

        ajax: "{{ route('rak.index') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'kode_rak', name: 'kode_rak'},

            {data: 'nama_rak', name: 'nama_rak'},

            {data: 'kode_rak', name: 'kode_rak'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

     

    $('#createNewProduct').click(function () {

        $('#saveBtn').val("create-product");

        $('#rak_id').val('');

        $('#productForm').trigger("reset");

        $('#modelHeading').html("Create New Product");

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

         

          },

          error: function (data) {

              console.log('Error:', data);

              $('#saveBtn').html('Save Changes');

          }

      });

    });

    

    $('body').on('click', '.deleteProduct', function () {

     

        var rak_id = $(this).data("id");

        confirm("Are You sure want to delete !");

      

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

    });

     

  });

</script>
@endsection
</body>
</html>
