<style>
  @media print {
      .noPrint{
          display:none;
      }
      .print{
          display: block;
      }
  }
</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top noPrint">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <div class="col">
        <h5>
          @if($breadcrumbs)
            @foreach($breadcrumbs as $item)
              <a class="@if($item['page'] == $title) text-warning  @else text-dark @endif" href="{{$item['link']}}">{{$item['page']}}</a>  @if($loop->iteration -1 < count($breadcrumbs) - 1) >>  @endif
            @endforeach
          @endif
        </h5>
        {{-- <select class="form-control js-example-basic-single" name="state">
          <option value="AL">Alabama</option>
          <option value="WY">Wyoming</option>
        </select> --}}
      </div>
      {{-- <div class="col-md-12">
        <div class="card-header bg-none" style="border:none !important; background:none !important; border-bottom: solid 1px #ddd !important;">
          <h3 style="margin-left:-2px !important;">{{$title}}</h3>
          <p>{{$subTitle}}</p>
        </div>
      </div> --}}
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      {{-- <form class="navbar-form">
        <div class="input-group no-border">
        <input type="text" value="" class="form-control" placeholder="Search...">
        <button type="submit" class="btn btn-white btn-round btn-just-icon">
          <i class="material-icons">search</i>
          <div class="ripple-container"></div>
        </button>
        </div>
      </form> --}}
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="">
            <i class="material-icons">dashboard</i>
            <p class="d-lg-none d-md-block">
              {{ __('Stats') }}
            </p>
          </a>
        </li>
        {{-- <li class="nav-item dropdown">
          <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">notifications</i>
            <span class="notification">5</span>
            <p class="d-lg-none d-md-block">
              {{ __('Some Actions') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">{{ __('Mike John responded to your email') }}</a>
            <a class="dropdown-item" href="#">{{ __('You have 5 new tasks') }}</a>
            <a class="dropdown-item" href="#">{{ __('You\'re now friend with Andrew') }}</a>
            <a class="dropdown-item" href="#">{{ __('Another Notification') }}</a>
            <a class="dropdown-item" href="#">{{ __('Another One') }}</a>
          </div>
        </li> --}}
        <li class="nav-item dropdown">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('change-password') }}">{{ __('Settings') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('logout')}}" >{{ __('Log out') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
