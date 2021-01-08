<?php

require 'config.php';
// Header
require 'header.php';
$db = new Ride();
$Us = new User();
$loc = new LocationTable();
$loc->connect('localhost', 'root', '', 'CabBooking');
$db->connect('localhost', 'root', '', 'CabBooking');
$Us->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->count_pending_ride();
$confirm = $db->count_ride();
$cancelled = $db->count_Cancelled();
$confirm_rides = $db->count_confirm_ride();
$count_user = $Us->count_user();
$count_pending_user = $Us->count_pending_request();
$total_revenue = $db->Total_Revenue();
$blocked = $Us->count_blocked();
$location = $loc->count_location();
?>

<body class="admintop">
    <div class="adminbody" style="height:800px;">
        <img src="../images/slider1.jpg" alt="" style="height:800px;">
        <div id="AdminWelcomeQuote">
            <h1>Welcome &nbsp;<?php if (!empty($username)) {
                                    echo $username;
                                } ?></h1>
        </div>
        <div class="maintiles">
            <div class="tiles"><a href="pending_ride.php">
                    <p><i class="fa fa-car"></i></p>Pending_Rides &nbsp;<span><?php echo $sql ?></span>
                </a>
            </div>
            <div class="tiles"><a href="pending_request.php">
                    <p><i class="fa fa-car"></i></p>Pending User &nbsp;<span><?php echo $count_pending_user ?></span>
                </a>
            </div>
            <div class="tiles"><a href="All_rides.php">
                    <p><i class="fa fa-car"></i></p>Total Rides &nbsp; <span><?php echo $confirm ?></span>
                </a>
            </div>
            <div class="tiles"><a href="manageLocation.php">
                    <p><i class="fa fa-car"></i></p>All location &nbsp; <span><?php echo $location ?></span>
                </a>
            </div>
        </div>
        <div class="maintiles">
            <div class="tiles"><a href="completed_rides.php">
                    <p><i class="fa fa-hourglass-2"></i></p>Confirm_Rides &nbsp;<span><?php echo $confirm_rides ?></span>
                </a>
            </div>
            <div class="tiles"><a href="javascript:void(0)">
                    <?php
                    $sum = 0;
                    foreach ($total_revenue as $key) {
                        $sum += $key['total_fare'];
                    }   ?>
                    <p><i class="fa fa-car"></i></p>Total_Revenue <span>$&nbsp;<?php echo $sum ?></span></a></div>
            <div class="tiles"><a href="javascript:void(0)">
                    <p><i class="fa fa-car"></i></p>Blocked_Users <span><?php echo $blocked ?></span>
                </a>
            </div>
            <div class="tiles"><a href="manageCustomer.php">
                    <p><i class="fa fa-car"></i></p>All_Users <span><?php echo $count_user ?></span>
                </a>
            </div>
        </div>
    </div>        
    <!-- Footer -->
    <?php require 'footer.php' ?>
    <!-- Javascript included -->
    <script src="../script.js"></script>
</body>