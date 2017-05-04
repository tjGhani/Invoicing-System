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
        <title>Customer Wise Ledger</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <br />
        <br />
        <?php
            require("connection.php");
            if(strcmp($_SESSION['utype'],"EMPLOYEE")==0) {
                include("empNav.html");
                $custID = $_POST['user'];
            }
            else if(strcmp($_SESSION['utype'],"CUSTOMER")==0) {
                include("custNav.html");
                $custID = $_SESSION['UserID'];
            }
            else
                header("location:accessDenied.php");

            $sql = "SELECT U.UFNAME,U.ULNAME FROM USERS U WHERE USER_ID=".$custID;
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);

            echo "<h3><center>Report for ".oci_result($result,"UFNAME")." ".oci_result($result,"ULNAME")."</center></h3><br />";
        ?>
        <table id="custLedger" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type of Transaction</th>
                    <th>Purchase Amount</th>
                    <th>Payment Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require("connection.php");
                    if(strcmp($_SESSION['utype'],"EMPLOYEE")==0) {
                        include("empNav.html");
                            $custID = $_POST['user'];
                    }
                    else if(strcmp($_SESSION['utype'],"CUSTOMER")==0) {
                        include("custNav.html");
                        $custID = $_SESSION['UserID'];
                    }
                    else
                        header("location:accessDenied.php");

                    $query = "WITH TEMPTABLE AS (
                                (SELECT I.INV_DATE, 'INVOICE', I.INV_AMOUNT_DUE FROM INVOICES I WHERE I.CUST_ID=".$custID.") UNION ALL
                                (SELECT R.RCREATED_DATE, 'RECEIPT', R.RAMOUNT_PAID FROM RECEIPTS R WHERE R.CUST_ID=".$custID.") UNION ALL
                                (SELECT CR.CRCREATED_DATE, 'CREDIT NOTE', CR_AMOUNT FROM CREDIT_NOTES CR WHERE CR.CR_STATUS='APPROVED' AND CR.CRCREATED_BY=".$custID.") UNION ALL
                                (SELECT D.DCREATED_DATE, 'DEBIT NOTE', D.D_AMOUNT FROM DEBIT_NOTES D WHERE D.CUST_ID=".$custID."))
                              SELECT * FROM TEMPTABLE ORDER BY 1";
                    $result = oci_parse($conn, $query);
                    oci_execute($result);
                    while (($row = oci_fetch_array($result, OCI_NUM))!=false) {
                        echo "<tr></tr><td>".$row[0]."</td>";
                        echo "<td>".$row[1]."</td>";
                        if(strcmp($row[1],"RECEIPT")==0 || strcmp($row[1],"CREDIT NOTE")==0) {
                            echo "<td></td>";
                            echo "<td>".$row[2]."</td></tr>";
                        }
                        else if(strcmp($row[1],"INVOICE")==0 || strcmp($row[1],"DEBIT NOTE")==0) {
                            echo "<td>".$row[2]."</td>";
                            echo "<td></td></tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
    </body>
</html>
