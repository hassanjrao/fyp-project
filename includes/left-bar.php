<?php

// $user_type_arr = $_SESSION["user_access_arr"];


?>


<div class="sidebar-menu">

	<div class="sidebar-menu-inner">

		<header class="logo-env">

			<!-- logo -->
			<div class="logo">
				<a href="index.php">
					<img src="assets/images/logo@2x.png" width="120" alt="" />
				</a>
			</div>

			<!-- logo collapse icon -->
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon">
					<!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>


			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation">
					<!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>

		</header>



		<ul id="main-menu" class="main-menu">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
			<li class="active active">
				<a href="index.php">
					<i class="entypo-gauge"></i>
					<span class="title">Dashboard</span>
				</a>

			</li>



			<li class="has-sub">
				<a href="#">
					<i class="entypo-layout"></i>
					<span class="title">Vendors</span>
				</a>
				<ul>
					<li>
						<a href="add_vendors.php">
							<span class="title">Add Vendors</span>
						</a>
					</li>

					<li>
						<a href="all_vendors.php">
							<span class="title">All Vendors</span>
						</a>

					</li>


				</ul>
			</li>


			<li class="">
				<a href="vendor_profile.php">
					<i class="entypo-gauge"></i>
					<span class="title">Profile Setting</span>
				</a>

			</li>



			<!-- <li class="has-sub">
				<a href="#">
					<i class="entypo-layout"></i>
					<span class="title">Genres</span>
				</a>
				<ul>
					<li>
						<a href="add_genres.php">
							<span class="title">Add Genres</span>
						</a>
					</li>

					<li>
						<a href="all_genres.php">
							<span class="title">All Genres</span>
						</a>
					</li>

				</ul>
			</li> -->












		</ul>

	</div>

</div>