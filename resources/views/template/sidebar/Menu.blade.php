<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">

            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>

                @if (session('agent.role') == 'Administrateur')
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Agent</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('shifts') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-clock"></i></span>
                            <span class="pcoded-mtext">Shift</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('list-compagne') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                            <span class="pcoded-mtext">Compagne</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('import') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-download"></i></span>
                            <span class="pcoded-mtext">Import</span>
                        </a>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                            <span class="pcoded-mtext">Station</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{ url('list-Station') }}">Liste</a></li>
                            <li><a href="{{ url('list-numero-station') }}">Numero station</a></li>
                            <li><a href="{{ url('list-quotas') }}">Quotas</a></li>
                        </ul>
                    </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-anchor"></i></span>
                            <span class="pcoded-mtext">Navire</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li><a href="{{ url('list-navire') }}">Liste navire</a></li>
                            <li><a href="{{ url('mouvement-navire') }}">Mouvement navire</a></li>
                        </ul>
                    </li>
                    @endif

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-package"></i></span>
                        <span class="pcoded-mtext">Magasin</span>
                    </a>
                    <ul class="pcoded-submenu">
                        @if (session('agent.role') == 'Agent_entree'  || session('agent.role') == 'Administrateur')
                            <li><a href="{{ url('entree-magasin') }}">Entree</a></li>
                        @endif
                        @if (session('agent.role') == 'Agent_sortie' || session('agent.role') == 'Administrateur')
                            <li><a href="{{ url('sortie-magasin') }}">Sortie</a></li>
                        @endif

                        <li><a href="{{ url('magasin-camion') }}">Camion</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->
