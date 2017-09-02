<?php
  if(!empty($_POST)){
    include 'connection.php';
    include 'session.php';

    $shift_date = $_POST['shift_date'];
    $start_time = $_POST['start_time'] . ':00';
    $end_time = $_POST['end_time'] . ':00';
    $color = $_POST['color'];
    $employee_id = $_POST['employee_select'];

    $mysqli->query("INSERT INTO SHIFT(employee_id, shift_date, start_time, end_time, color) VALUES ($employee_id, '$shift_date', '$start_time', '$end_time', '$color');");

    header("location: home.php");

  }
?>
