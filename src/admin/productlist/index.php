<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trocery - Admin</title>
    <link href="/css/style.css" rel="stylesheet" />
</head>

<body>
    <header>
        <div class="menu">
            <a href="/">Home</a>
            <div id="aisles">
                <button id="aisles-btn">Aisles</button>
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
      <h1>Trocery™ - Admin</h1>
      <h2>Product List</h2>
      <p>Add, remove, or edit products here</p>

      <button class="button button2" onclick="window.location.href = 'add.php'">Add Product</button>
      <table>
          <tr>
              <th>Actions</th>
              <th>ID</th>
              <th>Aisle</th>
              <th>Name</th>
              <th>Image</th>
              <th>Price</th>
              <th>Description</th>
              <th>More Description</th>
          </tr>

          <?php
            $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

            foreach ($products -> children() as $product) {

              echo '
              <tr>
                <td><button class="remove"><b>Delete</b></button> <button class="remove"><b>Edit</b></button>
                <td class="id">' . $product -> id . '</td>
                <td>' . $product -> aisle . '</td>
                <td>' . $product -> name . '</td>
                <td>' . $product -> image . '</td>
                <td>' . $product -> price . '</td>
                <td>' . $product -> description . '</td>
                <td>' . $product -> moredescription . '</td>
              </tr>';
            }
          ?>
      </table>
    </section>
    <footer>
        <p>Trocery</p>
        <p>Made by Chris El-Kehdy and Étienne Paquet</p>
    </footer>

    <script src="/admin/js/productlist.js"></script>

</body>

</html>
