@extends('layouts.app', [
  'breadcrumbs' => [
    [ 'page' => 'Dashboard', 'link' => 'http://dashboard.com'],
    [ 'page' => 'Profile', 'link' => 'http://profile.com'],
],
  'class' => 'off-canvas-sidebar', 
  'activePage' => 'home', 
  'title' => __('Dashboard')
])

@section('content')
  <div class="col-12">
    
  </div>
@endsection
