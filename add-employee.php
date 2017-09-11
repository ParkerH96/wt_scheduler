<?php
  if(!empty($_POST)){
    include 'connection.php';
    include 'session.php';

    $admin_tag = $mysqli->escape_string($_POST['admin_tag']);
    $first_name = $mysqli->escape_string($_POST['first_name']);
    $last_name = $mysqli->escape_string($_POST['last_name']);
    $email = $mysqli->escape_string($_POST['email']);
    $phone_number = $mysqli->escape_string($_POST['phone_number']);
    $dob = $mysqli->escape_string($_POST['dob']);
    $username = $mysqli->escape_string($_POST['username']);
    $password = $mysqli->escape_string($_POST['password']);
    $color = $mysqli->escape_string($_POST['color']);

    $mysqli->query("INSERT INTO EMPLOYEE(admin_tag, first_name, last_name, email, phone_number, dob, username, password, color) VALUES ($admin_tag, '$first_name', '$last_name', '$email', '$phone_number', '$dob', '$username', '$password', '$color');");

    header("location: scheduler.php?week=$week");

  }
  else {
    header("location: login.php");
  }
?>
