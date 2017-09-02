<?php
  //creates a session for storing data across pages
  session_start();

  if($_SESSION['logged_in']){
    $employee_id = $_SESSION['employee_id'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $phone_number = $_SESSION['phone_number'];
    $dob = $_SESSION['dob'];
    $admin_tag = $_SESSION['admin_tag'];
  }
  else {
    header("location: login.php");
  }
?>
