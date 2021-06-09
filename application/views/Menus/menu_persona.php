<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?= base_url('index.php/Personas/Loby/Loby') ?>">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-utensils"></i>
		</div>
		<div class="sidebar-brand-text mx-3">BusCOmida</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Personas/Loby/Loby') ?>">
			<i class="fas fa-concierge-bell"></i>
			<span>Ver Donaciones</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#" data-toggle="modal" data-target=".newpub">
			<i class="fas fa-hand-holding-heart"></i>
			<span>Hacer una Donación</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Personas/Ver_pub/Ver_pub') ?>">
			<i class="fas fa-drumstick-bite"></i>
			<span>Ver mis Donaciones</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Personas/Ver_pub_acept/Ver_pub_acept') ?>">
			<i class="fas fa-bone"></i>
			<span>Donaciones Aceptadas</span>
		</a>
	</li>
	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
