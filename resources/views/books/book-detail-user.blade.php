@extends('layouts-user.index')


@section('content')
<div class="card mt-4">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <img src="{{$data['cover']}}" class="img-fluid rounded" style="width:100%; min-height:300px;" alt="...">
            </div>
            <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header bg-light">
                            <span class="mt-2" style="font-size: 25px">Judul Buku : </h3><span style="font-size: 25px">{{$data['name']}}</span> <br><br>
                        </div>
                        <div class="card-body">
                            <span style="opacity: 0.7; margin-top:10px;">Deskripsi :</span> <span style="opacity: 0.7; margin-top:10px;">{{$data['description'] ?? 'Tidak ada deskripsi'}}</span>
                             <h4>Status Buku</h4>
                             <p style="font-size: 14px;">
                                Kategori : {{$item['category_name']}} <br>
                                Salinan Buku : {{$copy['copy_amount']}} <br>
                                Tersedia Buku : {{ $redy['redy'] }}
                            </p>
                        </div>
                    </div>
                    <div class="visible-print text-center" style="margin-top: 150px;">
                        {!! QrCode::size(150)->generate('https://www.youtube.com/channel/UC1jEJ2FjhuJzV3-hEt9WM2Q'); !!}
                        <p class="mt-2">Scan untuk meminjam buku ini atau klik tombol dibawah</p>
                    </div>
                    <div class="col text-center mt-2">
                        <button class="btn btn-success">Pinjam Buku</button>
                    </div>
            </div>
        </div>                
    </div>
</div>
@endsection
@section('script') 
    {{-- <script>
        let amount = "{{$data['copy_amount']}}"
        $('#amount').text(Number(amount))
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
                                    $('#amount').text(Number(amount) - 1)
                                    amount = Number(amount)-1
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
                                    amount = Number(amount)+1
                                }
                            }
                        });
                    }
                });
        })
    </script> --}}
@endsection
