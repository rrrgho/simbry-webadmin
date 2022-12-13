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
        {{-- <div class="container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filter"> <i class="fa fa-filter"></i> </button>
        </div>   --}}
        <div class="card">
            <div class="card-header">
                {{-- <h3>Peminjaman Expired!!</h3> --}}
            </div>
            <div class="card-body">
                <table class="ui celled table table-striped" id="data-expired">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Induk Siswa/Guru</th>
                            <th>Kelas</th>
                            <th>Nama Buku</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Expired</th>
                            <th>Lama Tunggakan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Filter --}}
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST">@csrf
                <div class="form-group">
                    <label for="">Dari Tanggal</label>
                    <input type="text"  class="form-control date-picker" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="">Sampai Tanggal</label>
                    <input type="text" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="form-group">
                   <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
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
        $(function(){
            $('#data-expired').DataTable({
                ajax: '{{route('expired-datatable')}}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'user_id', name: 'user_id'},
                    { data: 'nomor_induk', name: 'nomor_induk'},
                    { data: 'class_relation', name: 'class_relation'},
                    { data: 'book_id', name: 'book_id'},
                    { data: 'start_date', name: 'start_date'},
                    { data: 'end_date', name: 'end_date'},
                    { data: 'action', name: 'action'},
                ],
                language: {
                searchPlaceholder: 'Search Buku..',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
                destroy: true
                },
                columnDefs:[
                    {
                        "targets" : [0,1,2,3,5],
                        "className": "text-center"
                    },
                ],

                dom: 'Bfrtip',
                buttons: [
                    {extend:'copy', className: 'bg-info text-white rounded-pill ml-2 border border-white'},
                    {extend:'excel', className: 'bg-success text-white rounded-pill border border-white'},
                    {extend:'pdf', className: 'bg-danger text-white rounded-pill border border-white'},
                    {extend:'print', className: 'bg-warning text-white rounded-pill border border-white'},
                ],
                "bDestroy": true,
                "processing": true,
                "serverSide": true,
            });
        });
    </script>
@endsection
