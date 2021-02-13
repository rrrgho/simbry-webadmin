@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'management-peminjaman', 
  'activePage' => 'peminjaman-history', 
  'title' => __('Peminjaman history'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom mb-3">
            <div class="col border-bottom pl 0 pb-3">
                <h3>Peminjaman History!!</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data Peminjaman disini !</p>       
            </div>
        </div>    
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Peminjaman History!!</h3>
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="data-expired">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Peminjaman</th>
                            <th>Tanggal Peminjamn</th>
                            <th>Tanggal Expired</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                @if ($item->status == "SELESAI")
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->user->user_number }}</td>
                                    <td class="text-center">{{ $item->user->user_type_id == 1 ?  'SISWA' : 'GURU' }}</td>
                                    <td class="text-center">{{ $item->start_date }}</td>
                                    <td class="text-center">{{ $item->end_date }}</td>
                                    <td class="text-center"><button class="btn-danger">{{ $item->status }}</td> 
                                @endif                           
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
@endsection