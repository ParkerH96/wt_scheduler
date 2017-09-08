<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_POST) && !empty($_POST)){
    $shift_date = $mysqli->escape_string($_POST['shift_date']);
    $start_time_hour = $mysqli->escape_string($_POST['start_time_hour']);
    $start_time_min = $mysqli->escape_string($_POST['start_time_min']);
    $start_time_am_pm = $mysqli->escape_string($_POST['start_time_am_pm']);
    $end_time_hour = $mysqli->escape_string($_POST['end_time_hour']);
    $end_time_min = $mysqli->escape_string($_POST['end_time_min']);
    $end_time_am_pm = $mysqli->escape_string($_POST['end_time_am_pm']);
    $employee_id = $mysqli->escape_string($_POST['employee_select']);
    $shift_id = $mysqli->escape_string($_POST['shift_id']);
    $week = $mysqli->escape_string($_POST['week']);
    $month = $mysqli->escape_string($_POST['month']);

    if($start_time_am_pm == 'PM'){
      if($start_time_hour != 12){
        $start_time_hour += 12;
      }
    }
    if($start_time_am_pm == 'AM' && $start_time_hour == 12){
      $start_time_hour = 00;
    }

    if($end_time_am_pm == 'PM'){
      if($end_time_hour != 12){
        $end_time_hour += 12;
      }
    }
    if($end_time_am_pm == 'AM' && $end_time_hour == 12){
      $end_time_hour = 00;
    }

    $start_time = $start_time_hour.":".$start_time_min.':00';

    $end_time = $end_time_hour.":".$end_time_min.':00';

    $mysqli->query("UPDATE SHIFT SET employee_id = $employee_id, shift_date = '$shift_date', start_time = '$start_time', end_time = '$end_time' WHERE shift_id = $shift_id;");

    $get_location = $week ? 'week='.$week : 'month='.$month;

    header("location: home.php?$get_location");
  }
?>
