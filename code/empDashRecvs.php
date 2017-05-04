<?php
    session_start();
    require("connection.php");

    $query = "SELECT COUNT(CASE WHEN R.AMT_OWED<25000 THEN 1 END) as A, COUNT(CASE WHEN R.AMT_OWED BETWEEN 25000 AND 50000 THEN 1 END) as B,
                COUNT(CASE WHEN R.AMT_OWED BETWEEN 50000 AND 75000 THEN 1 END) as C, COUNT(CASE WHEN R.AMT_OWED>75000 THEN 1 END) as D
                FROM RECEIVABLES R";
    $result = oci_parse($conn, $query);
    $stmt = oci_execute($result);

    //oci_define_by_name($result, 'PRODUCT', $prod);

    //oci_define_by_name($result, 'QUANTITY', $qty);

    $rows = array();
    $row = oci_fetch_array($result,OCI_NUM);
    //while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
    $rows[] = array(
        'Amount' => "<25k",
        'No. of Customers' => $row[0]
    );
    $rows[] = array(
        'Amount' => "25k - 50k",
        'No. of Customers' => $row[1]
    );
    $rows[] = array(
        'Amount' => "50k - 75k",
        'No. of Customers' => $row[2]
    );
    $rows[] = array(
        'Amount' => ">75k",
        'No. of Customers' => $row[3]
    );
     //}

    echo json_encode($rows);
?>