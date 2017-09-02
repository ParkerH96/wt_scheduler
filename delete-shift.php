<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_GET['shift_id']) && !empty($_GET['shift_id']) && $admin_tag == 1){

    $shift_id = $_GET['shift_id'];

    $mysqli->query("DELETE FROM SHIFT WHERE shift_id = $shift_id");

    header('location: home.php');

  }
?>
