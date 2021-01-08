<?php

require 'config.php';
require 'header.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->cancelled_ride();

if (isset($_REQUEST['delid'])) {
    $user_id = $_REQUEST['delid'];
    echo $db->delete($user_id);
    echo "<script>alert('Ride Deleted Successfully')</script>";
    header("Refresh:0;url=cancelled_rides.php");
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}
$status= 0;
$sql = $db->completed_admin_order($sort, $status);
?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Cancelled Rides</h1>
        </div>
        <div class="dropdown sort">
            <button class="dropbtn sortbtn">Sort By</button>
            <div class="dropdown-content sortcontent">
                <a href="cancelled_rides.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=ASC_date">ASC by Date<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=DESC_date">DESC by Date<p hidden>A $_GET</p></a>
            </div>
        </div>
        <div class="dropdown sort" style="margin-left:-5px;">
            <button class="dropbtn sortbtn">Filter By</button>
            <div class="dropdown-content sortcontent">
                <a href="cancelled_rides.php?sort=WEEK">WEEK<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=MONTH">Monthly<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                <a href="cancelled_rides.php?sort=all">Show All<p hidden>A $_GET</p></a>
            </div>
        </div>
        <table id="LocationTable" class="ridetable">
            <tr>
                <th>ID</th>
                <th>PickUp Location</th>
                <th>Drop Location</th>
                <th>Luggage</th>
                <th>Total Distance(Km)</th>
                <th>Ride Date</th>
                <th>Cab Type</th>
                <th>Total_fare $</th>
                <th>User Id</th>
                <th>Status</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td id="td" hidden><?php echo $key['ride_id'] ?></td>
                        <td id="td"><?php echo $key['user_id'] ?></td>
                        <td id="td"><?php echo $key['pickup'] ?></td>
                        <td id="td"><?php echo $key['droplocation'] ?></td>
                        <td id="td"><?php echo $key['luggage'] ?>&nbsp;Kg</td>
                        <td id="td"><?php echo $key['total_distance'] ?>&nbsp;Km</td>
                        <td id="td"><?php echo $key['ride_date'] ?></td>
                        <td id="td"><?php echo $key['cabType'] ?></td>
                        <td id="td">$ &nbsp;<?php echo $key['total_fare'] ?></td>
                        <td id="td"><?php if ($key['status'] == '0') {
                                        echo "Cancelled Rides";
                                    } ?></td>
                        <td><a  onClick="javascript: return confirm('Please confirm deletion');" href="cancelled_rides.php?delid=<?php echo $key['ride_id'] ?>">Delete</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'footer.php' ?>
    <script src="../script.js"></script>
</body>