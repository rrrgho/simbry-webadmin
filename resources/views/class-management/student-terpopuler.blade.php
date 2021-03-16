@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'class-management', 
  'activePage' => 'terpopuler-data', 
  'title' => __('Manajemen Siswa Terpopuler'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
    <div class="row">
      <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
          <h3>Manajemen Siswa Terpopuler</h3>
          <p>anda dapat menambah, mengedit atau menghapus data disini !</p>
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
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        </div>
    @endif
<div class="row">
  <div class="col-md-12 col-lg-12">
    {{-- <button class="btn btn-danger p-2 mt-3" onclick="location.href='{{ route('reset-point') }}'">Reset Point</button> --}}
    <form action="{{ route('reset-point') }}" method="POST">@csrf
      <button type="submit" class="btn btn-danger p-2 mt-3">Reset Point</button>
    </form>
      <div class="card">
          <div class="card-header">
              <h3>Siswa SMK Terpopuler</h3>
          </div>
        <div class="card-body">
              <table class="ui celled table table-striped" id="">
                <thead>
                    <tr class="text-center">
                        <th>Nama</th>
                        <th>Unit</th>
                        <th>Point</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $smk->name }}</td>
                    <td class="text-center">{{ $smk->unit }}</td>
                    <td class="text-center">{{ $smk->point }}</td>
                    <td class="text-center">
                      <button type="button" class="btn btn-primary p-1" data-toggle="modal" data-target="#smk">
                        Publish
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>   
          </div>
      </div>
      <div class="card">
        <div class="card-header">
            <h3>Siswa SMA Terpopuler</h3>
        </div>
        <div class="card-body">
          <table class="ui celled table table-striped" id="">
            <thead>
                <tr class="text-center">
                  <th>Nama</th>
                  <th>Unit</th>
                  <th>Point</th>
                  <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $sma->name }}</td>
                <td class="text-center">{{ $sma->unit }}</td>
                <td class="text-center">{{ $sma->point }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-primary p-1" data-toggle="modal" data-target="#sma">
                    Publish
                  </button>
                </td>
              </tr>
            </tbody>
          </table>   
        </div>
      </div>
    <div class="card">
      <div class="card-header">
          <h3>Siswa SMP Terpopuler</h3>
      </div>
      <div class="card-body">
        <table class="ui celled table table-striped" id="">
          <thead>
              <tr class="text-center">
                <th>Nama</th>
                <th>Unit</th>
                <th class="text-center">Point</th>
                <th width="100px">Action</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ $smp->name }}</td>
              <td class="text-center">{{ $smp->unit }}</td>
              <td class="text-center">{{ $smp->point }}</td>
              <td class="text-center">
                <button type="button" class="btn btn-primary p-1" data-toggle="modal" data-target="#smp">
                  Publish
                </button>
              </td>
            </tr>
          </tbody>
        </table>   
      </div>
    </div>
  <div class="card">
    <div class="card-header">
        <h3>Siswa SD Terpopuler</h3>
    </div>
    <div class="card-body">
      <table class="ui celled table table-striped" id="">
        <thead>
            <tr class="text-center">
              <th>Nama</th>
              <th>Unit</th>
              <th class="text-center">Point</th>
              <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $sd->name }}</td>
            <td class="text-center">{{ $sd->unit }}</td>
            <td class="text-center">{{ $sd->point }}</td>
            <td class="text-center">
              {{-- <button class="btn btn-primary p-1" onclick="('Harap Perhatikan Data Dengan Baik', {id:{{$sd['id']}}} , '{{ route('student-publish') }}')">
                <i class="fa fa-plus"></i>
              </button> --}}
              <button type="button" class="btn btn-primary p-1" data-toggle="modal" data-target="#sd">
                Publish
              </button>
            </td>
          </tr>
        </tbody>
      </table>   
    </div>
  </div>
  </div>    
</div>
{{-- Modal SMK --}}
<div class="modal fade" id="smk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('student-publish') }}" method="POST">@csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="text" hidden name="user_id" value="{{ $smk['id'] }}">
            <input type="text" hidden name="unit_id" value="{{ $smk['unit'] }}">
            <input type="text" hidden name="point" value="{{ $smk['point'] }}">
          <div class="form-grouop">
            <h5>Nama : {{ $smk['name'] }}</h5>
          </div>
          </div>
          <div class="form-group">
            <h5>Unit : {{ $smk['unit'] }}</h5>
          </div>
          <div class="form-group">
            <h5>point : {{ $smk['point'] }}</h5>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal SMA --}}
<div class="modal fade" id="sma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('student-publish') }}" method="POST">@csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="text" hidden name="user_id" value="{{ $sma['id'] }}">
            <input type="text" hidden name="unit_id" value="{{ $sma['unit'] }}">
            <input type="text" hidden name="point" value="{{ $sma['point'] }}">
          <div class="form-grouop">
            <h5>Nama : {{ $sma['name'] }}</h5>
          </div>
          </div>
          <div class="form-group">
            <h5>Unit : {{ $sma['unit'] }}</h5>
          </div>
          <div class="form-group">
            <h5>point : {{ $sma['point'] }}</h5>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal SMP --}}
<div class="modal fade" id="smp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('student-publish') }}" method="POST">@csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="text" hidden name="user_id" value="{{ $smp['id'] }}">
            <input type="text" hidden name="unit_id" value="{{ $smp['unit'] }}">
            <input type="text" hidden name="point" value="{{ $smp['point'] }}">
          <div class="form-grouop">
            <h5>Nama : {{ $smp['name'] }}</h5>
          </div>
          </div>
          <div class="form-group">
            <h5>Unit : {{ $smp['unit'] }}</h5>
          </div>
          <div class="form-group">
            <h5>point : {{ $smp['point'] }}</h5>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal SD --}}
<div class="modal fade" id="sd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Publish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('student-publish') }}" method="POST">@csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="text" hidden name="user_id" value="{{ $sd['id'] }}">
            <input type="text" hidden name="unit_id" value="{{ $sd['unit'] }}">
            <input type="text" hidden name="point" value="{{ $sd['point'] }}">
          <div class="form-grouop">
            <h5>Nama : {{ $sd['name'] }}</h5>
          </div>
          </div>
          <div class="form-group">
            <h5>Unit : {{ $sd['unit'] }}</h5>
          </div>
          <div class="form-group">
            <h5>point : {{ $sd['point'] }}</h5>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
