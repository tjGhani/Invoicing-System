<?php
    session_start();
    require("connection.php");
    require("empHeader.php");

    $oid = $_POST['ord'];
    //$_SESSION['oid'] = $oid;

    $query = "SELECT * FROM ORDERS WHERE ORD_ID=".$oid;
    $result = oci_parse($conn,$query);

    oci_define_by_name($result, 'ORD_COST', $ocost);
    oci_define_by_name($result, 'CUST_ID', $ocust);

    oci_execute($result);
    oci_fetch($result);

    /*$oid = $_SESSION['oid'];
    $ocost = $_SESSION['ocost'];
    $UserID = $_SESSION['UserID'];
    $ocust = $_SESSION['ocust'];*/

    $UserID = $_SESSION['UserID'];

    $query = "INSERT INTO INVOICES(INV_ID, CUST_ID, INV_DATE, INV_AMOUNT_DUE, INV_REMAINING_BALANCE, ORD_ID, ICREATED_BY, ICREATED_DATE)
                VALUES(INVOICES_SEQUENCE.NEXTVAL, $ocust, SYSDATE, $ocost, $ocost, $oid, $UserID, SYSDATE)";
    $query2 = "UPDATE ORDERS SET ORD_STATUS='APPROVED' WHERE ORD_ID=".$oid;
    $query3 = "UPDATE RECEIVABLES SET AMT_OWED=AMT_OWED+".$ocost.", DATE_UPDATED=SYSDATE WHERE RECV_ID=(SELECT RECV_ID FROM CUSTOMERS WHERE CUST_ID=".$ocust.")";

    echo $query;
    echo $query2;
    echo $query3;

    $result = oci_parse($conn,$query);
    oci_execute($result);

    $result = oci_parse($conn,$query2);
    oci_execute($result);

    $result = oci_parse($conn,$query3);
    oci_execute($result);

    header("location:empApprOrd.php");

?>