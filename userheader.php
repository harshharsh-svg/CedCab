<?php
error_reporting(E_ERROR);

if (isset($_SESSION['userdata']) && ($_SESSION['userdata']['is_admin'] == 'user')) {
    $username = $_SESSION['userdata']['username'];
    $user = $_SESSION['userdata']['user_id'];
} else {
    echo "<script>
    alert('Permission Denied');
    window.location.href='Admin/login.php';
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Document</title>
</head>
<header id="userheader">
    <ul id="headernav">
      
        <li><a href="userdashboard.php">CEDCABB</a></li>
    </ul>
</header>
<div class="main">
    <ul id="nav">
        <li class="dropdown">
            <a href="userdashboard.php" class="dropbtn">UserDashboard</a>
        <li class="dropdown">
            <a href="index.php" class="dropbtn">Book Ride</a>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Ride</a>
            <div class="dropdown-content">
                <a href="user_pending_ride.php">Pending Rides</a>
                <a href="completed_rides.php">Completed Rides</a>
                <a href="user_rides.php">All Ride</a>
            </div>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">User Account</a>
            <div class="dropdown-content">
                <a href="user_account.php">View Details</a>
                <a href="change_password.php">Change Password</a>
        <li class="dropdown">
            <a href="Admin/logout.php">Logout</a>
</div>
</li>
</ul>
</div>