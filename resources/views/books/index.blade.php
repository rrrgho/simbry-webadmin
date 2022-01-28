@extends('layouts.app', [
'breadcrumbs' => [
[ 'page' => 'Menambahkan Buku', 'link' => 'http://dashboard.com'],
],
'class' => 'off-canvas-sidebar',
'activeMainPage' => 'books-management',
'activePage' => 'books-data',
'title' => __('Menambahkan Buku'),
'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')

{{-- <style>
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
</style> --}}
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
@if(session('success'))
    <div class="row pb-4 noPrint" id="flash-message">
        <div class="col-12">
            <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i
                    data-feather="thumbs-up"></i>
                <p>{{ session('success') }}</p>
                <button class="btn btn-success position-absolute" onclick="getAddBooksComponent()" data-toggle="modal"
                    id="btn-add-books" data-target="#addBooks" style="right: 10px; top:10px"><i class="fa fa-plus"></i>
                    Tambah Buku</button>
            </div>
        </div>
    </div>
@endif
<div class="row">
    {{-- <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Data Buku Examplar</h1>
                <p>Menampilkan data buku berdasarkan jumlah Examplar.</p>
                <button class="btn btn-success position-absolute" data-toggle="modal" data-target=".bd-example-modal-lg"
                    style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Buku</button>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4" id="data-book">
                    <table class="ui celled table table-striped" id="data-buku-examplar">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Examplar</th>
                                <th>Jumlah Copy</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12" id="qrWrapper">

    </div>

    <div class="col-md-12 noPrint">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Data Seluruh Buku</h1>
                <p>Anda hanya bisa mengedit data !</p>
                <button class="btn btn-success position-absolute" data-toggle="modal" data-target=".bd-example-modal-lg"
                    style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Buku</button>
                    <a class="btn btn-success" href="{{ route('books-export') }}">Export Books</a>
                    <a class="btn btn-success" href="{{ route('books-peryear') }}">Laporan Buku</a>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4" id="data-book">
                    <table class="ui celled table table-striped" id="data-buku">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nomor Induk</th>
                                <th>Nomor Panggil</th>
                                <th>Kode Buku</th>
                                <th>Nomor Panggil</th>
                                <th>Nomor Examplar</th>
                                <th>Kategori</th>
                                <th>Loker</th>
                                <th>Action</th>
                                <th>List QR</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Add Buku --}}
<div class="modal fade bd-example-modal-lg noPrint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <form id="form-add-buku" enctype="multipart/form-data" method="POST">@csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Buku</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="alert alert-danger d-none" id="warning">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Nama Buku : </label>
                                <input required class="form-control" name="name" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Jumlah Copy : </label>
                                <input required class="date form-control"  name="copy_amount" value="1" type="number">
                            </div>
                            <div class="col-6 mt-3">
                                @if($category->count())
                                <label>Pilih Kategori : </label><br>
                                <select required class="form-control" style="width: 100%" name="category_id">
                                    <option value="" hidden>Pilih Kategori</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select name="" id="" hidden required>
                                </select>
                                <div class="alert alert-warning">
                                    Data kategori buku tidak di temukan ! mohon masukkan data kategori!!
                                </div>
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label>Penulis : </label><br>
                                <input required class="date form-control"  name="creator" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                @if($publisher->count())
                                <label for="">Pilih Penerbit : </label>
                                <select required class="form-control" style="width: 100%;" name="publisher_id">
                                    <option value="" hidden>Pilih Penerbit</option>
                                    @foreach($publisher as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select name="" id="" hidden required>
                                </select>
                                <div class="alert alert-warning">
                                    Data penerbit buku tidak di temukan ! mohon masukkan data penerbit!!
                                </div>
                                @endif
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Pilih Edisi : </label>
                                <input required class="date form-control"  name="edition" value="" type="text">
                            </div>
                            <div class="col-6 mt-3">
                                @if($locker->count())
                                    <label for="">Pilih Loker : </label>
                                    <select required class="form-control" style="width: 100%" name="locker_id">
                                        <option value="" hidden>Pilih Loker</option>
                                        @foreach($locker as $item)
                                        <option value="{{ $item['id'] }}">
                                            {{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="" id="" hidden required>
                                    </select>
                                    <div class="alert alert-warning">
                                        Data loker buku tidak di temukan ! mohon masukkan data loker!!
                                    </div>
                                @endif

                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Asal Buku : </label>
                                <input required class="date form-control"  name="origin_book"  type="text">
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Tahun Pembelian : </label>
                                <input type="date" class="form-control" value="" name="buying_year" required>
                                {{-- <input required class="form-control"  id="buying_year" name="buying_year" type="text"> --}}
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Tahun Penerbit : </label>
                                <input type="date" class="form-control" value="" name="publish_year" required>
                                {{-- <input required class="form-control" id="publish_year" name="publish_year" type="text"> --}}
                            </div>
                            <div class="col-6 mt-3">
                                <label for="">Nomor Panggil : </label>
                                <input type="text" class="form-control" value="" name="no_panggil" required>
                                {{-- <input required class="form-control" id="publish_year" name="publish_year" type="text"> --}}
                            </div>
                            <div class="col-6 mt-3">
                                <label for="pfgInp">Upload Pdf</label>
                                <input type='file' name='link_pdf' />
                            </div>
                            <div class="col-12 mt-3">
                                <label for="">Deskripsi : </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                                    rows="3"></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <label for="imgInp">
                                <input type='file' name="cover" id="imgInp" class="d-none"/>
                                <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; height:50%; cursor: pointer;" alt="your image" />
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
{{-- Modal Edit Buku --}}



@endsection
@section('script')
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $( function() {
        $('#buying_year').datepicker();
    } );
    let callEditComponent = false;
    let editBooksId;
    // Add
    $('#form-add-buku').submit(function(event){
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ url('books-management/books') }}",
            type: 'POST', cache: false, contentType: false, processData: false,
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            success:function(response){
                if(response.error == true){
                    $('#warning').removeClass('d-none').text(response.message)
                }else{
                    infoSuccess(response.message)
                    setTimeout(() => {
                        location.reload()
                    },200)
                }
            }
        })
    })



    // Datatable
    $(function(){
        let printQR = []
        let hasListed = []
        var table = $('#data-buku').DataTable({
            ajax: {
                url :'{{route('books-datatable')}}',
            },
            columns: [
                // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'book_number', name: 'book_number'},
                { data: 'no_panggil', name: 'no_panggil'},
                { data: 'code_of_book', name: 'code_of_book'},
                { data: 'call_number', name: 'call_number'},
                { data: 'examplar', name: 'examplar'},
                { data: 'category_relation.name', name: 'category_relation.name'},
                { data: 'locker', name: 'locker'},
                { data: 'action', name: 'action'},
                { data: null, "searchable": false, defaultContent:
                `<button id="detail" class="btn btn-success p-1"><i class="fa fa-print"></i></button>`
                }

            ],
            language: {
            searchPlaceholder: 'Search Buku..',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },
            columnDefs:[
                {
                    "targets" : [2,3,4,5,6,7,8,9],
                    "className": "text-center"
                },
                {
                    "targets" : [0],
                    "visible" : false
                }
            ],

            dom: 'Bfrtip',  
            buttons: [
                {extend:'copy', className: 'bg-info text-white rounded-pill ml-2 border border-white'},
                {extend:'excel', className: 'bg-success text-white rounded-pill border border-white'},
                {extend:'pdf', className: 'bg-danger text-white rounded-pill border border-white'},
                {extend:'print', className: 'bg-warning text-white rounded-pill border border-white'},
            ],
            // retrieve: true,
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
        });


        $('#data-buku tbody').on('click', '#detail', function(){
            if(hasListed.length !== 50){
                var data = table.row( $(this).parents('tr') ).data();
                let store = {id : data.id, number:data.book_number}

                printQR.push(store)
                hasListed.push(data.id)
                $.ajax({
                    url : "{{route('print-qr')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        data : printQR
                    },
                    success: function(response){
                        $('#qrWrapper').html(response)
                    }
                })
                $(this).attr('disabled',true).html("<i class='fa fa-check'> </i>")
            }else{
                swal({
                    title: "Sorry?",
                    text: "maximal listing hanya 50 QR",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
            }
        })

    });

    // $(function(){
    //     $('#data-buku-examplar').DataTable({
    //         ajax: {
    //             url :'{{route('books-datatable-examplar')}}',
    //         },
    //         columns: [
    //             { data: 'DT_RowIndex', name: 'DT_RowIndex' },
    //             { data: 'name', name: 'name'},
    //             { data: 'examplar', name: 'examplar'},
    //             { data: 'copy_amount', name: 'copy_amount'},
    //             { data: 'action', name: 'action', 'render': function(data){
    //                 return data
    //             }},

    //         ],
    //         language: {
    //         searchPlaceholder: 'Search Buku..',
    //         sSearch: '',
    //         lengthMenu: '_MENU_ items/page',
    //         destroy: true
    //         },
    //         columnDefs:[
    //             {
    //                 "targets" : [0,1,2,3,4],
    //                 "className": "text-center"
    //             },
    //         ],

    //         dom: 'Bfrtip',
    //         buttons: [
    //             {extend:'copy', className: 'bg-info text-white rounded-pill ml-2 border border-white'},
    //             {extend:'excel', className: 'bg-success text-white rounded-pill border border-white'},
    //             {extend:'pdf', className: 'bg-danger text-white rounded-pill border border-white'},
    //             {extend:'print', className: 'bg-warning text-white rounded-pill border border-white'},
    //         ],
    //         "bDestroy": true,
    //         "processing": true,
    //         "serverSide": true,
    //     });
    // });

    // Datepicker
    $('#buying_year, #publish_year').datepicker({
        changeMonth: true,
        changeYear: true
    });
</script>
@endsection
