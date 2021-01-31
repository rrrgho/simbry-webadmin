@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'class-management', 
  'activePage' => 'class-data', 
  'title' => __('Manajemen Kelas'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom">
            <h3>Manajemen Pengguna dan Kelas</h3>
            <p>Anda dapat menambah, mengedit atau menghapus data disini !</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive mt-4">
                <table id="student-datatable" class="table ui celled table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Nomor Induk Siswa</th>
                            <th>Kelas</th>
                            <th>Tanggal Terdaftar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i=1; $i<10+1; $i++)
                            <tr class="text-center">
                                <td>{{$i}}</td>
                                <td>Rian Iregho</td>
                                <td>Lantai 3</td>
                                <td>Siapa ya</td>
                                <td>Siapa Juga</td>
                                <td>
                                    <button class="btn btn-success p-1">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info p-1">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger p-1">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Datatable
        $(function(){
            $('#student-datatable').DataTable({
                ajax: '{{route('student-datatable')}}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name'},
                    { data: 'user_number', name: 'user_number'},
                    { data: 'class_id', name: 'class_id'},
                    { data: 'created_at', name: 'created_at'},
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
                        "targets" : [0,1,2,3],
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
