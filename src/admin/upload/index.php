<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  if(isset($_POST["submit"])) {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../../img/" . basename($_FILES["fileToUpload"]["name"]));
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
      <h3>Upload Image</h3>

      <form action="" method="post" enctype="multipart/form-data">
        Select an image to upload to /img/:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
      </form>
      <h4>Files:</h4>
      <?php
        $path = '../../img';
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file) {
          echo '<p>' . $file . '</p>';
        }

      ?>
    </section>
    <footer>
      <p>Trocery</p>
      <p>Made by Chris El-Kehdy and Étienne Paquet</p>
    </footer>

    </body>
</html>
