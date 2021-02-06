@if(count($books) > 0)
    @foreach ($books as $item)
        <div class="row mt-3 border p-3 rounded">
            <div class="col-lg-2 col-md-12 p-0">
                <img src="{{$item['cover']}}" style="width:100%;" class="card-img-top rounded" alt="..." >
            </div>
            <div class="col-lg-8 col-md-12 pt-4">
                <h3>{{$item['name']}}</h3>
                <span class="text-secondary">{{$item['description']}}</span>
            </div>
            <div class="col-12 mt-2 p-3">
                <div class="row">
                    <div class="col-lg-9 col-md-12 text-lg-left text-center">
                        <h5 class="mt-4">Scan QR untuk Meminjam atau klik tombol Pinjam !</h5>
                        <img src="http://pngimg.com/uploads/star/star_PNG1594.png" style="width: 50px; height:50px;" alt="" srcset="">
                        <span class="ml-2 mt-2">7.8 of 10</span> <br>
                        <button class="btn btn-success mt-3 mb-3" onclick="orderBook('{{Auth::user()->id}}', '{{$item['examplar']}}')">Pinjam Buku {{Auth::user()->id}}</button>
                    </div>
                    <div class="col-lg-3 col-md-12  text-lg-right text-center">
                        {!! QrCode::size(200)->generate('https://www.youtube.com/channel/UC1jEJ2FjhuJzV3-hEt9WM2Q'); !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="row mt-3 border p-3 rounded">
        <div class="col-12 text-center pb-5">
            <img src="https://png.pngtree.com/png-vector/20200116/ourmid/pngtree-man-with-sadness-face-concept-for-expression-character-png-image_2129313.jpg" alt="" srcset=""> <br>
            <div class="display-4 mt-4 text-secondary">
                Maaf ya.. Datanya gak ada :(
            </div>
        </div>
    </div>
@endif