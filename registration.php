<?php
include("includes/navbar.php");
require('includes/database.php');
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
  if (empty($_POST['email'])) {
    $errors[] = 'email can not be empty';
  } else {
    $email = $dbc->real_escape_string(trim($_POST['email']));
  }
  if (empty($_POST['phone_number'])) {
    $errors[] = 'Phone Number can not be empty';
  } else {
    $phone_number = $dbc->real_escape_string(trim($_POST['phone_number']));
  }
  if (!empty($_POST['pass1'])) {
    if ($_POST['pass1'] != $_POST['pass2']) {
      $errors[] = 'Passwords do not match.';
    } else {
      $password = $dbc->real_escape_string(trim($_POST['pass1']));
    }
  } else {
    $errors[] = 'Enter your password.';
  }
  if (empty($_POST['user_type'])) {
    $errors[] = 'Please Select User Type';
  } else {
    $user_type = $dbc->real_escape_string(trim($_POST['user_type']));
  }
  if (empty($errors)) {
    include "classes/user.php";
    $user = new User($email, $dbc);
    $user->setFirstName($first_name);
    $user->setLastName($last_name);
    $user->setType($user_type);
    $user->setPass($password);
    $user->setPhoneNumber($phone_number);
    $user->setActive(true);
    $response = $user->registerUser();
    if (!$response['success']) {
      $errors[] = $response['message'];
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
  } else {
    echo '<h1>Registered!</h1> <p>You are now registered.</p> <p><a href="login.php">Login</a></p>';
    $dbc->close();
    include('includes/footer.html');
    exit();
  }
}
?>

<div class="card text-center mx-auto rounded-5" style="
        width: 30rem;
        margin-top: 80px;
        background-color: #e96e58;
        color: white;
      ">
  <div class="card-body">
    <main class="form-signin w-100 mx-auto mt-0 text-center">
      <form action="registration.php" method="post">
        <h1 class="h3 mb-3 fw-normal">Create an Account</h1>
        <div class="form-floating">
          <input type="text" name="first_name" value="<?php if (isset($_POST['first_name']))
            echo $_POST['first_name']; ?>" class="form-control" id="floatingInput" placeholder="postcode" />
          <label for="floatingInput" class="text-dark">First Name</label>
        </div>
        <div class="form-floating">
          <input type="text" name="last_name" value="<?php if (isset($_POST['last_name']))
            echo $_POST['last_name']; ?>" class="form-control" id="floatingInput" placeholder="postcode" />
          <label for="floatingInput" class="text-dark">Last Name</label>
        </div>
        <div class="form-floating">
          <input type="email" name="email" value="<?php if (isset($_POST['email']))
            echo $_POST['email']; ?>" class="form-control" id="floatingInput" placeholder="name@example.com" />
          <label for="floatingInput" class="text-dark">Enter your Email Address</label>
        </div>
        <div class="form-floating">
          <input type="text" name="phone_number" value="<?php if (isset($_POST['phone_number']))
            echo $_POST['phone_number']; ?>" class="form-control" id="floatingInput" placeholder="postcode" />
          <label for="floatingInput" class="text-dark">Phone Number</label>
        </div>
        <div class="form-floating">
          <input type="password" name="pass1" class="form-control" id="floatingPassword" placeholder="Password" />
          <label for="floatingPassword" class="text-dark">Enter a Password</label>
        </div>
        <div class="form-floating">
          <input type="password" name="pass2" class="form-control" id="floatingPassword" placeholder="Password" />
          <label for="floatingPassword" class="text-dark">Confirm Password</label>
        </div>
        <div>
          <label for="user_type">Choose a User Type:</label>
          <select name="user_type" id="user_type">
            <option disabled selected value> -- Select User Type -- </option>;
            <option value="tradesman">Tradesman</option>
            <option value="customer">Customer</option>
          </select>
        </div>
        <button class="w-100 btn btn-lg text-light mt-3" type="submit" style="background-color: #5b9bd5">
          Sign-up
        </button>
      </form>
    </main>
  </div>
</div>
<?php
include("includes/footer.html");
?>