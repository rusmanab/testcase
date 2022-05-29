
  <!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('assets/template/adminlte')}}/dist/img/majoo.jfif" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Majoo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php
        $user = auth()->user();
        $avatar = url(Storage::url(@$user->avatar_thumbs));
        $isExists = Storage::exists(@$user->avatar_thumbs);

        if (!$isExists){
            $avatar = asset('assets/template/adminlte')."/dist/img/avatar5.png";
        }
        ?>
        <div class="image">
          <img src="{{$avatar}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{@$user->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <?php
      $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

      $uri_ = explode('/', $uri_path);
      $uri_ = $uri_[1];

    ?>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="{{route("home")}}" class="nav-link <?php echo $uri_ == "home" ? "active":""?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{ route('category')}}" class="nav-link <?php echo $uri_ == "jenistrans" ? "active":""?>">

                <i class="nav-icon fas fa-car-crash"></i>
                <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product')}}" class="nav-link <?php echo $uri_ == "merekmobil" ? "active":""?>">
                <i class="nav-icon fas fa-taxi"></i>
                <p>Product</p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
