<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
    <div class="row" id="wrapper" style="margin-top:100px">
      <div class="col-md-12">
        @yield('content')
      </div>
    </div>
    {{-- @include('layouts.footers.auth') --}}
  </div>
</div>