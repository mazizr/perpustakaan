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

                <th width="5px">Kode Peminjaman</th>
                <th>Nama Petugas</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
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

                   <input type="hidden" name="peminjaman_id" id="peminjaman_id">

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Kode Peminjaman</label>

                        <div class="col-sm-12">

                            <input type="text" class="form-control" id="kode_pinjam" name="kode_pinjam" placeholder="Masukkan Kode Petugas" value="" maxlength="50" required="">

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Petugas</label>

                        <div class="col-sm-12">

                            <select type="text" class="form-control select2 isi-petugas" id="kode_petugas" name="kode_petugas" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                            </select>
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Anggota</label>

                        <div class="col-sm-12">

                                <select type="text" class="form-control select2 isi-anggota" id="kode_anggota" name="kode_anggota" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                </select>
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Buku</label>

                        <div class="col-sm-12">

                            <select type="text" class="form-control select2 isi-buku" id="kode_buku" name="kode_buku" placeholder="Masukkan Jabatan Petugas" value="" maxlength="50" required="">
                            </select>
                        </div>

                    </div>

                    <div class="form-group">

                            <label for="name" class="col-sm-2 control-label">Tanggal Peminjaman</label>
    
                            <div class="col-sm-12">
    
                                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" placeholder="Masukkan Telepon Petugas" value="" maxlength="50" required="">
    
                            </div>
    
                    </div>

                    <div class="form-group">

                            <label class="col-sm-2 control-label">Tanggal Pengembalian</label>
    
                            <div class="col-sm-12">
    
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" placeholder="Masukkan Telepon Petugas" value="" maxlength="50" required="">
    
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

      $('.select2').select2();

  var table = $('.data-table').DataTable({

      processing: true,

      serverSide: true,

      ajax: "{{ url('peminjaman') }}",

      columns: [

          {data: 'DT_RowIndex', name: 'DT_RowIndex'},

          {data: 'kode_pinjam', name: 'kode_pinjam'},

          {data: 'petugas.nama', name: 'kode_petugas'},

          {data: 'anggota.nama', name: 'kode_anggota'},

          {data: 'buku.judul', name: 'kode_buku'},

          {data: 'tanggal_pinjam', name: 'tanggal_pinjam'},

          {data: 'tanggal_kembali', name: 'tanggal_kembali'},

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
            $(".isi-buku").append(
                `
                <option value="${value.id}">
                    ${value.judul}
                </option>        
                `
            )
        }) 
    }
})

$.ajax({
    url: "{{ url('petugas') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-petugas").append(
                `
                <option value="${value.id}">
                    ${value.nama}
                </option>        
                `
            )
        }) 
    }
})

$.ajax({
    url: "{{ url('anggota') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-anggota").append(
                `
                <option value="${value.id}">
                    ${value.nama}
                </option>        
                `
            )
        }) 
    }
})

   

  $('#createNewProduct').click(function () {

      $('#saveBtn').val("create-product");

      $('#peminjaman_id').val('');

      $('#productForm').trigger("reset");

      $('#modelHeading').html("Create New");

      $('#ajaxModel').modal('show');

  });

  

  $('body').on('click', '.editProduct', function () {

    var peminjaman_id = $(this).data('id');

    $.get("{{ url('peminjaman') }}" +'/' + peminjaman_id +'/edit', function (data) {

        $('#modelHeading').html("Edit Product");

        $('#saveBtn').val("edit-user");

        $('#ajaxModel').modal('show');

        $('#peminjaman_id').val(data.id);

        $('#kode_pinjam').val(data.kode_pinjam);

        $('#kode_petugas').val(data.kode_petugas);

        $('#kode_anggota').val(data.kode_anggota);

        $('#kode_buku').val(data.kode_buku);

        $('#tanggal_pinjam').val(data.tanggal_pinjam);

        $('#tanggal_kembali').val(data.tanggal_kembali);

    })

 });

  

  $('#saveBtn').click(function (e) {

      e.preventDefault();

      $(this).html('Save Changes');

  

      $.ajax({

        data: $('#productForm').serialize(),

        url: "{{ url('peminjaman-store') }}",

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

      var peminjaman_id = $(this).data("id");
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
    
                url: "{{ url('peminjaman-destroy') }}"+'/'+peminjaman_id,
    
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
