<?php
    session_start();
    require("connection.php");

    $query = "SELECT PNAME, sum(OL_QTY) as QUANTITY FROM ORDER_LINE O JOIN PRODUCTS P ON O.PROD_ID=P.PROD_ID GROUP BY P.PNAME,O.PROD_ID";
    $result = oci_parse($conn, $query);
    $stmt = oci_execute($result);

    //oci_define_by_name($result, 'PRODUCT', $prod);

    //oci_define_by_name($result, 'QUANTITY', $qty);

    $rows = array();
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        $rows[] = array(
            'ProductName' => $row[0],
            'Quantity' => $row[1]
        );
    }

    echo json_encode($rows);
?>