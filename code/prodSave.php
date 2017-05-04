<?php
    session_start();
    require("connection.php");
    require("empHeader.php");


    $pname = $_POST['pname'];
    $prate = $_POST['prate'];
    $pdesc = $_POST['pdesc'];
    $UserID = $_SESSION['UserID'];

    //var_dump($pname,$prate,$UserID);

    if(isset($_SESSION['updateProd'])) {
        $query = "UPDATE PRODUCTS SET PNAME='".$pname."', PRATE=".$prate.", PDESC='".$pdesc."', PMODIFIED_BY=".$UserID.", PMODIFIED_DATE=SYSDATE
                    WHERE PROD_ID=".$_SESSION['pid'];
    }
    else {
        $query = "INSERT INTO PRODUCTS(PROD_ID, PNAME, PRATE, PSTATUS, PDESC, PCREATED_BY, PCREATED_DATE)
                      VALUES(PRODUCTS_SEQUENCE.NEXTVAL, '".$pname."', ".$prate.", 'ACTIVE', '".$pdesc."', ".$UserID.", SYSDATE)";
    }
    echo $query;
    $result = oci_parse($conn,$query);
    oci_execute($result);

    header("location:empMngProd.php");
?>