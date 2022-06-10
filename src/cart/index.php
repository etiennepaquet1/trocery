<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trocery - Shopping Cart</title>
    <link href="/css/style.css" rel="stylesheet" />
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
      <h2>Shopping Cart</h2>
      <p>View the items in your cart here</p>

      <h2>Items in Cart</h2>

      <table id="cart-table">
          <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Price Total</th>
          </tr>
      </table>

      <table>
          <tr>
              <th>Number Of Items</th>
              <th>QST</th>
              <th>GST</th>
              <th>Total</th>
          </tr>
          <tr>
              <td id="numberOfItems">0</td>
              <td id="QST">$0</td>
              <td id="GST">$0</td>
              <td id="total">$0</td>
          </tr>
      </table>

      <button class="submit" onclick="window.location='/meat.html';">Continue Shopping</button>
			<?php
				if (isset($_SESSION['email']) and isset($_SESSION['cart'])) {
					if (count($_SESSION['cart']) > 0) {
						echo '<button class="submit" onclick="fetch(\'/order/newOrder.php\');localStorage.clear();alert(\'Successfully ordered!\');window.location.reload(true);">Order Now</button>';
					}
				} else {
					echo '<p>Note: You must be logged in to order. This is only a preview.</p>';
				}
			?>
    </section>


    <footer>
        <p>Trocery</p>
        <p>Made by Chris El-Kehdy and Étienne Paquet</p>
    </footer>

    <script src="/js/cart.js"></script>
</body>

</html>
