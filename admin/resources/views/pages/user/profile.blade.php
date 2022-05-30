@extends('layouts.main')
@section('css')
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
            <h1>Members</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Member</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        <?php
                        $avatar = url(Storage::url($user->avatar_thumbs));
                        $isExists = Storage::exists($user->avatar_thumbs);

                        if (!$isExists){
                            $avatar = asset('assets/template/adminlte')."/dist/img/avatar5.png";
                        }
                        ?>
                        <img class="profile-user-img img-fluid img-circle"
                                src="{{$avatar}}"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                    </div>
                <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-at mr-1"></i> Email</strong>
                        <p class="text-muted">
                        {{$user->email}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-mobile-alt mr-1"></i> No HP</strong>
                        <p class="text-muted">
                            {{$user->phone}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">{{$user->alamat}}</p>
                        <hr>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Profile</a></li>

                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Ganti Password</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">&nbsp;</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="formUpload" method="POST">
                                    @csrf
                                    <input type="hidden" name="member_id" value="{{$user->id}}" />
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="name">Nama Lengkap</label>
                                            <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phone}}"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" id="alamat" class="form-control" value="{{$user->alamat}}"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Avatar</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="user_image" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>



                        </div>
                    </div>
                    <!-- /.tab-pane -->


                    <div class="tab-pane" id="settings">
                        <form id="formAktifasi" class="form-horizontal" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}" />
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox"> Saya yakin, <a href="#">driver sudah melakukan pembayaran dengan nominal yang sesuai</a>
                                    </label>
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->



  </div>
  <!-- /.content-wrapper -->
@endsection
@section('javascript')
<script src="{{asset('assets/template/adminlte')}}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{asset('assets/template/adminlte')}}/plugins/inputmask/jquery.inputmask.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(e){

        $('#formUpload').on('submit',function(event){
            event.preventDefault();
            var postUrl = "{{ route('users.updateprofile') }}";

            let dataForm = new FormData( document.getElementById("formUpload") );

            //
            $.ajax({
                url: postUrl,
                type:"POST",
                data: dataForm,
                processData: false,
                contentType: false,
                success:function(response){
                    let success = response.success;
                    let icon = 'error';
                    let title = 'Gagal';
                    if ( success ){
                        icon = 'success';
                        title = 'Berhasil'
                    }
                    Swal.fire({
                        icon: icon,
                        title: title,
                        text: response.message,
                    })
                },
                beforeSend: function() {
                    $("#loadingProgress").show();
                },
                complete: function() {
                    $("#loadingProgress").hide();
                }
            })
        })
        $('#formAktifasi').on('submit',function(event){
            event.preventDefault();
            var postUrl = "{{ route('members.aktifasi') }}";

            let dataForm = new FormData( document.getElementById("formAktifasi") );

            //
            $.ajax({
                url: postUrl,
                type:"POST",
                data: dataForm,
                processData: false,
                contentType: false,
                success:function(response){
                    let success = response.success;
                    let icon = 'error';
                    let title = 'Oops...';
                    if ( success ){
                        icon = 'success';
                        title = 'Oops...'
                    }
                    Swal.fire({
                        icon: icon,
                        //title: 'Oops...',
                        text: response.message,
                    })
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
