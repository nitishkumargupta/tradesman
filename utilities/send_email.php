<?php
function send_email($email, $msg, $subject)
{
  $response = mail($email, $subject, $msg);
}
?>