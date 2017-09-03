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
        <li><a id="show-scheduler" href="#">Schedule</a></li>
      </ul>
    </div>
  </head>
  <body>
    <?php

      function displayDate($date){
        $month = substr($date, 5, 2);
        if($month == '01') { echo 'January, '; } else if($month == '02') { echo 'Feburary, '; } else if($month == '03') { echo 'March, '; }
        else if($month == '04') { echo 'April, '; } else if($month == '05') { echo 'May, '; } else if($month == '06') { echo 'June, '; }
        else if($month == '07') { echo 'July, '; } else if($month == '08') { echo 'August, '; } else if($month == '09') { echo 'September, '; }
        else if($month == '10') { echo 'October, '; } else if($month == '11') { echo 'November, '; } else if($month == '12') { echo 'December, '; }
        echo substr($date, 8, 2) . ' ' . substr($date, 0, 4);
      }
    ?>
    <div id="scheduler">
      <h2>Your shifts</h2>
      <button class="btn btn-success" data-toggle="modal" data-target="#AddShift">Add Shift</button>
      <hr>
      <div class="container-fluid schedule-view">
        <?php
          include 'connection.php';

          $employees = $mysqli->query("SELECT * FROM EMPLOYEE");

          $shifts = $mysqli->query("SELECT * FROM SHIFT WHERE employee_id = $employee_id");
        ?>
        <script type="text/javascript">
          function getHeaderDate(headerDate) {
            var diff = date.getDate() + 1; document.write((new Date(date.setDate(diff))).toLocaleDateString());
          }
          var date = new Date();
          var day = date.getDay();

        </script>
        <table style="width: 100%;" class="schedule-table">
          <tr>
            <th></th>
            <th>Sunday<br /> <script type="text/javascript">var diff = date.getDate() - day; document.write((new Date(date.setDate(diff))).toLocaleDateString()); </script></th>

            <th>Monday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>

            <th>Tuesday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>

            <th>Wednesday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>

            <th>Thursday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>

            <th>Friday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>

            <th>Saturday<br /> <script type="text/javascript">getHeaderDate(date); </script></th>
          </tr>
          <?php
            while($current_row = $employees->fetch_assoc()){
                $date = date("Y/m/d");
                $dayofweek = date('w', strtotime($date));
                $weekStart = date('Y/m/d', strtotime('-'.$dayofweek.' days'));
              ?>

              <tr>
                <th><?php echo $current_row['first_name'] . " " . $current_row['last_name'] ?></th>
                <?php for ($i=0; $i < 7; $i++) {
                  include 'connection.php';

                  $employee_id = $current_row['employee_id'];

                  $shift_date = (string) date('Y-m-d', strtotime('-'.$dayofweek+$i.' days'));
                  $shift = $mysqli->query("SELECT * FROM SHIFT WHERE employee_id = $employee_id AND shift_date = '".$shift_date."' ");

                  if($shift->num_rows > 0){
                    while($row = $shift->fetch_assoc()) { ?>

                      <td class="shift-block" style="background-color: <?php echo $row['color'] ?>"><p>
                        <?php echo date('h:i A', strtotime($row['start_time'])) ?> - <?php echo date('h:i A', strtotime($row['end_time']))?><a class="remove-item" data-shift-id="<?php echo $row['shift_id']; ?>" data-toggle="modal" data-target="#DoubleCheck"><i class="fa fa-times" aria-hidden="true"></i></a></td>
                      </p>

              <?php
                    }
                  }
                  else { ?>
                    <td></td>
              <?php
                  }
                } ?>

              </tr>

      <?php } ?>

        </table>
      </div>
    </div>

    <!-- Modals -->
    <div id="DoubleCheck" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Remove Shift</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to remove this?</p>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-success">Yes</a>
            <button class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>

      </div>
    </div>

    <div id="AddShift" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Shift</h4>
          </div>
          <form action="add-shift.php" method="post">
            <div class="modal-body">
                Employee
                <select name="employee_select">
                  <?php
                    $employees = $mysqli->query("SELECT * FROM EMPLOYEE");

                    while($employee =  $employees->fetch_assoc()){
                      echo '<option value="' . $employee['employee_id'] . '">' . $employee['first_name'] . ' ' . $employee['last_name'] . '</option>';
                    }
                  ?>
                </select><br><br>
                Day <input type="date" name="shift_date" required><br><br>
                Start Time <input type="time" name="start_time" required><br><br>
                End Time <input type="time" name="end_time" required><br><br>
                Color <input type="color" name="color" required>
            </div>
            <div class="modal-footer">
              <input type="submit" name="submit" value="Add Shift" class="btn btn-success">
            </div>
          </form>
        </div>

      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.shift-block .remove-item').on('click', function(){
          let shift_id = $(this).data('shift-id');
          $('#DoubleCheck .modal-footer a').attr('href', 'delete-shift.php?shift_id=' + shift_id);
        });

        $('#show-scheduler').on('click', function(){
          $('#scheduler').show();
        });
      });
    </script>
  </body>
</html>
