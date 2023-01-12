<?php
include "../includes/login_navbar.php";
include "../utilities/validate_session.php";
require "../includes/database.php";
?>
<?php
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = array();
  if (empty($_POST['first_name'])) {
    $errors[] = 'First name can not be empty';
  } else {
    $first_name = $dbc->real_escape_string(trim($_POST['first_name']));
  }
  if (empty($_POST['last_name'])) {
    $errors[] = 'Last name can not be empty';
  } else {
    $last_name = $dbc->real_escape_string(trim($_POST['last_name']));
  }
  if (empty($_POST['bio'])) {
    $errors[] = 'Bio can not be empty';
  } else {
    $bio = $dbc->real_escape_string(trim($_POST['bio']));
  }
  if (empty($_POST['line_1'])) {
    $errors[] = 'Address Line 1 can not be empty';
  } else {
    $line_1 = $dbc->real_escape_string(trim($_POST['line_1']));
  }
  if (empty($_POST['line_2'])) {
    $line_2 = '';
  } else {
    $line_2 = $dbc->real_escape_string(trim($_POST['line_2']));
  }
  if (empty($_POST['city'])) {
    $errors[] = 'City can not be empty';
  } else {
    $city = $dbc->real_escape_string(trim($_POST['city']));
  }
  if (empty($_POST['postal_code'])) {
    $errors[] = 'Postal Code can not be empty';
  } else {
    $postal_code = $dbc->real_escape_string(trim($_POST['postal_code']));
  }
  if (empty($errors)) {
    try {
      include "../classes/user.php";
      $customerObject = new Customer($user_id, $dbc);
      $customerObject->setFirstName($first_name);
      $customerObject->setLastName($last_name);
      $customerObject->setBio($bio);
      include "../classes/user_address.php";
      $addressObject = new UserAddress($user_id, $dbc);
      $addressObject->setPostCode($postal_code);
      $addressObject->setLine1($line_1);
      $addressObject->setLine2($line_2);
      $addressObject->setcity($city);
      $dbc->begin_transaction();
      $customerObject->updateUser();
      $addressObject->updateAddress();
      $dbc->commit();
      echo '<h1>Profile Updated!</h1>';
      $dbc->close();
      include('./../includes/footer.html');
      exit();
    } catch (Exception $e) {
      $errors[] = 'Internal Server Error';
      $dbc->rollback();
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
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include "../classes/user.php";
  $customerObject = new Customer($user_id, $dbc);
  $customer = $customerObject->getCustomer();
  if ($customer['success']) {
    $customer = $customer['data']->fetch_assoc();
  } else {
    $customer = null;
  }
  include "../classes/user_address.php";
  $addressObject = new UserAddress($user_id, $dbc);
  $address = $addressObject->getUserAddress();
  if ($address['success']) {
    $address = $address['data']->fetch_assoc();
  } else {
    $address = null;
  }
}
?>
<div class="card text-center mx-auto rounded-5" style="
        width: 30rem;
        margin-top: 150px;
        background-color: #e96e58;
        color: white;
        ">
  <div class="card-body">
    <main class="form-signin w-100 mx-auto mt-0 text-center">
      <form action="edit_profile.php" method="post" class="form-signin" role="form">
        <h1 class="h3 mb-3 fw-normal">Edit Profile</h1>

        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" name="first_name" required="true" value="<?php if (isset($customer))
            echo $customer['first_name']; ?>">
          <label for="floatingInput" class="text-dark">First Name</label>
        </div>
        <div class="form-floating">
          <input type="text" name="last_name" class="form-control" id="floatingInput" value="<?php if (isset($customer))
            echo $customer['last_name']; ?>">
          <label for="floatingInput" class="text-dark">Last Name</label>
        </div>
        <div class="form-floating">
          <textarea type="text" style="height:100px" name="bio" required=true rows=4 cols=50 class="form-control"
            id="floatingInput"><?php if (isset($customer))
              echo $customer['bio'] ?></textarea>
            <label for="floatingInput" class="text-dark">Bio</label>
          </div>
          <p class="h5 mb-3 fw-normal">Address Details</p>
          <div class="form-floating">
            <input type="text" name="line_1" class="form-control" id="floatingInput" value="<?php if (isset($address))
              echo $address['line_1']; ?>">
          <label for="floatingInput" class="text-dark">Address Line 1</label>
        </div>
        <div class="form-floating">
          <input type="text" name="line_2" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['line_2']; ?>">
          <label for="floatingInput" class="text-dark">Address Line 2</label>
        </div>
        <div class="form-floating">
          <input type="text" name="city" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['city']; ?>">
          <label for="floatingInput" class="text-dark">City</label>
        </div>
        <div class="form-floating">
          <input type="text" name="postal_code" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['post_code']; ?>">
          <label for="floatingInput" class="text-dark">Postal Code</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #5b9bd5">
          Save
        </button>
      </form>
    </main>
  </div>
</div>