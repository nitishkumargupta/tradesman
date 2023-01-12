<?php
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
if (empty($_SESSION['user_id'])) {
  require("redirect.php");
  $_SESSION['redirect_url'] = "$_SERVER[REQUEST_URI]";
  load();
}
?>