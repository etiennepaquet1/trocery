<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  $orders = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

  if (isset($_POST['add'])) {

    $newId = $_POST['id'];
    $newItems = $_POST['items'];
    $newFullname = $_POST['fullname'];
    $newPostalcode = $_POST['postalcode'];
    $newUser = $_POST['user']; ;

    $newOrder = $orders -> addChild("order");

    $newOrder -> addChild("id", preg_replace("/[^a-z0-9]/", '', $newId));
    $newOrder -> addChild("items", $newItems);
    $newOrder -> addChild("fullname", $newFullname);
    $newOrder -> addChild("postalcode", $newPostalcode);
    $newOrder -> addChild("user", $newUser);

    $orders -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

    header('Location: ../orderlist');
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
      <h2>Add an Order</h2>
      <p>Add a new order.</p>

      <table>
        <tr>
          <th>Order ID</th>
          <th>Items</th>
          <th>Full Name</th>
          <th>Postal Code</th>
          <th>User</th>
        </tr>
        <?php

            echo '<form name="form" action="" method="post">
                    <tr>
                      <td><input type="text" id="id" name="id" value="' . uniqid() . '"></td>
                      <td><textarea id="items" name="items" value="">[{"name":"NAME_HERE","quantity":QUANTITY_HERE},{"name":"NAME_HERE","quantity":QUANTITY_HERE}]</textarea></td>
                      <td><input type="text" id="fullname" name="fullname"></td>
                      <td><input type="text" id="postalcode" name="postalcode"></td>
                      <td><input type="text" id="user" name="user"></td>
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
