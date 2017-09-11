<!DOCTYPE html>
<html>
  <head>
    <?php include 'session.php'; ?>
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
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="login.php">Sign Out</a>
        </div>
      </div>
      <ul class="nav navbar-nav">
        <li><a href="scheduler.php" href="home.php">Dashboard</a></li>
        <li><a id="show-scheduler" href="scheduler.php">Schedule</a></li>
      </ul>
    </div>
  </head>
  <body>
    <div class="dashboard">
      <h1 style="text-align: center">DASHBOARD HERE</h1>
    </div>
  </body>
</html>
