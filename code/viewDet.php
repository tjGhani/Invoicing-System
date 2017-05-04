<!DOCTYPE html>
<?php
    session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Details</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
            //session_start();
            require("connection.php");
            $utype = $_SESSION['utype'];

            //$oid = $_POST['ord'];

            if(strcmp($utype,"EMPLOYEE")==0) {
                require("empHeader.php");
                include("empNav.html");
            }
            else if(strcmp($utype,"CUSTOMER")==0) {
                require("custHeader.php");
                include("custNav.html");
            }

            if(strcmp($_SESSION['objType'],"receipt")==0) {
                //if(!isset($_POST['rcpt']))
                    //header("location:viewRcpt.php");
                $rid = $_POST['rcpt'];
                echo "<h2><br /><center>View Receipt Detail</center><br /></h2>";
            }
            else if(strcmp($_SESSION['objType'],"order")==0) {
                //if(!isset($_POST['ord']))
                    //header("location:empMngOrd.php");
                $oid = $_POST['ord'];
                echo "<h2><br /><center>View Order Detail</center><br /></h2>";
            }
            else if(strcmp($_SESSION['objType'],"invoice")==0) {
                //if(!isset($_POST['inv']))
                    //header("location:viewInv.php");
                $iid = $_POST['inv'];
                echo "<h2><br /><center>View Invoice Detail</center><br /></h2>";
            }
        ?>

        <form class="form-back" method="POST" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <?php
                        if(strcmp($_SESSION['objType'],"receipt")==0)
                            echo "<a href='viewRcpt.php' class='btn btn-lg btn-default'>Back</a>";
                        else if(strcmp($_SESSION['objType'],"order")==0 && strcmp($utype,"EMPLOYEE")==0 && strcmp($_SESSION['approve'],"true")==0)
                            echo "<a href='empApprOrd.php' class='btn btn-lg btn-default'>Back</a>";
                        else if(strcmp($_SESSION['objType'],"order")==0 && strcmp($utype,"EMPLOYEE")==0 && strcmp($_SESSION['approve'],"false")==0)
                            echo "<a href='empMngOrd.php' class='btn btn-lg btn-default'>Back</a>";
                        else if(strcmp($_SESSION['objType'],"order")==0 && strcmp($utype,"CUSTOMER")==0)
                            echo "<a href='custOrd.php' class='btn btn-lg btn-default'>Back</a>";
                        else if(strcmp($_SESSION['objType'],"invoice")==0)
                            echo "<a href='viewInv.php' class='btn btn-lg btn-default'>Back</a>";
                    ?>

                </div>
            </center>
            <br />
            <br />
            <h3><center>
                    <?php
                        if(strcmp($_SESSION['objType'],"receipt")==0)
                            echo "Receipt ID ".$rid;
                        else if(strcmp($_SESSION['objType'],"order")==0)
                            echo "Order ID ".$oid;
                        else if(strcmp($_SESSION['objType'],"invoice")==0)
                            echo "Invoice ID ".$iid;
                    ?>
                    <br /><br /></center></h3>
            <div class="content">
                <table class="table">
                    <thead>
                        <?php
                            if(strcmp($_SESSION['objType'],"receipt")==0) {
                                echo "<tr>
                                         <th>Transaction ID</th>
                                         <th>Transaction Type</th>
                                         <th>Total Amount Due</th>
                                         <th>Amount Paid</th>
                                      </tr></thead><tbody>";
                               // $query = "SELECT I.INV_ID, I.INV_AMOUNT_DUE, L.AMOUNT_PAID FROM RECEIPTS R, INVOICES I, INV_RECEIPT L
                                        //WHERE I.INV_ID=L.INV_ID AND L.R_ID=R.R_ID AND R.R_ID=".$rid;
                                $query = "WITH TEMPTABLE AS (
                                        (SELECT I.INV_ID,'INVOICE', I.INV_DATE, I.INV_AMOUNT_DUE,L.AMOUNT_PAID FROM RECEIPTS R, INVOICES I, INV_RECEIPT L
                                        WHERE I.INV_ID=L.INV_ID AND L.R_ID=R.R_ID AND R.R_ID=".$rid.") UNION ALL
                                        (SELECT D.D_ID,'DEBIT NOTE', D.DCREATED_DATE, D.D_AMOUNT,M.AMOUNT_PAID FROM RECEIPTS R, DEBIT_NOTES D, DNOTE_RECEIPT M
                                        WHERE D.D_ID=M.D_ID AND M.R_ID=R.R_ID AND R.R_ID=".$rid."))
                                      SELECT * FROM TEMPTABLE";
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                while(oci_fetch($result)) {
                                    echo  "<tr><td>".oci_result($result, 'INV_ID')."</td>";
                                    echo      "<td>".oci_result($result, "'INVOICE'")."</td>";
                                    echo      "<td>".oci_result($result, 'INV_AMOUNT_DUE')."</td>";
                                    echo      "<td>".oci_result($result, 'AMOUNT_PAID')."</td><td></td></tr>";
                                }

                                $query = "SELECT RAMOUNT_PAID FROM RECEIPTS WHERE R_ID=".$rid;
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                oci_fetch($result);
                                $total = oci_result($result, 'RAMOUNT_PAID');

                                echo  "<tr><td></td><td></td><td></td><td><b>Total</b></td><td><b>".$total."</b></td></tr>";
                            }
                            else if(strcmp($_SESSION['objType'],"order")==0) {
                                echo "<tr>
                                         <th>Product</th>
                                         <th>Rate</th>
                                         <th>Quantity</th>
                                         <th>Cost</th>
                                      </tr></thead><tbody>";

                                $query = "SELECT O.PROD_ID, P.PNAME, O.OL_RATE, O.OL_QTY, O.OL_COST FROM ORDER_LINE O, PRODUCTS P WHERE O.PROD_ID=P.PROD_ID AND O.ORD_ID=".$oid;
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                while(oci_fetch($result)) {
                                    echo  "<tr><td>".oci_result($result, 'PNAME')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_RATE')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_QTY')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_COST')."</td></tr>";
                                }

                                $query = "SELECT ORD_COST FROM ORDERS WHERE ORD_ID=".$oid;
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                oci_fetch($result);
                                $total = oci_result($result, 'ORD_COST');

                                echo  "<tr><td></td><td></td><td><b>Total</b></td><td><b>".$total."</b></td></tr>";
                            }
                            else if(strcmp($_SESSION['objType'],"invoice")==0) {
                                echo "<tr>
                                         <th>Product</th>
                                         <th>Rate</th>
                                         <th>Quantity</th>
                                         <th>Cost</th>
                                      </tr></thead><tbody>";

                                $query = "SELECT O.PROD_ID, P.PNAME, O.OL_RATE, O.OL_QTY, O.OL_COST FROM ORDER_LINE O, PRODUCTS P, INVOICES I
                                            WHERE O.PROD_ID=P.PROD_ID AND O.ORD_ID=I.ORD_ID AND I.INV_ID=".$iid;
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                while(oci_fetch($result)) {
                                    echo  "<tr><td>".oci_result($result, 'PNAME')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_RATE')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_QTY')."</td>";
                                    echo      "<td>".oci_result($result, 'OL_COST')."</td></tr>";
                                }

                                $query = "SELECT INV_AMOUNT_DUE FROM INVOICES WHERE INV_ID=".$iid;
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                oci_fetch($result);
                                $total = oci_result($result, 'INV_AMOUNT_DUE');

                                echo  "<tr><td></td><td></td><td><b>Total</b></td><td><b>".$total."</b></td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
    </body>
</html>