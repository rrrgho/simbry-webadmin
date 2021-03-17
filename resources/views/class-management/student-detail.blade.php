@extends('layouts.app', [
'breadcrumbs' => [
[ 'page' => 'Data Buku', 'link' => route('main-books')],
[ 'page' => 'Detail ' . $data[0]['name'], 'link' => route('detail-siswa', [$data[0]['id']])],
],
'class' => 'off-canvas-sidebar',
'activeMainPage' => 'class-management',
'activePage' => 'class-data',
'title' => __('Data Siswa'),
'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
<div class="row">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Manajemen Siswa</h3>
            <p>Anda dapat menambah, mengedit atau menghapus data disini !</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">{{ $data[0]['name'] }}</h5>
            </div>
            <form action="{{ route('detail-siswa-execute') }} " method="POST">@csrf
                <div class="card-body">
                    <input type="text" name="id" hidden value="{{ $data[0]['id'] }}">
                    <div class="form-group">
                        <label for="">Nomor Induk Siswa</label>
                        <input type="text" name="user_number" class="form-control" value="{{ $data[0]['user_number'] }}">
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $data[0]['name'] }}">
                    </div>
                    <div class="form-group">
                        <label for="">Ganti Password</label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">History {{ $data[0]['name'] }}</h5>
            </div>
            <div class="card-body">
                {{-- <h5 style="opacity: 0.7; margin-top:10px;">BUKU SEDANG PINJAM : {{$order[0]['id'] ?? 'Tidak ada Di pinjam'}}</h5> --}}
                <h5 style="opacity: 0.7; margin-top:10px;">POINT : {{$data[0]['point'] ?? 'Tidak ada Point'}}</h5>
                <h5 style="opacity: 0.7; margin-top:10px;">LEVEL : {{$data[0]['level'] ?? 'Tidak Ada Medali'}}</h5>
            </div>
        </div>
    </div>
</div>
{{-- Modal Change Password --}}
<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Password Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('reset-passsword') }}" method="post">@csrf
            <div class="modal-body">
            <input type="text" hidden value="{{ $data[0]['id'] }}">
                <div class="form-group">
                    <h5>Password Baru</h5>
                    <input type="text" class="form-control" name="password">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection