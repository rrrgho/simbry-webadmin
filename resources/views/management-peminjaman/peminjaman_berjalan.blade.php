@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'management-peminjaman',
  'activePage' => 'peminjaman-berjalan',
  'title' => __('Peminjaman Berjalan'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom mb-3">
            <div class="col border-bottom pl 0 pb-3">
                <h3>Peminjaman Berjalan!!</h3>
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
                {{-- <h3>Peminjaman Berjalan Approved!!</h3> --}}
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="data-masuk">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Induk Siswa/Guru</th>
                            <th>Kelas</th>
                            <th>Nama Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Expired</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        @if (!$item->user->deleted_at)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->user_number }}</td>
                            @if ($item->user->user_type_id == 2)
                                <td>Guru</td>
                            @else
                                <td>{{ $item->user->class_relation->name }}</td>
                            @endif
                            <td>{{ $item->book->name }}</td>
                            <td class="text-center">{{ $item->start_date }}</td>
                            <td class="text-center">{{ $item->end_date }}</td>
                            <td class="text-center">1</td>
                            <td class="text-center"><button class="btn-danger">{{ $item->status }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
         $(document).ready(function() {
            $('#data-masuk').DataTable();
        } );
    </script>
@endsection
