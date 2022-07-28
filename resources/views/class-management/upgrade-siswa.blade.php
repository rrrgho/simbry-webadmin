@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'class-management',
  'activePage' => 'upgrade-siswa',
  'title' => __('Upgrade Siswa'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12">
            <div class="col border-bottom pl-0 pb-3">
                <h3>Upgrade Siswa</h3>
                <p>Pilih kelas, lalu pilih kelas tujuan</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
            <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
                <p>{{session('success')['message']}}</p>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            @endif
            @if (session('failed'))
            <div class="alert alert-danger outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
                <p>{{session('failed')['message']}}</p>
                <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            @endif
            <div class="card">
                <div class="card-header bg-light">
                    <h1 class="text-success">Delete Kelas</h1>
                    <p>Pilih Kelas</p>

                </div>
                <form action="{{route('delete-class')}}" method="POST">@csrf
                    <div class="card-body">
                        <div class="col">
                            <select required name="class_id" id="class_delete" class="form-control">
                                <option value="" hidden>Pilih Kelas</option>
                                @foreach ($class as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-success">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header bg-light">
                    <h1 class="text-success">Cari Data</h1>
                    <p>Pilih Kelas</p>

                </div>
                <form action="" method="POST">@csrf
                    <div class="card-body">
                        <div class="col">
                            <select required name="class_id" id="class" class="form-control">
                                <option value="" hidden>Pilih Kelas</option>
                                @foreach ($class as $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button class="btn btn-success">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Data Siswa</h3>
                    <span>Silahkan pilih siswa dibawah lalu pilih kelas tujuan</span>
                </div>
                @if(isset($data))
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <form action="{{route('move-class')}}" method="POST">@csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-4">
                                            <input name="subject_all" class="subject-all mr-3" type="checkbox" checked>Pilih Semua <br>
                                            @foreach ($data as $item)
                                                {{-- <li style="list-style: none"> <input class="subject-list" checked type="checkbox" name="user_id[]" value="{{$item['id']}}" class="mr-3">{{$item['name']}}</li> --}}
                                                <li style="list-style: none"><input type="checkbox" checked name="user_id[]" value="{{$item['id']}}" class="mr-3 subject-list">{{$item['name']}}</li>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="col">
                                                <select required name="class_id" id="class_move" class="form-control">
                                                    <option value="" hidden>Pilih Kelas Tujuan</option>
                                                    @foreach ($class as $item)
                                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-success">Pindahkan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-6">
                            <form action="{{route('main-delete-siswa')}}" method="POST">@csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-4">
                                            <input name="subject_all" class="subject-all-delete mr-3" type="checkbox" checked>Pilih Semua <br>
                                            @foreach ($data as $item)
                                                {{-- <li style="list-style: none"> <input class="subject-list" checked type="checkbox" name="user_id[]" value="{{$item['id']}}" class="mr-3">{{$item['name']}}</li> --}}
                                                <li style="list-style: none"><input type="checkbox" checked name="user_id[]" value="{{$item['id']}}" class="mr-3 subject-list-delete">{{$item['name']}}</li>
                                            @endforeach
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="col">
                                                <button class="btn btn-danger">
                                                    <i class="fa fa-trash"></i> Delete Siswa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                @else
                    <div class="card-body">
                        <div class="alert alert-warning">
                            Data tidak ditemukan atau mungkin Anda belum memilih kelas !
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#class').select2()
        $('#class_move').select2()
        $('#class_delete').select2()
       $('.subject-all').on('change', function() {
	    	if(this.checked){
		    	$('.subject-list').prop('checked', true);
	    	}else{
	    		$('.subject-list').prop('checked', false);
	    	}
		});
       $('.subject-all-delete').on('change', function() {
	    	if(this.checked){
		    	$('.subject-list-delete').prop('checked', true);
	    	}else{
	    		$('.subject-list-delete').prop('checked', false);
	    	}
		});
    </script>
@endsection
