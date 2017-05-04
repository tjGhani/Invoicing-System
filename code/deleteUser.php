<?php

    session_start();
    require("connection.php");
    require("header.php");

    $uid = $_POST['user'];
    $UserID = $_SESSION['UserID'];
    $activity = $_SESSION['activity'];

    if (strcmp($activity,"inactive")==0) {
        $sql1 = "UPDATE USERS SET USTATUS='INACTIVE', UEND_DATE=SYSDATE, UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$uid'";
        $result = oci_parse($conn,$sql1);
        oci_execute($result);
        if(strcmp($_SESSION['utype'],"ADMIN")==0)
            header("location:adminMngUser.php");
        else
            header("location:empMngCust.php");
    }
    else {
        $sql1 = "UPDATE USERS SET USTATUS='ACTIVE', UEND_DATE=SYSDATE, UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$uid'";
        $result = oci_parse($conn,$sql1);
        oci_execute($result);
        header("location:viewInactive.php");
    }


?>