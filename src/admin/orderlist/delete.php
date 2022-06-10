<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $orders = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

    foreach ($orders -> children() as $order) {
      if (isset($order -> id) and ($id == $order -> id)) {
        $dom = dom_import_simplexml($order);
        $dom -> parentNode -> removeChild($dom);

        $orders -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/orders.xml');

        echo "success";
        die;
      }
    }
  }

  echo "error";
  die;
?>
