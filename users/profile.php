<?php
include "../includes/login_navbar.php";
include "../includes/database.php";
include "../utilities/validate_session.php";
include "../classes/user.php";
?>

<?php
$errors = array();
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$customerObject = new Customer($user_id, $dbc);
$result = $customerObject->getCustomer();
echo "<div class=container>";
if ($result['success']) {
  $customer = $result['data']->fetch_assoc();
  echo "<div class=row>";
  echo "<div class=col-3>";
  echo "<div class='card text-center rounded-5' style='
  width: 20rem;
  height: 30rem;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  margin-left: 80px;
  '>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class=col>";
  echo "<h5>$customer[first_name] $customer[last_name]</h5>";
  echo "</div>";
  echo "</div>";
  echo "<hr />";
  echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>$customer[bio]</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "<div class='col-6'>";
  echo "<div class='card text-center rounded-5' style='
  width: 45rem;
  height: auto;
  background-color: #e96e58;
  color: white;
  margin-left: 200px;
  margin-top: 100px;
  '>";
  echo "<div class=card-body>";
  echo "<div class='containter text-left'>";
  echo "<div class=row>";
  echo "<div class=col>";
  echo "<h5>Contact Details</h5>";
  echo "<hr />";
  include "../classes/user_address.php";
  $address = new UserAddress($user_id, $dbc);
  $customer_address = $address->getUserAddress();
  echo "<ul class='list-group text-start'>";
  if ($customer_address['success']) {
    $add = $customer_address['data']->fetch_assoc();
    echo "<li class='list-group-item'><b>Address:</b> $add[line_1], $add[line_2]</li>";
    echo "<li class='list-group-item'><b>City:</b> $add[city]</li>";
    echo "<li class='list-group-item'><b>Postal Code:</b> $add[post_code]</li>";
    echo "<li class='list-group-item'><b>Telephone:</b> $customer[phone_no]</li>";
  } else {
    echo "<li class='list-group-item'>No Contact Details Found</li>";
  }
  echo "</ul>";
  echo "</div>";
  echo "<small><a href='./edit_profile.php'>Edit Profile</a></small>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
} else {
  $errors[] = 'Invalid Request!';
}
?>