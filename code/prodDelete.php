<?php
    session_start();
    require("connection.php");
    require("empHeader.php");

    $pid = $_POST['prod'];

    $query = "UPDATE PRODUCTS SET PSTATUS='INACTIVE' WHERE PROD_ID=$pid";
    $result = oci_parse($conn,$query);
    oci_execute($result);

    //echo $query;

    header("location:empMngProd.php");
?>