
<?php
    session_start();
    $_SESSION = array();

    $sql = "COMMIT";
    $result = oci_parse($conn,$sql);
    oci_execute($result);

    if (!empty($_COOKIE[session_name()])) {
        setcookie(session_name(), "", -1);
    }
    session_destroy();

    header("location:index.html");
?>
