<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
  
  @include('layouts.navbar.left_navbar')

  @include('layouts.navbar.search_form')

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    
    @include('layouts.navbar.messages')

    @include('layouts.navbar.notifications')
    
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
        <i class="fa fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->