<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Request a Credit Note</title>
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
            include("custNav.html");
            $UserID = $_SESSION['UserID'];
            $query = "SELECT R.AMT_OWED FROM RECEIVABLES R, CUSTOMERS C WHERE C.RECV_ID=R.RECV_ID AND C.CUST_ID=".$UserID;
            $stmt = oci_parse($conn,$query);
            $_SESSION['credNote'] = "create";
            oci_define_by_name($stmt, 'AMT_OWED', $amt);

            oci_execute($stmt);
            oci_fetch($stmt);
        ?>
        <h2><br /><center>Request a Credit Note</center><br /></h2>
        <form method="POST" action="credNoteSave.php">
            <div align="center" class="container" style="width:900px">
                <table width="900px">
                    <tr>
                        <td>Receivable Amount</td>
                        <td><?php echo $amt; ?><br /></td>
                    </tr>
                    <tr>
                        <td>Amount for Credit Note</td>
                        <td><input type="number" name="cnoteamount" class="form-control"> </input><br /></td>
                    </tr>
                    <tr>
                        <td>Reason for Request</td>
                        <td>
                            <textarea class="form-control" rows="5" name="reason"></textarea><br />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button class="btn btn-lg btn-default" type="submit" value="requestCNote" onclick="form.action='credNoteSave.php';">Request</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    </body>
</html>

