<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Approve Pending Orders</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("empHeader.php");
            include("empNav.html");
        ?>
        <h2><br /><center>Requested Orders</center><br /></h2>
        <form id="form" class="form-back" method="POST" width="900px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="viewDet" onclick="form.action='viewDet.php';">View Details</button>
                    <button class="btn btn-lg btn-default" type="submit" value="approveOrd" onclick="form.action='ordApprovCreateInv.php';">Approve Order</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="approveOrder" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Customer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = "SELECT O.ORD_ID,O.ORD_DATE,O.ORD_COST,U.UFNAME,U.ULNAME,O.ORD_STATUS FROM ORDERS O INNER JOIN USERS U ON O.CUST_ID = U.USER_ID WHERE ORD_STATUS='PENDING'";
                            $result = oci_parse($conn,$query);

                            oci_define_by_name($result, 'ORD_ID', $oid);

                            oci_execute($result);
                            $_SESSION['objType'] = "order";
                            $_SESSION['approve'] = "true";

                            while(oci_fetch($result)) {
                                echo "<tr><td><center><input type='radio' class='order' name='ord' value='".$oid."'></center></td>";
                                echo     "<td>".oci_result($result, "ORD_DATE")."</td>";
                                echo     "<td>".oci_result($result, "ORD_COST")."</td>";
                                echo     "<td>".oci_result($result, "UFNAME")." ".oci_result($result, "ULNAME")."</td>";
                                echo     "<td>".oci_result($result, "ORD_STATUS")."</td></tr>";
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
                $('#approveOrder').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $("#form").submit(function (e) {
                if (!$(".order").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>