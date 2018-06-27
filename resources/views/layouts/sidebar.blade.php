<!-- Sidebar -->
<div class="sidebar">
  <!-- Sidebar user (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ URL::asset('components/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">Alexander Pierce</a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
      
      @foreach($arrSidebar as $sidebar)
        @if(isset($sidebar['header']) and !empty($sidebar['header']))
          <li class="nav-header">{{ $sidebar['header'] }}</li>
        @endif

        @foreach($sidebar['itens'] as $item)
          <li class="nav-item{{ ( isset($item['children']) ? ' has-treeview' : '' ) }}">
            <a href="{{ ( isset($item['children']) ? '#' : route($item['routeName']) ) }}" class="nav-link{{ ( $item['routeName'] == Route::currentRouteName() ? ' active' : '' ) }}">
              @if(isset($item['icon-left']) and !empty($item['icon-left']))
                <i class="{{ $item['icon-left'] }}"></i>
              @endif
              <p>
                {{ $item['title'] }}
                @if(isset($item['icon-right']) and !empty($item['icon-right']))
                  <{{$item['icon-right']['tag']}} class="{{ $item['icon-right']['class'] }}">
                    {{ $item['icon-right']['text'] }}
                  </{{$item['icon-right']['tag']}}>
                @endif
              </p>
            </a>

            @if(isset($item['children']))
              <ul class="nav nav-treeview">
                @foreach($item['children'] as $subitem)
                  <li class="nav-item">
                    <a href="{{ route($subitem['routeName']) }}" class="nav-link">
                      @if(isset($subitem['icon-left']))
                        <i class="{{ $subitem['icon-left'] }}"></i>
                      @endif
                      <p>{{ $subitem['title'] }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif

          </li>
        @endforeach

      @endforeach

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->