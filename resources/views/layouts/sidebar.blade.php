<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        {{-- <img src="{{ URL::asset('components/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
        <i class="nav-icon fas fa-user-circle fa-2x text-muted"></i>
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->ds_nome }}</a>
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
            @if(count($item))
              <li class="nav-item{{ ( isset($item['children']) ? ' has-treeview' : '' ) }}">
                @php
                  $urlMenu = '#';
                  if(!isset($item['children'])){
                    $urlMenu = ( is_array($item['routeName']) ? route($item['routeName'][0],$item['routeName'][1]) : route($item['routeName']) );
                  }
                @endphp
                <a href="{{ $urlMenu }}" class="nav-link{{ ( $item['routeName'] == Route::currentRouteName() ? ' active' : '' ) }}">
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
                      @if(count($subitem))
                        <li class="nav-item">
                          @php
                            $urlSubMenu = ( is_array($subitem['routeName']) ? route($subitem['routeName'][0],$subitem['routeName'][1]) : route($subitem['routeName']) );
                          @endphp
                          <a href="{{ $urlSubMenu }}" class="nav-link{{ ( $subitem['routeName'] == Route::currentRouteName() ? ' active' : '' ) }}">
                            @if(isset($subitem['icon-left']))
                              <i class="{{ $subitem['icon-left'] }}"></i>
                            @endif
                            <p>{{ $subitem['title'] }}</p>
                          </a>
                        </li>
                      @endif
                    @endforeach
                  </ul>
                @endif
  
              </li>
            @endif
          @endforeach
  
        @endforeach
  
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  
  @push('js')
    <script>
      $(function(){
        
        $.each($('ul.nav-sidebar li'), function( index, element ) {
          if( $(element).hasClass("has-treeview") ){
            var subitens = $(element).find('ul.nav-treeview li a');
            $.each(subitens, function( index, subelement ) {
              if( $(subelement).hasClass('active') ){
                $(element).children().addClass('active');
                $(element).addClass('menu-open');
              }
            });
          }
        });
        
      });
    </script>
  @endpush