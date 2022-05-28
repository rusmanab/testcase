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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Driver</label>
                                        <select class="form-control select2" name="member_id" id="memberId" required>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Topup</label>
                                        <input type="text" id="jumlah_topup" name="jumlah_topup" class="form-control" required />
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="bg-gray py-2 px-3 mt-4">
                                            <h1 class="mb-0 text-right" id="infoJumlah">
                                                0
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
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
        <div class="row">
          <div class="col-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">List Topup </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="token"></div>
                    <div id="msg"></div>
                    <div id="notis"></div>
                    <div id="err"></div>

                    <table class="table table-bordered" id="list-table">
                        <thead>

                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">No Transaksi</th>
                                <th class="text-center">Nama Lengkap</th>
                                <th class="text-center">Jumlah Topup</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center" width="280px">Action</th>
                            </tr>
                        </thead>

                    </table>

                </div>
                <!-- /.card-body -->
              </div>
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

    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:  {
            "url": "{{ route('topup.listtopup') }}",
            "type": "POST",
            "data": { "_token": "{{ csrf_token() }}", }
        },
        "columnDefs": [
            { "width": "10%", "targets": [4,6] },
            { "width": "5%", "targets": 0 },
            { className: "text-center", "targets": [ 0,4, 6 ] }
        ],
        order: [[ 0, "DESC" ]],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'notransaksi', name: 'notransaksi'},
            {data: 'nama_lengkap', name: 'nama_lengkap'},
            {data: 'jumlahTopup', name: 'jumlahTopup'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'aksi', name: 'aksi'},
        ]
    });

    $("#jumlah_topup").inputmask(
        { alias : "currency", prefix: '',digits: 0, groupSeparator: ",",});
    $("#jumlah_topup").on("keyup", function(e){
        let jumlah_topup = $("#jumlah_topup").val();
        $("#infoJumlah").text(jumlah_topup);

    });
    $("#memberId").select2({
        minimumInputLength: 1,
        allowClear: true,
        placeholder: 'Masukan nama driver',
        ajax: {
            type: "post",
            dataType: 'json',
            url: "{{ route('members.getdriver') }}",
            delay: 800,
            data: function(params) {
                return {
                    search: params.term,
                    "_token": "{{ csrf_token() }}",
                }
            },
            processResults: function (data, page) {
                return {
                    results: data
                };
            },
        }
    });
    $('#formTopup').on('submit',function(event){
        event.preventDefault();
        let nominal = $("#jumlah_topup").val();
        Swal.fire({
            title: 'Kamu yakin ?',
            text: "Driver topup dengan nominal " + nominal,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjut!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {

                var postUrl = "{{ route('topup.member') }}";

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
