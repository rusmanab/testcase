@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Tarif</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Tarif</li>
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
                  <h3 class="card-title">Form Edit</h3>
                </div>
                <!-- /.card-header -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                
                
                <form class="form-horizontal" action="{{ route('tarif.save') }}" method="POST" id="formEdit">
                    @csrf
                    <input type="hidden" id="" name="id" value="{{ $Tarif->id}}"/>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputNamaLengkap" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" name="title" value="{{ $Tarif->title}}" class="form-control"  id="inputNamaLengkap" placeholder="Keterangan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jarak" class="col-sm-2 col-form-label">Jarak</label>
                            <div class="col-sm-2">
                                <input type="number" name="jarak" value="{{ $Tarif->jarak}}"  class="form-control" id="jarak" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="biaya" class="col-sm-2 col-form-label">Biaya</label>
                            <div class="col-sm-3">
                                <input type="text" name="biaya" value="{{ $Tarif->biaya}}" class="form-control" id="biaya" placeholder="biaya"> 
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="biaya_cs" class="col-sm-2 col-form-label">Biaya cs</label>
                            <div class="col-sm-3">
                                <input type="text" name="biaya_cs" class="form-control" value="{{ $Tarif->biaya_cs}}" id="biaya_cs">
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Update</button>
                        <a href="{{ route('tarif.index')}}" class="btn btn-default float-right">Cancel</a>
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
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/inputmask/jquery.inputmask.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(e){
        $("#jumlah_topup").inputmask(
        { alias : "currency", prefix: '',digits: 0, groupSeparator: ",",});
        
        $('#formEdit').on('submit',function(event){
            event.preventDefault();
            var postUrl = $(this).attr("action");

            let dataForm = new FormData( document.getElementById("formEdit") );

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
                        title: 'Update Data!',
                        icon: tipe,
                        text: response.message,
                        type: tipe
                    }).then(function() {
                        //window.location = "redirectURL";
                        if ( response.success ){
                            window.location.href = "{{ route('tarif.index') }}";
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
    });
</script>
@endsection