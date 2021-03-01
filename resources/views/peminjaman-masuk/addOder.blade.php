@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Tambah Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'peminjaman-siswa', 
  'title' => __('Tambah Peminjaman Buku Siswa'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Tambah Peminjaman Buku Siswa Manual!!</h3>
            <p>Anda dapat menambah Peminjaman siswa yg ingin meminjam buku!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-lg-6 col-md-12">
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="text-success text-center">Peminjaman Buku Siswa</h5>
            <p></p>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ url('add-peminjaman') }}">@csrf
              <div class="form-group">
                <select class="livesearchSiswa form-control" name="livesearch">
                    @foreach ($user as $item)
                      <option value="{{$item['id']}}">{{$item['user_number']}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <select class="livesearchBuku form-control" name="livesearch">
                  @foreach ($book as $item)
                    @if($item->ready == 0)
                    <option disabled value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @else
                      <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Pinjam</button>
              </div>
            </form>
        </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="card">
        <div class="card-header bg-light">
          <h2 class="text-success text-center"> <i class="fa fa-warning"></i> Pemberitahuan</h2>
          <p></p>
        </div>
        <div class="card-body">
          <p>1. </p>
        </div>
    </div>
  </div>
</div>

@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $('.livesearchBuku').select2({
        placeholder: 'Pilih Buku',
    });
    $('.livesearchSiswa').select2({
      placeholder: 'Pilih Siswa',
    });
</script>

@endsection