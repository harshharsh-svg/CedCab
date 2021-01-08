<?php

require 'Admin/config.php';
require 'userheader.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ride_date';
}

$sql = $db->filter_user($user, $sort);
?>
<body class="admintop">
    <div class="adminbody">
        <img src="images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>All Rides</h1>
            <div class="dropdown sort">
                <button class="dropbtn sortbtn">Sort By</button>
                <div class="dropdown-content sortcontent">
                    <a href="user_rides.php?sort=ASC_date">ASC by date<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=DESC_date">DESC by date<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=all">Show All<p hidden>A $_GET</p></a>
                </div>
            </div>
            <div class="dropdown sort" style="margin-left:-5px;">
                <button class="dropbtn sortbtn">Filter By</button>
                <div class="dropdown-content sortcontent">
                    <a href="user_rides.php?sort=WEEK">WEEK<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=MONTH">Monthly<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=pending">Pending Rides<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=Completed">Completed Rides<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=Cancelled">Cancelled Rides<p hidden>A $_GET</p></a>
                    <a href="user_rides.php?sort=all">Show All<p hidden>A $_GET</p></a>
                </div>
            </div>
        </div>
        <table id="LocationTable" class="ridetable">
            <tr>
                <th>Ride Id</th>
                <th>PickUp Location</th>
                <th>Drop Location</th>
                <th>Total Distance</th>
                <th>Luggage</th>
                <th>Ride Date</th>
                <th>Cab Type</th>
                <th>Total_fare</th>
                <th>Status</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td id="td"><?php echo $key['ride_id'] ?></td>
                        <td id="td"><?php echo $key['pickup'] ?></td>
                        <td id="td"><?php echo $key['droplocation'] ?></td>
                        <td id="td"><?php echo $key['total_distance'] ?>&nbsp;Km</td>
                        <td id="td"><?php echo $key['luggage'] ?>&nbsp;Kg</td>
                        <td id="td"><?php echo $key['ride_date'] ?></td>
                        <td id="td"><?php echo $key['cabType'] ?></td>
                        <td id="td">$ &nbsp;<?php echo $key['total_fare'] ?></td>
                        <td id="td"><?php if ($key['status'] == '2') {
                                        echo "completed";
                                    } elseif ($key['status'] == '1') {
                                        echo "pending";
                                    } else {
                                        echo "cancelled";
                                    } ?></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'Admin/footer.php' ?>
    <script src="../script.js"></script>
</body>