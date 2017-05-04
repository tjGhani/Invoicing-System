<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Home Page</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>

        <?php
            session_start();
            require("connection.php");
            require("empHeader.php");
            include("empNav.html");

            $UserID = $_SESSION['UserID'];
            $pid = $_POST['prod'];
            $_SESSION['pid'] = $pid;
            //echo "this is the" . $uid;
            //$uid = $_SESSION['uid'];
            //var_dump($_SESSION['emptype']);

            $query = "SELECT PNAME, PRATE, PSTATUS, PDESC FROM PRODUCTS WHERE PROD_ID=" . $pid;
            $stmt = oci_parse($conn, $query);

            oci_define_by_name($stmt, "PNAME", $p_name);
            oci_define_by_name($stmt, "PRATE", $p_rate);
            oci_define_by_name($stmt, "PDESC", $p_desc);

            oci_execute($stmt);
            oci_fetch($stmt);

            //$_SESSION['updateProd'];

        ?>
        <h2><br /><center>Update Product</center><br /></h2>
        <div align="left|right|center|justify" class="container" style="width:900px">
            <form method="POST" action="prodSave.php">
                <table class="table" width="900px">
                    <tr>
                        <td>Product Name</td>
                        <td>
                            <input class="form-control" type='text' name='pname' value='<?php echo $p_name; ?>'> </input>
                        </td>
                    </tr>
                    <tr>
                        <td>Rate</td>
                        <td>
                            <input class="form-control" type='text' name='prate' value='<?php echo $p_rate; ?>'> </input>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>
                            <input class="form-control" type='text' name='pdesc' value='<?php echo $p_desc; ?>'> </input>
                        </td>
                    </tr>
                </table>
                <br />
                <input style="width:300px" class="btn btn-lg btn-default" type='submit' value='Save'>
            </form>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>
