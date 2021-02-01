@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Menambahkan Buku', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'books', 
  'activePage' => 'books-data', 
  'title' => __('Menambahkan Buku'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12">            
            <div class="col border-bottom pl-0 pb-3">
                <h3>Manajemen Buku</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data disini !</p>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if(session('success'))
    <div class="row pb-4" id="flash-message">
        <div class="col-12">
            <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
                <p>{{session('success')}}</p>
                <button class="btn btn-success position-absolute" onclick="getAddBooksComponent()" data-toggle="modal" id="btn-add-books" data-target="#addBooks" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Buku</button>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h1 class="text-success">Data Seluruh Buku</h1>
                    <p>Tambah, edit atau hapus data buku.</p>
                    <button class="btn btn-success position-absolute" data-toggle="modal" data-target="#dataBooks" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Buku</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4" id="data-book">
                        <table class="ui celled table table-striped" id="data-kategori">
                            <thead>
                                <tr class="text-center">
                                    <th width="50">#</th>
                                    <th>Nama</th>
                                    <th>Pencipta</th>
                                    <th>Penerbit</th>
                                    <th>Edisi</th>
                                    <th width="50">Loker</th>
                                    <th width="100px">Created At</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                        </table>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Add Buku --}}
    <div class="modal fade" id="dataBooks" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
            <div class="modal-content">
                <form action="{{url('books/books')}}" method="POST">@csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Buku</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Pencipta : </label><br>
                        <select class="form-control js-example-basic-single" style="width: 100%" name="creator_id">
                            <option value="">Pilih kategori dahulu...</option>
                            @foreach ($author as $item)
                                <option  value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Penerbit : </label>
                        <select class="form-control js-example-basic-single" style="width: 100%" name="publisher_id">
                            <option value="" hidden>Pilih Penerbit</option>
                            @foreach ($publisher as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Edisi : </label>
                        <select class="form-control js-example-basic-single" style="width: 100%" name="edition_id">
                            <option value="" hidden>Pilih Edisi</option>
                            @foreach ($edition as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Pilih Loker : </label>
                        <select class="form-control js-example-basic-single" style="width: 100%" name="locker_id">
                            <option value="" hidden>Pilih Loker</option>
                            @foreach ($locker as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Asal Buku : </label>
                        <input type="text" name="origin_book"class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nomor Buku : </label>
                        <input type="text" name="book_number"class="form-control">
                    </div> 
                    <div class="form-group">
                        <label for="">Tahun Pembelian : </label>
                        <input class="date form-control" value="01/01/2000" id="datepicker" name="buying_year" type="text">
                    </div>
                    <div class="form-group">
                        <label for="">Tahun Penerbit : </label>
                        <input class="date form-control" value="01/01/2000" name="publish_year" type="text">
                    </div>      
                    <div class="form-group">
                        <label for="">Nama Buku : </label>
                        <input class="form-control" name="name" type="text">
                    </div>      
                    <div class="form-group">
                        <label for="">Deskripsi : </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3"></textarea>
                    </div>      
                </div>
                <div class="modal-footer">
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button class="btn btn-success" id="btn-tambah-books">Tambah Buku</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const clearInput = () => {
            $('.form-control').val('')
        }
         $('.date').datepicker({  
            format: 'mm-dd-yyyy'
        });  
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection