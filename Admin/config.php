<?php

session_start();
//DB database
class DB
{
    //connect to the database 
    public function connect($host, $user, $pass, $dtb)
    {
        $this->serverame = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->dbname   = $dtb;

        return $this->conn = mysqli_connect($host, $user, $pass, $dtb) or die('Could Not Connect.');
    }
    //Inserting Data into the database
    public function insert($fields, $data, $table)
    {
        try {
            $queryFields = implode(",", $fields);

            $queryValues = implode('","', $data);

            $insert = 'INSERT INTO ' . $table . '(' . $queryFields . ') VALUES ("' . $queryValues . '")';

            if (mysqli_query($this->conn, $insert)) {
                unset($_SESSION['bookdata']);
                return true;
            } else {
                die(mysqli_error($this->conn));
            }
        } catch (Exception $ex) {
            echo "Some Exception Occured " . $ex;
        }
    }
    public function checkinsert($username, $email, $mobile)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `username`='$username' ");
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('UserName Already Present')</script>";
            return $result->num_rows;
        }
        $result1 = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `email`='$email' ");
        if (mysqli_num_rows($result1) > 0) {
            echo "<script>alert('Email Already Present')</script>";
            return $result1->num_rows;
        }
        $result2 = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `mobile`='$mobile' ");
        if (mysqli_num_rows($result2) > 0) {
            echo "<script>alert('Mobile Already Present')</script>";
            return $result2->num_rows;
        }
    }
}
//User class
class User extends DB
{
    //login function
    public function login($username, $password)
    {
        $is_block = 1;
        $sql = 'SELECT * FROM userTable WHERE 
        `username`="' . $username . '" AND 
        `password`="' . $password . '" AND is_block="' . $is_block . '"';
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['is_admin'] == 'admin') {
                    $rtn = "Login Success";
                    $_SESSION["userdata"] = array('username' => $row['username'], 'user_id' => $row['user_id'], 'is_admin' => $row['is_admin']);
                    header("Refresh:0; url=Admindashboard.php");
                } elseif ($row['is_admin'] == 'user') {
                    //unset session['bookdata] after 3min
                    if ((time() - $_SESSION['bookdata']['time']) > 180) {
                        unset($_SESSION['bookdata']);
                        header("location: ../userdashboard.php");
                    }
                    $rtn = "Login Success";
                    $_SESSION["userdata"] = array('username' => $row['username'], 'user_id' => $row['user_id'], 'is_admin' => $row['is_admin']);
                    header("Refresh:0; url=../userdashboard.php");
                } else {
                    $rtn = "Login Failed";
                    unset($_SESSION['bookdata']);
                }
                return $rtn;
            }
        }
    }
    // Signup Request of users
    public function signup_request()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_block`= '0' AND `is_admin`!='admin'");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Approved User Function
    public function approved($user_id)
    {
        $result = mysqli_query($this->conn, "UPDATE userTable SET `is_block`='1' WHERE `user_id`='" . $user_id . "'");
        return "SuccessFully Approved";
    }
    //showing Approved User from the database
    public function show_approved()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_block`='1' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Deleteing the user's from the database
    public function reject($user_id)
    {
        $result = mysqli_query($this->conn, "DELETE FROM userTable  WHERE `user_id`='" . $user_id . "'");
        return "Rejected SuccessFully";
    }
    //Unblocking the User for login
    public function blocked($user_id)
    {
        $result = mysqli_query($this->conn, "UPDATE userTable SET `is_block`='1' WHERE `user_id`='" . $user_id . "'");
        return "Blocked SuccessFully";
    }
    //Blocking the user's
    public function unblocked($user_id)
    {
        $result = mysqli_query($this->conn, "UPDATE userTable SET `is_block`='0' WHERE `user_id`='" . $user_id . "'");
        return "UnBlocked SuccessFully";
    }
    //Getting Sorted data from the Usertable according to the sort requirement
    public function getData($sort)
    {
        if ($sort == 'ASC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' ORDER BY `date` ASC ");
        } elseif ($sort == 'DESC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' ORDER BY `date` DESC ");
        } elseif ($sort == 'ASC' || $sort == 'DESC') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' ORDER BY `user_id` $sort");
        } elseif ($sort == 'blocked') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' AND `is_block`='0' ");
        } elseif ($sort == 'unblocked') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' AND `is_block`='1' ");
        } elseif ($sort == 'all') {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin'");
        } else {
            $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin'");
        }
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Counting total User who is not admin
    public function count_user()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_admin`!='admin' ");
        return $result->num_rows;
    }
    //Getting data of pending User's
    public function count_pending_request()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_block`= '0' AND `is_admin`!='admin'");
        return $result->num_rows;
    }
    //Getting total blocked user count from the usertable database
    public function count_blocked()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `is_block`='0'");
        return $result->num_rows;
    }
    //Checking User
    public function current_user($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM userTable WHERE `user_id`='$user_id' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Updating the user's detail's in the database
    public function setuser($user_id, $name, $mobile)
    {
        $result = mysqli_query($this->conn, "UPDATE userTable SET `name`='$name', `mobile`='$mobile' WHERE `user_id`='" . $user_id . "'");
        return "Updated SuccessFully";
    }
   
   
}

