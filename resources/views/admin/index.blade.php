@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Dashboard', 'link' => 'http://dashboard.com'],
    [ 'page' => 'Profile', 'link' => 'http://profile.com'],
],
  'class' => 'off-canvas-sidebar', 
  'activeMainPage' => 'dashboard',
  'activePage' => 'home', 
  'title' => __('Dashboard'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="material-icons">account_circle</i>
          </div>
          <p class="card-category">Total Guru & Murid</p>
          <h3 class="card-title">{{ $data }}
            <small>Orang</small>
          </h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            {{-- <i class="material-icons text-danger">warning</i> --}}
            {{-- <a href="#pablo">Get More Space...</a> --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">shopping_cart</i>
          </div>
          <p class="card-category">Pemesanan Approved</p>
          <h3 class="card-title">{{ $approved }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            {{-- <i class="material-icons">date_range</i> Last 24 Hours --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">shopping_cart</i>
          </div>
          <p class="card-category">Pemesanan Pending</p>
          <h3 class="card-title">{{ $pending }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            {{-- <i class="material-icons">date_range</i> Last 24 Hours --}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">book</i>
          </div>
          <p class="card-category">Total Buku</p>
          <h3 class="card-title">{{ $book }}</h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            {{-- <i class="material-icons">update</i> Just Updated --}}
          </div>
        </div>
      </div>
    </div>
      @foreach ($list_blocks as $block)
        <div class="col-md-6">
            <h3>{{ $block['title'] }}</h3>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Nomor Induk Siswa & Guru</th>
                    <th>Last login at</th>
                </tr>
                </thead>
                <tbody>
                @forelse($block['entries'] as $entry)
                    <tr>
                        <td>{{ $entry->name }}</td>
                        <td class="text-center">{{ $entry->user_number }}</td>
                        <td>{{ $entry->last_login_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">{{ __('No entries found') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
      @endforeach
</div>
<div class="row">
  <div class="{{ $chart->options['column_class'] }}">
      <h3>{!! $chart->options['chart_title'] !!}</h3>
      {!! $chart->renderHtml() !!}
  </div>
</div>
@endsection
@section('script')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    {!! $chart->renderJs() !!}
@endsection
