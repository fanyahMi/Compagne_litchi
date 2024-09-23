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
					    <a href="{{ url('list-Station') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Station</span></a>
					</li>
					<li class="nav-item">
					    <a href="{{ url('list-navire') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-align-justify"></i></span><span class="pcoded-mtext">Navire</span></a>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-box"></i></span><span class="pcoded-mtext">Magasin</span></a>
						<ul class="pcoded-submenu">
							<li><a href="{{ url('entree-magasin') }}">Entree</a></li>
							<li><a href="{{ url('sortie-magasin') }}">Sortie</a></li>
						</ul>
					</li>


				</ul>

			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
