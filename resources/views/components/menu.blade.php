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
@case('Mantenimiento')
<ul class="menu-inner py-1">
    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text"> Mantenimiento</span>
    </li>
    @can('mantenimiento')
    <li class="menu-item {{ request()->routeIs('mantenimiento') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-gauge-high"></i>
            <div class="text-truncate">Dashboard</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.empresas')
    <li class="menu-item {{ request()->routeIs('mantenimiento.empresas*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.empresas') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-building"></i>
            <div class="text-truncate">Empresa</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.sucursals')
    <li class="menu-item {{ request()->routeIs('mantenimiento.sucursals*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.sucursals') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-store"></i>
            <div class="text-truncate">Sucursales</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.categorias')
    <li class="menu-item {{ request()->routeIs('mantenimiento.categorias*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.categorias') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-tags"></i>
            <div class="text-truncate">Categorias</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.productos')
    <li class="menu-item {{ request()->routeIs('mantenimiento.productos*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.productos') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-cube"></i>
            <div class="text-truncate">Productos</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.mpagos')
    <li class="menu-item {{ request()->routeIs('mantenimiento.mpagos*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.mpagos') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-sack-dollar"></i>
            <div class="text-truncate">Modo pagos</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.series')
    <li class="menu-item {{ request()->routeIs('mantenimiento.series*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.series') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-file-invoice"></i>
            <div class="text-truncate">Series</div>
        </a>
    </li>
    @endcan
    @can('mantenimiento.clientes')
    <li class="menu-item {{ request()->routeIs('mantenimiento.clientes*') ? 'active' : '' }}">
        <a href="{{ route('mantenimiento.clientes') }}" class="menu-link">
            <i class="menu-icon tf-icons fa-solid fa-user-group"></i>
            <div class="text-truncate">Clientes</div>
        </a>
    </li>
    @endcan
</ul>
@break
@default
<p>Sin Menú</p>
@endswitch
