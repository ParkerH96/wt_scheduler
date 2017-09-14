<?php
  if(!empty($_POST)){
    include 'connection.php';
    include 'session.php';

    $shift_date = $mysqli->escape_string($_POST['shift_date']);
    $start_time_hour = $mysqli->escape_string($_POST['start_time_hour']);
    $start_time_min = $mysqli->escape_string($_POST['start_time_min']);
    $start_time_am_pm = $mysqli->escape_string($_POST['start_time_am_pm']);
    $end_time_hour = $mysqli->escape_string($_POST['end_time_hour']);
    $end_time_min = $mysqli->escape_string($_POST['end_time_min']);
    $end_time_am_pm = $mysqli->escape_string($_POST['end_time_am_pm']);
    $employee_id = $mysqli->escape_string($_POST['employee_select']);
    $week = $mysqli->escape_string($_POST['week']);
    $month = $mysqli->escape_string($_POST['month']);
    $day = $mysqli->escape_string($_POST['day']);

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

    $mysqli->query("INSERT INTO SHIFT(employee_id, shift_date, start_time, end_time) VALUES ($employee_id, '$shift_date', '$start_time', '$end_time');");

    if(isset($week) && !empty($week)) {
      $get_location = 'week='.$week;
    }
    else if(isset($month) && !empty($month)){
      $get_location = 'month='.$month;
    }
    else {
      $get_location = 'day='.$day;
    }

    header("location: scheduler.php?$get_location");

  }
  else {
    header("location: login.php");
  }
?>
