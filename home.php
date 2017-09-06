<!DOCTYPE html>
<html>
  <head>
    <?php include 'session.php'; ?>
    <?php
          if(isset($_GET['week'])) {
            $week = (int) $_GET['week'];
          }
          else {

            $week = (int) date('w');
          }
                /* "next week" control */
          $next_week_link = '<a type="button" class="btn btn-default btn-sm control button" href="?week='.($week + 1).'">Next Week</a>';

          /* "previous week" control */
          $previous_week_link = '<a type="button" class="btn btn-default btn-sm control button" href="?week='.($week - 1).'" class="control button">Prev Week</a>';

          /* bringing the controls together */
          $controls = '<form class="week-control-form" method="get">'.$previous_week_link.'     '.$next_week_link.' </form>';
       ?>
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
      <div class="control-bar">
        <?php if($admin_tag == 1) { ?>
        <div class="dropdown new" style="display:inline-block">
          <a class="btn btn-default dropdown-toggle control button btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;New
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#" data-toggle="modal" data-target="#AddEmployee">Employee</a></li>
            <li><a href="#" data-toggle="modal" data-target="#AddShift">Shift</a></li>
          </ul>
        </div>
            <?php } ?>
        <?php echo $controls; ?>
      </div>

       <br>
      <div class="container-fluid schedule-view" style="padding-left: 2px; padding-right: 2px;">
        <?php
          include 'connection.php';

          $employees = $mysqli->query("SELECT * FROM EMPLOYEE");
          $date = date("Y-m-d");
          $weekofmonth = date('w');
          $dayofweek = date('w', strtotime($date));
        ?>
        <table style="width: 100%;" class="schedule-table">
          <tr class="week-days">
            <th style="background-color: white; vertical-align: bottom;"></th>

            <th id="sunday-header">Sunday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="monday-header">Monday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-1+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="tuesday-header">Tuesday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-2+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="wednesday-header">Wednesday<br /><?php echo date('m/d/Y', strtotime('-'.($dayofweek-3+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="thursday-header">Thursday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-4+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="friday-header">Friday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-5+ (7*($weekofmonth-$week))).' days')); ?></th>

            <th id="saturday-header">Saturday<br /> <?php echo date('m/d/Y', strtotime('-'.($dayofweek-6+ (7*($weekofmonth-$week))).' days')); ?></th>
          </tr>
          <?php
            $sunhours = new DateTime('00:00:00');
            $monhours = new DateTime('00:00:00');
            $tueshours = new DateTime('00:00:00');
            $wedhours = new DateTime('00:00:00');
            $thurshours = new DateTime('00:00:00');
            $frihours = new DateTime('00:00:00');
            $sathours = new DateTime('00:00:00');

            while($current_row = $employees->fetch_assoc()){  ?>
              <tr>
                <th <?php if($current_row['employee_id'] == $employee_id) { echo 'style="background-color: #28a745 !important; color: #fff !important;"'; } ?> id="employee-<?php echo $current_row['employee_id']; ?>-header"><?php echo $current_row['first_name'] . " " . $current_row['last_name']; ?></th>

                  <?php

                  $hours = new DateTime('00:00:00');

                  for ($i=0; $i < 7; $i++) {
                    include 'connection.php';

                    $employee_id1 = $current_row['employee_id'];

                    $shift_date = (string) date('Y-m-d', strtotime('-'.($dayofweek-$i+(7*($weekofmonth-$week))).' days'));
                    $shift = $mysqli->query("SELECT * FROM SHIFT WHERE employee_id = $employee_id1 AND shift_date = '".$shift_date."' ");

                    if($shift->num_rows > 0){
                      while($row = $shift->fetch_assoc()) {?>

                        <td class="shift-block" style="background-color: <?php echo $current_row['color'] ?>">
                          <p>
                            <?php if((int)date('H', strtotime($row['start_time'])) % 12 != 0) { echo (int)date('H', strtotime($row['start_time'])) % 12; } else { echo 12; } echo date(':i A', strtotime($row['start_time'])) ?>
                              - <?php if((int)date('H', strtotime($row['end_time'])) % 12 != 0) { echo (int)date('H', strtotime($row['end_time'])) % 12; } else { echo 12; } echo date(':i A', strtotime($row['end_time'])); ?>
                              <?php if($admin_tag == 1) { ?>
                              <a class="remove-item" data-week="<?php echo $week; ?>" data-shift-id="<?php echo $row['shift_id']; ?>" data-toggle="modal" data-target="#DoubleCheck">
                                <i class="fa fa-times" aria-hidden="true"></i>
                              </a>
                              <a class="edit-item" data-week="<?php echo $week; ?>" data-employee-id="<?php echo $current_row['employee_id']; ?>" data-shift-date="<?php echo $row['shift_date']; ?>" data-shift-id="<?php echo $row['shift_id']; ?>" data-start-time="<?php echo $row['start_time']; ?>" data-end-time="<?php echo $row['end_time']; ?>" data-toggle="modal" data-target="#EditShift">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                              </a>
                            <?php } ?>
                          </p>
                        </td>

                        <?php
                        $datetime = new DateTime($row['start_time']);
                        $datetime1 = new DateTime($row['end_time']);
                        $hours->add($datetime->diff($datetime1));

                        switch ($i) {
                          case 0:
                            $sunhours->add($datetime->diff($datetime1));
                            break;
                          case 1:
                            $monhours->add($datetime->diff($datetime1));
                            break;
                          case 2:
                            $tueshours->add($datetime->diff($datetime1));
                            break;
                          case 3:
                            $wedhours->add($datetime->diff($datetime1));
                            break;
                          case 4:
                            $thurshours->add($datetime->diff($datetime1));
                            break;
                          case 5:
                            $frihours->add($datetime->diff($datetime1));
                            break;
                          case 6:
                            $sathours->add($datetime->diff($datetime1));
                            break;
                        }

                      }
                    }
                    else {  ?>
                      <td><?php if($admin_tag == 1) { ?><a class="in-cell-add add-item" data-week="<?php echo $week; ?>" data-employee-id="<?php echo $current_row['employee_id']; ?>" data-shift-date="<?php echo $shift_date; ?>" data-toggle="modal" data-target="#AddShift">
                        <i class="fa fa-plus" aria-hidden="true"></i></a><?php } ?></td>
                <?php
                    }
                  } ?>
                  <script type="text/javascript">
                    $('#employee-<?php echo $current_row['employee_id'] ?>-header').append("<br /><span class='employee-hours'><?php $total_hours = (int)$hours->format('i') / 60 + (int)$hours->format('H'); echo $total_hours; ?> hours</span>");
                  </script>
              </tr>
      <?php } ?>
            <script type="text/javascript">
              $('#sunday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$sunhours->format('i') / 60 + (int)$sunhours->format('H'); echo $totalhours; ?> hours</span>");
              $('#monday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$monhours->format('i') / 60 + (int)$monhours->format('H'); echo $totalhours; ?> hours</span>");
              $('#tuesday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$tueshours->format('i') / 60 + (int)$tueshours->format('H'); echo $totalhours; ?> hours</span>");
              $('#wednesday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$wedhours->format('i') / 60 + (int)$wedhours->format('H'); echo $totalhours; ?> hours</span>");
              $('#thursday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$thurshours->format('i') / 60 + (int)$thurshours->format('H'); echo $totalhours; ?> hours</span>");
              $('#friday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$frihours->format('i') / 60 + (int)$frihours->format('H'); echo $totalhours; ?> hours</span>");
              $('#saturday-header').append("<br /><span class='employee-hours'><?php $totalhours = (int)$sathours->format('i') / 60 + (int)$sathours->format('H'); echo $totalhours; ?> hours</span>");
            </script>
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
                <input style="display: none;" type="number" name="week" value="<?php echo $week; ?>">
            </div>
            <div class="modal-footer">
              <input type="submit" name="submit" value="Add Shift" class="btn btn-success">
            </div>
          </form>
        </div>

      </div>
    </div>

    <div id="AddEmployee" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Employee</h4>
          </div>
          <form action="add-employee.php" method="post">
            <div class="modal-body">
                First Name <input type="text" name="first_name" required><br><br>
                Last Name <input type="text" name="last_name" required><br><br>
                Email <input type="text" name="email" required><br><br>
                Phone Number <input type="number" name="phone_number" required><br><br>
                Date of Birth <input type="date" name="dob" required><br><br>
                Username <input type="text" name="username"><br><br>
                Password <input type="text" name="password"><br><br>
                Color <input type="color" name="color"><br><br>
                Role
                <select name="admin_tag">
                  <option value="0">Employee</option>
                  <option value="1">Admin</option>
                </select>
                <input style="display: none;" type="number" name="week" value="<?php echo $week; ?>">
            </div>
            <div class="modal-footer">
              <input type="submit" name="submit" value="Add Employee" class="btn btn-success">
            </div>
          </form>
        </div>

      </div>
    </div>

    <div id="EditShift" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Shift</h4>
          </div>
          <form action="edit-shift.php" method="post">
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
                <input style="display: none;" type="text" name="shift_id">
                <input style="display: none;" type="number" name="week" value="<?php echo $week; ?>">
            </div>
            <div class="modal-footer">
              <input type="submit" name="submit" value="Update" class="btn btn-success">
            </div>
          </form>
        </div>

      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('.shift-block .remove-item').on('click', function(){
          let shift_id = $(this).data('shift-id');
          let week = $(this).data('week');
          $('#DoubleCheck .modal-footer a').attr('href', 'delete-shift.php?shift_id=' + shift_id + '&week=' + week);
        });

        $('.shift-block .edit-item').on('click', function(){
          let shift_id = $(this).data('shift-id');
          let start_time = $(this).data('start-time');
          let end_time = $(this).data('end-time');
          let shift_date = $(this).data('shift-date');
          let employee_id = $(this).data('employee-id');
          $('#EditShift input[name="shift_id"]').attr('value', shift_id);
          $('#EditShift input[name="start_time"]').attr('value', start_time);
          $('#EditShift input[name="end_time"]').attr('value', end_time);
          $('#EditShift input[name="shift_date"]').attr('value', shift_date);
          $('#EditShift select option[value=' + employee_id + ']').attr('selected', 'selected');
        });

        $('.in-cell-add').on('click', function(){
          let shift_date = $(this).data('shift-date');
          let employee_id = $(this).data('employee-id');
          $('#AddShift input[name="shift_date"]').attr('value', shift_date);
          $('#AddShift select option[value=' + employee_id + ']').attr('selected', 'selected');
        });

      });
    </script>
  </body>
</html>
