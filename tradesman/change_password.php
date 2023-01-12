<?php
include '../includes/login_navbar.php';
include '../includes/database.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_SESSION['user_email'];
  $errors = array();
  if (empty($_POST['old_password'])) {
    $errors[] = 'Enter Old password';
  } else {
    $old_password = $dbc->real_escape_string(trim($_POST['old_password']));
  }
  if (empty($_POST['new_password'])) {
    $errors[] = 'Enter new password';
  } else {
    if ($_POST['new_password'] != $_POST['confirm_password']) {
      $errors[] = 'Passwords do not match.';
    } else {
      $new_password = $dbc->real_escape_string(trim($_POST['new_password']));
    }
  }
  if (empty($errors)) {
    try {
      include "../classes/user.php";
      $user = new User($email, $dbc);
      $isSame = $user->checkPassword($old_password);
      if ($isSame) {
        $user->setPass($new_password);
        $response = $user->resetPassword();
        if (!$response['success']) {
          $errors[] = $response['message'];
        }

      } else {
        $errors[] = 'Old Password is incorrect!';
      }
    } catch (Exception $e) {
      $errors = 'Internal server error';
      $errors = 'Please contact admin';
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
    echo '<h1>Password Updated Successfully!</h1>';
    $dbc->close();
    include('../includes/footer.html');
    exit();
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
    <main class="form-reset-password w-100 mx-auto mt-0 text-center">
      <form action="change_password.php" method="post" class="form-reset-password" role="form">
        <h1 class="h3 mb-3 fw-normal">Change Password</h1>
        <div class="form-floating">
          <input type="password" name="old_password" class="form-control" id="floatingPassword"
            placeholder="Old Password" />
          <label for="floatingPassword" class="text-dark">Old Password</label>
        </div>
        <div class="form-floating">
          <input type="password" name="new_password" class="form-control" id="floatingPassword"
            placeholder="New Password" title="Minimum eight characters, at least one letter and one number"
            pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" />
          <label for="floatingPassword" class="text-dark">New Password</label>
        </div>
        <div class="form-floating">
          <input type="password" name="confirm_password" class="form-control" id="floatingPassword"
            placeholder="Confirm Password" />
          <label for="floatingPassword" class="text-dark">Confirm Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #5b9bd5">
          Update Password
        </button>
      </form>
    </main>
  </div>
</div>