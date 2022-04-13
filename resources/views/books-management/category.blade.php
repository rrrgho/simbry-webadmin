@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Buku', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'books-management',
  'activePage' => 'cetegory-books',
  'title' => __('Kategori Buku'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="col border-bottom pl-0 pb-3">
                <h3>Buku Kategori</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data Buku Kategori disini !</p>
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
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <form action="{{url('books-management/category')}}" method="POST">@csrf
                    <div class="card-header bg-light">
                        <h3>Tambah Kategori Buku</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="name"class="form-control" placeholder="Ketik disini ..." required>
                        </div>
                        <div class="form-group">
                            @if($sub_category->count())
                            <label>Pilih Sub Kategori : </label><br>
                            <select required class="form-control" style="width: 100%" name="sub_category">
                                <option value="" hidden>Pilih Sub Kategori</option>
                                @foreach($sub_category as $item)
                                    <option value="{{ $item['id'] }}">
                                        {{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            @else
                            <select name="" id="" hidden required>
                            </select>
                            <div class="alert alert-warning">
                                Data kategori buku tidak di temukan ! mohon masukkan data kategori!!
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <table class="ui celled table table-striped" id="data-kategori">
                <thead>
                    <tr class="text-center">
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th>Jumlah buku</th>
                        <th width="100px">Created At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    {{-- Modal Category --}}
    <div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" id="box_edit_category">
        </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Datatable
        $(function(){
            $('#data-kategori').DataTable({
                ajax: '{{route('category-datatable')}}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name'},
                    { data: 'jumlah_buku', name: 'jumlah_buku'},
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
                    // {
                    //     "targets" : [0,1,2,3],
                    //     "className": "text-center"
                    // },
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
        // Ajax Edit Category Data
        editCategory = (link) => {
            $.ajax({
                url: link,
                success: function(response){
                    $('#box_edit_category').html(response)
                }
            })
        }
    </script>
@endsection
