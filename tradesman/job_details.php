<?php
include "../includes/login_navbar.php";
include("../utilities/validate_session.php");
require("../includes/database.php");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $errors = array();
  if (session_status() !== PHP_SESSION_ACTIVE)
    session_start();
  $user_id = $_SESSION['user_id'];
  if (empty($_POST['job_id'])) {
    $errors[] = 'Internal Server Error';
  } else {
    $job_id = $dbc->real_escape_string(trim($_POST['job_id']));
  }
  if ($_POST['change_status']) {
    try {

      $q = "UPDATE jobs set status = '$_POST[new_status]' where job_id = '$job_id'";
      $result = $dbc->query($q);
      if ($dbc->affected_rows == 1) {
        echo "<h1>Status has been changed</h1>";
        include "../includes/footer.html";
        exit();
      } else {
        $errors[] = "Internal Server Error";
      }
    } catch (Exception $e) {
      $errors[] = "Internal Server Error";
    }
  } else {
    if (empty($_POST['review_comment'])) {
      $errors[] = 'Comment can not be empty';
    } else {
      $review_comment = $dbc->real_escape_string(trim($_POST['review_comment']));
    }
    if (empty($_POST['rating'])) {
      $errors[] = 'Rating can not be empty';
    } else {
      $rating = $dbc->real_escape_string(trim($_POST['rating']));
    }
    if (empty($_POST['pin'])) {
      $errors[] = 'Pin can not be empty';
    } else {
      $pin = $dbc->real_escape_string(trim($_POST['pin']));
    }
    if (empty($_POST['cat_id'])) {
      $errors[] = 'Internal Server Error';
    } else {
      $cat_id = $dbc->real_escape_string(trim($_POST['cat_id']));
    }
    if (empty($_POST['tradesman_id'])) {
      $errors[] = 'Internal Server Error';
    } else {
      $tradesman_id = $dbc->real_escape_string(trim($_POST['tradesman_id']));
    }
    $q = "SELECT * from jobs where job_id = '$job_id' and pin='$pin'";
    $job = $dbc->query($q);
    if ($job->num_rows == 1) {
      $review = "INSERT into review (comments,job_id,customer_id,tradesman_id,rate) values ('$review_comment','$job_id','$user_id','$tradesman_id',$rating)";
      $result = $dbc->query($review);
      if ($result) {
        echo "<p> Review successfully posted</p>";
      }
      $dbc->close();
      include "../includes/footer.html";
      exit();
    } else {
      $errors[] = 'Please check the pin you have entered';
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
?>
<?php
$errors = array();
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
$user_id = $_SESSION['user_id'];
$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : $_POST['job_id'];
$q = "SELECT * from jobs where job_id = '$job_id'";
$job = $dbc->query($q)->fetch_assoc();
echo "<div class=container>";
echo "<div class=row>";
echo "<div class=col-3>";
echo "<div class='card text-center rounded-5' style='
  width: 20rem;
  min-height: 20rem;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  '>";
echo "<div class='card-body'>";
echo "<div class='row'>";
echo "<div class=col>";
echo "<h5>Job Details</h5>";
echo "</div>";
echo "</div>";
echo "<hr />";
echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>";
echo "<div class=col><b>Title: </b> $job[job_title]</div>";
echo "</div>";
echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>";
echo "<div class=col><b>Description: </b> $job[description]</div>";
echo "</div>";
list($bookedFrom) = explode(" ", $job['booked_from']);
list($bookedTo) = explode(" ", $job['booked_to']);
echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>";
echo "<div class=col><b>Booked From: </b> $bookedFrom</div>";
echo "</div>";
echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>";
echo "<div class=col><b>Booked Till: </b> $bookedTo</div>";
echo "</div>";
echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>";
echo "<div class=col><b>Pin: </b> $job[pin]</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "<div class='col-6'>";
echo "<div class='card text-center rounded-5' style='
  width: auto;
  min-height: 20rem;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  '>";
echo "<div class=card-body>";
echo "<div class='containter text-left'>";
echo "<div class=row>";
echo "<div class=col>";
echo "<h5>Trademan Information</h5>";
echo "<hr />";
include "../classes/user.php";
$trademanObject = new Trademan($job['tradesman_id'], $dbc);
$trademanResult = $trademanObject->getTrademan();
echo "<ul class='list-group text-start'>";
if ($trademanResult['success']) {
  $trademan = $trademanResult['data']->fetch_assoc();
  echo "<li class='list-group-item'><b>Name:</b> $trademan[first_name], $trademan[last_name]</li>";
  echo "<li class='list-group-item'><b>Email:</b> $trademan[email]</li>";
  echo "<li class='list-group-item'><b>Telephone:</b> $trademan[phone_no]</li>";

} else {
  echo "<li class='list-group-item'>No Contact Details Found</li>";
}
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
if ($job['status'] != 'COMPLETED' && $job['status'] != 'REJECTED') {
  echo "<div class='card text-center mx-auto rounded-5' style='
  width: 30rem;
  margin-top: 80px;
  background-color: #e96e58;
  color: white;
  '>";
  echo "<div class=card-body>";
  echo "<main class='form-signin w-100 mx-auto mt-0 text-center'>";
  echo "<form action=job_details.php method=post>";
  echo "<h1 class='h3 mb-3 fw-normal'>Change Job Status</h1>";
  echo "<div class=dropdown>";
  echo '<select name="new_status" class="btn bg-light dropdown-toggle mb-3 mt-0" style="width: 18rem;"">';
  echo '<option disabled selected value> -- select a new status -- </option>';
  if ($job['status'] == 'PENDING') {
    echo "<option class=dropdown-item value=REJECTED>Reject</option>";
    echo "<option class=dropdown-item value=CONFIRMED>Confirm</option>";
  } else {
    echo "<option class=dropdown-item value=COMPLETED>Complete</option>";
  }
  echo '</select>';
  echo "</div>";
  echo "<input type=text name=job_id value=$job_id hidden=true>";
  echo "<input type=text name=change_status value=true hidden=true>";
  echo "<button class='w-100 btn btn-lg text-light mt-3' type=submit style='background-color: #5b9bd5'>Change Status</button>";
  echo "</form>";
  echo "</main>";
  echo "</div>";
  echo "</div>";
}
?>