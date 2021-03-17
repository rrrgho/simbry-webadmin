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
                  @if(count($smk)>0)
                    @foreach ($smk as $item)
                      <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">{{ $item->unit }}</td>
                        <td class="text-center">{{ $item->point }}</td>
                        <td class="text-center">
                          <form id="publish-form" action="{{ route('student-publish') }}" method="POST">@csrf
                            <input type="hidden" name="user_id" value="{{$item['id']}}">
                            <input type="hidden" name="unit_id" value="{{$item['unit']}}">
                            <input type="hidden" name="point" value="{{$item['point']}}">
                            @php $isPublish = false; @endphp
                            @foreach ($popular as $hasPublish)
                              <?php
                                if($hasPublish['user_id'] != $item['id'])
                                  $isPublish = false;
                                else {
                                  $isPublish = true; break;
                                }
                              ?>                    
                            @endforeach
                            @if($isPublish == false)
                              <button type="submit" class="btn btn-primary p-1" data-toggle="modal" data-target="#sd">
                                PUBLISH
                              </button>
                            @else
                              <button disabled class="btn btn-success p-1">
                                PUBLISHED
                              </button>
                            @endif
                          </form>
                        </td>
                      </tr>                      
                    @endforeach
                  @else
                      <tr>
                        <td colspan="4">
                          <div class="alert alert-warning">
                            <span class="ml-2">
                              Belum ada data yang dihitung oleh system !
                            </span>
                          </div>
                        </td>
                      </tr>
                  @endif
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
              @if(count($sma) > 0)
                @foreach ($sma as $item)
                  <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->unit }}</td>
                    <td class="text-center">{{ $item->point }}</td>
                    <td class="text-center">
                      <form id="publish-form" action="{{ route('student-publish') }}" method="POST">@csrf
                        <input type="hidden" name="user_id" value="{{$item['id']}}">
                        <input type="hidden" name="unit_id" value="{{$item['unit']}}">
                        <input type="hidden" name="point" value="{{$item['point']}}">
                        @php $isPublish = false; @endphp
                        @foreach ($popular as $hasPublish)
                          <?php
                            if($hasPublish['user_id'] != $item['id'])
                              $isPublish = false;
                            else {
                              $isPublish = true; break;
                            }
                          ?>                    
                        @endforeach
                        @if($isPublish == false)
                          <button type="submit" class="btn btn-primary p-1" data-toggle="modal" data-target="#sd">
                            PUBLISH
                          </button>
                        @else
                          <button disabled class="btn btn-success p-1">
                            PUBLISHED
                          </button>
                        @endif
                      </form>
                    </td>
                  </tr>                  
                @endforeach
              @else
                <tr>
                  <td colspan="4">
                    <div class="alert alert-warning">
                      <span class="ml-2">
                        Belum ada data yang dihitung oleh system !
                      </span>
                    </div>
                  </td>
                </tr>
              @endif
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
            @if(count($smp) > 0)
              @foreach ($smp as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td class="text-center">{{ $item->unit }}</td>
                  <td class="text-center">{{ $item->point }}</td>
                  <td class="text-center">
                    <form id="publish-form" action="{{ route('student-publish') }}" method="POST">@csrf
                      <input type="hidden" name="user_id" value="{{$item['id']}}">
                      <input type="hidden" name="unit_id" value="{{$item['unit']}}">
                      <input type="hidden" name="point" value="{{$item['point']}}">
                      @php $isPublish = false; @endphp
                      @foreach ($popular as $hasPublish)
                        <?php
                          if($hasPublish['user_id'] != $item['id'])
                            $isPublish = false;
                          else {
                            $isPublish = true; break;
                          }
                        ?>                    
                      @endforeach
                      @if($isPublish == false)
                        <button type="submit" class="btn btn-primary p-1" data-toggle="modal" data-target="#sd">
                          PUBLISH
                        </button>
                      @else
                        <button disabled class="btn btn-success p-1">
                          PUBLISHED
                        </button>
                      @endif
                    </form>
                  </td>
                </tr>                
              @endforeach
            @else
              <tr>
                <td colspan="4">
                  <div class="alert alert-warning">
                    <span class="ml-2">
                      Belum ada data yang dihitung oleh system !
                    </span>
                  </div>
                </td>
              </tr>
            @endif
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
          @if(count($sd) > 0)
            @foreach ($sd as $item)
              <tr>
                <td>{{ $item->name }}</td>
                <td class="text-center">{{ $item->unit }}</td>
                <td class="text-center">{{ $item->point }}</td>
                <td class="text-center">
                  <form id="publish-form" action="{{ route('student-publish') }}" method="POST">@csrf
                    <input type="hidden" name="user_id" value="{{$item['id']}}">
                    <input type="hidden" name="unit_id" value="{{$item['unit']}}">
                    <input type="hidden" name="point" value="{{$item['point']}}">
                    @php $isPublish = false; @endphp
                    @foreach ($popular as $hasPublish)
                      <?php
                        if($hasPublish['user_id'] != $item['id'])
                          $isPublish = false;
                        else {
                          $isPublish = true; break;
                        }
                      ?>                    
                    @endforeach
                    @if($isPublish == false)
                      <button type="submit" class="btn btn-primary p-1" data-toggle="modal" data-target="#sd">
                        PUBLISH
                      </button>
                    @else
                      <button disabled class="btn btn-success p-1">
                        PUBLISHED
                      </button>
                    @endif
                  </form>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="4">
                <div class="alert alert-warning">
                  <span class="ml-2">
                    Belum ada data yang dihitung oleh system !
                  </span>
                </div>
              </td>
            </tr>
          @endif
        </tbody>
      </table>   
    </div>
  </div>
  </div>    
</div>

@endsection
