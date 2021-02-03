@extends('layouts-user.index')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-10">
            <div class="section-title text-center pb-10">
                <h3 class="title">Cari Buku</h3>
                <p class="text">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
                <p class="mt-4">
                    <form action="{{url('user')}}" method="POST">@csrf
                        <input type="text" class="form-control" name="judul" placeholder="Cari buku berdasarkan Judul buku">
                        <button class="btn btn-info btn-block mt-2" submit>Cari</button>
                    </form>
                </p>
            </div> <!-- row -->
        </div>
    </div> <!-- row -->
    <div class="row justify-content-center">
        @foreach ($books as $item)
            <div class="col-lg-5 col-md-12 col-sm-12 bg-white mt-4 mr-4" style="border-radius: 10px !important;">
                <div class="row">
                    <div class="col-6">
                        <div class="single-features mt-40">
                            <div class="features-title-icon d-flex justify-content-between">
                                <h4 style="font-size: 18px;"><a href="#">{{$item['name']}}</a></h4>
                            </div>
                            <div class="features-content mt-3">
                                <p style="font-size: 14px;">
                                    Kategori : {{$item['category_name']}} <br>
                                    Penerbit : {{$item['publisher_name']}} <br>
                                    Loker : {{$item['locker_name']}} <br>
                                    Edisi : {{$item['edition_name']}} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-2 text-center">
                        <img src="{{$item['cover']}}" style="border-radius:10px; min-height:300px; max-height:300px; width:100%;" alt="" srcset="">
                    </div>
                </div>
            </div>  
        @endforeach
    </div>
    <div class="row justify-content-center  mt-3">
        <div class="col-md-12 text-center">
            {{$books->links()}}
        </div>
    </div>
@endsection