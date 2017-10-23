<?php
  include 'session.php';
  include 'connection.php';

  if(isset($_GET['trade_id']) && !empty($_GET['trade_id'])) {

    $trade_id = $_GET['trade_id'];

    $mysqli->query("UPDATE TRADE_SHIFTS SET trade_status = 1 WHERE trade_id = $trade_id");

    header('location: home.php');
  }
  else {
    header('location: home.php');
  }
?>
