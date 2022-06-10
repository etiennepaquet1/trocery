<?php
  session_start();
  session_destroy();
  echo '<script type="text/JavaScript">
        localStorage.clear();
        window.location.href = "/login";
       </script>'
  ;
?>
