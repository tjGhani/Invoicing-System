<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Invoices</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            $utype = $_SESSION['utype'];
            if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");
            else if(strcmp($utype,"ADMIN")==0)
                header("location:accessDenied.php");
        ?>

        <h2><br /><center>View Invoices</center><br /></h2>
        <form id="form" class="form-back" method="POST" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="viewInvDet" onclick="form.action='viewDet.php';">View Details</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="viewInvoices" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Invoice ID</th>
                            <?php
                                if(strcmp($utype,"EMPLOYEE")==0)
                                    echo "<th>Customer</th>";
                            ?>
                            <th>Date</th>
                            <th>Amount Due</th>
                            <th>Remaining Balance</th>
                            <th>Order ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $_SESSION['objType'] = "invoice";
                            if(strcmp($utype,"CUSTOMER")==0)
                                $query = "SELECT INV_ID,INV_DATE,INV_AMOUNT_DUE,INV_REMAINING_BALANCE,ORD_ID FROM INVOICES
                                          WHERE CUST_ID=".$_SESSION['UserID'];
                            else if(strcmp($utype,"EMPLOYEE")==0)
                                $query = "SELECT I.INV_ID,U.UFNAME,U.ULNAME,I.INV_DATE,I.INV_AMOUNT_DUE,I.INV_REMAINING_BALANCE,I.ORD_ID FROM INVOICES I INNER JOIN
                                        USERS U ON I.CUST_ID=U.USER_ID";
                            $result = oci_parse($conn,$query);
                            oci_define_by_name($result,"INV_ID", $iid);
                            oci_execute($result);

                            if(strcmp($utype,"EMPLOYEE")==0) {
                                while (oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='invoice' name='inv' value='" . $iid . "'></center></td>";
                                    echo "<td>".oci_result($result, "INV_ID")."</td>";
                                    echo "<td>".oci_result($result, "UFNAME")." ".oci_result($result, "ULNAME")."</td>";
                                    echo "<td>".oci_result($result, "INV_DATE")."</td>";
                                    echo "<td>".oci_result($result, "INV_AMOUNT_DUE")."</td>";
                                    echo "<td>".oci_result($result, "INV_REMAINING_BALANCE")."</td>";
                                    echo "<td>".oci_result($result, "ORD_ID")."</td></tr>";
                                }
                            }
                            else {
                                while (oci_fetch($result)) {
                                    echo "<tr><td><center><input type='radio' class='invoice' name='inv' value='" . $iid . "'></center></td>";
                                    echo "<td>" . oci_result($result, "INV_ID") . "</td>";
                                    echo "<td>" . oci_result($result, "INV_DATE") . "</td>";
                                    echo "<td>" . oci_result($result, "INV_AMOUNT_DUE") . "</td>";
                                    echo "<td>" . oci_result($result, "INV_REMAINING_BALANCE") . "</td>";
                                    echo "<td>" . oci_result($result, "ORD_ID") . "</td></tr>";
                                }
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
                $('#viewInvoices').DataTable();
            } );
        </script>
        <script type="text/javascript">
            $("#form").submit(function (e) {
                if (!$(".invoice").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>