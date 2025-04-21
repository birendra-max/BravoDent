<?php
include '../../connect.php';

$rrp = mysqli_query($bd, "SELECT * FROM profile WHERE id=1");
$rowp = mysqli_fetch_assoc($rrp);

if (isset($_POST['submit'])) {
    // Array to store validation errors
    $errmsg_arr = array();
    
    // Validation error flag
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
        echo "<script>window.location='login.php';</script>";
        exit();
    }
    
    // Create query
    $qry = "SELECT * FROM user1 WHERE em=? AND password=? AND acpinid='1'";
    $stmt = mysqli_prepare($bd, $qry);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check whether the query was successful or not    
    if (mysqli_num_rows($result) > 0) {
        // Login Successful
        session_regenerate_id();
        $member = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $member['id'];
        $_SESSION['userid'] = $member['userid'];
        $_SESSION['email'] = $member['em'];
        $_SESSION['user_type'] = "designer";
        $_SESSION['name'] = $member['name'];
        $_SESSION['status'] = $member['status'];
        
        if (isset($_SESSION['pname'])) {
            $pname = $_SESSION['pname'];      
            $pprice = $_SESSION['pprice'];
            $imag = $_SESSION['imag'];
            $tdate = date("m/d/Y");
            $insert_stmt = mysqli_prepare($bd, "INSERT INTO product(mid, name, price, tdate, status, imag) VALUES(?, ?, ?, ?, 'N', ?)");
            mysqli_stmt_bind_param($insert_stmt, 'ssdss', $username, $pname, $pprice, $tdate, $imag);
            mysqli_stmt_execute($insert_stmt);
        }

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
            echo "<script>alert('Username or password invalid'); window.location='index.php';</script>";
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Designer Login | Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
    <style type="text/css">
        @import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
        .login-block {
            width: 100%;
            height: auto;
            bottom: 0px !important;
            padding: 10%;
        }
        .banner-sec {
            background: url(https://static.pexels.com/photos/33972/pexels-photo.jpg) no-repeat left bottom;
            background-size: cover;
            min-height: 500px;
            border-radius: 0 10px 10px 0;
            padding: 0;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 15px 20px 0px rgba(0, 0, 0, 0.1);
        }
        .carousel-inner {
            border-radius: 0 10px 10px 0;
        }
        .carousel-caption {
            text-align: left;
            left: 5%;
        }
        .login-sec {
            padding: 50px 30px;
            position: relative;
        }
        .login-sec .copy-text {
            position: absolute;
            width: 80%;
            bottom: 20px;
            font-size: 13px;
            text-align: center;
        }
        .login-sec .copy-text i {
            color: #FEB58A;
        }
        .login-sec .copy-text a {
            color: #E36262;
        }
        .login-sec h2 {
            margin-bottom: 30px;
            font-weight: 800;
            font-size: 30px;
            color: #DE6262;
        }
        .login-sec h2:after {
            content: " ";
            width: 100px;
            height: 5px;
            background: #FEB58A;
            display: block;
            margin-top: 20px;
            border-radius: 3px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-login {
            background: #DE6262;
            color: #fff;
            font-weight: 600;
        }
        .banner-text {
            width: 70%;
            position: absolute;
            bottom: 40px;
            padding-left: 20px;
        }
        .banner-text h2 {
            color: #fff;
            font-weight: 600;
        }
        .banner-text h2:after {
            content: " ";
            width: 100px;
            height: 5px;
            background: #FFF;
            display: block;
            margin-top: 20px;
            border-radius: 3px;
        }
        .banner-text p {
            color: #fff;
        }
    </style>
</head>
<body style="background: #FFB88C;">
    <section class="login-block">
        <img src="../../../images/logo.png" style="height:100px;width: 170px;" />
        <div class="container">
            <div class="row">
                <div class="col-md-4 login-sec">
                    <h2 class="text-center">Designer Login</h2>
                    <form class="login-form" method="post" action="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="text-uppercase">Username</label>
                            <input type="text" name="id" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="" required>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input">
                                <small>Remember Me</small>
                            </label>
                            <input type="submit" name="submit" class="btn btn-login float-right" value="Submit">
                        </div>
                    </form>
                    <div class="copy-text">Created with <i class="fa fa-heart"></i> Bravodent</div>
                </div>
                <div class="col-md-8">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $rr2 = mysqli_query($bd, "SELECT * FROM slider");
                            $f = 0;
                            while ($row2 = mysqli_fetch_assoc($rr2)) {
                                $active = ($f == 0) ? 'active' : '';
                                ?>
                                <div class="carousel-item <?php echo $active; ?>">
                                    <img class="img-fluid" src="../../../admin/<?php echo trim($row2['image']); ?>" alt="Slide">
                                </div>
                                <?php
                                $f++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>