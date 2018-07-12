<li class="nav-item dropdown">
  <a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-user"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <a href="#" class="dropdown-item">
      <i class="fas fa-address-card"></i> Perfil
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item" onclick="event.preventDefault();document.getElementById('form-logout').submit();">
      <i class="fas fa-sign-out-alt"></i> Sair
    </a>
  </div>

</li>
{{ Form::open(['route' => 'logout','id' => 'form-logout','style' => 'display: none;']) }}
{{ Form::close() }}