<?php
    session_start();
    require("connection.php");
    require("header.php");
    $step = $_SESSION['step'];



    if(strcmp($step,"first")==0) {
        if(strcmp($_SESSION['utype'],"EMPLOYEE")==0) {
            $rcptDate = $_POST['rdate'];
            $cid = $_POST['cid'];
            $_SESSION['cid'] = $cid;
        }
        else {
            $rcptDate = "SYSDATE";
            $cid = $_SESSION['UserID'];
            //var_dump($cid);
            $_SESSION['cid'] = $cid;
        }
        $query = "INSERT INTO RECEIPTS(R_ID,CUST_ID,RCREATED_BY,RCREATED_DATE) VALUES(RECEIPTS_SEQUENCE.NEXTVAL,".$cid.",".$_SESSION['UserID'].",SYSDATE)";
        $result = oci_parse($conn,$query);
        oci_execute($result);

        $query = "SELECT R_ID FROM RECEIPTS WHERE R_ID=(SELECT MAX(R_ID) FROM RECEIPTS)";
        $result = oci_parse($conn,$query);
        oci_define_by_name($result,"R_ID",$rid);
        oci_execute($result);
        oci_fetch($result);
        var_dump($rid);
        $_SESSION['rid'] = $rid;
        $_SESSION['step'] = "second";

        header("location:chooseInv.php");
    }
    else {
        $inv = $_SESSION['rcptIids'];
        $iamount = $_POST['iamount'];
        $rid = $_SESSION['rid'];
        var_dump($rid);
        for ($i=0; $i<count($inv); $i++) {
            if($inv[$i]>=73643) {
                $query = "INSERT INTO DNOTE_RECEIPT VALUES(".$rid.", ".$inv[$i].", ".$iamount[$i].")";
            }
            else {
                $query = "INSERT INTO INV_RECEIPT VALUES(" . $rid . ", " . $inv[$i] . ", " . $iamount[$i] . ")";
            }
            echo $query;
            $result = oci_parse($conn,$query);
            oci_execute($result);


        }
        $query = "UPDATE RECEIPTS SET RAMOUNT_PAID=(SELECT SUM(AMOUNT_PAID) FROM INV_RECEIPT GROUP BY R_ID HAVING R_ID=".$rid.")+(SELECT SUM(AMOUNT_PAID) FROM DNOTE_RECEIPT GROUP BY R_ID HAVING R_ID=".$rid.") WHERE R_ID=".$rid;
        echo $query;
        $result = oci_parse($conn,$query);
        oci_execute($result);
        $query = "UPDATE RECEIVABLES SET AMT_OWED=AMT_OWED-((SELECT SUM(AMOUNT_PAID) FROM INV_RECEIPT GROUP BY R_ID HAVING R_ID=".$rid.")+(SELECT SUM(AMOUNT_PAID) FROM DNOTE_RECEIPT GROUP BY R_ID HAVING R_ID=".$rid."))
                    WHERE RECV_ID=(SELECT RECV_ID FROM CUSTOMERS WHERE CUST_ID=".$_SESSION['cid'].")";
        $result = oci_parse($conn,$query);
        oci_execute($result);
        for ($i=0; $i<count($inv); $i++) {
            if($inv[$i]>=73643) {
                $query = "UPDATE DEBIT_NOTES SET D_AMT_REMAINING=D_AMT_REMAINING-(SELECT AMOUNT_PAID FROM DNOTE_RECEIPT WHERE R_ID=" . $rid . " AND D_ID=".$inv[$i]."),
                        DMODIFIED_BY=".$_SESSION['UserID'].", DMODIFIED_DATE=SYSDATE WHERE INV_ID=".$inv[$i];
            }
            $query = "UPDATE INVOICES SET INV_REMAINING_BALANCE=INV_AMOUNT_DUE-(SELECT AMOUNT_PAID FROM INV_RECEIPT WHERE R_ID=" . $rid . " AND INV_ID=".$inv[$i]."),
                        IMODIFIED_BY=".$_SESSION['UserID'].", IMODIFIED_DATE=SYSDATE WHERE INV_ID=".$inv[$i];
            echo $query;
            $result = oci_parse($conn,$query);
            oci_execute($result);
        }

        header("location:viewRcpt.php");
    }

?>