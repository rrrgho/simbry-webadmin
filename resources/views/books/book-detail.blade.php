@extends('layouts.app', [
'breadcrumbs' => [
[ 'page' => 'Data Buku', 'link' => route('main-books')],
[ 'page' => 'Detail ' . $data[0]['name'], 'link' => route('book-detail', [$data[0]['examplar']])],
],
'class' => 'off-canvas-sidebar',
'activeMainPage' => 'books-management',
'activePage' => 'books-data',
'title' => __('Data Buku'),
'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
<div class="row noPrint">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Manajemen Buku</h3>
            <p>Anda dapat menambah, mengedit atau menghapus data disini !</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<style>
    @media print {
        .noPrint{
            display:none;
        }
        .print{
            display: block;
            text-align: left !important;
            margin-top: -150px;
        }
    }
    @page { size: auto;  margin: 0mm; }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light noPrint">
                <h1 class="text-success">Detail {{$data[0]['name']}}</h1>
                <p></p>
            </div>
            <div class="card-header text-center pt-5 print">
                {!! QrCode::size(200)->generate(asset('/api/book-qr/1')); !!} <br>
                <button class="btn btn-info noPrint" onclick="window.print()"><i class="fa fa-print mr-3" ></i> Cetak QR Code</button>
            </div>
            <div class="card-body noPrint">
                <div class="row">
                    <div class="col-lg-4 col-md-12 pt-5 text-center">
                        <img src="{{$data[0]['cover'] ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsNGGjrfSqqv8UjL18xS4YypbK-q7po_8oVQ&usqp=CAU'}}" class="img-fluid rounded" alt="...">
                        @if($data[0]['link_pdf'])
                            <h4><a href="{{ $data[0]['link_pdf'] }}">Buku ini memiliki file digital,click disini!!</a></h4>
                        @else
                            <p>Buku ini tidak memiliki file digital</p>
                        @endif
                    </div>
                    <div class="col-md-12 col-lg-8 p-0">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <span style="font-size: 25px">{{$data[0]['name']}}</span> <br><br>
                                    <button class="btn btn-success position-absolute" data-toggle="modal" data-target=".bd-example-modal-lg" style="top:5px; right:10px;"><i class="fa fa-plus"></i> <span class="ml-2">Tambah duplikasi</span></button>
                                </div>
                                <div class="card-body">
                                    <span style="opacity: 0.7; margin-top:10px;">{{$data[0]['description'] ?? 'Tidak ada deskripsi'}}</span>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tr class="text-center">
                                                        <th>#</th>
                                                        <th>Nomor Induk</th>
                                                        <th>Nomor Panggil</th>
                                                        <th>Judul</th>
                                                        <th>Kode Buku</th>
                                                        <th>Penulis</th>
                                                        <th>Edisi</th>
                                                        <th>Asal Buku</th>
                                                        <th>Kategori</th>
                                                        <th>:</th>
                                                    </tr>
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <th class="text-center">{{$loop->iteration}}</th>
                                                            <td class="text-center">{{$item['book_number']}}</td>
                                                            <td class="text-center">{{$item['no_panggil']}}</td>
                                                            <td>{{$item['name']}}</td>
                                                            <td class="text-center">{{$item['code_of_book']}}</td>
                                                            <td>{{$item['creator']}}</td>
                                                            <td class="text-center">{{$item['edition'] ?? '-'}}</td>
                                                            <td class="text-center">{{$item['origin_book']}}</td>
                                                            <td class="text-center">{{$item['category']}}</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-danger p-1" onclick="confirm_me_post('Data yang dihapus tidak dapat dikembalikan', {id:{{$item['id']}}} , '{{route('book-delete')}}')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary p-1" data-toggle="modal"  data-target=".bd-edit-modal-lg"> <i class="fa fa-edit"> </i> </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Add Buku --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <form action="{{route('duplicate-book')}}" method="POST">@csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Buku</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="examplar" value="{{$data[0]['examplar']}}">
                            <div class="col-6 mt-3">
                                <label>Penulis : </label><br>
                                <input required class="date form-control"  name="creator" value="{{$data[0]['creator']}}" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Pilih Penerbit : </label>
                                <select required class="form-control" style="width: 100%;" name="publisher_id">
                                    @foreach($publisher as $item)
                                        <option value="{{ $item['id'] }}" @if($data[0]['publisher_id'] == $item['id']) selected @endif>{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Pilih Edisi : </label>
                                <input required class="date form-control"  name="edition" value="{{$data[0]['edition']}}" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Pilih Loker : </label>
                                <select required class="form-control" style="width: 100%" name="locker_id">
                                    <option value="" hidden>Pilih Loker</option>
                                    @foreach($locker as $item)
                                        <option @if($data[0]['locker_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                                            {{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Asal Buku : </label>
                                <input required class="date form-control"  name="origin_book"  type="text" value="{{$data[0]['origin_book']}}">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Tahun Pembelian : </label>
                                <input required class=" form-control" autocomplete="off"  name="buying_year" type="date">
                            </div>
                            <div class="col-12 mt-4">
                                <label for="pfgInp">Upload Pdf</label>
                                <input type='file' name='link_pdf' />
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Tahun Penerbit : </label>
                                <input required class=" form-control" autocomplete="off"  name="publish_year" type="date">
                            </div>
                            <div class="col-12 mt-3">
                                <label for="">Deskripsi : </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            <button class="btn btn-success" id="btn-tambah-books" type="submit">Tambah Buku</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Modal Edit --}}
<div class="modal fade bd-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <form action="{{ url('books-management/'.$data[0]['examplar'].'/edit-books') }}" enctype="multipart/form-data" method="POST">@csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Buku</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="examplar" value="{{$data[0]['examplar']}}">
                            <div class="col-6 mt-3">
                                <label>Judul : </label><br>
                                <input required class="date form-control"  name="name" value="{{$data[0]['name']}}" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label>Pilih Kategori : </label><br>
                                <select required class="form-control" style="width: 100%" name="category_id">
                                    <option value="" hidden>Pilih Kategori</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label>Penulis : </label><br>
                                <input required class="date form-control"  name="creator" value="{{$data[0]['creator']}}" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Pilih Loker : </label>
                                <select required class="form-control" style="width: 100%" name="locker_id">
                                    <option value="" hidden>Pilih Loker</option>
                                    @foreach($locker as $item)
                                    <option @if($data[0]['locker_id'] == $item['id']) selected @endif value="{{ $item['id'] }}">
                                        {{ $item['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                            {{-- <div class="col-6 mt-3">
                                <label for="pfgInp">Upload Pdf</label>
                                <input type='file' name='link_pdf' />
                            </div> --}}
                            <div class="col-6 mt-3">
                                <label for="">Asal Buku : </label>
                                <input required class="date form-control"  name="origin_book"  type="text" value="{{$data[0]['origin_book']}}">
                            </div>
                            <div class="col-12 mt-1">
                                <label for="imgInp">
                                <input type='file' name="cover" id="imgInp" class="d-none"/>
                                @if($data[0]['cover'] == true)
                                <img id="image-preview" src="{{ $data[0]['cover'] }}" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                                @else
                                <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
                                @endif
                            </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group text-center">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                            <button class="btn btn-success" id="btn-tambah-books" type="submit">Tambah Buku</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $('#buying_year, #publish_year').datepicker({
            changeMonth: true,
            changeYear: true
        });
        function setIdBooks(id){
            $('#id_books').val(id)
        }
    </script>
@endsection
