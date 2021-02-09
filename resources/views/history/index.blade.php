@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Riwayat Peminjaman', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'history-orders', 
  'activePage' => 'orders', 
  'title' => __('Riwayat Peminjaman'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12">            
            <div class="col border-bottom pl-0 pb-3">
                <h3>Riwayat Peminjaman buku</h3>
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
            <button class="btn btn-success position-absolute" onclick="getAddBooksComponent()" data-toggle="modal" id="btn-add-books" data-target="#addBooks" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Buku</button>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">
                <h1 class="text-success">Data History Peminjaman</h1>
            </div>
            <div class="card-body">
                <div class="row input-daterange">
                    <div class="col-lg-3 col-sm-4">
                        <input type="text" name="start_date" id="start_date" class="form-control" placeholder="Dari Tanggal" readonly>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <input type="text" name="end_date" id="end_date" class="form-control" placeholder="Sampai Tanggal" readonly>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                       <button type="button" name="filter" class="btn btn-primary" id="filter">Filter</button>
                       {{-- <button type="button" name="refresh" class="btn btn-default" id="refresh">Refresh</button> --}}
                    </div>
                </div>
                <div class="table-responsive mt-4" id="history-book">
                    <table class="ui celled table table-striped" id="data-history">
                        <thead>
                            <tr class="text-center">
                                <th width="50">#</th>
                                <th>NIP</th>
                                <th>ID Buku</th>
                                <th>Status</th>
                                <th>Start</th>
                                <th>End</th>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
     $('#filter').click(function () {
        var start_date = $('#start_date').val(); 
        var end_date = $('#end_date').val(); 
        if (start_date != '' && end_date != '') {
            $('#data-history').DataTable().destroy();
            load_data(start_date, end_date);
        } else {
            alert('Both Date is required');
        }
    });
    // Datatable
    $(function(){
        $('#data-history').DataTable({
            ajax: '{{route('history-datatable')}}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'user_id', name: 'user_id'},
                { data: 'book_id', name: 'book_id'},
                { data: 'status', name: 'status'},
                { data: 'start_date', name: 'start_date'},
                { data: 'end_date', name: 'end_date'},
                { data: 'created_at', name: 'created_at'},
            ],
            language: {
            searchPlaceholder: 'Search Penerbit..',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            destroy: true
            },  
            columnDefs:[
                {
                    "targets" : [0,1,2,3,4,5],
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
    $( function() {
        $( "#start_date" ).datepicker();
    });
    $(function(){
        $('#end_date').datepicker();
    })
    </script>
@endsection