<?php
include "header.html";
?>
<div id="container">
  <nav class="navbar navbar-expand-sm navbar-dark" style="background: rgb(91,155,213);
  background: linear-gradient(140deg, rgba(91,155,213,1) 50%, rgba(0,81,154,1) 100%);">
    <div class="col-md-1 collapse navbar-collapse text-end">
      <a href="../index.php" class="navbar-brand mb-0 h1"> Rater </a>
      <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="col-md-7 collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <?php
          if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
          if (!empty($_SESSION['user_id'])) {
            if ($_SESSION['user_type'] == 'tradesman') {
              echo "<a href=./../tradesman/dashboard.php class=nav-link>Dashboard</a>";
            } else {
              echo "<a href=./../users/dashboard.php class=nav-link>Dashboard</a>";
            }
          }
          ?>
        </li>
        <li class="nav-item active">
          <?php
          if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
          if (!empty($_SESSION['user_id'])) {
            if ($_SESSION['user_type'] == 'tradesman') {
              echo "<a href=./../tradesman/profile.php.php class=nav-link>Profile</a>";
            } else {
              echo "<a href=./../users/profile.php class=nav-link>Profile</a>";
            }
          }
          ?>
        </li>
      </ul>
    </div>
    <div class="col-md-4 text-center">
      <a href="../logout.php">
        <button type="button" class="btn" style="background-color: #e96e58; color: white">
          Logout
        </button>
      </a>
    </div>
  </nav>
</div>