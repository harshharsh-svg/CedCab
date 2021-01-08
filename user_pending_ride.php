<?php


require 'Admin/config.php';
require 'userheader.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');

if (isset($_REQUEST['canid'])) {
    $ride_id = $_REQUEST['canid'];
    echo $db->cancelled($ride_id);
    echo "<script>alert('Ride cancelled SuccessFully')</script>";
    header("Refresh:0;url=user_pending_ride.php");
}

$sql = $db->pending($user);

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = `ride_date`;
}
$status=1;
$sql = $db->completed_order($user, $sort, $status)
?>

<body class="admintop">
    <div class="adminbody">
        <img src="images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Pending Rides</h1>
        </div>
        <div class="dropdown sort">
            <button class="dropbtn sortbtn">Sort By</button>
            <div class="dropdown-content sortcontent">
                <a href="user_pending_ride.php?sort=ASC_date">ASC by date<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=DESC_date">DESC by date<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
            </div>
        </div>
        <div class="dropdown sort" style="margin-left:2px;">
            <button class="dropbtn sortbtn">Filter By</button>
            <div class="dropdown-content sortcontent">
                <a href="user_pending_ride.php?sort=WEEK">WEEK<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=MONTH">Monthly<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                <a href="user_pending_ride.php?sort=all">Show All<p hidden>A $_GET</p></a>
            </div>
        </div>
        <table id="LocationTable" class="ridetable">
            <tr>
                <th>Ride Id</th>
                <th>PickUp Location</th>
                <th>Drop Location</th>
                <th>Total Distance(Km)</th>
                <th>Luggage</th>
                <th>Ride Date</th>
                <th>Cab Type</th>
                <th>Total_fare $</th>
                <th>Status</th>
                <th>Action</th>
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
                        <td id="td"><?php if ($key['status'] == '1') {
                                        echo "pending";
                                    } ?></td>
                        <td id="td"><a onClick="javascript: return confirm('Please confirm Cancellation');" href="user_pending_ride.php?canid=<?php echo $key['ride_id'] ?>">Cancelled</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'Admin/footer.php' ?>
    <script src="../script.js"></script>
</body>