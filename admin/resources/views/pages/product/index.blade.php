@extends('layouts.main')
@section('title')
Majoo :: Product
@endsection
@section('css')
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
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>

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
                    <h3 class="card-title">List of Product </h3>
                    <div class="card-tools">
                        <a href="{{route('product.add')}}" id="addProduct" class="btn btn-block bg-gradient-primary">Add Product</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body" id="table_data">
                    @include('pages.product.tableajax')
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
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){

    $("body").on("click",".pagination a", function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadTable(page);
    })
    function loadTable(page){
        $.ajax({
            url:"{{route('product.gettable')}}?page="+page,
            success:function(data)
            {
                $('#table_data').html(data);
            },
            beforeSend: function() {
                $("#loadingProgress").show();
            },
            complete: function() {
                $("#loadingProgress").hide();
            }
        });
    }
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
                    url: "{{route('product.delete')}}",
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
                                loadTable(1);
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

})
</script>
@endsection

