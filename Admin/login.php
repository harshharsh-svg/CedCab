<?php

require 'config.php';
if (isset($_SESSION['userdata']['is_admin'])) {
    if ($_SESSION['userdata']['is_admin'] == 'admin') {
        header('Location:Admindashboard.php');
    } elseif ($_SESSION['userdata']['is_admin'] == 'user') {
        header('Location:../userdashboard.php');
    }
}
$user = new User();
$user->connect('localhost', 'root', '', 'CabBooking');
$msg = "";
$error = array();
if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $user->login($username, $password);
    if (isset($_POST['rememberme'])) {
        setcookie('username', $_POST['username'],  time() + (86400 * 30), "/");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        Login
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
    <div id="wrapper" style="height:600px;">
        <div id="login-form">
            <form action="" method="POST">
                <div class="loginlogo"><span>Login</span></div>
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
                <p class="input">
                    <label for="username">Username:
                        <input type="text" name="username" value="<?php if (isset($_COOKIE['username'])) {
                                                                        echo $_COOKIE['username'];
                                                                    } ?>" required></label>
                </p>
                <p class="input">
                    <label for="password">Password:
                        <input type="password" name="password" required></label>
                </p>
                
                <p class="submit">
                    <input type="submit" name="submit" value="Login">
                </p>
              <a href="signup.php" style="font-size:20px;">Sign Up</a>
            </form>
        </div>
    </div>
    <?php require 'footer.php' ?>
</body>

</html>