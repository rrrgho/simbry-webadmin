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
                    <button type="submit" data-toggle="modal" data-target="#passwordall" class="btn btn-danger p-2 mt-3">Reset Password</button>
                    <button class="btn btn-success position-absolute" onclick="getAddStudentComponent()" data-toggle="modal" id="btn-add-student" data-target="#addStudent" style="right: 10px; top:10px"><i class="fa fa-plus"></i> Tambah Siswa</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-4" id="student-datatable-box">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Reset Password --}}
    <div class="modal fade" id="passwordall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Password Terbaru</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('reset-passsword-all') }}" method="post">@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <h5>Password Terbaru</h4>
                        <input type="text" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
          </div>
        </div>
      </div>

    <!-- Modal Add Student -->
    <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                                    <div class="col-12 mt-3">
                                        <select name="unit_id" required class="form-control select2-single">
                                            <option value="" hidden>Unit Kelas</option>
                                            @foreach ($unit as $item)
                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <input type="text" required name="name" placeholder="Nama kelas" class="form-control text-white">
                                    </div>
                                    <div class="col-6 mt-3">
                                        <select required name="author_id" class="form-control select2-single">
                                            <option value="" hidden>Penanggung jawab kelas</option>
                                            @foreach ($teacher as $item)
                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
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
        // Props
        let callEditComponent = false;
        let editStudentId;
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
                    function edit(){
                        alert('aku')
                    }
                    // Edit Student Button Modal
                    
                }
            })
        }
        getStudentDatatableComponent();
        // Get Add Student Component
        const getAddStudentComponent = () => {
            callEditComponent = false;
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
        // Get Edit Student Component
        const getEditStudentComponent = (id) => {
            callEditComponent = true;
            editStudentId = id;
            $('#add-student-box').html('Sedang memuat ...')
            $.ajax({
                url: "{{route('component-edit-student')}}",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id : id,
                },
                success:function(response){
                    $('#add-student-box').html(response)
                    $('#form-edit-student').submit(function(event){
                        event.preventDefault();
                        var formData = new FormData(this);
                        $.ajax({
                            type: 'POST', cache: false, contentType: false, processData: false,
                            url: "{{ route('edit-student') }}",
                            data: formData,
                            success: (response) => {
                                infoSuccess(response.message)
                                $('#btn-add-class').text('Tambah Kelas').attr('disabled', false)
                                getEditStudentComponent(editStudentId);
                                clearInput();
                                getStudentDatatableComponent();
                            },
                        })
                    })
                }
            })
        }
        // Delete Student Data
        const deleteStudentData = (id) => {
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
                        url: "{{route('delete-student')}}",
                        type: "POST",
                        headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            id : id,
                        },
                        success:function(response){
                            infoSuccess(response.message)
                            getStudentDatatableComponent()
                        }
                    })
                    
                }
                });
        }
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
                    if(callEditComponent == false)
                        getAddStudentComponent();
                    else
                        getEditStudentComponent(editStudentId);
                    clearInput()
                },
            })
        })
        // Datatable
        function studentDatatable(){
            $(function(){
                $('#student-datatable').DataTable({
                    ajax: {
                        url :'{{route('student-datatable')}}',
                    },
                    columns: [
                        // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name'},
                        { data: 'user_number', name: 'user_number'},
                        { data: 'class_id', name: 'class_id'},
                        { data: 'created_at', name: 'created_at'},
                        { data: 'action', name: 'action', 'render': function(data){
                            return data
                        }},
                        
                    ],
                    language: {
                    searchPlaceholder: 'Search Buku..',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                    destroy: true
                    },   
                    columnDefs:[
                        {
                            "targets" : [1,2,3,4],
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