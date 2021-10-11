@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Preferensi', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'preference',
  'title' => __('Pengumuman'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Menerima Preferensi dari Siswa</h3>
            <p>Anda dapat mensetujui jika buku sudah ada!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive mt-4" id="pending-preferensi">
            <div class="row">
                <div class="col-lg-2" id="event_period">
                    <input type="text" class="actual_range">
                </div>
            </div>
            <table class="ui celled table table-striped" id="data-history">
                <thead>
                    <tr class="text-center">
                        <th width="50">#</th>
                        <th>Nama Siswa</th>
                        <th>Nama Buku</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $('#event_period').datepicker({
    inputs: $('.actual_range')
    });
</script>
@endsection
