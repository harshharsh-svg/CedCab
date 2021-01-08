<?php

require 'config.php';
require 'header.php';
$db = new Ride();
$db->connect('localhost', 'root', '', 'CabBooking');

// Delete the Record From the database
if (isset($_REQUEST['delid'])) {
    $user_id = $_REQUEST['delid'];
    echo "<script>alert('Ride Deleted Successfully')</script>";
    echo $db->delete($user_id);
    header("Refresh:0;url=All_rides.php");
}
?>
<!-- Sorting the data -->
<?php if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ride_id';
}
$sql = $db->All_ride($sort);

?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>All Rides</h1>
            <div class="dropdown sort">
                <button class="dropbtn sortbtn">Sort By</button>
                <div class="dropdown-content sortcontent">
                    <a href="All_rides.php?sort=ASC_date">ASC by Date<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=DESC_date">DESC by Date<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=ASC">ASC by Fare<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=DESC">DESC by Fare<p hidden>A $_GET</p></a>
                </div>
            </div>
            <div class="dropdown sort" style="margin-left:-5px;">
                <button class="dropbtn sortbtn">Filter By</button>
                <div class="dropdown-content sortcontent">
                    <a href="All_rides.php?sort=WEEK">Week<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=MONTH">Month<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=YEAR">Yearly<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=pending">Pending Rides<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=Completed">Completed Rides<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=Cancelled">Cancelled Rides<p hidden>A $_GET</p></a>
                    <a href="All_rides.php?sort=all">Show All<p hidden>A $_GET</p></a>
                </div>
            </div>
        </div>
        <!-- Representing All Ride data in Table Form -->
        <table id="LocationTable" class="ridetable">
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
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td id="td" hidden><?php echo $key['ride_id'] ?></td>
                        <td id="td"><?php echo $key['user_id'] ?></td>
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
                        <td><a onClick="javascript: return confirm('Please confirm deletion');" href="All_rides.php?delid=<?php echo $key['ride_id'] ?>">Delete</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <!-- Footer -->
    <?php require 'footer.php' ?>
    <!-- Javascript -->
    <script src="../script.js"></script>
</body>