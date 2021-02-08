@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Manajemen Peraturan', 'link' => 'http://dashboard.com'],
],
  'class' => 'off-canvas-sidebar',
  'activePage' => 'management-peraturan', 
  'title' => __('Management Peraturan'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
@section('title')
<div class="row">
    <div class="col-md-12">            
        <div class="col border-bottom pl-0 pb-3">
            <h3>Management Peraturan</h3>
            <p>Anda dapat melihan Management Peraturan!!</p>
        </div>
    </div>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Aturan Limit Pinjaman!!</h3>
                </div>
                <div class="card-body">
                    <table class="ui celled table table-striped" id="">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Pengguna</th>
                                <th>Limit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['user_type'] == 1 ?  'SISWA' : 'GURU' }}</td>
                                    <td>{{ $item['limit'] }}</td>
                                    <td class="text-center"><button type="button" class="btn btn-primary" data-toggle="modal" onclick="setIdRule('{{ $item['id'] }}')" data-target="#exampleModal"> <i class="fa fa-edit"> </i> </button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
    </div>
    {{-- Modal Edit --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ route ('main-peraturan') }}" method="POST">@csrf
                    <div class="modal-header">      
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <input type="hidden" name="id" id="id_rule_limit">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <label for="">Limit : </label>
                        <input type="number" name="limit" required class="form-control" value="">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function setIdRule(id){
            $('#id_rule_limit').val(id)
        }
    </script>
@endsection
