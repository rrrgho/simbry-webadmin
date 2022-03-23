<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('ADMIN SIM') }}
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
      <li class="nav-item {{ ($activeMainPage == 'books-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="material-icons">book</i>
          <p>{{ __('Manajemen Buku') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activeMainPage == 'books-management') ? ' show' : '' }}" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'books-data' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-books')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Data Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'e-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('e-books')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('E-Books') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'cetegory-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-category-management')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Kategori Buku') }} </span>
              </a>
            </li>
            {{-- <li class="nav-item{{ $activePage == 'author-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-author-management')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Penulis Buku') }} </span>
              </a>
            </li> --}}
            <li class="nav-item{{ $activePage == 'publisher-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('main-publisher-management') }}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Penerbit Buku') }} </span>
              </a>
            </li>
            {{-- <li class="nav-item{{ $activePage == 'edition-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('main-edition-management') }}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Edisi Buku') }} </span>
              </a>
            </li> --}}
            <li class="nav-item{{ $activePage == 'locker-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('main-locker-management') }}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Rak Buku') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'sub-cetegory-books' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('main-sub-category-management') }}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal"> {{ __('Sub Kategori Buku') }} </span>
              </a>
            </li>
            {{-- <li class="nav-item{{ $activePage == 'qr-data' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('books-qr') }}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Print QR') }} </span>
              </a>
            </li> --}}
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
                <span class="sidebar-normal">{{ __('Data Siswa') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'upgrade-siswa' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-upgrade-siswa')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Upgrade Siswa') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'teacher-data' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-teacher-management')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Data Guru') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'terpopuler-data' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('student-terpopuler')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Siswa Terpopuler') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      {{-- Tambah Peminjaman Siswa --}}
      {{-- <li class="nav-item {{ ($activePage == 'peminjaman-siswa') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('main-peminjaman-siswa') }}">
          <i class="material-icons">bookmark_add</i>
            <span class="sidebar-mini"></span>
            <span class="sidebar-normal">{{ __('Tambah Peminjaman') }} </span>
          </p>
        </a>
      </li> --}}
      {{-- Pemulangan Buku --}}
      <li class="nav-item {{ ($activePage == 'pemulangan-buku') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('main-pemulangan-buku') }}">
          <i class="material-icons">book</i>
            <span class="sidebar-mini"></span>
            <span class="sidebar-normal">{{ __('Pemulangan Buku') }} </span>
          </p>
        </a>
      </li>
      {{-- Management Peminjamman --}}
      <li class="nav-item {{ ($activeMainPage == 'management-peminjaman') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#management-peminjaman" aria-expanded="true">
          <i class="material-icons">book</i>
          <p>{{ __('Peminjaman') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activeMainPage == 'management-peminjaman') ? ' show' : '' }}" id="management-peminjaman">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'peminjaman-berjalan' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-management-peminjaman-berjalan')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Peminjaman Berjalan') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'peminjaman-expired' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-management-peminjaman-expired')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Peminjaman Expired') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'peminjaman-history' ? ' active' : '' }}">
              <a class="nav-link" href="{{route('main-management-peminjaman-history')}}">
                <span class="sidebar-mini"> - </span>
                <span class="sidebar-normal">{{ __('Peminjaman History') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'peminjaman-extends' ? ' active' : '' }}">
                <a class="nav-link" href="{{route('main-management-peminjaman-extends')}}">
                  <span class="sidebar-mini"> - </span>
                  <span class="sidebar-normal">{{ __('Perpanjang Peminjaman') }} </span>
                </a>
            </li>
          </ul>
        </div>
      </li>
      {{-- Add Books --}}
      {{-- <li class="nav-item {{ ($activeMainPage == 'books') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#add-books" aria-expanded="true">
          <i class="material-icons">book</i>
          <p>{{ __('Buku') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activeMainPage == 'books') ? ' show' : '' }}" id="add-books">

          </ul>
        </div>
      </li> --}}
      {{-- Peminjaman Masuk --}}
      <li class="nav-item {{ ($activePage == 'peminjaman-masuk') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('main-peminjaman-masuk') }}">
          <i class="material-icons">supervisor_account</i>
            <span class="sidebar-mini"></span>
            <span class="sidebar-normal">{{ __('Peminjaman Masuk') }} </span>
          </p>
        </a>
      </li>
      {{-- Kritik & Saran --}}
      <li class="nav-item {{ ($activePage == 'kritik-saran') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('main-kritik-saran') }}">
          <i class="material-icons">announcement</i>
            <span class="sidebar-mini"></span>
            <span class="sidebar-normal">{{ __('Kritik & Saran') }} </span>
          </p>
        </a>
      </li>
     {{-- Preference dari Siswa --}}
     <li class="nav-item {{ ($activePage == 'preference') ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('main-preferensi') }}">
          <i class="material-icons">mail</i>
            <span class="sidebar-mini"></span>
            <span class="sidebar-normal">{{ __('Preferensi Siswa') }} </span>
          </p>
        </a>
      </li>
    {{-- Manajemen Peraturan --}}
    {{-- <li class="nav-item {{ ($activePage == 'management-peraturan') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('main-management-peraturan') }}">
        <i class="material-icons">contactless</i>
          <span class="sidebar-mini"></span>
          <span class="sidebar-normal">{{ __('Menajemen Peraturan') }} </span>
        </p>
      </a>
    </li> --}}
    {{-- Pengumuman --}}
    <li class="nav-item {{ ($activeMainPage == 'announcement-management') ? ' active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#announcement-management" aria-expanded="true">
        <i class="material-icons">campaign</i>
        <p>{{ __('Pengumuman') }}
          <b class="caret"></b>
        </p>
      </a>
      <div class="collapse {{ ($activeMainPage == 'announcement-management') ? ' show' : '' }}" id="announcement-management">
        <ul class="nav">
          <li class="nav-item{{ $activePage == 'announcement' ? ' active' : '' }}">
            <a class="nav-link" href="{{route('announcements')}}">
              <span class="sidebar-mini"> - </span>
              <span class="sidebar-normal">{{ __('Pengumuman') }} </span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    {{-- Settings --}}
    <li class="nav-item {{ ($activeMainPage == 'settings') ? ' active' : '' }}">
      <a class="nav-link" data-toggle="collapse" href="#management-settings" aria-expanded="true">
        <i class="material-icons">settings</i>
        <p>{{ __('Pengaturan Halaman Siswa') }}
          <b class="caret"></b>
        </p>
      </a>
      <div class="collapse {{ ($activeMainPage == 'management-settings') ? ' show' : '' }}" id="management-settings">
        <ul class="nav">
          <li class="nav-item{{ $activePage == 'slide-banner' ? ' active' : '' }}">
            <a class="nav-link" href="{{route('slide-banner')}}">
              <span class="sidebar-mini"> - </span>
              <span class="sidebar-normal">{{ __('Slide Banner') }} </span>
            </a>
          </li>
          <li class="nav-item{{ $activePage == 'contact' ? ' active' : '' }}">
            <a class="nav-link" href="{{route('contact')}}">
              <span class="sidebar-mini"> - </span>
              <span class="sidebar-normal">{{ __('Kontak') }} </span>
            </a>
          </li>
          <li class="nav-item{{ $activePage == 'about' ? ' active' : '' }}">
            <a class="nav-link" href="{{route('about-school')}}">
              <span class="sidebar-mini"> - </span>
              <span class="sidebar-normal">{{ __('Tentang Sekolah') }} </span>
            </a>
          </li>
        </ul>
      </div>
    </li>
    {{-- <li class="nav-item {{ ($activePage == 'activity') ? ' active' : '' }}">
      <a class="nav-link" href="{{ route('main-activity-log') }}">
        <i class="material-icons">donut_large</i>
          <span class="sidebar-mini"></span>
          <span class="sidebar-normal">{{ __('Activtylog') }} </span>
        </p>
      </a>
    </li> --}}
    </ul>
  </div>
</div>
