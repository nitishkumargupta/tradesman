<?php
// TODO: Need to test this bcz mails are not getting delivered so leaving it for now
function generate_password($email)
{
  require "includes/database.php";
  $errors = array();
  $new_password = sha1(time());
  try {
    $q = "UPDATE user set password = '$new_password' where email = '$email'";
    $result = $dbc->query($q);
    if ($result) {
      include "send_email.php";
      $subject = 'Your account password is changed!';
      $msg = "<h1>Hello $email!$</h1> <p>Please find your new password. You can change the password under the profile section if you wish to do so.</p> <p>$new_password</p>";
      send_email($email, $msg, $subject);
      $dbc->close();
    } else {
      include "redirect.php";
      load('reset_password.php');
    }
  }
  exit();
}
?>