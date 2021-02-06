<div class="card mt-3" style="border-radius: 10px;">
    <div class="card-header">
        <h3 class="text-secondary">Peminjaman Berjalan</h3>
        <span class="text-secondary">Control peminjaman anda melalui tab ini !</span>
    </div>
    <div class="card-body">
        @if(count($order) > 0)
            @foreach ($order as $item)
                <div class="row mt-3 border p-3 rounded">
                    <div class="col-lg-2 col-md-12 p-0">
                        <img src="{{$item['book']['cover']}}" style="width:100%;" class="card-img-top rounded" alt="..." >
                    </div>
                    <div class="col-lg-8 col-md-12 pt-4">
                        <h3>{{$item['book']['name']}}</h3>
                        <span class="text-secondary">{{$item['book']['description']}}</span>
                        <p>
                            <span class="badge @if($item['status'] == 'PENDING') badge-warning @else badge-success @endif">{{$item['status']}}</span>
                        </p>
                        Waktu Pengajuan : {{$item['created_at']}}
                    </div>
                </div>
            @endforeach
        @else
            <div class="row mt-3 border p-3 rounded">
                <div class="col-12 text-center pb-5">
                    <img src="https://png.pngtree.com/png-vector/20200116/ourmid/pngtree-man-with-sadness-face-concept-for-expression-character-png-image_2129313.jpg" alt="" srcset=""> <br>
                    <div class="display-4 mt-4 text-secondary">
                       Kamu belum punya peminjaman berjalan, ayo pinjam buku !
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>