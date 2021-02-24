@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'kritik-saran', 
  'title' => __('Kritik Saran'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12">            
            <div class="col border-bottom pl-0 pb-3">
                <h3>Kritik & Saran</h3>
                <p>Anda dapat melihan kritik & saran!!</p>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Kritik & Saran</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4" id="kritik-saran">
                    <table class="ui celled table table-striped" id="data-kritik-saran">
                        <thead>
                            <tr class="text-center">
                                <th width="50">#</th>
                                <th>Id Murid</th>
                                <th>Deskripsi</th>
                                <th width="100px">Created At</th>
                            </tr>
                        </thead>
                    </table>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        // Datatable

        $(function(){
        $('#data-kritik-saran').DataTable({
            ajax: '{{route('kritik-saran-datatable')}}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'user_id', name: 'user_id'},
                { data: 'deskripsi', name: 'deskripsi'},
                { data: 'created_at', name: 'created_at'},
            ],
            language: {
            searchPlaceholder: 'Search Kritik..',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },  
            columnDefs:[
                {
                    "targets" : [0,1,2],
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