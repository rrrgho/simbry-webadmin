@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'management-peminjaman',
  'activePage' => 'peminjaman-extends',
  'title' => __('Perpanjang Peminjaman'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom mb-3">
            <div class="col border-bottom pl 0 pb-3">
                <h3>Riwayat Peminjaman</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data Peminjaman disini !</p>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                {{-- <h3>Peminjaman Berjalan Approved!!</h3> --}}
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="data-history">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            {{-- <th>Kelas</th> --}}
                            <th>Nama Buku</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        @if (!$item->user->deleted_at)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name }}</td>
                            {{-- <td>{{ $item->user->class_relation->name }}</td> --}}
                            <td>{{ $item->book->name }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td class="text-center"><button type="submit" class="btn-primary" data-toggle="modal" onclick="setIdOrder('{{ $item['id'] }}')" data-target="#editPeminjaman"><i class="fa fa-check"></i></button></td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Modal Approved --}}
<div class="modal fade" id="editPeminjaman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('extends') }}" method="POST">@csrf
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Perpanjang Peminjaman</h5>
            <input type="hidden" name="id" id="id_order">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                {{-- <input type="text" name="status" class="form-control" value="SUCCESS" readonly> --}}
                <label>Pilih Status Peminjaman : </label><br>
                <select required class="form-control" style="width: 100%" name="status">
                    <option>APPROVED</option>
                </select>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script>
        function setIdOrder(id){
            $('#id_order').val(id)
        }
         $(document).ready(function() {
            $('#data-history').DataTable();
        } );
    </script>
@endsection