//LocationTable Database
class LocationTable extends DB
{
    //Getting All Location data from the database
    public function location_getData()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM LocationTable ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Updating Location details in the database
    public function setLocation($user_id, $locname, $distance, $avail)
    {
        $sql = mysqli_query($this->conn, "SELECT * FROM LocationTable WHERE `name`='$locname' AND `is_available`='$avail' ");
        if (mysqli_num_rows($sql) > 0) {
            echo "<script>alert('Location Already Available')</script>";
        } else {
            $result = mysqli_query($this->conn, "UPDATE LocationTable SET `name`='$locname',`distance`='$distance',`is_available`='$avail' WHERE `id`='" . $user_id . "'");
            echo "<script>alert('Location Updated SuccessFully')</script>";
            if (mysqli_num_rows($result) > 0) {
                return $result;
            }
        }
    }
    //Counting total location available 
    public function count_location()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM LocationTable");
        return $result->num_rows;
    }
    //Deleting the Locationtable data
    public function deleteloc($id)
    {
        $result = mysqli_query($this->conn, "DELETE FROM LocationTable  WHERE `id`='" . $id . "' ");
        return "Deleted SuccessFully";
    }

    //checklocation 
    public function checklocation($location, $distance)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM LocationTable WHERE `name`='" . $location . "' ");
        if (mysqli_num_rows($result) == 1) {
            echo "<script>alert('Location Already Present')</script>";
        } else {
            $result = mysqli_query($this->conn, "INSERT INTO LocationTable(`name`, `distance`)VALUES('$location', '$distance')");
        }
    }
}
//Ride class
class Ride extends DB
{
    //Ride Pending 
    public function pending_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '1'");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Completed Ride from the Ride database
    public function completed_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2'");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //All ride including completed,pending,cancelled
    public function All_ride($order)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable ORDER BY $order");
        if ($order == 'WEEK' || $order == 'YEAR' || $order == 'MONTH') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `ride_date`> DATE_SUB(curdate(),INTERVAL 1 $order) ");
        } elseif ($order == 'ASC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable ORDER BY `ride_date` ASC ");
        } elseif ($order == 'DESC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable ORDER BY `ride_date` DESC ");
        } elseif ($order == 'ASC' || $order == 'DESC') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable ORDER BY `total_Fare` $order");
        } elseif ($order == 'pending') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`='1' ");
        } elseif ($order == 'Completed') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`='2' ");
        } elseif ($order == 'Cancelled') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`='0' ");
        } elseif ($order == 'all') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable");
        }
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }

    //Cancelled Ride
    public function cancelled_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '0'");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Count total Ride
    public function count_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable");
        return $result->num_rows;
    }
    ///count pending_ride
    public function count_pending_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '1'");
        return $result->num_rows;
    }
    //Confirm Ride
    public function confirm($ride_id)
    {
        $result = mysqli_query($this->conn, "UPDATE rideTable SET `status`='2' WHERE `ride_id`='" . $ride_id . "'");
        return "Confirm SuccessFully";
    }
    //Counting total confirm password
    public function count_confirm_ride()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2'");
        return $result->num_rows;
    }
    //Cancelled Ride
    public function cancelled($ride_id)
    {
        $result = mysqli_query($this->conn, "UPDATE rideTable SET `status`='0' WHERE `ride_id`='" . $ride_id . "'");
        return "Cancelled Approved";
    }
    //Count Cancelled Ride
    public function count_Cancelled()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`='0' ");
        return mysqli_num_rows($result);
    }
    //Total Revenue
    public function Total_Revenue()
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2'");
        if (mysqli_num_rows($result)) {
            return $result;
        }
    }
    //Blocked Ride
    public function blocked_Ride($user_id)
    {
        $result = mysqli_query($this->conn, "UPDATE LocationTable SET `is_block`='1' WHERE `id`='" . $user_id . "'");
        return "Blocked SuccessFully";
    }
    //Unblocked Ride
    public function unblocked_Ride($user_id)
    {
        $result = mysqli_query($this->conn, "UPDATE LocationTable SET `is_block`='0' WHERE `id`='" . $user_id . "'");
        return "UnBlocked SuccessFully";
    }
    //Completed User Ride
    public function user_completed_ride($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2' AND `user_id`='$user_id '");
        return $result->num_rows;
    }
    //User Pending Ride
    public function user_pending_ride($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '1' AND `user_id`='$user_id' ");
        return $result->num_rows;
    }
    //User Total Revenue
    public function user_revenue($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2' AND `user_id`='$user_id' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    public function user_revenu($user_id, $ride_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2' AND `user_id`='$user_id' AND `ride_id`='$ride_id' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Total Completed Ride
    public function complete_ride($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '2' AND `user_id`='$user_id '");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //User Ride Pending 
    public function pending($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`= '1' AND `user_id`='$user_id' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }

    public function completed_order($user, $sort, $status)
    {
        if ($sort == 'WEEK' || $sort == 'MONTH') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status AND `ride_date`> DATE_SUB(curdate(),INTERVAL 1 $sort) ");
        } elseif ($sort == 'ASC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status ORDER BY `ride_date` ASC ");
        } elseif ($sort == 'DESC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status ORDER BY `ride_date` DESC ");
        } elseif ($sort == 'year') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status AND `ride_date`> DATE_SUB(curdate(),INTERVAL 1 YEAR) ");
        } elseif ($sort == 'all') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status AND `user_id`='$user' ");
        } elseif ($sort == 'ASC' || $sort == 'DESC') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user' AND `status`=$status ORDER BY `total_fare`  $sort");
        } else {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status AND `user_id`='$user' ");
        }
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }

    public function completed_admin_order($sort, $status)
    {
        if ($sort == 'WEEK' || $sort == 'MONTH' || $sort == 'YEAR') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status AND `ride_date`> DATE_SUB(curdate(),INTERVAL 1 $sort) ");
        } elseif ($sort == 'all') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status ");
        } elseif ($sort == 'ASC' || $sort == 'DESC') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status ORDER BY `total_fare`  $sort");
        } elseif ($sort == 'ASC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status ORDER BY `ride_date` ASC ");
        } elseif ($sort == 'DESC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status ORDER BY `ride_date` DESC ");
        } else {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `status`=$status ");
        }
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Sorted Ride data according to the sort required
    public function ride_user($user_id, $sort)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' ORDER BY $sort ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Confirm Ride 
    public function confirm_ride($ride_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `ride_id`='$ride_id' AND `status`='2' ");
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //Filtering Data from the database
    public function filter_user($user_id, $sort)
    {
        if ($sort == 'WEEK' || $sort == 'MONTH' || $sort == 'YEAR') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' AND `ride_date`> DATE_SUB(curdate(),INTERVAL 1 $sort) ");
        } elseif ($sort == 'all') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' ");
        } elseif ($sort == 'ASC' || $sort == 'DESC') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable  WHERE `user_id`='$user_id' ORDER BY `total_fare`  $sort");
        } elseif ($sort == 'ASC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id'  ORDER BY `ride_date` ASC ");
        } elseif ($sort == 'DESC_date') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' ORDER BY `ride_date` DESC ");
        } elseif ($sort == 'pending') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' AND `status`='1' ");
        } elseif ($sort == 'Completed') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' AND `status`='2' ");
        } elseif ($sort == 'Cancelled') {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' AND `status`='0' ");
        } else {
            $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' ORDER BY `ride_date` ASC ");
        }
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
    //counting total ride of an particular user
    public function user_ride($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' ");
        return $result->num_rows;
    }
    public function user_cancelled_ride($user_id)
    {
        $result = mysqli_query($this->conn, "SELECT * FROM rideTable WHERE `user_id`='$user_id' AND `status`='0' ");
        return $result->num_rows;
    }
    //deleting ride
    public function delete($ride_id)
    {
        $result = mysqli_query($this->conn, "DELETE FROM rideTable  WHERE `ride_id`='" . $ride_id . "'");
        return "Deleted SuccessFully";
    }
}
