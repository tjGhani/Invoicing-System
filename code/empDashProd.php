<?php
    session_start();
    require("connection.php");

    $query = "SELECT * FROM
              (SELECT P.PNAME,SUM(OL_QTY) FROM PRODUCTS P, ORDER_LINE L WHERE P.PROD_ID=L.PROD_ID GROUP BY P.PNAME, L.PROD_ID ORDER BY SUM(OL_QTY) DESC)
               WHERE ROWNUM<=3";
    $result = oci_parse($conn, $query);
    $stmt = oci_execute($result);

    //oci_define_by_name($result, 'PRODUCT', $prod);

    //oci_define_by_name($result, 'QUANTITY', $qty);

    $rows = array();
    //$row = oci_fetch_array($result,OCI_NUM);
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        $rows[] = array(
            'ProductName' => $row[0],
            'Quantity' => $row[1]
        );
    }

    echo json_encode($rows);
?>