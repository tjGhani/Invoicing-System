<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Confirm Order</title>
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
            $_SESSION['step'] = "second";
            include("custNav.html");
        ?>
        <h2><br /><center>Confirm Your Order</center><br /></h2>
        <br />
        <form class="form-back" method="post" action="ordPlace.php" width="600px">
            <div class="content">
                <table id="confirmOrder" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <tr>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Qty</th>
                    </tr>
                    <?php
                        $prod = $_GET['product'];
                        foreach($prod as $product) {
                            $query = "SELECT PNAME,PRATE,PDESC FROM PRODUCTS WHERE PROD_ID=".$product;
                            $result = oci_parse($conn,$query);
                            oci_execute($result);
                            while(oci_fetch($result)) {
                                echo "<tr><td>".oci_result($result,"PNAME")."</td>";
                                echo     "<td>".oci_result($result,"PDESC")."</td>";
                                echo     "<td>".oci_result($result,"PRATE")."</td>";
                                echo     "<td><input class='form-control' type='number' name='oqty[]'></td></tr>";
                            }
                        }
                        $_SESSION['ordPids'] = $prod;
                        //var_dump($pids);
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><center><button class="btn btn-lg btn-default" type="submit" value="next">Confirm</button></center></td>
                    </tr>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>
        <script>
            $(document).ready(function() {
                $('#confirmOrder').DataTable();
            } );
        </script>
    </body>
</html>