<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Orders</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("custHeader.php");
            include("custNav.html");
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
                <table border="1" id="orders" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date</th>
                            <th>Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];
                            $_SESSION['objType'] = "order";
                            $query = "SELECT * FROM ORDERS WHERE CUST_ID=".$_SESSION['UserID']." ORDER BY ORD_STATUS";
                            $stmt = oci_parse($conn,$query);

                            oci_define_by_name($stmt, 'ORD_ID', $oid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                                echo  "<tr><td><center><input type='radio' class='order' name='ord' value='".$oid."'></center></td>";
                                echo      "<td>".oci_result($stmt, "ORD_DATE")."</td>";
                                echo      "<td>".oci_result($stmt, "ORD_COST")."</td>";
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
                $('#orders').DataTable();
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