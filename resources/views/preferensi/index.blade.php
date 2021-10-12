@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Preferensi', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'preference',
  'title' => __('Pengumuman'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
            <h3>Menerima Preferensi dari Siswa</h3>
            <p>Anda dapat mensetujui jika buku sudah ada!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive mt-4" id="pending-preferensi">
            {{-- <div class="row">
                <div class="col-lg-2" id="event_period">
                    <input type="text" class="actual_range">
                </div>
            </div> --}}
            <table class="ui celled table table-striped" id="data-history">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Judul</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
{{-- Modal Preferensi --}}
<div class="modal fade" id="editPreferensi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content" id="box_edit_preferensi">
    </div>
    </div>
  </div>
@endsection
@section('script')
<script>
    $(function(){
        $('#data-history').DataTable({
            ajax: '{{route('preferensi-siswa-datatable')}}',
            columns:[
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'user', name: 'user'},
                { data: 'judul', name: 'judul'},
                { data: 'description', name: 'description'},
                { data: 'status', name: 'status'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action', name: 'action'},
            ],
            language: {
            searchPlaceholder: 'Search ..',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },
            columnDefs:[
                {
                    "targets" : [0,4,5,6],
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
    editPreferensi = (link) => {
      $.ajax({
          url: link,
          success: function(response){
              $('#box_edit_preferensi').html(response)
          }
      })
  }
</script>
@endsection
