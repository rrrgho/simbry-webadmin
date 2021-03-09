@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peraturan', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'announcement', 
  'title' => __('Pengumuman'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Menambahkan Pengumuman Perpustakaan</h3>
            <p>Anda dapat menambahkan pengumuman!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container">
  @if (session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h4>Menambahkan Pengumuman</h4>
        </div>
        <div class="card-body">
          <form action="{{ route('add-annountcements') }}" enctype="multipart/form-data" method="POST">@csrf
            <div class="form-group">
              <label for="name">Judul :</label>
              <input type="text" name="name" class="form-control" />
            </div>
            <div class="form-group">
              <label for="name">Deskripsi :</label>
              <input type="text" name="description" class="form-control" />
            </div>
            <div class="form-group">
              <label for="imgInp">
                <input type='file' name="images" id="imgInp" class="d-none"/>
                <img id="image-preview" src="https://www.canadasoccer.com/wp-content/uploads/2019/11/no-image-default.png" style="width:100%; cursor: pointer;" alt="your image" />
                </label>
            </div>
            <input type="submit" class="btn btn-success float-right" value="Submit" />
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <table class="ui celled table table-striped" id="announcement">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Created_at</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
  </div>
  </div>
</div>
{{-- Modal Annountcement --}}
<div class="modal fade" id="editAnnouncements" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="box_edit_announcements">
  </div>
  </div>
</div>
@endsection
@section('script')
    <script>
      // Datatable
      $(function(){
      $('#announcement').DataTable({
          ajax: '{{route('announcement-datatable')}}',
          columns: [
              { data: 'DT_RowIndex', name: 'DT_RowIndex' },
              { data: 'name', name: 'name'},
              { data: 'description', name: 'description'},
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
                  "targets" : [0,3,4],
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
  editAnnouncements = (link) => {
      $.ajax({
          url: link,
          success: function(response){
              $('#box_edit_announcements').html(response)
          }
      })
  }
    </script>
@endsection
