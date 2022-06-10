<?php
  session_start();

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

  if (isset($_SESSION['email']) and isset($_SESSION['cart']) and count($_SESSION['cart']) > 0) {
    $orders = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

    $id = uniqid();
    $items = json_encode($_SESSION['cart']);
    $fullname = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
    $postalcode = str_replace(' ', '', $_SESSION['postalcode']);
    $user = $_SESSION['email'];

    $order = $orders -> addChild("order");

    $order -> addChild("id", $id);
    $order -> addChild("items", $items);
    $order -> addChild("fullname", $fullname);
    $order -> addChild("postalcode", $postalcode);
    $order -> addChild("user", $user);

    $orders -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

    $_SESSION['cart'] = array();
    updateCart();

    header('Location: ../cart');
    die;
  } else {
    echo "error";
    die;
  }
?>
