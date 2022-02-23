@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Kelas', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'class-management', 
  'activePage' => 'teacher-data', 
  'title' => __('Manajemen Guru'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
    <div class="row">
      <div class="col-md-12">
        <div class="col border-bottom pl-0 pb-3">
          <h3>Manajemen Pengguna</h3>
          <p>anda dapat menambah, mengedit atau menghapus data disini !</p>
        </div>
      </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h1 class="text-success">Data Seluruh Guru</h1>
                    <p>Tambah, edit atau hapus data guru.</p>

                    <button class="btn btn-success position-absolute" data-toggle="modal" id="btn-add-teacher" data-target="#addTeacher" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Guru</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4" id="teacher-datatable-box">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add Teacher -->
    <div class="modal fade" id="addTeacher" tabindex="-1" role="dialog" aria-labelledby="addTeacherLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Guru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" id="add-teacher-box">
                
            </div>
        </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Props
        let callEditComponent = false;
        let editTeacherId;
        // Clear Input
        const clearInput = () => {
            $('.form-control').val('')
        }
        // Get Teacher Datatable
        const getTeacherDatatableComponent = () => {
            $('#teacher-datatable-box').html('Sedang memuat ...')
            $.ajax({
                url: '{{route('component-teacher-datatable')}}',
                success:function(response){
                    $('#teacher-datatable-box').html(response)
                    teacherDatatable()
                }
            })
        }
        getTeacherDatatableComponent();
        // Get Add Teacher Component
        const getAddTeacherComponent = () => {
            $('#add-teacher-box').html('Sedang memuat ...')
            $.ajax({
                url: '{{route('component-add-teacher')}}',
                success:function(response){
                    $('#add-teacher-box').html(response)
                    $('#form-add-teacher').submit(function(event){
                        event.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST', cache: false, contentType: false, processData: false,
                            url: "{{ route('add-teacher') }}",
                            data: formData,
                            success: (response) => {
                                infoSuccess(response.message)
                                getAddTeacherComponent();
                                clearInput();
                                getTeacherDatatableComponent();
                            },
                            error: (response) => {
                                if (response.status === 401){
                                    infoFailed(response.responseJSON.message)
                                }
                            }
                        })
                    })
                }
            })
        }
        // Get Edit Teacher Component
        const getEditTeacherComponent = (id) => {
            callEditComponent =  true;
            editTeacherId = id;
            $('#add-teacher-box').html('sedang memuat...')
            $.ajax({
                url: "{{ route('component-edit-teacher') }}",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id : id,
                },
                success:function(response){
                    $('#add-teacher-box').html(response)
                    $('#form-edit-teacher').submit(function(event){
                        event.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST', cache: false, contentType: false, processData: false,
                            url: "{{ route('edit-teacher') }}",
                            data: formData,
                            success: (response) => {
                                infoSuccess(response.message)
                                getEditTeacherComponent(editTeacherId);
                                clearInput();
                                getTeacherDatatableComponent()
                            },
                        })
                    })
                }
            })
        }
        // Delete Teacher Data
        const deleteTeacherData = (id) => {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{route('delete-teacher')}}",
                        type: "POST",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            id : id,
                        },
                        success:function(response){
                            infoSuccess(response.message)
                            getTeacherDatatableComponent()
                        }
                    })
                    
                }
                });
        }
        // Add Teacher Button Modal
        $('#btn-add-teacher').click(function(){
            getAddTeacherComponent()
        })
        function tol(){
            alert('sa')
        }
        // Datatable
        function teacherDatatable(){
            $(function(){
                $('#teacher-datatable').DataTable({
                    ajax: {
                        url :'{{route('teacher-datatable')}}',
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name'},
                        { data: 'user_number', name: 'user_number'},
                        { data: 'created_at', name: 'created_at'},
                        { data: 'action', name: 'action', 'render': function(data){
                            return data
                        }},
                    ],
                    language: {
                    searchPlaceholder: 'Search Guru..',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                    destroy: true
                    },  
                    columnDefs:[
                        {
                            "targets" : [0,1,2,3,4],
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