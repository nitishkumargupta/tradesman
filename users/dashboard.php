<?php
include "../includes/login_navbar.php";
include "../utilities/validate_session.php";
?>
<?php
$user = $_SESSION['user_id'];
echo "<h1> Welcome $_SESSION[first_name] $_SESSION[last_name]</h1>";
?>
<?php
include "../includes/database.php";
$q = "SELECT * from jobs where user_id = '$user' and status = 'PENDING'";
$r = $dbc->query($q);
echo "<div class=container>";
echo "<div class=row>";
echo "<div class='card rounded-5' style='
          width: 30rem;
          min-height: 20rem;
          background-color: #e96e58;
          color: white;
          margin-top: 80px;
          margin-left: 25px;
        '>";
echo "<div class=card-body>";
echo "<div class=row>";
echo "<div class='col text-center'>";
echo "<h5 class=card-title>Pending Jobs</h5>";
echo "</div>";
echo "</div>";
echo "<div class=row>";
echo "<div class='card text-start rounded-4 mx-auto mt-4' style='
                width: 28rem;
                height: 24rem;
                background: rgb(91, 155, 213);
                background: linear-gradient(
                  140deg,
                  rgba(91, 155, 213, 1) 50%,
                  rgba(0, 81, 154, 1) 100%
                );
                color: white;
              '>";
if ($r->num_rows != 0) {
  echo "<ol style='padding-left: 2rem; padding-right: 2rem'>";
  while ($row = $r->fetch_assoc()) {
    echo "<li>";
    if (isset($row['booked_from'])) {
      list($bookedFrom) = explode(" ", $row['booked_from']);
    } else {
      $bookedFrom = '';
    }
    if (isset($row['booked_to'])) {
      list($bookedTo) = explode(" ", $row['booked_to']);
    } else {
      $bookedTo = '';
    }
    echo "<a href=./job_details.php?job_id=$row[job_id] style='color: white'> $row[job_title]</a> from $bookedFrom to $bookedTo</li>";
  }
  echo "</ol>";
} else {
  echo "<ul style='padding-left: 2rem; padding-right: 2rem'>";
  echo "<li>";
  echo "<a style='color: white'> No Data Found</li>";
  echo "</ul>";
}
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
?>
<?php
$q = "SELECT * from jobs where user_id = '$user' and status = 'CONFIRMED'";
$r = $dbc->query($q);
echo "<div class='card rounded-5' style='
          width: 30rem;
          min-height: 20rem;
          background-color: #e96e58;
          color: white;
          margin-top: 80px;
          margin-left: 25px;
        '>";
echo "<div class=card-body>";
echo "<div class=row>";
echo "<div class='col text-center'>";
echo "<h5 class=card-title>Confirmed Jobs</h5>";
echo "</div>";
echo "</div>";
echo "<div class=row>";
echo "<div class='card text-start rounded-4 mx-auto mt-4' style='
                width: 28rem;
                height: 24rem;
                background: rgb(91, 155, 213);
                background: linear-gradient(
                  140deg,
                  rgba(91, 155, 213, 1) 50%,
                  rgba(0, 81, 154, 1) 100%
                );
                color: white;
              '>";
if ($r->num_rows != 0) {
  echo "<ol style='padding-left: 2rem; padding-right: 2rem'>";
  while ($row = $r->fetch_assoc()) {
    echo "<li>";
    if (isset($row['booked_from'])) {
      list($bookedFrom) = explode(" ", $row['booked_from']);
    } else {
      $bookedFrom = '';
    }
    if (isset($row['booked_to'])) {
      list($bookedTo) = explode(" ", $row['booked_to']);
    } else {
      $bookedTo = '';
    }
    echo "<a href=./job_details.php?job_id=$row[job_id] style='color: white'> $row[job_title]</a> from $bookedFrom to $bookedTo</li>";
  }
  echo "</ol>";
} else {
  echo "<ul style='padding-left: 2rem; padding-right: 2rem'>";
  echo "<li>";
  echo "<a style='color: white'> No Data Found</li>";
  echo "</ul>";
}
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
?>
<?php
$q = "SELECT * from jobs where user_id = '$user' and status = 'REJECTED'";
$r = $dbc->query($q);
echo "<div class='card rounded-5' style='
          width: 30rem;
          min-height: 20rem;
          background-color: #e96e58;
          color: white;
          margin-top: 80px;
          margin-left: 25px;
        '>";
