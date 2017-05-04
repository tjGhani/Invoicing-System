<?php
    //session_start();
	require("connection.php");

	if (!isset($_SESSION['UserID'])) {
        header("location:index.html");
    }

    else if (strcmp($_SESSION['utype'],"ADMIN")==0 || strcmp($_SESSION['utype'],"EMPLOYEE")==0) {
        header("location:accessDenied.php");
    }


?>