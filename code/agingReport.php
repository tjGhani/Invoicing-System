<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Aging Report</title>
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
        <h2><br /><center>Aging Report</center><br /></h2>

        <form id="form" class="form-back" method="POST" width="600px">
            <br />
            <div class="content">
                <table id="agingReport" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>1-30 Days</th>
                            <th>31-60 Days</th>
                            <th>61-90 Days</th>
                            <th>91+ Days</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        //$basename(path)ack = $_SESSION['Back'];

                        $query = "SELECT U.USER_ID,U.UFNAME,U.ULNAME,
                                        (SELECT NVL(SUM(I.INV_REMAINING_BALANCE),0) FROM INVOICES I WHERE I.INV_DATE BETWEEN SYSDATE-30 AND SYSDATE AND I.CUST_ID=U.USER_ID) - (SELECT NVL(SUM(CR.CR_AMOUNT),0) FROM CREDIT_NOTES CR WHERE CR.CRCREATED_DATE BETWEEN SYSDATE-30 AND SYSDATE AND CR.CRCREATED_BY=U.USER_ID) + (SELECT NVL(SUM(D.D_AMT_REMAINING),0) FROM DEBIT_NOTES D WHERE D.DCREATED_DATE BETWEEN SYSDATE-30 AND SYSDATE AND D.CUST_ID=U.USER_ID) AS A,
                                        (SELECT NVL(SUM(I.INV_REMAINING_BALANCE),0) FROM INVOICES I WHERE I.INV_DATE BETWEEN SYSDATE-61 AND SYSDATE-30 AND I.CUST_ID=U.USER_ID) - (SELECT NVL(SUM(CR.CR_AMOUNT),0) FROM CREDIT_NOTES CR WHERE CR.CRCREATED_DATE BETWEEN SYSDATE-61 AND SYSDATE-30 AND CR.CRCREATED_BY=U.USER_ID) + (SELECT NVL(SUM(D.D_AMT_REMAINING),0) FROM DEBIT_NOTES D WHERE D.DCREATED_DATE BETWEEN SYSDATE-61 AND SYSDATE-30 AND D.CUST_ID=U.USER_ID) AS B,
                                        (SELECT NVL(SUM(I.INV_REMAINING_BALANCE),0) FROM INVOICES I WHERE I.INV_DATE BETWEEN SYSDATE-91 AND SYSDATE-60 AND I.CUST_ID=U.USER_ID) - (SELECT NVL(SUM(CR.CR_AMOUNT),0) FROM CREDIT_NOTES CR WHERE CR.CRCREATED_DATE BETWEEN SYSDATE-91 AND SYSDATE-60 AND CR.CRCREATED_BY=U.USER_ID) + (SELECT NVL(SUM(D.D_AMT_REMAINING),0) FROM DEBIT_NOTES D WHERE D.DCREATED_DATE BETWEEN SYSDATE-91 AND SYSDATE-60 AND D.CUST_ID=U.USER_ID) AS C,
                                        (SELECT NVL(SUM(I.INV_REMAINING_BALANCE),0) FROM INVOICES I WHERE I.INV_DATE<(SYSDATE-90) AND I.CUST_ID=U.USER_ID) - (SELECT NVL(SUM(CR.CR_AMOUNT),0) FROM CREDIT_NOTES CR WHERE CR.CRCREATED_DATE<(SYSDATE-90) AND CR.CRCREATED_BY=U.USER_ID) + (SELECT NVL(SUM(D.D_AMT_REMAINING),0) FROM DEBIT_NOTES D WHERE D.DCREATED_DATE<(SYSDATE-90) AND D.CUST_ID=U.USER_ID) AS E,R.AMT_OWED
                                    FROM USERS U INNER JOIN CUSTOMERS C ON U.USER_ID=C.CUST_ID
 			                                     INNER JOIN RECEIVABLES R ON C.RECV_ID=R.RECV_ID";
                        $stmt = oci_parse($conn,$query);

                        oci_define_by_name($stmt, 'USER_ID', $uid);

                        oci_execute($stmt);

                        while (($row = oci_fetch_array($stmt, OCI_NUM))!= false) {
                            //$_SESSION['uid'] = $uid;
                            //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                            echo      "<td>".oci_result($stmt, "UFNAME")." ".oci_result($stmt, "ULNAME")."</td>";
                            echo      "<td>".oci_result($stmt, "A")."</td>";
                            //var_dump(oci_result($stmt, "A"));
                            echo      "<td>".oci_result($stmt, "B")."</td>";
                            echo      "<td>".oci_result($stmt, "C")."</td>";
                            echo      "<td>".oci_result($stmt, "E")."</td>";
                            echo      "<td>".oci_result($stmt, "AMT_OWED")."</td></tr>";
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
                $('#agingReport').DataTable();
            } );
        </script>

    </body>
</html>