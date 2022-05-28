@extends('layouts.main')
@section('title')
Majoo :: Add Product
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<link rel="stylesheet" href="{{asset('assets/template/adminlte')}}/plugins/summernote/summernote-bs4.min.css">
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
            <h1>Add Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Product</li>
              <li class="breadcrumb-item active">Add</li>
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
                  <h3 class="card-title">Form Product</h3>
                </div>

                <form class="form-horizontal" id="formAdd" action="{{ route('product.save') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputProductName" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="product_name" class="form-control"  id="inputProductName" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" name="category_id" id="category_id" required>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-3">
                                <input type="text" name="price" class="form-control" id="price" placeholder="price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_desc" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="product_desc" id="product_desc"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Save</button>
                        <a href="{{ route('product')}}" class="btn btn-default float-right">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
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
<script src="{{asset('assets/template/adminlte')}}/plugins/select2/js/select2.full.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/summernote/summernote-bs4.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){

    $('#product_desc').summernote({ height: 150});
    $("#category_id").select2({
        minimumInputLength: 1,
        allowClear: true,
        placeholder: 'Input Category Name',
        ajax: {
            type: "post",
            dataType: 'json',
            url: "{{ route('category.getbyname') }}",
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
    $('#formAdd').on('submit',function(event){
        event.preventDefault();
        var postUrl = "{{ route('product.save') }}";

        let dataForm = new FormData( document.getElementById("formAdd") );

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
                    title: 'Add Product!',
                    icon: tipe,
                    html: response.message,
                    type: tipe
                }).then(function() {
                    //window.location = "redirectURL";
                    if ( response.success ){
                        window.location.replace("{{route('product')}}");
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
    })
})
</script>
@endsection
