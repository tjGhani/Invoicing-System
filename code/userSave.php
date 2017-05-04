<?php

    session_start();
    require("connection.php");
    require("header.php");

    $utype = $_SESSION['utype'];
    $User_ID = $_SESSION['User_ID'];
    $u_fname = $_POST['userFName'];
    $u_lname = $_POST['userLName'];
    $u_phone = $_POST['userPhone'];
    $u_email = $_POST['userEmail'];
    $u_type = $_POST['userType'];
    $u_stat = $_POST['userStatus'];
    if(strcmp($_SESSION['utype'],"ADMIN")==0) {
        //$u_lcount = $_POST['uLogCount'];
        $u_lstat = $_POST['uLockStatus'];
        if(strcmp($u_lstat,"UNLOCKED")==0) {
            $u_lcount = 0;
        }
    }
    $u_enddate = $_POST['uEndDate'];
    $UserID = $_SESSION['UserID'];

    /*$sql = "DELETE FROM USERS WHERE USER_ID=".$User_ID;

    $result = oci_parse($conn,$sql);
    oci_execute($result);

    $sql1 = "INSERT INTO USERS(USER_ID, UNAME, UTYPE, USTART_DATE, USTATUS, ULOG_COUNT, ULOCK, UEND_DATE, UPASSWORD)
                   VALUES('$User_ID', '$u_name', '$u_type', '$u_stdate', '$u_stat', '$u_lcount', '$u_lstat', '$u_enddate', '$u_password')";
    echo $sql1;*/
    if(strcmp($_SESSION['utype'],"ADMIN")==0)
        $sql1 = "UPDATE USERS SET UFNAME='$u_fname', ULNAME='$u_lname', UPHONE='$u_phone', UEMAIL='$u_email', USTATUS='$u_stat', ULOG_COUNT='$u_lcount', ULOCK='$u_lstat', UEND_DATE='$u_enddate',
                    UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$User_ID'";

    else if (strcmp($_SESSION['utype'],"EMPLOYEE")==0) {
        $sql1 = "UPDATE USERS SET UFNAME='$u_fname', ULNAME='$u_lname', UPHONE='$u_phone', UEMAIL='$u_email',USTATUS='$u_stat',
  					UEND_DATE='$u_enddate', UMODIFIED_BY='$UserID', UMODIFIED_DATE=SYSDATE WHERE USER_ID='$User_ID'";
    }
    echo $sql1;

    $result=oci_parse($conn,$sql1);
    oci_execute($result);

    if (strcmp($utype,"ADMIN")==0)
        header("location:adminMngUser.php");
    else if (strcmp($utype,"EMPLOYEE")==0)
        header("location:empMngCust.php");

?>