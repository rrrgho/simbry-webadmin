@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'class-management', 
  'activePage' => 'migrasi-class', 
  'title' => __('Manajemen Migrasi Data'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
    <div class="row">
      <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
          <h3>Migrasi Kelas Siswa</h3>
          <p>anda dapat menambah, mengedit atau menghapus data disini !</p>
        </div>
      </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header bg-light">
            <h1 class="text-success">Perpindahan Kelas Siswa</h1>
            <p>Tambah, edit atau hapus data siswa.</p>
        </div>
        <form action="">@csrf
          <div class="card-body">
            <div class="form-group">
              <select id="select-user" class="form-control" name="user[]" multiple="multiple">
                @foreach ($user as $item)
                  <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <select id="select-class" name="class_id" class="form-control">
                @foreach ($class as $item)
                  <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-light float-right mt-3" id="" type="submit">Pindah Kelas</button>
            </div>
          </div>
        </form>
    </div>
    </div>  
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
    $('#select-user').select2({
      placehodler: 'Pilih Nama Siswa',
      allowclear:true
    });
    $('#select-class').select2({
      placehodler: 'Pilih Kelas',
      allowclear: true
    });
  });
</script>
@endsection