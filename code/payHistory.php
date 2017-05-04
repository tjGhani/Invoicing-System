<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Payment History</title>
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
        <br />
        <h2> View Payment History </h2>

        <form class="form-back" method="POST" width="600px">
            <center>
                <div class="menu" style="width:300px; vertical-align:middle">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" value="createUser" onclick="form.action='viewDetails.html';">View Details</button>
                    <button class="btn btn-lg btn-primary btn-block" type="submit" value="editUser" onclick="form.action='home.php';">Back</button>
                </div>
            </center>
            <div class="content">
                <table id="paymentHistory" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <tr>
                        <th></th>
                        <th>Receipt ID</th>
                        <th>Date</th>
                        <th>Amount Paid</th>
                    </tr>

                    <?php
                        $UserID = $_SESSION['UserID'];

                        $sql = "SELECT R_ID, RCREATED_DATE, RAMOUNT_PAID FROM RECEIPTS WHERE CUST_ID=".$UserID;

                        $result = oci_parse($conn,$sql);

                        oci_define_by_name('R_ID', $rid);

                        oci_execute($result);

                        while(oci_fetch($result)) {
                            echo  "<tr><td><input type='radio' name='receipt' value='".$rid."'></td>";
                            echo  	  "<td>".oci_result($stmt, "R_ID")."</td>";
                            echo      "<td>".oci_result($stmt, "RCREATED_DATE")."</td>";
                            echo 	  "<td>".oci_result($stmt, "RAMOUNT_PAID")."</td></tr>";
                        }

                    ?>
                </table>
            </div>
        </form>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>
        <script>
            $(document).ready(function() {
                $('#paymentHistory').DataTable();
            } );
        </script>
    </body>
</html>


