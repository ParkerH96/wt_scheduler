<!DOCTYPE html>
<html>
  <head>
    <?php include 'session.php'; ?>
    <?php include 'connection.php'; ?>
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
    <?php

    function pretty_date($date) {
      switch(substr($date, 5, 2)) {
        case '01':
          echo 'Jan ' . substr($date, 8, 2);
          break;
        case '02':
          echo 'Feb ' . substr($date, 8, 2);
          break;
        case '03':
          echo 'March ' . substr($date, 8, 2);
          break;
        case '04':
          echo 'April ' . substr($date, 8, 2);
          break;
        case '05':
          echo 'May ' . substr($date, 8, 2);
          break;
        case '06':
          echo 'June ' . substr($date, 8, 2);
          break;
        case '07':
          echo 'July ' . substr($date, 8, 2);
          break;
        case '08':
          echo 'Aug ' . substr($date, 8, 2);
          break;
        case '09':
          echo 'Sep ' . substr($date, 8, 2);
          break;
        case '10':
          echo 'Oct ' . substr($date, 8, 2);
          break;
        case '11':
          echo 'Nov ' . substr($date, 8, 2);
          break;
        case '12':
          echo 'Dec ' . substr($date, 8, 2);
          break;
      }
    }

    ?>
    <div class="dashboard">
      <div class="container">
        <div class="row">
          <div class="col-md-3">

          </div>
          <div class="col-md-6">

          </div>
          <div class="col-md-3">
            <div class="notification">
              <h3>Pending Trades</h3>
              <div class="notification-data">
                <?php
                  $traded_shifts = $mysqli->query("SELECT * FROM TRADE_SHIFTS WHERE traded_to = $employee_id AND trade_status = 0");

                  while($current_row = $traded_shifts->fetch_assoc()){
                    $traded_by = $current_row['traded_by'];
                    $shift_traded_by = $current_row['shift_traded_by'];
                    $shift_traded_to = $current_row['shift_traded_to'];
                    $trade_shift_id = $current_row['trade_id'];

                    $shift1 = $mysqli->query("SELECT * FROM SHIFT WHERE shift_id = $shift_traded_by");
                    $shift2 = $mysqli->query("SELECT * FROM SHIFT WHERE shift_id = $shift_traded_to");
                    $employee = $mysqli->query("SELECT * FROM EMPLOYEE WHERE employee_id = $traded_by");
                    $current_shift1 = $shift1->fetch_assoc();
                    $current_shift2 = $shift2->fetch_assoc();
                    $current_employee = $employee->fetch_assoc();

                    $shift_date1 = $current_shift1['shift_date'];
                    $start_time1 = $current_shift1['start_time'];
                    $end_time1 = $current_shift1['end_time'];
                    $shift_date2 = $current_shift2['shift_date'];
                    $start_time2 = $current_shift2['start_time'];
                    $end_time2 = $current_shift2['end_time'];
                    $f_name = $current_employee['first_name'];
                    $l_name = $current_employee['last_name']; ?>

                    <div class="pending-shift">
                      <h6><?php echo $f_name . ' ' . $l_name; ?></h6>
                      <?php echo pretty_date($shift_date1) . ' '; ?>
                      <?php if((int)date('H', strtotime($start_time1)) % 12 != 0) { echo (int)date('H', strtotime($start_time1)) % 12; } else { echo 12; } echo date(':i A', strtotime($start_time1)) ?>
                        - <?php if((int)date('H', strtotime($end_time1)) % 12 != 0) { echo (int)date('H', strtotime($end_time1)) % 12; } else { echo 12; } echo date(':i A', strtotime($end_time1)); ?>
                      <br>
                      <?php echo pretty_date($shift_date2) . ' '; ?>
                      <?php if((int)date('H', strtotime($start_time2)) % 12 != 0) { echo (int)date('H', strtotime($start_time2)) % 12; } else { echo 12; } echo date(':i A', strtotime($start_time2)) ?>
                        - <?php if((int)date('H', strtotime($end_time2)) % 12 != 0) { echo (int)date('H', strtotime($end_time2)) % 12; } else { echo 12; } echo date(':i A', strtotime($end_time2)); ?>
                      <br>
                      <a class="employee-approve-shift btn btn-success" href="#" data-toggle="modal" data-target="#DoubleCheck" data-trade-id="<?php echo $trade_shift_id; ?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                      <a class="btn btn-danger" href="#"><i class="fa fa-times" aria-hidden="true"></i></a>
                    </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modals -->
    <div id="DoubleCheck" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Approve Trade</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to Approve this trade? Upon approval, a final request will be sent to your manager.</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-success">Yes</a>
            <button class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>

      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.employee-approve-shift').on('click', function(){
          let trade_id = $(this).data('trade-id');
          $('#DoubleCheck .modal-footer a').attr('href', 'employee-approve-shift-trade.php?trade_id=' + trade_id);
        });
      });
    </script>
  </body>
</html>
