<?php

require 'config.php';
require 'header.php';
$db = new User();
$db->connect('localhost', 'root', '', 'CabBooking');
$sql = $db->show_approved();
?>

<body class="admintop">
    <div class="adminbody">
        <img src="../images/slider1.jpg" alt="">
        <div id="AdminWelcomeQuote">
            <h1>Approved Users</h1>
        </div>
        <table id="AdminTable" style="margin-left:10%;">
            <tr>
                <th>User_ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>
            </tr>
            <?php if (isset($sql)) {
                foreach ($sql as $key) { ?>
                    <tr>
                        <td><?php echo $key['user_id'] ?></td>
                        <td><?php echo $key['username'] ?></td>
                        <td><?php echo $key['email'] ?></td>
                        <td><?php echo $key['mobile'] ?></td>
                        <td><?php if ($key['is_block'] == '1') {
                                echo "Approved";
                            } ?>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
    <?php require 'footer.php' ?>
    <script src="../script.js"></script>
</body>