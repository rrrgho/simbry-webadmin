<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel pl-3 pr-3 " style="min-height:calc(100vh) !important;">
    @include('layouts.navbars.navs.auth')
    <div class="col" id="wrapper" style="margin-top:100px">
      <div class="row justify-content-center">
          <div class="col-md-12">
              <div class="col">
                <div class="card-header" style="background:none !important;">
                  <h5>
                    @if($breadcrumbs)
                      @foreach($breadcrumbs as $item)
                        <a class="@if($item['page'] == $title) text-warning  @else text-dark @endif" href="{{$item['link']}}">{{$item['page']}}</a>  @if($loop->iteration -1 < count($breadcrumbs) - 1) >>  @endif
                      @endforeach
                    @endif
                  </h5>
                </div>
              </div>
          </div>
          @yield('content')
      </div>
    </div>
    @include('layouts.footers.auth')
  </div>
</div>