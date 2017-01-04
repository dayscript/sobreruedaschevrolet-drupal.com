<li class="dropdown">
    <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
       data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                <i></i>
              </span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li role="presentation">
            <a href="/users/{{ $user->id }}" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Perfil</a>
        </li>
        <li role="presentation">
            <a href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> Configuración</a>
        </li>
        <li class="divider" role="presentation"></li>
        <li role="presentation">
            <a href="{{ url('logout') }}" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Salir</a>
        </li>
    </ul>
</li>