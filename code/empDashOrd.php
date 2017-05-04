<?php
    session_start();
    require("connection.php");

    $query = "SELECT INV_ID,INV_DATE,INV_AMOUNT_DUE FROM INVOICES WHERE INV_DATE BETWEEN SYSDATE-30 AND SYSDATE";
    $result = oci_parse($conn, $query);
    $stmt = oci_execute($result);

    //oci_define_by_name($result, 'PRODUCT', $prod);

    //oci_define_by_name($result, 'QUANTITY', $qty);

    $rows = array();
    //$row = oci_fetch_array($result,OCI_NUM);
    while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        $rows[] = array(
            'InvID' => $row[0],
            'Date' => $row[1],
            'Amount' => $row[2]
        );
    }

    echo json_encode($rows);
?>