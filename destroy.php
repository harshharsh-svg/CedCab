<?php

session_start();
unset($_SESSION['bookdata']);
header('Location:index.php');
?>