<?php
  include 'connection.php';
  include 'session.php';

  if(isset($_GET['date']) && !empty($_GET['employee'])){

    $date = $mysqli->escape_string($_GET['date']);
    $employee = $mysqli->escape_string($_GET['employee']);

    $shift_date = date('Y-m-d', strtotime($date));

    $shift = $mysqli->query("SELECT * FROM SHIFT WHERE employee_id = $employee AND shift_date = '".$shift_date."' ");

    if($shift->num_rows > 0){
      echo "There is a shift that already exist for this employee! <br />";
    }
    else {
      echo "";
    }
  }
?>
