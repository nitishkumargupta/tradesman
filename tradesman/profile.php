<?php
include("../includes/navbar.php");
require("../includes/database.php");
include("../utilities/validate_session.php");
?>
<?php
$errors = array();
if (session_status() !== PHP_SESSION_ACTIVE)
  session_start();
$tradesman_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
include "../classes/user.php";
$trademan = new Trademan($tradesman_id, $dbc);
$result = $trademan->getTrademan();
echo "<div class=container>";
if ($result['success']) {
  $trademanResult = $result['data']->fetch_assoc();
  echo "<div class=row>";
  echo "<div class=col-3>";
  echo "<div class='card text-center rounded-5' style='
  width: 20rem;
  height: auto;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  '>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class=col>";
  echo "<h5>$trademanResult[first_name] $trademanResult[last_name] | £ $trademanResult[hourly_rate]/hour</h5>";
  echo "</div>";
  echo "</div>";
  echo "<hr />";
  echo "<div class='row text-start' style='padding-left: 20px; padding-right: 20px'>$trademanResult[bio]</div>";
  echo "<div class='row text-center'>";
  echo "<a href=#traderReview>";
  echo "<button class='text-center rounded-5' style='
  width: 8rem;
  height: 2rem;
  background-color: #5b9bd5;
  color: white;
  margin-top: 14rem;
  '>
  Reviews
  </button>";
  echo "</a>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "<div class='col-6'>";
  echo "<div class='card text-center rounded-5' style='
  width: auto;
  height: auto;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  '>";
  echo "<div class=card-body>";
  echo "<div class='containter text-left'>";
  echo "<div class=row>";
  echo "<div class=col>";
  echo "<h5>Contact Details</h5>";
  echo "<hr />";
  include "../classes/user_address.php";
  $address = new UserAddress($tradesman_id, $dbc);
  $tradesman_address = $address->getUserAddress();
  echo "<ul class='list-group text-start'>";
  if ($tradesman_address['success']) {
    $add = $tradesman_address['data']->fetch_assoc();
    echo "<li class='list-group-item'><b>Address:</b> $add[line_1], $add[line_2]</li>";
    echo "<li class='list-group-item'><b>City:</b> $add[city]</li>";
    echo "<li class='list-group-item'><b>Postal Code:</b> $add[post_code]</li>";
    echo "<li class='list-group-item'><b>Telephone:</b> $trademanResult[phone_no]</li>";

  } else {
    echo "<li class='list-group-item'>No Contact Details Found</li>";
  }
  echo "</ul>";
  echo "</div>";
  echo "<div class=col>";
  echo "<h5>Skills";
  echo "<svg xmlns='http://www.w3.org/2000/svg' width=16 height=16 fill=currentColor class='bi bi-hammer' viewBox='0 0 16 16'>";
  echo "<path
  d='M9.972 2.508a.5.5 0 0 0-.16-.556l-.178-.129a5.009 5.009 0 0 0-2.076-.783C6.215.862 4.504 1.229 2.84 3.133H1.786a.5.5 0 0 0-.354.147L.146 4.567a.5.5 0 0 0 0 .706l2.571 2.579a.5.5 0 0 0 .708 0l1.286-1.29a.5.5 0 0 0 .146-.353V5.57l8.387 8.873A.5.5 0 0 0 14 14.5l1.5-1.5a.5.5 0 0 0 .017-.689l-9.129-8.63c.747-.456 1.772-.839 3.112-.839a.5.5 0 0 0 .472-.334z' />";
  echo "</svg>";
  echo "</h5>";
  echo "<hr />";
  echo "<ul class='list-group text-start'>";
  include "../classes/user_skill.php";
  $skillObject = new UserSkill($tradesman_id, $dbc);
  $skills = $skillObject->getUserSkills();
  if ($skills['success']) {
    while ($skill = $skills['data']->fetch_assoc()) {
      echo "<li class='list-group-item'>$skill[skill]</li>";
    }
  } else {
    echo "<li class='list-group-item'>No Skill Found</li>";
  }
  echo "</ul>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "<div class=col-2>";
  echo "<div class='card text-center rounded-5' style='
  width: 20rem;
  height: auto;
  background-color: #e96e58;
  color: white;
  margin-top: 100px;
  '>";
  echo "<div class='card-body'>";
  echo "<div class='row'>";
  echo "<div class=col>";
  echo "<h5>Other Information</h5>";
  echo "</div>";
  echo "</div>";
  echo "<hr />";
  echo "<ul class='list-group text-start'>";
  if ($trademanResult['is_professional']) {
    echo "<li class=list-group-item><b>Professionally Registered?</b>Yes</li>";
    echo "<li class=list-group-item><b>Registered with:</b> $trademanResult[registered_with]</li>";
  } else {
    echo "<li class=list-group-item><b>Professionally Registered?</b>No</li>";
  }
  echo "<li class=list-group-item><b>Past Experience:</b> $trademanResult[past_experience]</li>";
  echo "</ul>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

} else {
  $errors[] = 'Invalid Request!';
}
?>