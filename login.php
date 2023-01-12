<?php
include "includes/navbar.php";
include "includes/database.php";
require("utilities/login.php");
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
  if (empty($_POST['email'])) {
    $errors[] = 'Enter your email.';
  } else {
    $e = $dbc->real_escape_string(trim($_POST['email']));
  }
  if (!empty($_POST['password'])) {
    $p = $dbc->real_escape_string(trim($_POST['password']));
  } else {
    $errors[] = 'Enter your password.';
  }
  if (empty($errors)) {
    $response = login($dbc, $e, $p);
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
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
  if (!empty($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == 'tradesman') {
      load('tradesman/dashboard.php');
    } else {
      load('users/dashboard.php');
    }
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
      <form action="login.php" method="post" class="form-signin" role="form">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
          <label for="floatingInput" class="text-dark">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" />
          <label for="floatingPassword" class="text-dark">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #5b9bd5">
          Sign in
        </button>
        <small><a href="reset_password.php">Reset Password?</a></small>
      </form>
    </main>
  </div>
</div>


<?php
include("includes/footer.html");
?>