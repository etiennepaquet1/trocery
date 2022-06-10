<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trocery - Meat Aisle</title>
		<link href="/css/style.css" rel="stylesheet"/>
	</head>
	<body>
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
												<a href="/admin/upload">Upload Images</a>
											</div>
										</div>';
							}

						echo '<div style="float:right;">
										<a><b>' . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . '</b></a>
										<a href="/logout">Logout</a>
									</div>';
					}
				?>
			</div>
		</header>

		<section class="container">
			<?php
			  $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

			  foreach ($products -> children() as $product) {
					if ($product -> aisle == "meat") {
						echo '<a href="/products/productDisplay.php?id=' . $product -> id . '">
										<div class="product">
											<img src="/img/' . $product -> image . '">
											<h1>' . $product -> name . '</h1>
											<p>$' . $product -> price . '</p>
										</div>
									</a>';
					}
				}
			?>
		</section>

		<footer>
			<p>Trocery</p>
			<p>Made by Chris El-Kehdy and Étienne Paquet</p>
		</footer>
	</body>
</html>
