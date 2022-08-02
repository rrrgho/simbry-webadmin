@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peraturan', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'pemulangan-buku',
  'title' => __('Pemulangan Buku'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Pemulangan Buku</h3>
            <p>Anda dapat melihat Buku Peminjaman sudah harus di kembalikan!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<ul>
  @foreach ($errors->all() as $item)
      <li>{{ $item }}</li>
  @endforeach
</ul>
@if(session('success'))
<div class="row pb-4">
    <div class="col-7">
        <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i data-feather="thumbs-up"></i>
            <p>{{session('success')['message']}}</p>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
    </div>
</div>
@endif
  <form action="{{ url('pemulangan') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-lg-7 col-md-12">
        <div class="card">
          <div class="card header">
            <h3 class="text-center">Menu Pemulangan Buku</h3>
          </div>
          <div class="card-body">
          <div class="form-group">
            <label for="user-id">No Induk Siswa/ No Induk Guru</label>
            @if($data->count())
                <label for="">Pilih Siswa/Guru : </label>
                <select required class="form-control" style="width: 100%" name="user_number" id="user_number">
                    <option value="" hidden>Pilih Siswa/Guru</option>
                    @foreach($data as $item)
                    <option value="{{ $item['user_number'] }}">
                        {{ $item['name'] }} - {{ $item['user_number'] }}</option>
                    @endforeach
                </select>
            @else
                <select name="" id="" hidden required>
                </select>
                <div class="alert alert-warning">
                    Data User/Guru buku tidak di temukan ! mohon masukkan data loker!!
                </div>
            @endif
            {{-- <input type="text" name="user_number" id="user-id" class="form-control" required> --}}
          </div>
          <div class="form-group">
            <label for="book-id">No Induk Buku</label>
            @if($book->count())
                <label for="">Pilih No Induk Buku : </label>
                <select required class="form-control" style="width: 100%" name="book_number" id="book_number">
                    <option value="" hidden>Pilih No Induk Buku</option>
                    @foreach($book as $item)
                    <option value="{{ $item['book_number'] }}">
                        {{ $item['name'] }} - {{ $item['book_number'] }}</option>
                    @endforeach
                </select>
            @else
                <select name="" id="" hidden required>
                </select>
                <div class="alert alert-warning">
                    Data User/Guru buku tidak di temukan ! mohon masukkan data loker!!
                </div>
            @endif
            {{-- <input type="text" name="book_number" id="book-id" class="form-control" required> --}}
          </div>
          <div class="card-footer">
            <div class="form-group">
                <button class="btn btn-success">Kembalikan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
@section('script')
    <script>
      $('#user_number').select2()
      $('#book_number').select2();
      // $(document).ready(function() {

      // });
      $('#select-peminjam').change(function (e) {
        const userId = $(this).val()

        $.ajax({
          url: '/get-book-user',
          data: {
            user_id: userId
          },
          success: function (res) {
            let html = ''

            res.forEach(el => {
              // console.log(el.book.id);
              // console.log(el.book.name);
              html += `<option value="${el.book.id}">${el.book.name}</option>`
            });

            $('#select-buku-peminjam').html(html)
            // console.log(res);
          },
          error: function (err) {
            alert('Gagal mengambil data buku')
          }
        })
      })
    </script>
@endsection
