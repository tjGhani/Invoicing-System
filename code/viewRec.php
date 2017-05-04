<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>View Receivables</title>
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
        <h2><br /><center>Receivables</center><br /></h2>
        <br />
        <br />
        <div class="content">
            <table border="1" id="receivables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount Owed</th>
                        <th>Date Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //$basename(path)ack = $_SESSION['Back'];

                        $query = "SELECT U.UFNAME,U.ULNAME,R.AMT_OWED,R.DATE_UPDATED FROM RECEIVABLES R, CUSTOMERS C, USERS U WHERE R.RECV_ID=C.RECV_ID AND C.CUST_ID=U.USER_ID";
                        $stmt = oci_parse($conn,$query);

                        //oci_define_by_name($stmt, 'PROD_ID', $pid);

                        oci_execute($stmt);

                        while (oci_fetch($stmt)) {
                            //$_SESSION['uid'] = $uid;
                            //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                            //echo  "<tr><td><input type='radio' name='prod' value='".$pid."'></td>";
                            echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                            echo      "<td>".oci_result($stmt, "AMT_OWED")."</td>";
                            echo      "<td>".oci_result($stmt, "DATE_UPDATED")."</td></tr>";
                        }

                        //$_SESSION['activity'] = "inactive";
                        //$_SESSION['product'] = "true";
                    ?>
                </tbody>
            </table>
        </div>
        <script src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js" rel="stylesheet"></script>
        <script src="bootstrap-3.3.5-dist/DataTables/datatables.js" rel="stylesheet"></script>
        <script>
            $(document).ready(function() {
                $('#receivables').DataTable();
            } );
        </script>
    </body>
</html>
