<?php

require 'config.php';
require 'header.php';
$db = new User();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->signup_request();
if (isset($_REQUEST['user_id'])) {
    $user_id = $_REQUEST['user_id'];
    echo $db->approved($user_id);
    header("Refresh:0;url=pending_request.php");
}
if (isset($_REQUEST['delid'])) {
    $user_id = $_REQUEST['delid'];
    echo $db->reject($user_id);
    header("Refresh:0;url=pending_request.php");
}
?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Pending Request List</h1>
        </div>
        <table id="AdminTable" style="margin-left:15%;">
            <tr>
                <th>User_ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td><?php echo $key['user_id'] ?></td>
                        <td><?php echo $key['username'] ?></td>
                        <td><?php echo $key['email'] ?></td>
                        <td><a href="pending_request.php?user_id=<?php echo $key['user_id'] ?>">Approved</a>
                            <a  onClick="javascript: return confirm('Please confirm Rejection');" href="pending_request.php?delid=<?php echo $key['user_id'] ?>">Reject</a></td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'footer.php' ?>
    <script src="../script.js"></script>
</body>