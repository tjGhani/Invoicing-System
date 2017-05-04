<?php
    session_start();
    require("connection.php");
    require("custHeader.php");
    $step = $_SESSION['step'];
    //var_dump($step);

    //if(strcmp($_SESSION['step'],"first")==0) {
        //$ord_date = $_POST['oDate'];
        $cust_id = $_SESSION['UserID'];

        $query = "INSERT INTO ORDERS(ORD_ID, ORD_DATE, CUST_ID, ORD_STATUS) VALUES(ORDERS_SEQUENCE.NEXTVAL, SYSDATE, ".$cust_id.", 'PENDING')";
        $result = oci_parse($conn,$query);
        oci_execute($result);

        $query = "SELECT ORD_ID FROM ORDERS WHERE ORD_ID=(SELECT MAX(ORD_ID) FROM ORDERS)";
        $result = oci_parse($conn,$query);
        oci_define_by_name($result,"ORD_ID", $oid);
        oci_execute($result);
        oci_fetch($result);

        $_SESSION['oid'] = $oid;
        $step = "second";
        $_SESSION['step'] = $step;

        //header("location:chooseProd.php");
    //}
    //else {
        $pids = $_SESSION['ordPids'];
        $qtys = $_POST['oqty'];
        $oid = $_SESSION['oid'];

        for ($i=0; $i<count($pids); $i++) {
            $query = "INSERT INTO ORDER_LINE VALUES(".$oid.", ".$pids[$i].", (SELECT PRATE FROM PRODUCTS WHERE PROD_ID=".$pids[$i]."),
                            ".$qtys[$i].", (SELECT PRATE FROM PRODUCTS WHERE PROD_ID=".$pids[$i].")*".$qtys[$i].")";
            echo $query;
            $result = oci_parse($conn,$query);
            oci_execute($result);


        }
        $query = "UPDATE ORDERS SET ORD_COST=(SELECT SUM(OL_COST) FROM ORDER_LINE GROUP BY ORD_ID HAVING ORD_ID=".$oid.") WHERE ORD_ID=".$oid;
        $result = oci_parse($conn,$query);
        oci_execute($result);
        header("location:custOrd.php");
    //}
?>