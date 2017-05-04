<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Manage Customers</title>
        <!-- Bootstrap -->
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
        <h2><br /><center>View Orders</center><br /></h2>

        <form id="form" class="form-back" method="POST" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="editProd" onclick="form.action='viewDet.php';">View Details</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="manageOrders" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];
                            $_SESSION['objType'] = "order";
                            $_SESSION['approve'] = "false";
                            $query = "SELECT O.ORD_ID,O.ORD_DATE,O.ORD_COST,U.UFNAME,U.ULNAME,O.ORD_STATUS FROM ORDERS O INNER JOIN USERS U
                                        ON O.CUST_ID=U.USER_ID ORDER BY ORD_STATUS";
                            $stmt = oci_parse($conn,$query);

                            oci_define_by_name($stmt, 'ORD_ID', $oid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                                echo  "<tr><td><center><input type='radio' class='order' id='toggleElement' name='ord' value='".$oid."'></center></td>";
                                echo      "<td>".oci_result($stmt, "ORD_DATE")."</td>";
                                echo      "<td>".oci_result($stmt, "ORD_COST")."</td>";
                                echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                                echo      "<td>".oci_result($stmt, "ORD_STATUS")."</td></tr>";
                            }

                            $_SESSION['activity'] = "inactive";

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
                $('#manageOrders').DataTable();
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