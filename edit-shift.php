<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_POST) && !empty($_POST)){
    $shift_date = $mysqli->escape_string($_POST['shift_date']);
    $start_time = $mysqli->escape_string($_POST['start_time'] . ':00');
    $end_time = $mysqli->escape_string($_POST['end_time'] . ':00');
    $employee_id = $mysqli->escape_string($_POST['employee_select']);
    $shift_id = $mysqli->escape_string($_POST['shift_id']);

    $mysqli->query("UPDATE SHIFT SET employee_id = $employee_id, shift_date = '$shift_date', start_time = '$start_time', end_time = '$end_time' WHERE shift_id = $shift_id;");

    header("location: home.php");

  }
?>
