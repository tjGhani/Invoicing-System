<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Choose Invoice(s)</title>
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

        <h3><br /><center>Choose Your Invoice(s)/Debit Note(s)</center><br /></h3>
        <form class="form-back" method="GET" action="rcptConfirm.php" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="submit" value="editProd">Next</button>
                </div>
            </center>
            <div class="content">
                <table id="chooseInv" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Transaction ID</th>
                            <th>Transaction Type</th>
                            <th>Date</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];

                            //$query = "SELECT INV_ID,INV_DATE,INV_REMAINING_BALANCE FROM INVOICES WHERE CUST_ID=".$_SESSION['cid'];

                            $query = "WITH TEMPTABLE AS (
                                        (SELECT I.INV_ID, 'INVOICE', I.INV_DATE, I.INV_REMAINING_BALANCE FROM INVOICES I WHERE I.CUST_ID=".$_SESSION['cid'].") UNION ALL
                                        (SELECT D.D_ID, 'DEBIT NOTE', D.DCREATED_DATE, D.D_AMT_REMAINING FROM DEBIT_NOTES D WHERE D.CUST_ID=".$_SESSION['cid']."))
                                      SELECT * FROM TEMPTABLE";

                            $stmt = oci_parse($conn,$query);

                            //echo $query;

                            oci_define_by_name($stmt, 'INV_ID', $iid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                echo "<tr><td><center><input type='checkbox' name='invoice[]' value='" . $iid . "'></center></td>";
                                echo "<td>" . oci_result($stmt, "INV_ID") . "</td>";
                                echo "<td>" . oci_result($stmt, "'INVOICE'") . "</td>";
                                echo "<td>" . oci_result($stmt, "INV_DATE") . "</td>";
                                echo "<td>" . oci_result($stmt, "INV_REMAINING_BALANCE") . "</td>";
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
                $('#chooseInv').DataTable();
            } );
        </script>
    </body>
</html>