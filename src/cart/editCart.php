<?php
  function updateCart() {
    if (isset($_SESSION['email']) and isset($_SESSION['cart'])) {
      $users = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');
      $email = $_SESSION['email'];
      $cart = $_SESSION['cart'];

      foreach ($users -> children() as $user) {
        if (isset($user -> email)) {
          if ($email == $user -> email) {
            $user -> cart = json_encode($cart);
            $users -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');
          }
        }
      }
    }
  }

  if (isset($_GET['id']) and isset($_GET['delete'])) {
    session_start();

    $id = preg_replace("/[^a-z0-9]/", '', $_GET['id']);
    $found = false;
    $i = 0;

    if (isset($_SESSION["cart"])) {
      foreach ($_SESSION["cart"] as $itemObj) {
        if ($itemObj -> id == $id) {
          array_splice($_SESSION["cart"], $i, 1);
          $found = true;
          break;
        }

        $i++;
      }

      if (!$found) {
        echo "error";
      } else {
        echo json_encode($_SESSION["cart"]);
        updateCart();
      }
    } else {
      echo "error";
    }

  }
  elseif (isset($_GET['id']) and isset($_GET['quantity']) and isset($_GET['brand']) and isset($_GET['weight'])) {
  	$id = preg_replace("/[^a-z0-9]/", '', $_GET['id']);
    $quantity = abs((int) ($_GET['quantity']));
    $brand = abs((int) ($_GET['brand']));
    $weight = abs((int) ($_GET['weight']));

    $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');
    foreach ($products -> children() as $product) {
      if ($product -> id == $id) {
        $name = (string) $product -> name;
        $price = (string) $product -> price;
      }
    }

    if (isset($name)) {
      $item = new stdClass();

      $item -> id = $id;
      $item -> name = $name;
      $item -> quantity = $quantity;
      $item -> brand = $brand;
      $item -> weight = $weight;
      $item -> price = (int) $price + (int) $brand + (int) $weight;

      session_start();

      if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
      } else {
        $found = false;
        $i = 0;

        foreach ($_SESSION["cart"] as $itemObj) {
          if ($itemObj -> id == $id) {
            $_SESSION["cart"] = array_replace($_SESSION["cart"], array($i => $item));
            $found = true;
            break;
          }

          $i++;
        }

        if (!$found) {
          array_push($_SESSION["cart"], $item);
        }
      }

      echo json_encode($_SESSION["cart"]);
      updateCart();
    } else {
      echo "error";
    }
  } else {
    echo "error";
  }
?>
