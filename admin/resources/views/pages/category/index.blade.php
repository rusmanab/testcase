@extends('layouts.main')
@section('title')
Majoo :: Category
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.css">

@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>

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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List of Category </h3>
                    <div class="card-tools">
                        <a href="#" id="addCategory" class="btn btn-block bg-gradient-primary">Add Category</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered" id="list-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Created at</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>

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
    <div class="modal fade" id="modalForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal" id="formCategory" action="{{ route('category.save') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h4 class="modal-title">Category Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <input type="hidden" id="id"  name="id"/>
                            <label for="inputCategory" class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="category_name" class="form-control"  id="inputCategory" placeholder="Nama Lengkap">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>


<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>

<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){

    var table = $('#list-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('category.gettable') }}",
        "columnDefs": [
            { className: "text-center", "targets": [ 0,2 ] }
        ],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'category_name', name: 'category_name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'aksi', name: 'aksi'},
        ]
    });
    $("#addCategory").on("click", function(e){
        $("#id").val('');
        $("#inputCategory").val('');
        $("#modalForm").modal('show');

    })


    $("body").on("click",".hapusItem", function(e){
        Swal.fire({
            title: 'Delete!',
            text: "Kamu yakin hapus data ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, lanjut!',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                let id = $(this).attr('data-id');
                $.ajax({
                    url: "{{route('category.delete')}}",
                    type:"POST",
                    data:{
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                    dataType:"json",
                    success:function(response){
                        let tipe = "error";
                        if ( response.success ){
                            tipe = "success"
                        }

                        Swal.fire({
                            title: 'Hapus Data!',
                            icon: tipe,
                            text: response.message,
                            type: tipe
                        }).then(function() {
                            //window.location = "redirectURL";
                            if ( response.success ){
                                table.ajax.reload();
                            }
                        });
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
    });
    $("body").on("click",".edit", function(e){

        let id = $(this).attr('data-id');
        $.ajax({
            url: "{{route('category.getdata')}}",
            type:"POST",
            data:{
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
            dataType:"json",
            success:function(response){
                console.log(response);
                if ( response.success ){
                    let data = response.data;
                    $("#inputCategory").val(data.category_name);
                    $("#id").val(data.id);
                    $("#modalForm").modal('show');
                }else{
                    Swal.fire({
                        title: 'Edit Data!',
                        icon: error,
                        text: response.message,
                        type: tipe
                    })
                }
            },
            beforeSend: function() {
                $("#loadingProgress").show();
            },
            complete: function() {
                $("#loadingProgress").hide();
            }
        });

        return e.preventDefault;
    });

    $('#formCategory').on('submit',function(event){
        event.preventDefault();
        var postUrl = "{{ route('category.save') }}";

        let dataForm = new FormData( document.getElementById("formCategory") );

        //
        $.ajax({
            url: postUrl,
            type:"POST",
            data: dataForm,
            processData: false,
            contentType: false,
            success:function(response){
                let tipe = "error";
                if ( response.success ){
                    tipe = "success"
                }

                Swal.fire({
                    title: 'Add Category!',
                    icon: tipe,
                    text: response.message,
                    type: tipe
                }).then(function() {
                    //window.location = "redirectURL";
                    if ( response.success ){
                        table.ajax.reload();
                    }
                    $("#modalForm").modal('hide');
                });
            },
            beforeSend: function() {
                $("#loadingProgress").show();
            },
            complete: function() {
                $("#loadingProgress").hide();
            }
        })
    })
})
</script>
@endsection

