<?php
    session_start();
    require("connection.php");

    $query = "SELECT SUM(COUNT(CASE WHEN P.PNAME LIKE '%Canon%' THEN 1 END)) as CANON, SUM(COUNT(CASE WHEN P.PNAME LIKE '%Nikon%' THEN 1 END)) as NIKON,
                SUM(COUNT(CASE WHEN P.PNAME LIKE '%Olympus%' THEN 1 END)) as OLYMPUS, SUM(COUNT(CASE WHEN P.PNAME LIKE '%Sony%' THEN 1 END)) as SONY
                FROM ORDER_LINE O JOIN PRODUCTS P ON O.PROD_ID=P.PROD_ID GROUP BY P.PNAME,O.PROD_ID";
    $result = oci_parse($conn, $query);
    $stmt = oci_execute($result);

    //oci_define_by_name($result, 'PRODUCT', $prod);

    //oci_define_by_name($result, 'QUANTITY', $qty);

    $rows = array();
    $row = oci_fetch_array($result,OCI_NUM);
    //while (($row = oci_fetch_array($result, OCI_NUM)) != false) {
        $rows[] = array(
            'Brand' => 'CANON',
            'Share' => ($row[0]/($row[1]+$row[2]+$row[3]+$row[0]))*100
        );
        $rows[] = array(
            'Brand' => 'NIKON',
            'Share' => ($row[1]/($row[1]+$row[2]+$row[3]+$row[0]))*100
        );
        $rows[] = array(
            'Brand' => 'OLYMPUS',
            'Share' => ($row[2]/($row[1]+$row[2]+$row[3]+$row[0]))*100
        );
        $rows[] = array(
            'Brand' => 'SONY',
            'Share' => ($row[3]/($row[1]+$row[2]+$row[3]+$row[0]))*100
        );
    //}

    echo json_encode($rows);
?>