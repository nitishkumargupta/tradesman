<?php
include "utilities/validate_session.php";
$_SESSION = array();
session_destroy();
echo "<head><style>
body {
  background-image: url('img/electrician.jpeg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>";
echo "</head>";
include "utilities/logout.php";
?>