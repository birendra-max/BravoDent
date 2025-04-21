<?php
include '../../connect.php';

// Fetch company profile details
$rrp = mysqli_query($bd, "SELECT * FROM profile WHERE id=1");
$rowp = mysqli_fetch_assoc($rrp);

if (isset($_POST['submit'])) {
    $errmsg_arr = array();
    $errflag = false;

    // Function to sanitize values received from the form. Prevents SQL injection
    function clean($bd, $str) {
        $str = trim($str);
        return mysqli_real_escape_string($bd, $str);
    }

    // Sanitize the POST values
    $username = clean($bd, $_POST['id']);
    $password = clean($bd, $_POST['password']);

    // Input Validations
    if ($username == '') {
        $errmsg_arr[] = 'Username missing';
        $errflag = true;
    }
    if ($password == '') {
        $errmsg_arr[] = 'Password missing';
        $errflag = true;
    }

    // If there are input validations, redirect back to the login form
    if ($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        echo "<script>window.location='../../index.php';</script>";
        exit();
    }

    // Create query
    $qry = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($bd, $qry);

    // Check whether the query was successful or not
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // Login Successful
            $member = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $member['username'];
            session_write_close();
            echo "<script>window.location='../../index.php';</script>";
            exit();
        } else {
            // Login failed
            $errmsg_arr[] = 'Username and password not found';
            $errflag = true;
            if ($errflag) {
                $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
                session_write_close();
                echo "<script>window.location='login.php';</script>";
                exit();
            }
        }
    } else {
        die("Query failed");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login | Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" style="background-image: url('../../images/oral.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
<div class="login-box">
  <div class="login-logo"></div>
  <div class="card">
    <h4 style="padding: 20px; margin: 10px;" class="text-center">
      <a href="#"><b><?php echo $rowp['cname']; ?></b></a>
    </h4>
    <div class="card-body login-card-body" style="background: rgba(255,255,255,0.5); box-shadow: 4px 4px 4px 4px rgba(0,0,0,0.5);">
      <p class="login-box-msg">Admin Login</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="id" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Remember Me</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <p class="mb-0">
        <a href="#" class="text-center">Forgot Password?</a>
      </p>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>