<?php
include "includes/navbar.php";
require("includes/database.php");
echo "<head><style>
body {
  background-image: url('img/electrician.jpeg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>";
echo "</head>";
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $errors = array();
  $user_id = $_POST['user_id'];
  $tradesman_id = $_POST['tradesman_id'];
  $cat_id = $_POST['cat_id'];
  if (empty($_POST['booking_id'])) {
    if (empty($_POST['job_title'])) {
      $errors[] = 'Job title can not be empty';
    } else {
      $job_title = $dbc->real_escape_string(trim($_POST['job_title']));
    }
    if (empty($_POST['job_description'])) {
      $errors[] = 'Job description can not be empty';
    } else {
      $job_description = $dbc->real_escape_string(trim($_POST['job_description']));
    }
    if (empty($_POST['booking_from']) || empty($_POST['booking_to'])) {
      $errors[] = 'Booking dates are required';
    } else {
      $booking_from = $dbc->real_escape_string(trim($_POST['booking_from']));
      $booking_to = $dbc->real_escape_string(trim($_POST['booking_to']));
    }
    if (empty($_POST['tradesman_id'])) {
      $errors[] = 'Internal server error';
    } else {
      $tradesman_id = $dbc->real_escape_string(trim($_POST['tradesman_id']));
    }
    if (empty($errors)) {
      try {
        $q = "INSERT into jobs (job_title,description,cat_id,booked_from,booked_to,user_id,tradesman_id) values ('$job_title','$job_description','$cat_id','$booking_from','$booking_to','$user_id','$tradesman_id')";
        $r = $dbc->query($q);
        if ($r) {
          echo '<h1>Congratulations!</h1>';
          echo '<p>Job request has been send to the selected tradesman. He will review it and connect with you shortly.</p>';
        }
        $dbc->close();
        include('./includes/footer.html');
        exit();
      } catch (Exception $e) {
        $errors[] = 'Internal Server Error';
        $errors[] = 'Please contact admin of this website';
      }
    }
    if (!empty($errors)) {
      echo '<h1>Error!</h1>
           <p id="err_msg">The following error(s) occurred:<br>';
      foreach ($errors as $msg) {
        echo " - $msg<br>";
      }
      echo 'Please try again.</p>';
      $dbc->close();
    }
  } else {
    // TODO: Update booking
  }
}
?>