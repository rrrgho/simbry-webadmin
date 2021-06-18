@extends('layouts.app', [
'breadcrumbs' => [
[ 'page' => 'QR Buku', 'link' => 'http://dashboard.com'],
],
'class' => 'off-canvas-sidebar',
'activeMainPage' => 'books-management',
'activePage' => 'qr-data',
'title' => __('QRCode Buku'),
'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
<div class="row">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Qr Buku</h3>
            <p>Anda dapat mencetak QRCode Buku disini !</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>QRCode Buku</h3>
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="qrcode">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Induk</th>
                            <th>Kode Buku</th>
                            <th>Nomor Panggil</th>
                            <th>Nomor Examplar</th>
                            {{-- <th>Kategori</th> --}}
                            {{-- <th>Loker</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count() == 0)
                        <tr>
                            <td colspan="5">No products to display.</td>
                        </tr>
                        @endif
                
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['book_number'] }}</td>
                                <td>{{ $item['code_of_book'] }}</td>
                                <td>{{ $item['call_number'] }}</td>
                                <td>{{ $item['examplar'] }}</td>
                                <td class="text-center"><button type="button" class="btn btn-primary" data-toggle="modal" onclick="setIdRule('{{ $item['id'] }}')" data-target="#exampleModal"> <i class="fa fa-edit"> </i> </button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $data->links() !!}
            </div>
        </div>
    </div>    
</div>
@endsection

