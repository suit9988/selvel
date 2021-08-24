<div class="header">
	<!-- Logo -->
	<div class="header-left">
		<div class="page-title-box">
			<!-- <h3>Admin Panel</h3> -->
			<img src="assets/img/logo.png" class="logo">
		</div>
	</div>
	<!-- /Logo -->

	<a id="toggle_btn" href="javascript:void(0);">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>

	<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
	
	<!-- Header Menu -->
	<ul class="nav user-menu">
		<li class="nav-item dropdown has-arrow main-drop">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img"><img src="assets/img/user.jpg" alt="">
					<span class="status online"></span></span>
					<span><?php echo $loggedInUserDetailsArr['full_name']; ?></span>
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="profile.php">My Profile</a>
					<a class="dropdown-item" href="admin-logout.php">Logout</a>
				</div>
			</li>
		</ul>
		<!-- /Header Menu -->

		<!-- Mobile Menu -->
		<div class="dropdown mobile-user-menu">
			<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="profile.php">My Profile</a>
				<a class="dropdown-item" href="admin-logout.php">Logout</a>
			</div>
		</div>
		<!-- /Mobile Menu -->
	</div>