<?php
include "includes/login_navbar.php";
include("utilities/validate_session.php");
require("includes/database.php");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = array();
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
  $user_id = $_SESSION['user_id'];
  if (empty($_POST['review_comment'])) {
    $errors[] = 'Comment can not be empty';
  } else {
    $review_comment = $dbc->real_escape_string(trim($_POST['review_comment']));
  }
  if (empty($_POST['rating'])) {
    $errors[] = 'Rating can not be empty';
  } else {
    $rating = $dbc->real_escape_string(trim($_POST['rating']));
  }
  if (empty($_POST['pin'])) {
    $errors[] = 'Pin can not be empty';
  } else {
    $pin = $dbc->real_escape_string(trim($_POST['pin']));
  }
  if (empty($_POST['cat_id'])) {
    $errors[] = 'Internal Server Error';
  } else {
    $cat_id = $dbc->real_escape_string(trim($_POST['cat_id']));
  }
  if (empty($_POST['job_id'])) {
    $errors[] = 'Internal Server Error';
  } else {
    $job_id = $dbc->real_escape_string(trim($_POST['job_id']));
  }
  if (empty($_POST['tradesman_id'])) {
    $errors[] = 'Internal Server Error';
  } else {
    $tradesman_id = $dbc->real_escape_string(trim($_POST['tradesman_id']));
  }
  $q = "SELECT * from jobs where job_id = '$job_id' and pin='$pin'";
  $job = $dbc->query($q);
  if ($job->num_rows == 1) {
    $review = "INSERT into review (comments,job_id,customer_id,tradesman_id,rate) values ('$review_comment','$job_id','$user_id','$tradesman_id',$rating)";
    $result = $dbc->query($review);
    if ($result) {
      echo "<p> Review successfully posted</p>";
    }
  } else {
    $errors[] = 'Please check the pin you have entered';
  }

}
?>