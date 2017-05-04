<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Choose Products</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <br />
        <?php
            session_start();
            require("connection.php");
            require("custHeader.php");
            $_SESSION['step'] = "first";
            include("custNav.html");
        ?>

        <h2><br /><center>Choose Your Products</center><br /></h2>
        <form class="form-back" method="GET" action="ordConfirm.php" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="editProd">Next</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table border="1" id="chooseProducts" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];

                            $query = "SELECT PROD_ID,PNAME,PRATE FROM PRODUCTS WHERE PSTATUS='ACTIVE'";
                            $stmt = oci_parse($conn,$query);

                            oci_define_by_name($stmt, 'PROD_ID', $pid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                echo "<tr><td><center><input type='checkbox' name='product[]' value='" . $pid . "'></center></td>";
                                echo "<td>" . oci_result($stmt, "PROD_ID") . "</td>";
                                echo "<td>" . oci_result($stmt, "PNAME") . "</td>";
                                echo "<td>" . oci_result($stmt, "PRATE") . "</td>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>
        <script>
            $(document).ready(function() {
                $('#chooseProducts').DataTable();
            } );
        </script>
    </body>
</html>