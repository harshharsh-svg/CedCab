<?php

require 'config.php';
require 'header.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->pending_ride();

if (isset($_GET['Confirm_id'])) {
    $ride_id = $_GET['Confirm_id'];
    echo $db->confirm($ride_id);
    header("Refresh:0;url=pending_ride.php");
}
if (isset($_REQUEST['canid'])) {
    $ride_id = $_REQUEST['canid'];
    echo $db->cancelled($ride_id);
    header("Refresh:0;url=pending_ride.php");
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = `ride_date`;
}
$status=1;
$sql = $db->completed_admin_order($sort, $status);
?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Pending Rides</h1>
        </div>
        <div class="dropdown sort">
            <button class="dropbtn sortbtn">Sort By</button>
            <div class="dropdown-content sortcontent">
            <a href="pending_ride.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=ASC_date">ASC by Date<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=DESC_date">DESC by Date<p hidden>A $_GET</p></a>
            </div>
        </div>
        <div class="dropdown sort" style="margin-left:-5px;">
            <button class="dropbtn sortbtn">Filter By</button>
            <div class="dropdown-content sortcontent">
                <a href="pending_ride.php?sort=WEEK">WEEK<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=MONTH">Monthly<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                <a href="pending_ride.php?sort=all">Show All<p hidden>A $_GET</p></a>
            </div>
        </div>
        <table id="LocationTable" class="ridetable" style="margin-left:-2%;">
            <tr>
                <th>User ID</th>
                <th>PickUp Location</th>
                <th>Drop Location</th>
                <th>Total Distance(Km)</th>
                <th>Ride Date</th>
                <th>Cab Type</th>
                <th>Total_fare  $</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td id="td" hidden><?php echo $key['ride_id'] ?></td>
                        <td id="td"><?php echo $key['user_id'] ?></td>
                        <td id="td"><?php echo $key['pickup'] ?></td>
                        <td id="td"><?php echo $key['droplocation'] ?></td>
                        <td id="td"><?php echo $key['total_distance'] ?>&nbsp;Km</td>
                        <td id="td"><?php echo $key['ride_date'] ?></td>
                        <td id="td"><?php echo $key['cabType'] ?></td>
                        <td id="td">$ &nbsp;<?php echo $key['total_fare'] ?></td>
                        <td id="td"><?php if ($key['status'] == '1') {
                                        echo "pending";
                                    } ?></td>
                        <td><a id="blocked" href="pending_ride.php?<?php if ($key['status'] == '1') {
                                                                        echo "Confirm";
                                                                    }
                                                                    ?>_id=<?php echo $key['ride_id'] ?>">
                                <?php if ($key['status'] == '1') {
                                    echo "Confirm";
                                }
                                ?><p hidden>A $_GET</p>
                            </a>

                            <a onClick="javascript: return confirm('Please confirm Cancellation');" href="pending_ride.php?canid=<?php echo $key['ride_id'] ?>">Cancelled</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'footer.php' ?>
    <script src="../script.js"></script>
</body>