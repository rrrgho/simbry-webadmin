@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Activitylog Guru & Siswa', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'activity', 
  'title' => __('Activitylog'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Activitylog Siswa & Guru</h3>
            <p>Anda dapat melihat Peminjaman Masuk!!</p>
        </div>
    </div>
</div>
@endsection