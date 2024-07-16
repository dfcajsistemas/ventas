@props(['modulo' => ''])

@switch($modulo)
    @case('Espacio')
        <ul class="menu-inner py-1">
            <!-- Apps & Pages -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text"> Mi espacio</span>
            </li>
            <li class="menu-item {{ request()->routeIs('espacio') ? 'active' : '' }}">
                <a href="{{ route('espacio') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-widget'></i>
                    <div class="text-truncate">Mis módulos</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('espacio.datos') ? 'active' : '' }}">
                <a href="{{ route('espacio.datos') }}" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-user-account'></i>
                    <div class="text-truncate">Mis datos</div>
                </a>
            </li>
        </ul>
        @break
    @case('Accesos')
        <ul class="menu-inner py-1">
            <!-- Apps & Pages -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text"> Accesos</span>
            </li>
            @can('accesos')
            <li class="menu-item {{ request()->routeIs('accesos') ? 'active' : '' }}">
                <a href="{{ route('accesos') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-gauge-high"></i>
                    <div class="text-truncate">Dashboard</div>
                </a>
            </li>
            @endcan
            @can('accesos.users')
            <li class="menu-item {{ request()->routeIs('accesos.users*') ? 'active' : '' }}">
                <a href="{{ route('accesos.users') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-user-lock"></i>
                    <div class="text-truncate">Usuarios</div>
                </a>
            </li>
            @endcan
            @can('accesos.roles')
            <li class="menu-item {{ request()->routeIs('accesos.roles*') ? 'active' : '' }}">
                <a href="{{route('accesos.roles')}}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-lock"></i>
                    <div class="text-truncate">Roles</div>
                </a>
            </li>
            @endcan
            @can('accesos.permisos')
            <li class="menu-item {{ request()->routeIs('accesos.permisos') ? 'active' : '' }}">
                <a href="{{route('accesos.permisos')}}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-key"></i>
                    <div class="text-truncate">Permisos</div>
                </a>
            </li>
            @endcan
        </ul>
        @break

    @default
        <p>Sin Menú</p>
@endswitch
