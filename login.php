<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Portal</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">

    <script type="text/javascript">
      function Success(){
        alert("Login was successful!");
      }
      function PassFailure(){
        alert("Login unsuccessful. The password was not correct.");
      }
      function UserFailure(){
        alert("Login unsuccessful. The username could not be found.");
      }
    </script>

    <?php
      session_start();
      session_unset();
      session_destroy();

      if(!empty($_POST)){

        include 'connection.php';
        session_start();

        //escape the strings
        $username = $mysqli->escape_string($_POST['username']);
        $password = $mysqli->escape_string($_POST['password']);

        $username = strtolower($username);

        //Query for the username
        $result = $mysqli->query("SELECT * FROM EMPLOYEE WHERE username='$username'");

        if($result->num_rows == 0){
          echo '<script type="text/javascript"> UserFailure(); </script>';
        }
        else {
          $user = $result->fetch_assoc();

          if($password === $user['password']){

            //create session
            $_SESSION['employee_id'] = $user['employee_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone_number'] = $user['phone_number'];
            $_SESSION['dob'] = $user['dob'];
            $_SESSION['admin_tag'] = $user['admin_tag'];

            $_SESSION['logged_in'] = true;

            //redirect to home page
            header("location: home.php");

          }
          else {
            echo "<script type='text/javascript'> PassFailure(); </script>";
          }
        }

        //Close the connection
        $mysqli->close();
      }
    ?>

  </head>
  <body class="login-body">
    <div id="login">
      <h1>WT Scheduler</h1>
      <form action="" method="post">
        <label for="username">Username</label><br>
        <input type="text" name="username" required><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" required><br>
        <input type="submit" name="submit" value="Log In">
      </form>
    </div>
  </body>
</html>
