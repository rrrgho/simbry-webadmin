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
            <input type="text" name="user_number" id="user-id" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="book-id">No Induk Buku</label>
            <input type="text" name="book_number" id="book-id" class="form-control" required>
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
      console.log('tes');
      $('#select-peminjam').select2()
      $('#select-buku-peminjam').select2();
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