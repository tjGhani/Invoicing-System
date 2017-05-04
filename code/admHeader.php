<?php
    require("connection.php");
    if (!isset($_SESSION['UserID'])) {
        header("location:index.html");
    }

    if (strcmp($_SESSION['utype'],"EMPLOYEE")==0 || strcmp($_SESSION['utype'],"CUSTOMER")==0) {
        header("location:accessDenied.php");
    }

?>
