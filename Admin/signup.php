<?php
error_reporting(E_ERROR);

require 'config.php';
$con = new DB();
$con->connect('localhost', 'root', '', 'CabBooking');
$msg = '';
$error = array();
$headers = "";
if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = md5($_POST['password']);
    $repassword = md5($_POST['repassword']);
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $activationcode = md5($email . time());

    if (!empty($mobile)) // phone number is not empty
    {
        if (preg_match('/^\d{10}$/', $mobile)) // phone number is valid
        {
            $mobile = $mobile;
        } else {
            echo "<script>alert('Enter valid Mobile Number')</script>";
            $error = array('input' => 'password', 'msg' => 'Enter Valid Mobile Number');
        }
    }
    
    if ($password != $repassword) {
        $error = array('input' => 'password', 'msg' => 'password doesnt match');
    }
    $err = $con->checkinsert($username, $email, $mobile);
    if ($err == 0) {
        if (sizeof($error) == 0) {
            $fields = array('username', 'name', 'mobile', 'password', 'email');
            $values = array($username, $name, $mobile, $password, $email);

            $res = $con->insert($fields, $values, 'userTable');

            if ($res) {
                echo "<script>alert('SignUp Successfully wait for the response by Admin')</script>";
                $error = array('input' => 'form', 'msg' => "1 Row inserted");
                header('refresh:0; url=login.php');
            }
        }
    }
}
?>
<html>

<head>
    <title>
        Register
    </title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<header style="margin-top:-2%;">
    <ul id="headernav">
        
        <li><a href="Admindashboard.php">CEDCABB</a></li>
    </ul>
</header>
<div class="main">
    <ul id="nav">
        <li class="dropdown">
            <a href="../index.php" class="dropbtn">Book Ride</a>
        </li>
    </ul>
</div>

<body class="body" style="margin:0;">
    <div id="errordiv">
        <?php if (sizeof($error) > 0) : ?>
            <ul>
                <?php foreach ($error as $value) : ?>
                    <li><?php echo $error['msg'];
                        break ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <div id="wrapper" style="height:600px;">
        <div id="signup-form">
            <form action="" method="POST">
                <div class="loginlogo"><span>Sign Up</span></div>
                <p class="input">
                    <label for="username">Username:
                        <input type="text" name="username" required>
                    </label>
                </p>
                <p class="input">
                    <label for="username">Name:
                        <input type="text" name="name"  required>
                    </label>
                </p>
                <p class="input">
                    <label for="password">Password:
                        <input type="password" name="password" required>
                    </label>
                </p>
                <p class="input">
                    <label for="repassword">Re-Password:
                        <input type="password" name="repassword" required>
                    </label>
                </p>
                <p class="input">
                    <label for="mobile">Mobile:
                        <input type="text" name="mobile" pattern="[789][0-9]{9}" required>
                    </label>
                </p>
                <p class="input">
                    <label for="email">Email:
                        <input type="email" name="email" required>
                    </label>
                </p>
                <p class="submit">
                    <input type="submit" name="submit" value="Submit">
                </p>
                <p class="bottom">
                    <a href="login.php" style="margin-left:70px;">Click Here To Login</a>
                    <!-- <a href="index.php" style="margin-left:70px;">Book Ride Now</a> -->
                </p>
            </form>
        </div>
    </div>
    <?php require 'footer.php' ?>
</body>

</html>