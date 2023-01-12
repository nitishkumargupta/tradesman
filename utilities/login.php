<?php
require("utilities/redirect.php");
?>
<?php
function login($dbc, $email, $password)
{
  try {
    $q = "SELECT * FROM users WHERE email='$email' and pass=SHA1('$password')";
    $r = $dbc->query($q);
    $rowcount = $r->num_rows;
    if ($rowcount == 1) {
      $data = $r->fetch_array(MYSQLI_ASSOC);
      if (session_status() !== PHP_SESSION_ACTIVE)
        session_start();
      $_SESSION['user_id'] = $data['user_id'];
      $_SESSION['user_email'] = $data['user_email'];
      $_SESSION['first_name'] = $data['first_name'];
      $_SESSION['last_name'] = $data['last_name'];
      $_SESSION['user_type'] = $data['type'];
      if (isset($_SESSION['redirect_url'])) {
        $redirect_url = $_SESSION['redirect_url'];
        unset($_SESSION['redirect_url']);
        // $_SESSION['redirect_url'] = "";
        load($redirect_url);
      }
      if ($data['type'] == 'tradesman') {
        $dbc->close();
        load('tradesman/dashboard.php');
      } else {
        $dbc->close();
        load('users/dashboard.php');
      }
    } else {
      return array('success' => false, 'message' => 'Invalid Credentials.');
    }
  } catch (Exception $e) {
    return array('success' => false, 'message' => 'Internal Server Error');
  }
}
?>