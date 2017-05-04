<?php

    if (!isset($_SESSION['UserID'])) {
        header("location:index.html");
    }

?>