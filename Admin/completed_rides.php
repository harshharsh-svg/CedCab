<?php

require 'config.php';
require 'header.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->completed_ride();

if (isset($_REQUEST['delid'])) {
    $user_id = $_REQUEST['delid'];
    echo $db->delete($user_id);
    echo "<script>alert('Ride Deleted Successfully')</script>";
    header("Refresh:0;url=completed_rides.php");
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}
$status=2;
$sql = $db->completed_admin_order($sort, $status);
?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Completed Rides</h1>
        </div>
        <div class="dropdown sort">
            <button class="dropbtn sortbtn">Sort By</button>
            <div class="dropdown-content sortcontent">
                <a href="completed_rides.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=ASC_date">ASC by Date<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=DESC_date">DESC by Date<p hidden>A $_GET</p></a>
            </div>
        </div>
        <div class="dropdown sort" style="margin-left:-5px;">
            <button class="dropbtn sortbtn">Filter By</button>
            <div class="dropdown-content sortcontent">
                <a href="completed_rides.php?sort=WEEK">WEEK<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=MONTH">Monthly<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                <a href="completed_rides.php?sort=all">Show All<p hidden>A $_GET</p></a>
            </div>
        </div>
        <table id="LocationTable" class="ridetable" style="margin-left:-2%;">
            <tr>
                <th>ID</th>
                <th>PickUp Location</th>
                <th>Drop Location</th>
                <th>Total Distance(Km)</th>
                <th>Luggage</th>
                <th>Ride Date</th>
                <th>Cab Type</th>
                <th>Total_fare</th>
                <th>User Id</th>
                <th>Status</th>
                <th>Invoice</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td id="td"><?php echo $key['user_id'] ?></td>
                        <td id="td" hidden><?php echo $key['ride_id'] ?></td>
                        <td id="td"><?php echo $key['pickup'] ?></td>
                        <td id="td"><?php echo $key['droplocation'] ?></td>
                        <td id="td"><?php echo $key['total_distance'] ?>&nbsp;Km</td>
                        <td id="td"><?php echo $key['luggage'] ?>&nbsp;Kg</td>
                        <td id="td"><?php echo $key['ride_date'] ?></td>
                        <td id="td"><?php echo $key['cabType'] ?></td>
                        <td id="td">$ &nbsp;<?php echo $key['total_fare'] ?></td>
                        <td id="td"><?php if ($key['status'] == '2') {
                                        echo "completed";
                                    } ?></td>
                        <td><a href="invoice.php?ride_id=<?php echo $key['ride_id'] ?>&amp;user_id=<?php echo $key['user_id'] ?>">Invoice</a></td>
                        <td><a  onClick="javascript: return confirm('Please confirm deletion');" href="completed_rides.php?delid=<?php echo $key['ride_id'] ?>">Delete</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'footer.php' ?>
    <script src="../script.js"></script>
</body>