<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_GET['shift_id']) && !empty($_GET['shift_id']) && $admin_tag == 1){

    $shift_id = $mysqli->escape_string($_GET['shift_id']);
    $week = $mysqli->escape_string($_GET['week']);
    $month = $mysqli->escape_string($_GET['month']);
    $day = $mysqli->escape_string($_GET['day']);

    $mysqli->query("DELETE FROM SHIFT WHERE shift_id = $shift_id");

    if(isset($week) && !empty($week)) {
      $get_location = 'week='.$week;
    }
    else if(isset($month) && !empty($month)){
      $get_location = 'month='.$month;
    }
    else {
      $get_location = 'day='.$day;
    }


    header("location: scheduler.php?".$get_location);

  }
?>
