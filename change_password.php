<?php


require 'Admin/config.php';
require 'userheader.php';
$conn = new User();
$conn->connect('localhost', 'root', '', 'CabBooking');

if (isset($_POST['update'])) {
    $new = md5($_POST['newpassword']);
    $confirm = md5($_POST['confirmpassword']);
    if ($new == $confirm) {
        $sql = $conn->changepassword($new, $user);
        if ($sql) {
            unset($_SESSION['userdata']);
            echo "<script>
            alert('Password Changed Successfully');
            window.location.href='Admin/login.php';
            </script>";
        } else {
            echo "<script>alert('password doesnt match')</script>";
        }
    }
}
?>

<body class="admintop">
    <div class="adminbody">
        <img src="images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Change Password</h1>
        </div>
        <div class="table1">
            <form action="" method="post" class="bookid">
                <p>
                    <label for="">New Password :</label>
                    <input type="password" name="newpassword" placeholder="Enter the password" />
                </p>
                <p>
                    <label for="">Confirm Password :</label>
                    <input type="password" name="confirmpassword" placeholder="Confirm password" />
                </p>
                <p>
                    <input type="submit" class="btn1" name="update" value="Update" id="update" />
                </p>
            </form>
        </div>
    </div>
    <?php require 'Admin/footer.php' ?>