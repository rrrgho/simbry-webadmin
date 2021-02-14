@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peraturan', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'Peminjaman masuk', 
  'title' => __('Peminjaman masuk'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Management Peminjaman masuk</h3>
            <p>Anda dapat melihat Peminjaman Masuk!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Pengaturan Approved & Declined !!</h3>
                </div>
                <div class="card-body">
                    <table class="ui celled table table-striped" id="peminjaman">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>NIP</th>
                                <th>Nomor Buku</th>
                                <th>Status</th>
                                <th>Created_at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td class="text-center">{{ $item->book_id }}</td>
                                <td class="text-center"><button class="btn-danger">{{ $item->status }}</button></td>
                                <td class="text-center">{{ $item->created_at }}</td>
                                <td class="text-center"><button type="submit" class="btn-primary" data-toggle="modal" onclick="setIdOrder('{{ $item['id'] }}')" data-target="#editPeminjaman"><i class="fa fa-check"></i></button></td>
                            </tr>
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
            <form action="{{ route('approved') }}" method="POST">@csrf
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <input type="hidden" name="id" id="id_order">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    {{-- <input type="text" name="status" class="form-control" value="SUCCESS" readonly> --}}
                    <label>Pilih Status Peminjaman : </label><br>
                    <select required class="form-control" style="width: 100%" name="status">
                        <option value="APPROVED">APPROVED</option>
                        <option value="CANCEL">CANCEL</option>
                        
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
    // Datatable
      function setIdOrder(id){
            $('#id_order').val(id)
        }
        
        $(document).ready(function() {
            $('#peminjaman').DataTable();
        } );
    </script>
@endsection
