@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Dashboard', 'link' => 'http://dashboard.com'],
    [ 'page' => 'Profile', 'link' => 'http://profile.com'],
],
  'class' => 'off-canvas-sidebar', 
  'title' => __('Ganti Password'),
  'subTitle' => __('Halaman Ganti Password, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Menu Mengganti Password</h3>
            <p>Anda dapat Mengganti Password!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="container">
        @if(session('success'))
        <div class="row pb-4">
            <div class="col-7">
                <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
                    <p>{{session('success')}}</p>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Mengganti Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('change-password-post') }}" method="POST">@csrf
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
        </div>
    </div>
@endsection