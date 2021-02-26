@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'management-peminjaman', 
  'activePage' => 'peminjaman-expired', 
  'title' => __('Peminjaman expired'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom mb-3">
            <div class="col border-bottom pl 0 pb-3">
                <h3>Peminjaman Expired!!</h3>
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
                <h3>Peminjaman Expired!!</h3>
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="data-expired">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nama Buku</th>
                            <th>Tanggal Peminjamn</th>
                            <th>Tanggal Expired</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->book->name }}</td>
                                {{-- <td class="text-center">{{ $item->user->user_type_id == 1 ?  'SISWA' : 'GURU' }}</td> --}}
                                <td class="text-center">{{ $item->start_date }}</td>
                                <td class="text-center">{{ $item->end_date }}</td>
                                <td class="text-center"><button class="btn-danger">{{ $item->status }}</td>                        s
                                <td class="text-center"><button type="submit" class="btn-primary" data-toggle="modal" onclick="setIdFinished('{{ $item['id'] }}')" data-target="#editFinished"><i class="fa fa-check"></i></button></td>                        
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
</div>
{{-- Modal Finished Order --}}
<div class="modal fade" id="editFinished" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('finished') }}" method="POST">@csrf
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <input type="hidden" name="id" id="id_finished">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                {{-- <input type="text" name="status" class="form-control" value="SUCCESS" readonly> --}}
                <label>Pilih Status Peminjaman : </label><br>
                <select required class="form-control" style="width: 100%" name="status">
                    <option value="FINISHED">FINSHED</option>
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
        function setIdFinished(id){
                $('#id_finished').val(id)
            }
         $(document).ready(function() {
            $('#data-expired').DataTable();
        } );

    </script>
@endsection
