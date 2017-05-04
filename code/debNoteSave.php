<?php
    session_start();
    require("connection.php");
    require("header.php");


    /*if(strcmp($_SESSION['dnoteSA'],"specific")==0) {
        $query = "INSERT INTO DEBIT_NOTES(D_ID, CUST_ID, D_AMOUNT, D_DESC, D_TO, DCREATED_BY, DCREATED_DATE)
                    VALUES(DEBITNOTE_SEQUENCE.NEXTVAL, ".$_SESSION['dcust'].", ".$amt.", '".$reason."', 'ONE', ".$_SESSION['UserID'].", SYSDATE)";
        $query2 = "UPDATE RECEIVABLES SET AMT_OWED=AMT_OWED+".$amt." WHERE RECV_ID=(SELECT RECV_ID FROM CUSTOMERS WHERE CUST_ID=".$_SESSION['dcust'].")";
    }
    else if(strcmp($_SESSION['dnoteSA'],"all")==0) {
        $query = "INSERT INTO DEBIT_NOTES(D_ID, D_AMOUNT, D_DESC, D_TO, DCREATED_BY, DCREATED_DATE)
                    VALUES(DEBITNOTE_SEQUENCE.NEXTVAL, ".$amt.", '".$reason."', 'ALL', ".$_SESSION['UserID'].", SYSDATE)";
        $query2 = "UPDATE RECEIVABLES SET AMT_OWED=AMT_OWED+".$amt;
    }*/

    $amt = $_POST['txtDAmount'];
    $reason = $_POST['reason'];

    $query = "begin debitnote_all(:vamount, :vreason, :vcreated_by); end;";


    echo $query;
    //echo $query2;

    $result = oci_parse($conn, $query);

    oci_bind_by_name($result, ':vamount', $amt);
    oci_bind_by_name($result, ':vreason', $reason);
    oci_bind_by_name($result, ':vcreated_by', $_SESSION['UserID']);
    //$result2 = oci_parse($conn, $query2);



    oci_execute($result);
    //oci_execute($query2);

    header("location:viewDNote.php");
?>