<?php
  session_start();

  if (isset($_GET['id'])) {
  	$id = preg_replace("/[^a-z0-9]/", '', $_GET['id']);
    $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');
    foreach ($products -> children() as $product) {
      if ($product -> id == $id) {
        $name = $product -> name;
        $image = $product -> image;
        $price = $product -> price;
        $description = $product -> description;
        $moredescription = $product -> moredescription;
      }
    }
  }

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trocery - <?php echo $name; ?></title>
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

		<section class="product-page container">
			<h1 class="product-name"><?php echo $name; ?></h1>
			<img <?php echo 'src="/img/' . $image . '"'; ?>><br>
			<input type="number" id="quantity" name="quantity" min="1" max="100" value="1">
			<select name="brand" id="brand">
				<option value=0>Bingi</option>
				<option value=1>Porto</option>
			</select>
			<select name="weight" id="weight">
				<option value=0>250g</option>
				<option value=3>500g</option>
			</select>
			<h2 id="price"><?php echo "$" . $price; ?></h2>
			<button class="add-to-cart" onclick="addToCart()">Add to Cart</button>
			<p class="description"><?php echo $description; ?><br><br></p>

			<button class="more-description-btn" onclick="moreDescription()">More Description</button>

			<p class="more-description" style="display:none;"><?php echo $moredescription; ?></p>
		</section>

		<div style="clear: both;height: 62px;"></div>
		<footer>
			<p>Trocery</p>
			<p>Made by Chris El-Kehdy and Étienne Paquet</p>
		</footer>

		<script src="/js/product.js"></script>
	</body>
</html>
