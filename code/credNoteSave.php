<?php
    session_start();
    require("connection.php");
    require("header.php");

    if(strcmp($_SESSION['credNote'],"create")==0) {
        $sql = "INSERT INTO CREDIT_NOTES(CR_ID,CUST_ID,CR_AMOUNT,CR_STATUS,CRCREATED_BY,CRCREATED_DATE,CR_DESC)
                    VALUES(CREDITNOTE_SEQUENCE.NEXTVAL, ".$_SESSION['UserID'].", ".$_POST['cnoteamount'].", 'PENDING', ".$_SESSION['UserID'].", SYSDATE, '".$_POST['reason']."')";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        header("location:viewCNote.php");
    }
    else if(strcmp($_SESSION['credNote'],"update")==0) {
        if(isset($_POST['decisionA'])) {
            $sql = "UPDATE CREDIT_NOTES SET CR_STATUS='APPROVED' WHERE CR_ID=".$_SESSION['crid'];
            $sql2 = "UPDATE RECEIVABLES SET AMT_OWED = AMT_OWED - (SELECT CR_AMOUNT FROM CREDIT_NOTES WHERE CR_ID = ".$_SESSIONG['crid'].") WHERE RECV_ID = (SELECT RECV_ID FROM CUSTOMERS WHERE CUST_ID = ".$_SESSION['custID'].")";
            $hi = 1;
        }
        else if(isset($_POST['decisionR'])) {
            $sql = "UPDATE CREDIT_NOTES SET CR_STATUS='REJECTED' WHERE CR_ID=".$_SESSION['crid'];
            $hi = 0;
        }
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        echo $sql;

        if ($hi==1) {
            $result = oci_parse($conn, $sql2);
            oci_execute($result);
            echo $sql2;
        }
        header("location:viewCNote.php");
    }
?>