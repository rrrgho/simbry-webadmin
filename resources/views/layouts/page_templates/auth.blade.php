<div class="wrapper ">
  @include('layouts.navbars.sidebar', ['breadcrumbs' => $breadcrumbs])
  <div class="main-panel pl-3 pr-3 " style="min-height:calc(100vh) !important;">
    @include('layouts.navbars.navs.auth')
    <div class="col" id="wrapper" style="margin-top:100px">
      @yield('title')
        @yield('content')
    </div>
    @include('layouts.footers.auth')
  </div>
</div>