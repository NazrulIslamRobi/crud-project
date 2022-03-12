<?php
    session_start();
    require_once 'inc/functions.php';

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        header("location:index.php");
    }


    if ( isset( $_POST['login'] ) ) {

        $userName = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
        $password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );

        $fp = fopen( "data\\users.txt", "r" );

        if ( $userName && $password ) {

            while ( $user = fgetcsv( $fp ) ) {

                if ( $user[0] == $_POST['username'] && $user[1] == sha1( $_POST['password'] ) ) {

                    $_SESSION['loggedin'] = true;
                    $_SESSION['name']     = $_POST['username'];
                    $_SESSION['role']     = $user[2];

                    header( "location:index.php" );
                } else {
                    $_SESSION['incorrect'] = "Invalid Credentials";
                }
            }

        }
    }

    if ( isset($_GET['logout']) && $_GET['logout'] == true ) {
 
        $_SESSION['loggedin'] = false;
        $_SESSION['role'] = false;
        session_destroy();
        header( "location:login.php" );

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="public/bootstrap5/css/bootstrap.min.css">

</head>

<body>


  <div class="container">
    <div class="row">
      <div class="col-md-6 m-auto">
        <h2>Authentication</h2>

        <p>Welcome login Bellow,</p>
        
     
      </div>
    </div>

      <div class="row">
        <p class="text-danger text-center"><?php if ( isset( $_SESSION['incorrect'] ) ) {echo $_SESSION['incorrect'];unset( $_SESSION['incorrect'] );}?></p>
        <div class="col-md-6 offset-md-3">
          <form method="POST">
            <div class="form-group">
              <label for="name">User Name</label>
              <input type="text" class="form-control" name="username" placeholder="Enter User Name"><br>
            </div>

            <div class="form-group">
              <label for="department">Password</label>
              <input type="password" class="form-control" name="password" placeholder="Enter Password"><br>
            </div>

            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </form>

        </div>
      </div>
    
  </div>

  <script src="public/bootstrap5/js/bootstrap.min.js"></script>
</body>

</html>