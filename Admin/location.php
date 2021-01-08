<?php

require 'config.php';
require 'header.php';
$loct = new LocationTable();
$loct->connect('localhost', 'root', '', 'CabBooking');
$error = array();
if (isset($_POST["submit"])) {
    $location = $_POST['location'];
    $distance = $_POST['distance'];
    if (sizeof($error) == 0) {
        if ((preg_match('/^[a-zA-Z]+[a-zA-Z0-9- _]+$/', $location)) && (preg_match("/^[0-9]+$/", $distance))) {

            $loct->checklocation($location, $distance);
        }
    }
}
?>

<body class="admintop">
    <div class="adminbody" style="position:absolute; width:100%">
        <img src="../images/slider1.jpg" alt="">

        <p class="location-logo">Add Locations</p>
        <div id="admin-location-form">
            <form action="" method="POST">
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
                    <label for="username">Location:
                        <input type="text" name="location" required></label>
                </p>
                <p class="input">
                    <label for="text">Distance:
                        <input type="text" name="distance" required></label>
                </p>
                <p class="submit">
                    <input type="submit" name="submit" value="ADD">
                </p>
            </form>
        </div>
        </form>
    </div>
</body>