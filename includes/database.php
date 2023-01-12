<?php

DEFINE('DB_USER', 'c2032632');
DEFINE('DB_PASSWORD', 'admin1234567890');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'c2032632_db2');

// Create connection
$dbc = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($dbc->connect_error) {
  echo "connection error";
  die("Connection failed: " . $dbc->connect_error);
}

$dbc->set_charset("utf8");
?>