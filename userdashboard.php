<?php


require 'Admin/config.php';
require 'userheader.php';
$db = new Ride();
$ddb = new DB();
$db->connect('localhost', 'root', '', 'CabBooking');
$ddb->connect('localhost', 'root', '', 'CabBooking');

if (isset($_SESSION['bookdata'])) {
    $user_id = $_SESSION['userdata']['user_id'];
    $Location = $_SESSION['bookdata']['pickup'];
    $luggage = $_SESSION['bookdata']['luggage'];
    if ($luggage == "") {
        $luggage = 0;
    }
    $Destination = $_SESSION['bookdata']['droplocation'];
    $cab = $_SESSION['bookdata']['cabType'];
    $distance = $_SESSION['bookdata']['total_distance'];
    $totalFare = $_SESSION['bookdata']['total_fare'];
    $status = $_SESSION['bookdata']['status'];

    $field = array('pickup', 'droplocation', 'luggage', 'cabType', 'total_distance', 'total_fare', 'status', 'user_id');
    $values = array($Location, $Destination, $luggage, $cab, $distance, $totalFare,  $status, $user_id);
    $sql = $ddb->insert($field, $values, 'rideTable');
    echo "<script>alert('Your Ride Is Pending Wait For confirmation');
    window.location.href='user_pending_ride.php';</script>";
}
$sql = $db->user_completed_ride($user);
$pending_ride = $db->user_pending_ride($user);
$expense = $db->user_revenue($user);
$sql1 = $db->user_cancelled_ride($user);
$sql2 = $db->user_ride($user);
?>

<body class="admintop">
    <div class="adminbody" style="height:600px;">
        <img src="images/slider1.jpg" alt="" style="height:600px;">
        <div id="AdminWelcomeQuote">
            <h1>Welcome &nbsp;<?php if (!empty($username)) {
                                    echo $username;
                                } ?></h1>
        </div>
        <div class="maintiles">
            <div class="tiles"><a href="user_pending_ride.php">
                    <p><i class="fa fa-bar-chart"></i></p>Pending_Rides <span><?php echo $pending_ride ?></span>
                </a>
            </div>
            <div class="tiles"><a href="completed_rides.php">
                    <p><i class="fa fa-group"></i></p>Completed_Rides <span><?php echo $sql ?></span>
                </a>
            </div>
            <?php
            if (isset($expense)) {
                $sum = 0;
                foreach ($expense as $key) {
                    $sum += $key['total_fare'];
                } ?>
                <div class="tiles"><a href="completed_rides.php">
                        <p><i class="fa fa-handshake-o"></i></p>Total_Expense $ &nbsp;<span><?php echo $sum ?></span>
                    </a>
                </div>
            <?php } else { ?>
                <div class="tiles"><a href="completed_rides.php">
                        <p><i class="fa fa-handshake-o"></i></p>Total_Expense <span>0 $</span>
                    </a>
                </div> <?php } ?>
            <div class="tiles"><a href="user_rides.php">
                    <p><i class="fa fa-group"></i></p>All_Rides <span><?php echo $sql2 ?></span>
                </a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Completed Rides', <?php echo $sql ?>],
                ['Cancelled Rides', <?php echo $sql1 ?>],
                ['Pending Rides', <?php echo $pending_ride ?>]
            ]);

            // Optional; add a title and set the width and height of the chart
            var options = {
                'title': 'Graphical Representation of data',
                'width': 1350,
                'height': 400
            };

            // Display the chart inside the <div> element with id="piechart"
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <div id="piechart"></div>
    <?php require 'Admin/footer.php' ?>
</body>