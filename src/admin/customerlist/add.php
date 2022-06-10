<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  $users = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

  if (isset($_POST['add'])) {
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $newFirstname = $_POST['firstname'];
    $newLastname = $_POST['lastname'];
    $newPostalcode = str_replace(' ', '', $_POST['postalcode']);
    $newAdmin = $_POST['admin'];
    $newCart = "[]";

    $newUser = $users -> addChild("user");

    $newUser -> addChild("email", $newEmail);
    $newUser -> addChild("password", md5($newPassword));
    $newUser -> addChild("firstname", $newFirstname);
    $newUser -> addChild("lastname", $newLastname);
    $newUser -> addChild("postalcode", $newPostalcode);
    $newUser -> addChild("admin", $newAdmin);
    $newUser -> addChild("cart", $newCart);

    $users -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

    header('Location: ../customerlist');
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
      <h2>Add a Customer</h2>
      <p>Create a new customer user, or admin.</p>
      <p>Set "Admin" to yes or no.</p>

          <table>
            <tr>
                <th>Email</th>
                <th>Password</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Postal Code</th>
                <th>Admin</th>
            </tr>
            <?php

                echo '<form name="form" action="" method="post">
                        <tr>
                          <td><input type="text" id="email" name="email"></td>
                          <td><input type="text" id="password" name="password"></td>
                          <td><input type="text" id="firstname" name="firstname"></td>
                          <td><input type="text" id="lastname" name="lastname"></td>
                          <td><input type="text" id="postalcode" name="postalcode"></td>
                          <td><input type="text" id="admin" name="admin"></td>
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
