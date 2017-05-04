<?php

    session_start();
    require("connection.php");
    require("header.php");

    $UserID = $_SESSION['UserID'];
    $userfname = $_POST['txtUfname'];
    $userlname = $_POST['txtUlname'];
    $useremail = $_POST['txtUemail'];
    $userphone = $_POST['txtUphone'];

    if (strcmp($_SESSION['utype'],"ADMIN")==0) {
        //var_dump($usertype);
        $usertype = $_POST['utype'];
        $usdate = $_POST['dateUSDate'];
        if(strcmp($usertype,"CUSTOMER")==0) {
            $sql1 = "INSERT INTO USERS(USER_ID, UFNAME, ULNAME, UPHONE, UEMAIL, UTYPE, USTART_DATE, USTATUS, ULOG_COUNT, ULOCK, UPASSWORD, UCREATED_BY, UCREATED_DATE)
         	    VALUES(USERSID_CUST_SEQUENCE.NEXTVAL, '$userfname', '$userlname', '$userphone', '$useremail', '$usertype', '$usdate', 'ACTIVE', 0, 'UNLOCKED', USERSID_CUST_SEQUENCE.CURRVAL, $UserID, SYSDATE)";
            $sql2="INSERT INTO RECEIVABLES VALUES(RECEIVABLES_SEQUENCE.NEXTVAL, 0, SYSDATE)";
            $sql3="INSERT INTO CUSTOMERS VALUES (USERSID_CUST_SEQUENCE.CURRVAL, RECEIVABLES_SEQUENCE.CURRVAL)";
            $hi=1;
            //echo $sql1;
            //echo $sql2;
            //echo $sql3;
        }
        else if(strcmp($usertype,"EMPLOYEE")==0) {
            $sql1 = "INSERT INTO USERS(USER_ID, UFNAME, ULNAME, UPHONE, UEMAIL, UTYPE, USTART_DATE, USTATUS, ULOG_COUNT, ULOCK, UPASSWORD, UCREATED_BY, UCREATED_DATE)
         	    VALUES(USERSID_EMP_SEQUENCE.NEXTVAL, '$userfname', '$userlname', '$userphone', '$useremail', '$usertype', '$usdate', 'ACTIVE', 0, 'UNLOCKED', USERSID_EMP_SEQUENCE.CURRVAL, $UserID, SYSDATE)";
        }
        else {
            $sql1 = "INSERT INTO USERS(USER_ID, UFNAME, ULNAME, UPHONE, UEMAIL, UTYPE, USTART_DATE, USTATUS, ULOG_COUNT, ULOCK, UPASSWORD, UCREATED_BY, UCREATED_DATE)
         	    VALUES(USERSID_ADMIN_SEQUENCE.NEXTVAL, '$userfname', '$userlname', '$userphone', '$useremail', '$usertype', '$usdate', 'ACTIVE', 0, 'UNLOCKED', USERSID_ADMIN_SEQUENCE.CURRVAL, $UserID, SYSDATE)";
        }
    }
    else {
        $sql1="INSERT INTO USERS(USER_ID, UFNAME, ULNAME, UPHONE, UEMAIL, UTYPE, USTART_DATE, USTATUS, ULOG_COUNT, ULOCK, UPASSWORD, UCREATED_BY, UCREATED_DATE)
         			VALUES(USERSID_CUST_SEQUENCE.NEXTVAL, '$userfname', '$userlname', '$userphone', '$useremail', 'CUSTOMER', SYSDATE, 'ACTIVE', 0, 'UNLOCKED', USERSID_CUST_SEQUENCE.CURRVAL, $UserID, SYSDATE)";
        $sql2="INSERT INTO RECEIVABLES VALUES(RECEIVABLES_SEQUENCE.NEXTVAL, 0, SYSDATE)";
        $sql3="INSERT INTO CUSTOMERS VALUES (USERSID_CUST_SEQUENCE.CURRVAL, RECEIVABLES_SEQUENCE.CURRVAL)";
        $hi = 1;
        //echo $sql2;
        //echo $sql3;
    }

    echo $sql1;

    $result=oci_parse($conn,$sql1);
    oci_execute($result);

    if($hi==1) {
        $result = oci_parse($conn, $sql2);
        oci_execute($result);

        $result = oci_parse($conn, $sql3);
        oci_execute($result);
    }


    if(strcmp($_SESSION['utype'],"EMPLOYEE")==0) {

        header("location:empMngCust.php");
    }
    else {
        header("location:adminMngUser.php");
    }
?>