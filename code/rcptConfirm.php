<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Confirm Receipts</title>
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/DataTables/datatables.min.css" rel="stylesheet">
    </head>
    <body>
        <br />
        <?php
            session_start();
            require("connection.php");
            require("header.php");
            $_SESSION['step'] = "second";

            $utype = $_SESSION['utype'];

            if(strcmp($utype,"ADMIN")==0)
                header("location:accessDenied.php");
            else if(strcmp($utype,"EMPLOYEE")==0)
                include("empNav.html");
            else if(strcmp($utype,"CUSTOMER")==0)
                include("custNav.html");
        ?>
        <br />
        <br />
        <h3><br /><center>Confirm Your Receipt</center><br /></h3>
        <br />
        <form class="form-back" method="post" action="rcptSave.php" width="600px">
            <div class="content">
                <table id="confirmReceipts" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Transaction Type</th>
                            <th>Date</th>
                            <th>Remaining Balance</th>
                            <th>Amount to Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $inv = $_GET['invoice'];
                            foreach($inv as $invoice) {
                                //$query = "SELECT INV_DATE,INV_REMAINING_BALANCE FROM INVOICES WHERE INV_ID=".$invoice;

                                $query = "WITH TEMPTABLE AS (
                                        (SELECT 'INVOICE', I.INV_DATE, I.INV_REMAINING_BALANCE FROM INVOICES I WHERE I.INV_ID=".$invoice.") UNION ALL
                                        (SELECT 'DEBIT NOTE', D.DCREATED_DATE, D.D_AMT_REMAINING FROM DEBIT_NOTES D WHERE D.D_ID=".$invoice."))
                                      SELECT * FROM TEMPTABLE";
                                $result = oci_parse($conn,$query);
                                oci_execute($result);
                                while(oci_fetch($result)) {
                                    echo "<tr><td>".$invoice."</td>";
                                    echo     "<td>".oci_result($result,"'INVOICE'")."</td>";
                                    echo     "<td>".oci_result($result,"INV_DATE")."</td>";
                                    echo     "<td>".oci_result($result,"INV_REMAINING_BALANCE")."</td>";
                                    echo     "<td><input class='form-control' type='number' name='iamount[]'></td></tr>";
                                }
                            }
                            $_SESSION['rcptIids'] = $inv;
                            $_SESSION['step'] = "second";
                            //var_dump($pids);
                        ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-lg btn-default" type="submit" value="next">Confirm</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>

    </body>
</html>
