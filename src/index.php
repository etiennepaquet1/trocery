<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<title>Trocery - Home</title>
		<link href="/css/style.css" rel="stylesheet"/>
	</head>
	<body style='background-image: url("/img/home_background.jpg");background-repeat: no-repeat;background-size:cover;background-position:center;'>
		<header>
			<div class="menu">
				<a href="/">Home</a>
				<div id="aisles">
					<button id="aisles-btn">Aisles
					</button>
					<div id="categories">
						<a href="/aisles/meat">Meat</a>
						<a href="/aisles/vegetables">Fruits & Vegetables</a>
					</div>
				</div>
				<a href="/login">Login</a>
				<a href="/signup">Sign Up</a>
				<a href="/cart">Cart</a>
				<?php
					if (isset($_SESSION['firstname'])) {
						if ($_SESSION['admin'] == "yes") {
							echo '<div id="admin">
											<button id="admin-btn">Admin
											</button>
											<div id="admin-pages">
												<a href="/admin/productlist">Product List</a>
												<a href="/admin/customerlist">Customer List</a>
												<a href="/admin/orderlist">Order List</a>
											</div>
										</div>';
							}

						echo '<div style="float:right;">
										<a><b>' . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . '</b></a>
										<a href="/logout">Logout</a>
									</div>';
					}
				?>
		</header>

		<section class="container">
			<h1 style="text-align:center;">Welcome to Trocery
				<?php
					if (isset($_SESSION['firstname'])) {
						echo ', ' . $_SESSION['firstname'];
					}
				?>
			!</h1>



		</section>

		<footer>
			<p>Trocery</p>
			<p>Made by Chris El-Kehdy and Étienne Paquet</p>
		</footer>
	</body>
</html>
