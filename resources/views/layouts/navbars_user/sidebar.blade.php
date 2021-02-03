<div class="sidebar" data-color="green" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('Creative Tim') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">

      {{-- Dashboard --}}
      <li class="nav-item{{ $activeMainPage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{route('main')}}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>


      
      {{-- Add Books --}}
      
      {{-- History --}}
      
      
    </ul>
  </div>
</div>
