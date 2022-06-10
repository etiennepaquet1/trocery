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
      <h2>Order List</h2>
      <p>Add, remove, or edit orders here</p>

      <button class="button button2" onclick="window.location.href = 'add.php'">Add Order</button>
      <table>
          <tr>
              <th>Actions</th>
              <th>Order ID</th>
              <th>Items</th>
              <th>Full Name</th>
              <th>Postal Code</th>
              <th>User</th>
          </tr>

          <?php
            $orders = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

            foreach ($orders -> children() as $order) {
              $items = "";
              foreach(json_decode($order -> items, true) as $item) {
                $items = $items . $item["quantity"] . " " . $item["name"] . ", ";
              }

              echo '
              <tr>
                <td><button class="remove"><b>Delete</b></button> <button class="remove"><b>Edit</b></button>
                <td class="id">' . $order -> id . '</td>
                <td>' . $items . '</td>
                <td>' . $order -> fullname . '</td>
                <td>' . $order -> postalcode . '</td>
                <td>' . $order -> user . '</td>
              </tr>';
            }
          ?>
      </table>
    </section>
    <footer>
        <p>Trocery</p>
        <p>Made by Chris El-Kehdy and Étienne Paquet</p>
    </footer>

    <script src="/admin/js/orderlist.js"></script>

</body>

</html>
