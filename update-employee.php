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

    if ($password == "") {
      $employees = $mysqli->query("SELECT * FROM EMPLOYEE WHERE employee_id = $employee_id");
      while($current_row = $employees->fetch_assoc()){
        $password = $current_row['password'];
      }
    }

    $mysqli->query("UPDATE EMPLOYEE SET admin_tag = $admin_tag, first_name = $first_name, last_name = $last_name, email = $email, phone_number = '$phone_number', dob = '$dob', username = $username, password = $password, color = $color WHERE employee_id = $employee_id;");

    header("location: profile.php");

  }
  else {
    header("location: login.php");
  }
?>
