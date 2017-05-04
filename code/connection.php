<?php

    $conn = oci_pconnect("tghani", "07109", "XE");
    if (!$conn) {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;
    }

?>