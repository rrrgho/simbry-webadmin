<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('Creative Tim') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">

      {{-- Dashboard --}}
      <li class="nav-item{{ $activeMainPage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('main')}}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      {{-- Book Management --}}
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="material-icons">book</i>
          <p>{{ __('Manajemen Buku') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse " id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Kategori Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Penulis Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Penerbit Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Edisi Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Rak Buku') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      {{-- Class Management --}}
      <li class="nav-item {{ ($activeMainPage == 'class-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#class-management" aria-expanded="true">
          <i class="material-icons">book</i>
          <p>{{ __('Manajemen Kelas') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activeMainPage == 'class-management') ? ' show' : '' }}" id="class-management">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'class-data' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-class-management')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Data Kelas') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>


