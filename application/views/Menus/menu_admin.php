<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center"
		href="<?= base_url('index.php/Admin/Loby/Loby') ?>">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-utensils"></i>
		</div>
		<div class="sidebar-brand-text mx-3">BusCOmida</div>
	</a>

	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Pages Collapse Menu -->
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Admin/Loby/Loby') ?>">
			<i class="fas fa-concierge-bell"></i>
			<span>Donaciones</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Admin/VerAdmin/VerAdmin') ?>">
			<i class="fas fa-user-plus"></i>
			<span>Ver administradores</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Admin/Estadisticas/Estadisticas') ?>">
			<i class="fas fa-chart-bar"></i>
			<span>Estadisticas</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('index.php/Admin/Denuncias/Denuncias') ?>">
			<i class="far fa-angry"></i>
			<span>Denuncias</span>
		</a>
	</li>
	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>
