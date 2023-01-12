<?php
include "../includes/login_navbar.php";
include "../utilities/validate_session.php";
require "../includes/database.php";
?>
<?php
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
$user_id = $_SESSION['user_id'];
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
  if (empty($_POST['skills'])) {
    $errors[] = 'Skillls can not be empty';
  } else {
    $skills = $_POST['skills'];
  }
  if (empty($_POST['hourly_rate'])) {
    $errors[] = 'hourly Rate can not be empty';
  } else {
    $hourly_rate = $dbc->real_escape_string(trim($_POST['hourly_rate']));
  }
  if (empty($_POST['is_professional'])) {
    $errors[] = 'Is Professional can not be empty';
  } else {
    $is_professional = $dbc->real_escape_string(trim($_POST['is_professional']));
  }
  if (empty($_POST['registered_with'])) {
    $registered_with = '';
  } else {
    $registered_with = $dbc->real_escape_string(trim($_POST['registered_with']));
  }
  if (empty($_POST['past_experience'])) {
    $past_experience = '';
  } else {
    $past_experience = $dbc->real_escape_string(trim($_POST['past_experience']));
  }

  if (empty($errors)) {
    try {
      include "../classes/user.php";
      $trademanObject = new Trademan($user_id, $dbc);
      $trademanObject->setFirstName($first_name);
      $trademanObject->setLastName($last_name);
      $trademanObject->setBio($bio);
      $trademanObject->setHourlyRate($hourly_rate);
      $trademanObject->setIsProfessional($is_professional);
      $trademanObject->setRegisteredWith($registered_with);
      include "../classes/user_address.php";
      $addressObject = new UserAddress($user_id, $dbc);
      $addressObject->setPostCode($postal_code);
      $addressObject->setLine1($line_1);
      $addressObject->setLine2($line_2);
      $addressObject->setcity($city);
      $dbc->begin_transaction();
      $trademanObject->updateUser();
      $addressObject->updateAddress();
      include "../classes/user_skill.php";
      $skillObject = new UserSkill($user_id, $dbc);
      $skillObject->removeSkills();
      foreach ($skills as $skill) {
        list($skillName, $catId) = explode(":", $skill);
        $skillObject->setSkill($catId, $skillName);
      }
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
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  include "../classes/user.php";
  $tradesmanObject = new Trademan($user_id, $dbc);
  $tradesman = $tradesmanObject->getTrademan();
  if ($tradesman['success']) {
    $tradesman = $tradesman['data']->fetch_assoc();
  } else {
    $tradesman = null;
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
          <input type="text" class="form-control" id="floatingInput" name="first_name" required="true" value="<?php if (isset($tradesman))
            echo $tradesman['first_name']; ?>">
          <label for="floatingInput" class="text-dark">First Name</label>
        </div>
        <div class="form-floating">
          <input type="text" name="last_name" class="form-control" id="floatingInput" value="<?php if (isset($tradesman))
            echo $tradesman['last_name']; ?>">
          <label for="floatingInput" class="text-dark">Last Name</label>
        </div>
        <div class="form-floating">
          <input type="text" style="height:100px" name="bio" placeholder="Bio" class="form-control" id="floatingInput"
            required=true value="<?php if (isset($tradesman))
              echo $tradesman['bio']; ?>">
          <label for="floatingInput" class="text-dark">Bio</label>
        </div>
        <p class="h5 mb-3 fw-normal">Address Details</p>
        <div class="form-floating">
          <input type="text" name="line_1" required="true" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['line_1']; ?>">
          <label for="floatingInput" class="text-dark">Address Line 1</label>
        </div>
        <div class="form-floating">
          <input type="text" name="line_2" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['line_2']; ?>">
          <label for="floatingInput" class="text-dark">Address Line 2</label>
        </div>
        <div class="form-floating">
          <input type="text" name="city" required="true" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['city']; ?>">
          <label for="floatingInput" class="text-dark">City</label>
        </div>
        <div class="form-floating">
          <input type="text" name="postal_code" required="true" class="form-control" id="floatingInput" value="<?php if (isset($address))
            echo $address['post_code']; ?>">
          <label for="floatingInput" class="text-dark">Postal Code</label>
        </div>
        <p class="h5 mb-3 fw-normal">Professional Details</p>
        <div class="form-floating">
          <?php
          $query = "SELECT * FROM job_category";
          $result = $dbc->query($query);
          $rowcount = $result->num_rows;
          if ($rowcount != 0) {
            echo '<select name="skills[]" id="skills" multiple require="true">';
            echo '<option disabled selected value> -- select relevent skill(s) -- </option>';
            while ($row = $result->fetch_assoc()) {
              echo "<option value='$row[cat_id]:$row[cat_name]'>$row[cat_name]</option>";
            }
            echo '</select>';
          }
          ?>
        </div>
        <div class="form-floating">
          <input type="text" required="true" name="hourly_rate" class="form-control" id="floatingInput" value="<?php if (isset($tradesman))
            echo $tradesman['hourly_rate']; ?>">
          <label for="floatingInput" class="text-dark">Hourly Rate</label>
        </div>
        <label class="text-dark">Are you professionally registered?</label>
        <input type="radio" name="is_professional" id="yes" value="1" checked required="true">
        <label for="yes">Yes</label>
        <input type="radio" name="is_professional" id="no" value="0">
        <label for="no">No</label>
        <div class="form-floating">
          <input type="text" name="registered_with" class="form-control" id="floatingInput" value="<?php if (isset($tradesman))
            echo $tradesman['registered_with']; ?>">
          <label for="floatingInput" class="text-dark">Registered With</label>
        </div>
        <div class="form-floating">
          <textarea style="height:100px" type="text" name="past_experience" class="form-control" id="floatingInput"
            value="<?php if (isset($tradesman))
              echo $tradesman['past_experience']; ?>"></textarea>
          <label for="floatingInput" class="text-dark">Tell us about your relevent past experience</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #5b9bd5">
          Save
        </button>
      </form>
    </main>
  </div>
</div>