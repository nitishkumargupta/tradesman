<?php
include "includes/navbar.php";
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
<div class="card text-center rounded-5"
  style="width: 20rem; height: 23rem; background-color: #e96e58; color: white; margin-top: 100px; margin-left: 150px;">
  <div class="card-body">
    <form action="search_result.php" method="post" class="form-signin" role="form">
      <h5 class="card-title">Looking for a Trader?</h5>
      <p class="card-text">
        What work would you like done?
      </p>
      <?php
      require("includes/database.php");
      $query = "SELECT * FROM job_category";
      $result = $dbc->query($query);
      $rowcount = $result->num_rows;
      if ($rowcount != 0) {
        echo "<div class=dropdown>";
        echo '<select name="category" id="category" class="btn bg-light dropdown-toggle mb-3 mt-0" style="width: 18rem;" required="true">';
        echo '<option disabled selected value> -- select a category -- </option>';
        while ($row = $result->fetch_assoc()) {
          echo "<option class=dropdown-item value='$row[cat_id]'>$row[cat_name]</option>";
        }
        echo '</select>';
        echo "</div>";
      }
      ?>
      <p class="card-text">
        Enter the postal code
      </p>
      <input type="text" required="true" name="postal_code" placeholder="Postal Code">
      <p class="card-text">
        When do you want this work done?
      </p>
      <label for="date_time">Booking (date):</label>
      <input type="date" name="date_time" required="true">
      <button class="btn rounded-5 mt-2" type="submit" style="background-color:#5b9bd5; color:white; width: 18rem">
        Search
      </button>
  </div>
</div>

<?php
include "includes/footer.html";
?>