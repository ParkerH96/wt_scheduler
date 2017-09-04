<?php
  if(!empty($_POST)){
    include 'connection.php';
    include 'session.php';

    $shift_date = $mysqli->escape_string($_POST['shift_date']);
    $start_time = $mysqli->escape_string($_POST['start_time'] . ':00');
    $end_time = $mysqli->escape_string($_POST['end_time'] . ':00');
    $employee_id = $mysqli->escape_string($_POST['employee_select']);
    $week = $mysqli->escape_string($_POST['week']);

    $mysqli->query("INSERT INTO SHIFT(employee_id, shift_date, start_time, end_time) VALUES ($employee_id, '$shift_date', '$start_time', '$end_time');");

    header("location: home.php?week=$week");

  }
?>
