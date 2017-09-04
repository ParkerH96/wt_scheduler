<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_GET['shift_id']) && !empty($_GET['shift_id']) && $admin_tag == 1){

    $shift_id = $mysqli->escape_string($_GET['shift_id']);
    $week = $mysqli->escape_string($_GET['week']);

    $mysqli->query("DELETE FROM SHIFT WHERE shift_id = $shift_id");

    header("location: home.php?week=$week");

  }
?>
