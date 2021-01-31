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
        <div class="col-md-12">            
            <div class="col border-bottom pl-0 pb-3">
                <h3>Manajemen Pengguna dan Kelas</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data disini !</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h1 class="text-success">Data Seluruh Siswa</h1>
                    <p>Tambah, edit atau hapus data siswa.</p>

                    <button class="btn btn-success position-absolute" data-toggle="modal" id="btn-add-student" data-target="#addStudent" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Siswa</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4" id="student-datatable-box">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add Student -->
    <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" id="add-student-box">
                
            </div>
            <div class="modal-footer">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <h5 class="text-white">Jika anda tidak menemukan kelas, silahkan tambah kelas dibawah ini</h5>
                            <form id="form-add-class">@csrf
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <input type="text" name="name" placeholder="Nama kelas" class="form-control text-white">
                                    </div>
                                    <div class="col-6 mt-3">
                                        <input type="text" name="author_id" placeholder="Penanggung jawab" class="form-control text-white">
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light float-right mt-3" id="btn-add-class" type="submit">Tambah Kelas</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Clear Input
        const clearInput = () => {
            $('.form-control').val('')
        }
        // Get Student Datatable
        const getStudentDatatableComponent = () => {
            $('#student-datatable-box').html('Sedang memuat ...')
            $.ajax({
                url: '{{route('component-student-datatable')}}',
                success:function(response){
                    $('#student-datatable-box').html(response)
                    studentDatatable()
                }
            })
        }
        getStudentDatatableComponent();
        // Get Add Student Component
        const getAddStudentComponent = () => {
            $('#add-student-box').html('Sedang memuat ...')
            $.ajax({
                url: '{{route('component-add-student')}}',
                success:function(response){
                    $('#add-student-box').html(response)
                    $('#form-add-student').submit(function(event){
                        event.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST', cache: false, contentType: false, processData: false,
                            url: "{{ route('add-student') }}",
                            data: formData,
                            success: (response) => {
                                infoSuccess(response.message)
                                $('#btn-add-class').text('Tambah Kelas').attr('disabled', false)
                                getAddStudentComponent();
                                clearInput();
                                getStudentDatatableComponent();
                            },
                        })
                    })
                }
            })
        }
        // Add Student Button Modal
        $('#btn-add-student').click(function(){
            getAddStudentComponent()
        })
        // Add New Class
        $('#form-add-class').submit(function(event){
            event.preventDefault();
            $('#btn-add-class').text('Loading...').attr('disabled', true)
            var formData = new FormData(this);
            $.ajax({
                type: 'POST', cache: false, contentType: false, processData: false,
                url: "{{ route('add-class') }}",
                data: formData,
                success: (response) => {
                    infoSuccess(response.message)
                    $('#btn-add-class').text('Tambah Kelas').attr('disabled', false)
                    getAddStudentComponent();
                    clearInput()
                },
            })
        })
        function tol(){
            alert('sa')
        }
        // Datatable
        function studentDatatable(){
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
        }
    </script>
@endsection