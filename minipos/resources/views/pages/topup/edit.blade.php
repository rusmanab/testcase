@extends('layouts.main')
@section('css')

<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.css">
  <!-- BS Stepper -->
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Topup Saldo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Topup</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form id="formTopup" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Topup </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Jumlah Topup Sebelum Koreksi</h3>
                                    <hr/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Driver</label>
                                        <div class="bg-gray py-2 px-3">
                                            <h1 class="mb-0 text-left" id="infoDriver">
                                                {{$driverTopup->nama_lengkap}}
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Topup</label>
                                        <div class="bg-gray py-2 px-3">
                                            <h1 class="mb-0 text-right" id="infoJumlah">
                                                {{$driverTopup->jumlah_topup}}
                                            </h1>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Jumlah Topup di Koreksi</h3>
                                    <hr/>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="saldoId" value="{{$driverTopup->id}}" />
                                    <div class="form-group">
                                        <label>Jumlah Topup</label>
                                        <input type="text" id="jumlah_topup" name="jumlah_topup" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan</label>
                                        <textarea class="form-control" name="note"></textarea>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="bg-gray py-2 px-3 mt-4">
                                            <h1 class="mb-0 text-right" id="newJumlah">
                                                0
                                            </h1>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <!-- /.card -->
            </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('javascript')
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>


<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>

<script src="{{asset('assets/template/adminlte')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/inputmask/jquery.inputmask.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){



    $("#infoJumlah, #jumlah_topup").inputmask(
        { alias : "currency", prefix: '',digits: 0, groupSeparator: ",",});
    $("#jumlah_topup").on("keyup", function(e){
        let jumlah_topup = $("#jumlah_topup").val();
        $("#newJumlah").text(jumlah_topup);
    });
    $('#formTopup').on('submit',function(event){
        event.preventDefault();
        let oldNominal  = $("#infoJumlah").text();
        let newNominal  = $("#jumlah_topup").val();
        Swal.fire({
            title: 'Kamu yakin ?',
            text: "Koreksi saldo " + oldNominal + ", menjadi " + newNominal,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjut!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {

                var postUrl = "{{ route('topup.submitkoreksi') }}";

                let dataForm = new FormData( document.getElementById("formTopup") );

                $.ajax({
                    url: postUrl,
                    type:"POST",
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        let tipe = "error";
                        let title = "Perhatian!"
                        if ( response.success ){
                            tipe = "success";
                        }
                        Swal.fire(
                            title,
                            response.message,
                            tipe
                        );
                    },
                    beforeSend: function() {
                        $("#loadingProgress").show();
                    },
                    complete: function() {
                        $("#loadingProgress").hide();
                    }
                })
            }
        })
    })
})
</script>
@endsection
