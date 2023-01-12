<?php
include("includes/navbar.php");
require "includes/database.php";
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
  if (empty($_POST['category'])) {
    $errors[] = 'Select a Category.';
  } else {
    $category = $dbc->real_escape_string(trim($_POST['category']));
  }
  if (!empty($_POST['postal_code'])) {
    $postal_code = $dbc->real_escape_string(trim($_POST['postal_code']));
  } else {
    $errors[] = 'Enter postal code.';
  }
  if (!empty($_POST['date_time'])) {
    $date_time = $dbc->real_escape_string(trim($_POST['date_time']));
  } else {
    $errors[] = 'Select Date';
  }
  if (empty($errors)) {
    try {
      include "utilities/search.php";
      include "classes/review.php";
      $result = search($dbc, $category, $date_time, $postal_code);
      echo "<div class='container text-center'>";
      if ($result['success']) {
        while ($row = $result['data']->fetch_assoc()) {
          echo "<div class='card text-center rounded-5 mx-auto' style='
            width: 50rem;
            height: 12rem;
              background-color: #e96e58;
              color: white;
              margin-top: 50px;' data-bs-target=trader data-bs-spy=scroll data-bs-offset=0>";
          echo "<div class='container text-start'>";
          echo "<div class='row mt-3'>";
          echo "<div class='col'>";
          echo "<h5>$row[first_name] $row[last_name]</h5>";
          echo "</div>";
          $review = new Review($row['user_id'], $dbc);
          $revCount = $review->getCount();
          if ($revCount['success']) {
            $revCount = $revCount['data']->fetch_assoc()['count'];
          } else {
            $revCount = 0;
          }
          $revAvg = $review->getAverage();
          if ($revAvg['success']) {
            $revAvg = round($revAvg['data']->fetch_assoc()['avg'], 2);
          } else {
            $revAvg = 0.00;
          }
          echo "<div class='col'>$revCount Review(s) | $revAvg Rating</div>";
          echo "<div class='col'>";
          echo "<a href='./tradesman_profile.php?tradesman_id=$row[user_id]&cat_id=$category'>";
          echo "<button class='text-center rounded-5' style='width: 8rem;height: 2rem;background-color: #5b9bd5;color: white;'>More Info</button>";
          echo "</a>";
          echo "</div>";
          echo "</div>";
          echo "<div class='row text-start' style='margin-top: 30px'>";
          echo "<div class='col'>";
          echo "<h6>$row[bio]</h6>";
          echo "</div>";
          echo "</div>";
          echo "<div class='row' style='margin-top: 40px'>";
          echo "<div class='col-md-10'>Professional Tradesperson | Telephone: $row[phone_no] | Email: $row[email]</div>";
          echo "</div>";
          echo "</div>";
          echo "</div>";
        }
        $dbc->close();
      } else {
        $errors[] = $result['message'];
      }
    } catch (Exception $e) {
      $errors[] = 'Internal Server Error';
      $errors[] = 'Please contact the admin.';
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
?>
<?php
include('./includes/footer.html');
?>