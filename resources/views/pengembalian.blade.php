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
                <table class="table table-bordered data-table" style="width: 100%;">

                        <thead class="thead-dark bg-primary">
                
                            <tr>
                
                                <th width="10px">No</th>
                                <th width="5px">Kode Kembali</th>
                                <th>Kode Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Jatuh Tempo</th>
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

                   <input type="hidden" name="pengembalian_id" id="pengembalian_id">

                    <div class="form-group">

                        <label for="name" class="control-label">Kode Kembali</label>

                        <div class="col-sm-10">

                            <input type="text" class="form-control" id="kode_kembali" name="kode_kembali" placeholder="Masukkan Kode Petugas" value="" maxlength="50" required="">

                        </div>

                    </div>

                    <div class="form-group">

                            <label for="name" class="control-label">Kode Pinjam</label>
    
                            <div class="col-sm-10">
    
                                <select type="text" class="form-control isi-pinjam" id="kode_pinjam" name="kode_pinjam" placeholder="Masukkan Nama Petugas" value="" maxlength="50" required="">
                                </select>

                            </div>
    
                    </div>

                    <div class="form-group">

                        <label for="name" class="control-label">Tanggal Kembali</label>

                                <div class="col-sm-10">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right datepicker" required="" id="tanggal_kembali" name="tanggal_kembali">
                                        </div>
                                </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="control-label">Jatuh Tempo</label>

                        <div class="col-sm-10">
                                <input type="hidden" name="jatuh_tempo" id="isi_jatuh_tempo">
                                <input type="text" placeholder="Nama Anggota" class="form-control datepicker" id="jatuh_tempo" disabled>
                        </div>

                    </div>

                    <div class="form-group">

                            <label for="name" class="control-label">Nama Petugas</label>
    
                            <div class="col-sm-10">
                                    <input type="hidden" name="kode_petugas" id="isi_kode_petugas">
                                    <input type="text" placeholder="Nama Anggota" class="form-control" id="kode_petugas" disabled>
                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                            <label for="name" class="control-label">Nama Anggota</label>
    
                            <div class="col-sm-10">
                                    <input type="hidden" name="kode_anggota" id="isi_kode_anggota">
                                    <input type="text" class="form-control" id="kode_anggota" placeholder="Nama Anggota" value="" disabled>

                            </div>
    
                        </div>
    
                        <div class="form-group">
    
                            <label for="name" class="control-label">Nama Buku</label>
    
                            <div class="col-sm-10">
                                    <input type="text" placeholder="Nama Anggota" class="form-control" id="kode_buku" disabled>
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
          {data: 'kode_pinjam', name: 'kode_pinjam'},
          {data: 'tanggal_kembali', name: 'tanggal_kembali'},
          {data: 'jatuh_tempo', name: 'jatuh_tempo'},
          {data: 'jumlah_hari', name: 'jumlah_hari'},
          {data: 'total_denda', name: 'total_denda'},
          {data: 'nama_petugas', name: 'nama'},
          {data: 'nama_anggota', name: 'nama'},
          { data: 'buku', name: 'buku' },
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

   $('#kode_pinjam').on('change', function(){
        var kode_pinjam = $(this).val();
        $.ajax({
            url: "pengembalian-isi/"+kode_pinjam,
            method: "GET",
            dataType: "json",
            success: function (berhasil) {
                $.each(berhasil.datapeminjaman, function(key, value){
                    
                    $('#kode_anggota').val(value.nama_anggota);
                    $('#kode_petugas').val(value.nama_petugas);
                    
                    $('#jatuh_tempo').val(value.tanggal_kembali);
                    $('#isi_kode_anggota').val(value.id_anggota);
                    $('#isi_kode_petugas').val(value.id_petugas);
                    
                    $('#isi_jatuh_tempo').val(value.tanggal_kembali);
                });
                console.log(berhasil.buku);
                $('#kode_buku').val(berhasil.buku);
            }
        })
   });

  $('#createNewProduct').click(function () {
      $('#saveBtn').val("create-product");
      $('#pengembalian_id').val('');
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

    var pengembalian_id = $(this).data('id');

    $.get("{{ url('pengembalian') }}" +'/' + pengembalian_id +'/edit', function (data) {
        //console.log(data);
        $('#modelHeading').html("Edit Product");
        $('#saveBtn').val("edit-user");
        $('#ajaxModel').modal({backdrop: 'static', keyboard: false});
        $('#ajaxModel').modal('show');
        $('#pengembalian_id').val(data.datapengembalian.id);
        $('#kode_pinjam').val(data.datapengembalian.kode_pinjam);
        $('#kode_kembali').val(data.datapengembalian.kode_kembali);
        $('#isi_jatuh_tempo').val(data.datapengembalian.jatuh_tempo);
        $.each(data.peminjaman, function(key, value){
            
            $('#kode_petugas').val(value.nama_petugas);
            $('#kode_anggota').val(value.nama_anggota);
            $('#isi_kode_anggota').val(value.id_anggota);
            $('#isi_kode_petugas').val(value.id_petugas);
            $('#jatuh_tempo').val(value.jatuh_tempo);
            $('#tanggal_kembali').val(value.tanggal_kembali);
        });
        console.log(data)
        $('#kode_buku').val(data.buku);
        $('.alert-danger').html('');
        $('.alert-danger').css('display','none');
        $("input").keypress(function(){
            $('.alert-danger').css('display','none');
        });
        
    })

 });

  

  $('#saveBtn').click(function (e) {
      e.preventDefault();
      $(this).html('Simpan');
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
