@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Buku', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activeMainPage' => 'books-management', 
  'activePage' => 'locker-books', 
  'title' => __('Rak Buku'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])

@section('title')
    <div class="row">
        <div class="col-md-12 border-bottom mb-3">
            <div class="col border-bottom pl 0 pb-3">
                <h3>Rak Buku</h3>
                <p>Anda dapat menambah, mengedit atau menghapus data Rak buku disini !</p>       
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
                <form action="{{url('books-management/locker')}}" method="POST">@csrf
                    <div class="card-header bg-light">
                        <h3>Tambah Rak Buku</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="name"class="form-control" placeholder="Ketik disini ..." required>                            
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">                 
            <table class="ui celled table table-striped" id="data-locker">
                <thead>
                    <tr class="text-center">
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th width="100px">Created At</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
            </table>   
        </div>        
    </div>
    {{-- Modal Rak --}}
    <div class="modal fade" id="editLocker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content" id="box_edit_locker">
        </div>
        </div>
    </div>
@endsection
@section('script')
<script>
  // Datatable
  $(function(){
      $('#data-locker').DataTable({
          ajax: '{{route('locker-datatable')}}',
          columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex' },
              { data: 'name', name: 'name'},
              { data: 'created_at', name: 'created_at'},
              { data: 'action', name: 'action'},
          ],
          language: {
          searchPlaceholder: 'Search Loker..',
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
  // Ajax Edit Locker Data
  editLocker = (link) => {
      $.ajax({
          url: link,
          success: function(response){
              $('#box_edit_locker').html(response)
          }
      })
  }
</script>
@endsection