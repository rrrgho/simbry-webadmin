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
            <h3>Data Kelas</h3>
            <p>Anda dapat menambah, mengedit atau menghapus data kelas disini !</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Name</th>
                            <th>Floor</th>
                            <th>Stackholder</th>
                            <th>Manager</th>
                            <th>Created At</th>
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
                                <td>November 19, 1999</td>
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
