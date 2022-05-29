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
            <h1>Edit Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Product</li>
              <li class="breadcrumb-item active">Edit</li>
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
                    <input type="hidden" name="id" value="{{$product->id}}" />
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputProductName" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="product_name" value="{{$product->product_name}}" class="form-control"  id="inputProductName" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPicture" class="col-sm-2 col-form-label">Picture</label>
                            <div class="col-sm-6">
                                <?php
                                $image = url(Storage::url(@$product->image));
                                $isExists = Storage::exists(@$product->image);

                                if ($isExists){
                                    $show = "none";
                                ?>
                                <div id="img-preview2" class="img-preview" >
                                    <img src="{{$image}}" class="img-fluid"/>
                                    <button type="button" class="rounded float-start img-remove delete" id="img-remove2">
                                        <i class="fa fa-trash"></i>
                                      </button>
                                </div>
                                <?php }else{
                                    $show = "block";
                                } ?>
                                <div id="img-preview" class="img-preview" style="display: {{$show}}" >
                                    <div id="template" class="file-row">
                                        <!-- This is used as the file preview template -->
                                        <img data-dz-thumbnail />
                                        <button data-dz-remove class="rounded float-start img-remove delete" id="img-remove">
                                            <i class="fa fa-trash"></i>
                                          </button>
                                        <div id="total-progress">
                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                            </div>
                                        </div>
                                        <div class="dropzone-error" data-dz-errormessage></div>
                                    </div>
                                    <div id="camera" class="take-pic"><i class="fa fa-2x fa-camera"></i></div>
                                    <div id="hiddenImage"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" name="category_id" id="category_id">

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-3">
                                <input type="text" name="price" class="form-control" value="{{$product->price}}" id="price" placeholder="price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_desc" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="product_desc" cols="6" id="product_desc">{{$product->product_desc}}</textarea>
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
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e){

    $('#product_desc').summernote({ height: 150});
    $("#img-remove2").on("click", function(e){
        $("#img-preview2").remove();
        $("#img-preview").show();
    });
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    let myDropzone = new Dropzone("div#camera", {
            url: "{{route('product.uploadimage')}}",
            maxFilesize: 2, // MB
            thumbnailWidth: 140,
            thumbnailHeight: 140,
            acceptedFiles: ".jpeg,.jpg,.png,",
            maxFiles: 1,
            previewTemplate: previewTemplate,
            previewsContainer: "#img-preview",
            addRemoveLinks: true,
            removedfile: function(file) {
                let name = file.previewElement.id;
                let tagidname = name.split(".");

                $.ajax({
                    type: 'POST',
                    url: '{{route('product.deleteimage')}}',
                    data: {name: name,request: 2},
                    sucess: function(data){
                        console.log('success: ' + tagidname[0]);
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            autoProcessQueue:true,
            params: {
                _token: "{{csrf_token()}}"
            },

        });

    myDropzone.on("success", function(file,resp){
        if(resp.success){
            file.previewElement.id = resp.imagename;
            $("#hiddenImage").html('');
            var row = "<input type='hidden' name='image' value='"+ resp.imagePath +"' id='row" + resp.tagidname + "' />"
            $("#hiddenImage").append(row);
        }else {
            alert("Faild to upload image! Try again");
        }
    });
    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        $(".progress-bar").html( progress + "%");
    });

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";

    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {

        setTimeout(function () {
            document.querySelector("#total-progress").style.opacity = "0";
        }, 300);
    });
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
    <?php if ($product->category_id){ ?>
        var option = new Option("{{$product->category_name}}", "{{$product->category_id}}", true, true);
        $("#category_id").append(option).trigger('change');

    <?php } ?>

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
