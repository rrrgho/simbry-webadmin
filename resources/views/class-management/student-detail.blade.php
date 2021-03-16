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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Detail {{$data[0]['name']}}</h1>
                <p></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12 p-0">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <span style="font-size: 25px">{{$data[0]['name']}}</span> <br><br>
                                    <button class="btn btn-success position-absolute" data-toggle="modal" data-target="#changePassword" style="top:5px; right:10px;"><i class="fa fa-plus"></i> <span class="ml-2">Ganti Password</span></button>
                                </div>
                                <div class="card-body">
                                    <h5 style="opacity: 0.7; margin-top:10px;">BUKU DI PINJAM : {{$order[0]['id'] ?? 'Tidak ada Point'}}</h5>
                                    <h5 style="opacity: 0.7; margin-top:10px;">POINT : {{$data[0]['point'] ?? 'Tidak ada Point'}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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