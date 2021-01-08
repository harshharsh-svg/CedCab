<?php

session_set_cookie_params(180, "/");
require 'Admin/config.php';
$db = new LocationTable();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->location_getData();
global $distance, $luggageprice, $cab;
$Location = $_REQUEST['Location'];
$Destination = $_REQUEST['Destination'];
$Cab = $_REQUEST['Cab'];
$luggage = $_REQUEST['Luggage'];

if (isset($luggage)) {
    if ($luggage <= 10) {
        $luggageprice = 50;
    } elseif ($luggage > 10 && $luggage <= 20) {
        $luggageprice = 100;
    } elseif ($luggage > 20) {
        $luggageprice = 200;
    } else {
        $luggageprice = 0;
    }
}

foreach ($sql as $key) {
    if ($key['name'] == $Location) {
        $pickup = $key['distance'];
    }
    if ($key['name'] == $Destination) {
        $drop = $key['distance'];
    }
}
$distance = abs($pickup - $drop);

if ($Cab == "1") {
    $cab = "CedMicro";
    $fixedFare = 50;
    $price = 13.50;
    $price1 = (13.50 * 10);
    $price2 = (12 * 50);
    $price3 = (100 * 10.20);
    $price4 = 8.50;
    if ($distance > 0 && $distance <= 10) {
        $totalFare = $fixedFare + ($distance * $price);
    } elseif ($distance > 10 && $distance <= 50) {
        $totaldistance = 12 * ($distance - 10);
        $totalFare = $fixedFare + $totaldistance + $price1;
    } elseif ($distance > 50 && $distance <= 100) {
        $totaldistance = 10.20 * ($distance - 60);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2;
    } elseif ($distance > 100) {
        $totaldistance = $price4 * ($distance - 160);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $price3;
    }
    echo "Total Fare : " ."$". $totalFare;
}
if ($Cab == "2") {
    $cab = "CedMini";
    $fixedFare = 150;
    $price = 14.50;
    $price1 = (14.50 * 10);
    $price2 = (13 * 50);
    $price3 = (100 * 11.20);
    $price4 = 9.50;
    if ($distance > 0 && $distance <= 10) {
        $totalFare = $fixedFare + ($distance * $price) + $luggageprice;
    } elseif ($distance > 10 && $distance <= 50) {
        $totaldistance = 13 * ($distance - 10);
        $totalFare = $fixedFare + $totaldistance + $price1 + $luggageprice;
    } elseif ($distance > 50 && $distance <= 100) {
        $totaldistance = 11.20 * ($distance - 60);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $luggageprice;
    } elseif ($distance > 100) {
        $totaldistance = $price4 * ($distance - 160);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $price3 + $luggageprice;
    }
    echo "Total Fare : " ."$". $totalFare;
}
if ($Cab == "3") {
    $cab = "CedRoyal";
    $fixedFare = 200;
    $price = 15.50;
    $price1 = (15.50 * 10);
    $price2 = (14 * 50);
    $price3 = (100 * 12.20);
    $price4 = 10.50;
    if ($distance > 0 && $distance <= 10) {
        $totalFare = $fixedFare + ($distance * $price) + $luggageprice;
    } elseif ($distance > 10 && $distance <= 50) {
        $totaldistance = 14 * ($distance - 10);
        $totalFare = $fixedFare + $totaldistance + $price1 + $luggageprice;
    } elseif ($distance > 50 && $distance <= 100) {
        $totaldistance = 12.20 * ($distance - 60);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $luggageprice;
    } elseif ($distance > 100) {
        $totaldistance = $price4 * ($distance - 160);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $price3 + $luggageprice;
    }
    echo "Total Fare : " ."$". $totalFare;
}
if ($Cab == "4") {
    $cab = "CedSUV";
    $fixedFare = 250;
    $price = 16.50;
    $price1 = (16.50 * 10);
    $price2 = (15 * 50);
    $price3 = (100 * 13.20);
    $price4 = 11.50;
    if ($distance > 0 && $distance <= 10) {
        $totalFare = $fixedFare + ($distance * $price) + ($luggageprice * 2);
    } elseif ($distance > 10 && $distance <= 50) {
        $totaldistance = 15 * ($distance - 10);
        $totalFare = $fixedFare + $totaldistance + $price1 + ($luggageprice * 2);
    } elseif ($distance > 50 && $distance <= 100) {
        $totaldistance = 13.20 * ($distance - 60);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + ($luggageprice * 2);
    } elseif ($distance > 100) {
        $totaldistance = $price4 * ($distance - 160);
        $totalFare = $fixedFare + $totaldistance + $price1 + $price2 + $price3 + ($luggageprice * 2);
    }
    echo "Total Fare : " ."$". $totalFare;
}
if (!empty($_SESSION['userdata'])) {
    if (isset($_REQUEST['action'])) {
        $db = new DB();
        $user_id = $_SESSION['userdata']['user_id'];
        $status = 1;
        if ($luggage =="") {
            $luggage = 0;
        }
        $db->connect('localhost', 'root', '', 'CabBooking');
        $action = $_REQUEST['action'];
        echo $action;
        if ($action == 1) {
            $field = array('pickup', 'droplocation', 'cabType', 'luggage', 'total_distance', 'total_fare', 'status', 'user_id');
            $values = array($Location, $Destination, $cab, $luggage,  $distance, $totalFare,  $status, $user_id);
            $sql = $db->insert($field, $values, 'rideTable');
        }
    }
} else {
    $status = 1;
    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];
        if (isset($action)) {
            $_SESSION['bookdata'] = array(
                'pickup' => $Location, 'droplocation' => $Destination, 'cabType' => $cab,
                'total_distance' => $distance, 'luggage' => $luggage, 'total_fare' => $totalFare, 'status' => $status,
                'time' => time()
            );
        }
    }
}
