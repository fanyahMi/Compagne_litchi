	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >

				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label>------</label>
					</li>
					<li class="nav-item">
					    <a href="/" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Agent</span></a>
					</li>
					<li class="nav-item">
					    <a href="{{ url('shifts') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Shift</span></a>
					</li>
                    <li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Station</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{ url('list-Station') }}">Liste</a></li>
							<li><a href="{{ url('list-numero-station') }}">Numero station</a></li>
							<li><a href="{{ url('list-compagne') }}">Compagne</a></li>
							<li><a href="{{ url('list-quotas') }}">Quotas</a></li>
							<li><a href="{{ url('sortie-magasin') }}">Historique</a></li>
						</ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Navire</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{ url('list-navire') }}">Liste navire</a></li>
							<li><a href="{{ url('mouvement-navire') }}">Mouvement navire</a></li>
						</ul>
					</li>
                    <li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Magasin</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{ url('entree-magasin') }}">Entree</a></li>
							<li><a href="{{ url('sortie-magasin') }}">Sortie</a></li>
                            <li><a href="{{ url('magasin-camion') }}">Camion</a></li>
						</ul>
					</li>


				</ul>

			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
