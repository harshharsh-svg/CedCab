<?php

require 'Admin/config.php';
require 'userheader.php';
$conn = new User();
$error = array();
$conn->connect('localhost', 'root', '', 'CabBooking');
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');

$sql = $conn->current_user($user);
$expense = $db->user_revenue($user);

if (isset($_REQUEST['update'])) {
    $user_id = $_REQUEST['user_id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];

    if (!empty($mobile)) // phone number is not empty
    {
        if (!preg_match('/^\d{10}$/', $mobile)) // phone number is valid
        {
            echo "<script>alert('Enter valid Mobile Number')</script>";
            $error = array('input' => 'password', 'msg' => 'Enter Valid Mobile Number');
        }
    }
    // Name number is not empty
    if (!empty($name)) {
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            echo "<script>alert('Enter valid name ')</script>";
            $error = array('input' => 'password', 'msg' => 'Enter Valid Username');
        }
    }
    if (sizeof($error) == 0) {

        $sql = $conn->setuser($user_id, $name, $mobile);
        if ($sql) {
            header("Location:user_account.php");
        }
    }
}
?>

<body class="admintop">
    <div class="adminbody">
        <img src="images/slider1.jpg" alt="">
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
        <div id="AdminWelcomeQuote">
            <h1>User Details</h1>
        </div>
        <div class="table1">
            <?php foreach ($sql as $key) { ?>
                <form action="" method="post" class="formid">
                    <p>
                        <label for="">UserName :</label> <?php echo $key['username']; ?>
                    </p>
                    <p>
                        <label for="">Name :</label> <?php echo $key['name']; ?>
                    </p>
                    <p>
                        <label for="">Mobile :</label><?php echo $key['mobile']; ?>
                    </p>
                    <p>
                        <label for="">Email:</label><?php echo $key['email']; ?>
                    </p>
                    <p>
                        <label for="">Date Of Joining:</label><?php echo $key['date']; ?>
                    </p>
                    <p>
                        <input type="button" class="btn1" name="update" value="Edit" id="edit" class="editbtn" />
                    </p>
                </form>
            <?php } ?>
        </div>

        <div class="table2">
            <?php foreach ($sql as $key) { ?>
                <form action="" method="post" class="formid">
                    <p>
                        <input type="hidden" name="user_id" value="<?php echo $key['user_id'] ?>" />
                    </p>
                    <p>
                        <label for="">UserName :</label>&nbsp;<?php echo $key['username'] ?>
                    </p>
                    <p>
                        <label for="">Name :</label>
                        <input type="text" name="name" value="<?php echo $key['name'] ?>" />
                    </p>
                    <p>
                        <label for="">Mobile(10-Digits) :</label>
                        <input type="text" name="mobile" value="<?php echo $key['mobile'] ?>" />
                    </p>
                    <p>
                        <label for="">Email:</label><?php echo $key['email'] ?>
                    </p>
                    <p>
                        <input type="submit" class="btn1" name="update" value="Update" id="update" />
                    </p>
                </form>
            <?php } ?>
        </div>
    </div>
    <?php require 'Admin/footer.php' ?>
    <script src="script.js"></script>
</body>