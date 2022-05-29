@extends('layouts.main')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Tarif</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Tarif</li>
              <li class="breadcrumb-item active">Tambah</li>
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
                  <h3 class="card-title">Form Tarif</h3>
                </div>
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
                <form class="form-horizontal" action="{{ route('tarif.save') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputNamaLengkap" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" name="title" class="form-control"  id="inputNamaLengkap" placeholder="Keterangan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jarak" class="col-sm-2 col-form-label">Jarak</label>
                            <div class="col-sm-2">
                                <input type="number" name="jarak" class="form-control" id="jarak" placeholder="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="biaya" class="col-sm-2 col-form-label">Biaya</label>
                            <div class="col-sm-3">
                                <input type="text" name="biaya" class="form-control" id="biaya" placeholder="biaya">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="biaya_cs" class="col-sm-2 col-form-label">Biaya cs</label>
                            <div class="col-sm-3">
                                <input type="text" name="biaya_cs" class="form-control" id="biaya_cs">
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Save</button>
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
