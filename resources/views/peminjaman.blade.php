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
                            {{ $error }}
                        @endforeach
                    </ul>
                </div>

                <form id="productForm" name="productForm" class="form-horizontal">

                   <input type="hidden" name="peminjaman_id" id="peminjaman_id">

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Kode Peminjaman</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="kode_pinjam" name="kode_pinjam" placeholder="Masukkan Kode Petugas" value="" maxlength="50" required="">

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Petugas</label>

                        <div class="col-sm-10">
                            <input type="hidden" name="kode_petugas" class="p">
                            <select style="width: 100%;" type="text" class="form-control select2 isi-petugas" id="kode_petugas" name="kode_petugas" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                            </select>
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Anggota</label>

                        <div class="col-sm-10">
                                <input type="hidden" name="kode_anggota" class="a">
                                <select style="width: 100%;" type="text" class="form-control select2 isi-anggota" id="kode_anggota" name="kode_anggota" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                </select>
                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-2 control-label">Nama Buku</label>

                        <div class="col-sm-10">
                                <input type="hidden" name="kode_buku" class="b">
                            <select style="width: 100%;" type="text" class="form-control select2 isi-buku" id="kode_buku" name="kode_buku" placeholder="Masukkan Jabatan Petugas" value="" maxlength="50" required="">
                            </select>
                        </div>

                    </div>

                    <div class="form-group">

                            <label for="name" class="col-sm-2 control-label">Tanggal Peminjaman</label>
    
                            <div class="col-sm-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right datepicker" required="" id="tanggal_pinjam" name="tanggal_pinjam">
                                    </div>
                            </div>
    
                    </div>

                    <div class="form-group">

                            <label class="col-sm-2 control-label">Tanggal Pengembalian</label>
    
                            <div class="col-sm-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                  <i class="fa fa-calendar"></i>
                                                </div>
                                                <input style="width: 100%;" type="text" class="form-control pull-right datepicker" required="" id="tanggal_kembali" name="tanggal_kembali">
                                            </div>
    
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

<script>
    
    $("#productForm").validate({
        rules: {
            kode_pinjam:{
                required: true,
                maxlength: 4
            }
        },
        messages:{
            kode_pinjam:{
                required:"Harap diisi",
                maxlength : "Tidak bisa lebih dari 4"
            }
        }
    });

    $('#ajaxModel').on('shown.bs.modal',function(){
        $('.tgl').datepicker({
                zIndex: 999999,
                format: 'dd-mm-yyyy',
                autoclose: true,
                changeMonth: true,
                changeYear: true,
        });

        $(document).ready(function(){
            $('.tgl').on("cut paste",function(e) {
            e.preventDefault();
            });
        });

        $('.tgl').keydown(function(e) {
            if (e.keyCode === 8 || e.keyCode === 46) {
            return false;
            }
        });

        $('.tgl').keypress(function(e) {
            return false
        });
    });
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

      ajax: "{{ url('peminjaman') }}",

      columns: [

          {data: 'DT_RowIndex', name: 'DT_RowIndex'},

          {data: 'kode_pinjam', name: 'kode_pinjam'},

          {data: 'nama_petugas', name: 'kode_petugas'},

          {data: 'nama_anggota', name: 'kode_anggota'},

          {data: 'judul', name: 'kode_buku'},

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
      $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
      
      $('#ajaxModel').modal('show');
      $('.alert-danger').html('');
      $('.alert-danger').css('display','none');
      $("input").keypress(function(){
          $('.alert-danger').css('display','none');
      });
  });

  

  $('body').on('click', '.editProduct', function () {

    var peminjaman_id = $(this).data('id');
        $.get("{{ url('peminjaman') }}" +'/' + peminjaman_id +'/edit', function (data) {
            $.each(data,function(key, value){
                console.log(value);
            $('#modelHeading').html("Edit Peminjaman");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
            $('#ajaxModel').modal('show');
            $('#peminjaman_id').val(value.id);
            $('#kode_pinjam').val(value.kode_pinjam);
            $('#tanggal_pinjam').val(value.tanggal_pinjam);
            $('#tanggal_kembali').val(value.tanggal_kembali);
            $('#kode_petugas').val(value.nama_petugas);
            $('#kode_anggota').val(value.nama_anggota);
            $('#kode_buku').val(value.judul);
            $('.p').val(value.id_petugas);
            $('.a').val(value.id_anggota);
            $('.b').val(value.id_buku);
            $('.alert-danger').html('');
            $('.alert-danger').css('display','none');
            });
        })
    });

  

  $('#saveBtn').click(function (e) {

      e.preventDefault();

      $(this).html('Simpan');

  

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