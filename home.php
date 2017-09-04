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
    <div id="scheduler">
      <h2>Your shifts</h2>
      <button class="btn btn-success" data-toggle="modal" data-target="#AddShift">Add Shift</button>
      <?php
          if(isset($_GET['week'])) {
            $week = (int) $_GET['week'];
          }
          else {
            $week = (int) date('w');
          }
                /* "next week" control */
          $next_week_link = '<a href="?week='.($week + 1).'" class="control">Next Week >></a>';

          /* "previous week" control */
          $previous_week_link = '<a href="?week='.($week - 1).'" class="control"><< 	Previous Week</a>';

          /* bringing the controls together */
          $controls = '<form method="get">'.$previous_week_link.'     '.$next_week_link.' </form>';

          echo $controls;
       ?>
      <hr>
      <div class="container-fluid schedule-view" style="padding-left: 2px; padding-right: 2px;">
        <?php
          include 'connection.php';

          $employees = $mysqli->query("SELECT * FROM EMPLOYEE");
          $date = date("Y-m-d");
          $weekofmonth = date('w');
          $dayofweek = date('w', strtotime($date));
        ?>
        <script type="text/javascript">
          console.log("<?php echo $week.":".$weekofmonth ?>");
        </script>
        <table style="width: 100%;" class="schedule-table">
          <tr class="week-days">
            <th style="background-color: white;"></th>
            <th>Sunday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Monday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-1+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Tuesday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-2+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Wednesday<br /><?php echo date('m/d/Y', strtotime('-'.($dayofweek-3+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Thursday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-4+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Friday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-5+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th>Saturday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-6+ (7*($weekofmonth-$week))).' days')); ?></th>
          </tr>
          <?php
            while($current_row = $employees->fetch_assoc()){  ?>
              <tr>
                <th id="employee-<?php echo $current_row['employee_id'] ?>-header"><?php echo $current_row['first_name'] . " " . $current_row['last_name'] ?></th>

                  <?php
                  $hours = new DateTime('00:00:00');

                   for ($i=0; $i < 7; $i++) {
                    include 'connection.php';

                    $employee_id = $current_row['employee_id'];

                    $shift_date = (string) date('Y-m-d', strtotime('-'.($dayofweek-$i+(7*($weekofmonth-$week))).' days'));
                    $shift = $mysqli->query("SELECT * FROM SHIFT WHERE employee_id = $employee_id AND shift_date = '".$shift_date."' ");

                    if($shift->num_rows > 0){
                      while($row = $shift->fetch_assoc()) { ?>

                        <td class="shift-block" style="background-color: <?php echo $current_row['color'] ?>">
                          <p>
                            <?php echo date('h:i A', strtotime($row['start_time'])) ?> - <?php echo date('h:i A', strtotime($row['end_time']))?>
                              <a class="remove-item" data-shift-id="<?php echo $row['shift_id']; ?>" data-toggle="modal" data-target="#DoubleCheck">
                                <i class="fa fa-times" aria-hidden="true"></i>
                              </a>
                          </p>
                        </td>

                        <?php
                        $datetime = new DateTime($row['start_time']);
                        $datetime1 = new DateTime($row['end_time']);
                        $hours->add($datetime->diff($datetime1));

                      }
                    }
                    else { ?>
                      <td></td>
                <?php
                    }
                  } ?>
                  <script type="text/javascript">
                    $('#employee-<?php echo $current_row['employee_id'] ?>-header').append("<br /><span class='employee-hours'><?php echo $hours->format('H.i') ?> hours</span>");
                  </script>
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

      });
    </script>
  </body>
</html>
