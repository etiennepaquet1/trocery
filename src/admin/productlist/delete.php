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
    $products = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

    foreach ($products -> children() as $product) {
      if (isset($product -> id) and ($id == $product -> id)) {
        $dom = dom_import_simplexml($product);
        $dom -> parentNode -> removeChild($dom);

        $products -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/products.xml');

        echo "success";
        die;
      }
    }
  }

  echo "error";
  die;
?>
