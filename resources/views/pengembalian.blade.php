@extends('layouts.backend')
    
@section('content')
<!-- Main content -->
<div class="container">
        
    <a class="btn btn-dark btn-sm" href="javascript:void(0)" id="createNewProduct">
         Create New
    </a>
    <br/>
    <br/>
    <table class="table table-bordered data-table">

        <thead class="thead-dark">

            <tr>

                <th width="10px">No</th>
                <th width="5px">Kode Kembali</th>
                <th>Kode Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Jatuh Tempo</th>
                <th>Denda per Hari</th>
                <th>Jumlah Hari</th>
                <th>Total Denda</th>
                <th>Nama Petugas</th>
                <th>Nama Anggota</th>
                <th>Nama Buku</th>
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

                   <input type="hidden" name="pengembalian_id" id="pengembalian_id">

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Kode Kembali</label>

                        <div class="col-sm-12">

                            <input type="text" class="form-control" id="kode_kembali" name="kode_kembali" placeholder="Masukkan Kode Petugas" value="" maxlength="50" required="">

                        </div>

                    </div>

                    <div class="form-group">

                            <label for="name" class="col-sm-2 control-label">Kode Pinjam</label>
    
                            <div class="col-sm-12">
    
                                <select type="text" class="form-control select2 isi-pinjam" id="kode_pinjam" name="kode_pinjam" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                </select>
                            </div>
    
                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Tanggal Kembali</label>

                        <div class="col-sm-12">

                            <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali">

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Jatuh Tempo</label>

                        <div class="col-sm-12">

                                <input type="date" name="jatuh_tempo" class="form-control" id="jatuh_tempo">
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
            kode_kembali:{
                required: true,
                maxlength: 4
            }
        },
        messages:{
            kode_kembali:{
                required:"Harap diisi",
                maxlength : "Tidak bisa lebih dari 4"
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

      ajax: "{{ url('pengembalian') }}",

      columns: [

          {data: 'DT_RowIndex', name: 'DT_RowIndex'},

          {data: 'kode_kembali', name: 'kode_kembali'},

          {data: 'peminjaman.kode_pinjam', name: 'kode_pinjam'},

          {data: 'tanggal_kembali', name: 'tanggal_kembali'},

          {data: 'jatuh_tempo', name: 'jatuh_tempo'},

          {data: 'denda_per_hari', name: 'denda_per_hari'},
          
          {data: 'jumlah_hari', name: 'jumlah_hari'},

          {data: 'total_denda', name: 'total_denda'},

          {data: 'petugas.nama', name: 'nama'},

          {data: 'anggota.nama', name: 'nama'},

          {data: 'buku.judul', name: 'judul'},

          {data: 'action', name: 'action', orderable: false, searchable: false},
          

      ]

  });

  $.ajax({
    url: "{{ url('peminjaman') }}",
    method: "GET",
    dataType: "json",
    
    success: function (berhasil) {
        // console.log(berhasil)
        $.each(berhasil.data, function (key, value) {
            $(".isi-pinjam").append(
                `
                <option value="${value.id}">
                    ${value.kode_pinjam}
                </option>        
                `
            )
        }) 
    }
})

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

      $('#pengembalian_id').val('');

      $('#productForm').trigger("reset");

      $('#modelHeading').html("Create New");

      $('#ajaxModel').modal('show');

  });

  

  $('body').on('click', '.editProduct', function () {

    var pengembalian_id = $(this).data('id');

    $.get("{{ url('pengembalian') }}" +'/' + pengembalian_id +'/edit', function (data) {

        $('#modelHeading').html("Edit Product");

        $('#saveBtn').val("edit-user");

        $('#ajaxModel').modal('show');

        $('#pengembalian_id').val(data.id);

        $('#kode_kembali').val(data.kode_kembali);

        $('#tanggal_kembali').val(data.tanggal_kembali);

        $('#jatuh_tempo').val(data.jatuh_tempo);

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

        url: "{{ url('pengembalian-store') }}",

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

      var pengembalian_id = $(this).data("id");
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
    
                url: "{{ url('pengembalian-destroy') }}"+'/'+pengembalian_id,
    
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
