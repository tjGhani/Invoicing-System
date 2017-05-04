<?php

    session_start();
    require("connection.php");
    require("header.php");

    if(strcmp($_SESSION['object'],"user")==0)
        $uid = $_POST['user'];
    else
        $pid = $_POST['prod'];
    $UserID = $_SESSION['UserID'];
    $activity = $_SESSION['activity'];

    if (strcmp($activity,"inactive")==0)
        $sql1 = "UPDATE USERS SET USTATUS='INACTIVE', UEND_DATE=SYSDATE, UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$uid'";
    else {
        if(strcmp($_SESSION['object'],"user")==0)
            $sql1 = "UPDATE USERS SET USTATUS='ACTIVE', UEND_DATE=NULL, UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$uid'";
        else
            $sql1 = "UPDATE PRODUCTS SET PSTATUS='ACTIVE' WHERE PROD_ID=".$pid;
    }

    $result = oci_parse($conn,$sql1);
    oci_execute($result);

    if (strcmp($activity,"inactive")==0 && strcmp($_SESSION['utype'],"ADMIN")==0)
        header("location:adminMngUser.php");
    else if(strcmp($activity,"inactive")==0 && strcmp($_SESSION['utype'],"EMPLOYEE")==0)
        header("location:empMngUser.php");
    else
        header("location:viewInactive.php");

?>