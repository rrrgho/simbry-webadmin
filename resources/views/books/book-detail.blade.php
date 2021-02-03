@extends('layouts.app', [
'breadcrumbs' => [
[ 'page' => 'Data Buku', 'link' => route('main-books')],
[ 'page' => 'Detail ' . $data['name'], 'link' => route('book-detail', [$data['examplar']])],
],
'class' => 'off-canvas-sidebar',
'activeMainPage' => 'books',
'activePage' => 'books-data',
'title' => __('Data Buku'),
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Detail {{$data['name']}}</h1>
                <p></p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <img src="{{$data['cover']}}" class="img-fluid rounded" alt="...">
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="card">
                            <div class="card-header bg-light">
                                <span style="font-size: 25px">{{$data['name']}}</span> <br><br>
                            </div>
                            <div class="card-body">
                                <span style="opacity: 0.7; margin-top:10px;">{{$data['description'] ?? 'Tidak ada deskripsi'}}</span>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <table class="table table-striped">
                                            <thead class="bg-light">
                                                <tr class="text-center">
                                                    <th>Kode Examplar</th>
                                                    <th>Jumlah Copy</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>{{$data['examplar']}}</td>
                                                    <td>
                                                        <button class="btn btn-success mr-2 p-1" id="delete"><i class="fa fa-minus"></i></button>
                                                        <span id="amount"></span>
                                                        <button class="btn btn-success ml-2 p-1" id="duplicate"><i class="fa fa-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
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



@endsection
@section('script') 
    <script>
        let amount = "{{$data['copy_amount']}}";
        $('#amount').text('aa')
        $('#delete').click(function(){
            var formData = new FormData();
            formData.append('examplar', "{{$data['examplar']}}")
            swal({
                title: "Are you sure?",
                text: "Data buku yang dihapus tidak dapat dikembalikan",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{route('delete-book')}}",
                            type: 'POST', cache: false, contentType: false, processData: false,
                            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            success:function(response){
                                if(response.error != true){
                                    infoSuccess(response.message)
                                    $('#amount').text(amount)-1)
                                }
                            }
                        });
                    }
                });
        });

        $('#duplicate').click(function(){
            var formData = new FormData();
            formData.append('examplar', "{{$data['examplar']}}")
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin untuk menambah jumlah buku ini ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{route('duplicate-book')}}",
                            type: 'POST', cache: false, contentType: false, processData: false,
                            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                            data: formData,
                            success:function(response){
                                if(response.error != true){
                                    infoSuccess(response.message)
                                    $('#amount').text(Number(amount)+1)
                                }
                            }
                        });
                    }
                });
        })
    </script>
@endsection