echo "<div class=card-body>";
echo "<div class=row>";
echo "<div class='col text-center'>";
echo "<h5 class=card-title>Rejected Jobs</h5>";
echo "</div>";
echo "</div>";
echo "<div class=row>";
echo "<div class='card text-start rounded-4 mx-auto mt-4' style='
                width: 28rem;
                height: 24rem;
                background: rgb(91, 155, 213);
                background: linear-gradient(
                  140deg,
                  rgba(91, 155, 213, 1) 50%,
                  rgba(0, 81, 154, 1) 100%
                );
                color: white;
              '>";
if ($r->num_rows != 0) {
  echo "<ol style='padding-left: 2rem; padding-right: 2rem'>";
  while ($row = $r->fetch_assoc()) {
    echo "<li>";
    if (isset($row['booked_from'])) {
      list($bookedFrom) = explode(" ", $row['booked_from']);
    } else {
      $bookedFrom = '';
    }
    if (isset($row['booked_to'])) {
      list($bookedTo) = explode(" ", $row['booked_to']);
    } else {
      $bookedTo = '';
    }
    echo "<a href=./job_details.php?job_id=$row[job_id] style='color: white'> $row[job_title]</a> from $bookedFrom to $bookedTo</li>";
  }
  echo "</ol>";
} else {
  echo "<ul style='padding-left: 2rem; padding-right: 2rem'>";
  echo "<li>";
  echo "<a style='color: white'> No Data Found</li>";
  echo "</ul>";
}
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
?>
<?php
$q = "SELECT * from jobs where user_id = '$user' and status = 'COMPLETED'";
$r = $dbc->query($q);
echo "<div class='card rounded-5' style='
          width: 30rem;
          min-height: 20rem;
          background-color: #e96e58;
          color: white;
          margin-top: 80px;
          margin-left: 25px;
        '>";
echo "<div class=card-body>";
echo "<div class=row>";
echo "<div class='col text-center'>";
echo "<h5 class=card-title>Completed Jobs</h5>";
echo "</div>";
echo "</div>";
echo "<div class=row>";
echo "<div class='card text-start rounded-4 mx-auto mt-4' style='
                width: 28rem;
                height: 24rem;
                background: rgb(91, 155, 213);
                background: linear-gradient(
                  140deg,
                  rgba(91, 155, 213, 1) 50%,
                  rgba(0, 81, 154, 1) 100%
                );
                color: white;
              '>";
if ($r->num_rows != 0) {
  echo "<ol style='padding-left: 2rem; padding-right: 2rem'>";
  while ($row = $r->fetch_assoc()) {
    echo "<li>";
    if (isset($row['booked_from'])) {
      list($bookedFrom) = explode(" ", $row['booked_from']);
    } else {
      $bookedFrom = '';
    }
    if (isset($row['booked_to'])) {
      list($bookedTo) = explode(" ", $row['booked_to']);
    } else {
      $bookedTo = '';
    }
    echo "<a href=./job_details.php?job_id=$row[job_id] style='color: white'> $row[job_title]</a> from $bookedFrom to $bookedTo</li>";
  }
  echo "</ol>";
} else {
  echo "<ul style='padding-left: 2rem; padding-right: 2rem'>";
  echo "<li>";
  echo "<a style='color: white'> No Data Found</li>";
  echo "</ul>";
}
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";
?>