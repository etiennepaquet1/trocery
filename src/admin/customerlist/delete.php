<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
    header('Location: ../../');
    die;
  } elseif ($_SESSION['admin'] != "yes") {
    header('Location: ../../');
    die;
  }

  if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $users = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

    foreach ($users -> children() as $user) {
      if (isset($user -> email) and ($email == $user -> email)) {
        $dom = dom_import_simplexml($user);
        $dom -> parentNode -> removeChild($dom);

        $users -> asXML($_SERVER['DOCUMENT_ROOT'] . '/databases/users.xml');

        echo "success";
        die;
      }
    }
  }

  echo "error";
  die;
?>
