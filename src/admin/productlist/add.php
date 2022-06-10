<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

  if (isset($_POST['add'])) {

    $newId = $_POST['id'];
    $newAisle = $_POST['aisle'];
    $newName = $_POST['name'];
    $newImage = $_POST['image'];
    $newPrice = str_replace(' ', '', $_POST['price']);
    $newDescription = $_POST['description'];
    $newMoredescription = $_POST['moredescription'];

    $newProduct = $products -> addChild("product");

    $newProduct -> addChild("id", preg_replace("/[^a-z0-9]/", '', $newId));
    $newProduct -> addChild("aisle", $newAisle);
    $newProduct -> addChild("name", $newName);
    $newProduct -> addChild("image", $newImage);
    $newProduct -> addChild("price", $newPrice);
    $newProduct -> addChild("description", $newDescription);
    $newProduct -> addChild("moredescription", $newMoredescription);

    $products -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

    header('Location: ../productlist');
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
      <h1>Trocery™ - Admin</h1>
      <h2>Add a Product</h2>
      <p>Add a new product.</p>

      <table>
        <tr>
            <th>ID</th>
            <th>Aisle</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Description</th>
            <th>More Description</th>
        </tr>
        <?php

            echo '<form name="form" action="" method="post">
                    <tr>
                      <td><input type="text" id="id" name="id" value="' . uniqid() . '"></td>
                      <td><input type="text" id="aisle" name="aisle"></td>
                      <td><input type="text" id="name" name="name"></td>
                      <td><input type="text" id="image" name="image"></td>
                      <td><input type="text" id="price" name="price"></td>
                      <td><textarea id="description" name="description"></textarea></td>
                      <td><textarea id="moredescription" name="moredescription"></textarea></td>
                    </tr>
                    <input class="submit" name="add" type="submit" value="Save Changes"></input>
                  </form>';
        ?>
      </table>
    </section>
    <footer>
        <p>Trocery</p>
        <p>Made by Chris El-Kehdy and Étienne Paquet</p>
    </footer>

  </body>

</html>
