<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Manage Products</title>
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
        <h2><br /><center>Manage Products</center><br /></h2>

        <form id="form" class="form-back" method="POST" width="600px">
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-lg btn-default" type="button" data-toggle="modal" data-target="#createProd">New</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="editProd" onclick="form.action='prodUpdate.php';">Edit</button>
                    <button class="btn btn-lg btn-default matter" type="submit" value="deleteProd" onclick="form.action='prodDelete.php';">Delete</button>
                    <button class="btn btn-lg btn-default" type="submit" value="viewIn" onclick="form.action='viewInactive.php';">View Inactive</button>
                </div>
            </center>
            <br />
            <br />
            <div class="content">
                <table id="manageProducts" class="table table-striped table-bordered" border="1" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Rate</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$basename(path)ack = $_SESSION['Back'];
                            $_SESSION['object'] = "product";
                            $query = "SELECT PROD_ID,PNAME,PRATE,PDESC FROM PRODUCTS WHERE PSTATUS='ACTIVE'";
                            $stmt = oci_parse($conn,$query);

                            oci_define_by_name($stmt, 'PROD_ID', $pid);

                            oci_execute($stmt);

                            while (oci_fetch($stmt)) {
                                //$_SESSION['uid'] = $uid;
                                //echo  "<tr><td><input type='radio' name='user' value='".$_SESSION['uid']."'></td>";
                                echo  "<tr><td><center><input type='radio' class='product' name='prod' value='".$pid."'></center></td>";
                                echo      "<td>".oci_result($stmt, "PNAME")."</td>";
                                echo      "<td>".oci_result($stmt, "PRATE")."</td>";
                                echo      "<td>".oci_result($stmt, "PDESC")."</td></tr>";
                            }

                            $_SESSION['activity'] = "inactive";
                            $_SESSION['product'] = "true";
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
                $('#manageProducts').DataTable();
            } );
        </script>

        <script type="text/javascript">
            $(".matter").click(function (e) {
                if (!$(".product").is(':checked')) {
                    alert('Nothing is checked!');
                    e.preventDefault();
                }
            });
        </script>

        <div class="modal fade" id="createProd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
                    </div>
                    <form method="POST" action="prodSave.php">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="txtUfname" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" name="txtUlname" class="form-control" placeholder="Rate">
                            </div>
                            <div class="form-group">
                                <input type="number" name="txtUphone" class="form-control" placeholder="Description">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>