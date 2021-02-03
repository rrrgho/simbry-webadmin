@extends('layouts.app-user', [
  'breadcrumbs' => [
    [ 'page' => 'Dashboard', 'link' => 'http://dashboard.com'],
    [ 'page' => 'Profile', 'link' => 'http://profile.com'],
],
  'class' => 'off-canvas-sidebar', 
  'activeMainPage' => 'dashboard',
  'activePage' => 'home', 
  'title' => __('Dashboard'),
  'subTitle' => __('Halaman dashboard, menampilkan laporan secara judul besar !')
])
