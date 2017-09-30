<!DOCTYPE html>
<html>
  <head>
    <?php include 'session.php';
    include 'connection.php'; ?>

    <meta charset="utf-8">
    <title>WT Scheduler</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/main.css">
    <div class="navbar scheduler-navbar">
      <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $first_name; ?>
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="profile.php">Profile</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="login.php">Sign Out</a>
        </div>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="home.php">Dashboard</a></li>
        <li><a id="show-scheduler" href="scheduler.php">Schedule</a></li>
      </ul>
    </div>
  </head>
  <body>
    <div class="profile-page">
      <div class="container">
        <?php
          $employees = $mysqli->query("SELECT * FROM EMPLOYEE WHERE employee_id = $employee_id");
          while($current_row = $employees->fetch_assoc()){ $color = $current_row['color']; $username = $current_row['username'];}
         ?>
        <br>
        <h3>Personal Information</h3><br>
        <form action="update-employee.php" method="post">
          <div class="row">
            <div class="col-md-4">
              <label for="first_name">First Name</label><br>
              <input type="text" name="first_name" value="<?php echo $first_name; ?>" style="width: 17rem; padding-left: 5px;"><br><br>
              <label for="email">Email Address</label><br>
              <input type="text" name="email" value="<?php echo $email; ?>" style="width: 17rem; padding-left: 5px;"><br><br>
              <label for="dob">Date of Birth</label><br>
              <input type="date" name="dob" value="<?php echo $dob; ?>" style="width: 17rem; padding-left: 5px;"><br><br>
            </div>
            <div class="col-md-4">
              <label for="last_name">Last Name</label><br>
              <input type="text" name="last_name" value="<?php echo $last_name; ?>" style="width: 17rem; padding-left: 5px;"><br><br>
              <label for="phone">Phone Number</label><br>
              <input type="number" name="phone_number" value="<?php echo $phone_number; ?>" style="width: 17rem; padding-left: 5px;"><br><br>
              <label for="color">Color</label><br>
              <input type="color" name="color" value="<?php echo $color ?>" style="width: 4rem;"><br><br>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <label for="username">Username</label><br>
              <input type="text" name="username" value="<?php echo $username ?>" style="width: 17rem; padding-left: 5px;"><br><br>
            </div>
            <div class="col-md-4">
              <label for="password">Password</label><br>
              <input type="text" name="password" style="width: 17rem; padding-left: 5px;"><br><br>
            </div>
            <div class="col-md-4"></div>
            <input type="text" name="admin_tag" value="<?php echo $admin_tag; ?>" style="display: none;">
          </div>
          <input type="submit" name="Save Changes" value="Save Changes" class="btn btn-success">
        </form>
      </div>
    </div>
  </body>
</html>
