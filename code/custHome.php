<!DOCTYPE html>
<?php
    session_start();
?>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Home</title>
        <link href="bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/sb-admin.css" rel="stylesheet">
        <link href="bootstrap-3.3.5-dist/css/morris.css" rel="stylesheet">
        <link rel="stylesheet" href="jqwidgets-ver3.9.1/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link href="bootstrap-3.3.5-dist/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>

        <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxcore.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.core.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdraw.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdata.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdatatable.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxscrollbar.js"></script>
        <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxbuttons.js"></script>

        <!-- top 3 products -->
        <script type="text/javascript">
            $(document).ready(function () {
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Quantity'},
                        { name: 'ProductName'}
                    ],
                    url: 'empDashProd.php'
                };

                var dataAdapter = new $.jqx.dataAdapter(source,
                    {
                        autoBind: true,
                        async: false,
                        downloadComplete: function () { },
                        loadComplete: function () { },
                        loadError: function () { }
                    });

                // prepare jqxChart settings
                var settings = {
                    title: "Top 3 Products",
                    description: "",
                    showLegend: true,
                    padding: { left: 5, top: 5, right: 50, bottom: 5 },
                    titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                    source: dataAdapter,
                    categoryAxis:
                    {
                        dataField: 'ProductName',
                        showGridLines: false,
                    },
                    colorScheme: 'scheme05',
                    seriesGroups:
                        [
                            {
                                type: 'column',
                                columnsGapPercent: 50,
                                valueAxis:
                                {
                                    displayValueAxis: true,
                                    description: 'Quantity',
                                    unitInterval :10,
                                    minValue: 0,
                                    maxValue: 50
                                },
                                series: [
                                    { dataField: 'Quantity', displayText: 'Product' }
                                ]
                            }
                        ]
                };

                // setup the chart
                $('#jqxChart').jqxChart(settings);
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                // prepare chart data as an array
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Brand' },
                        { name: 'Share' }
                    ],
                    url: 'empDashBrands.php'
                };

                var dataAdapter = new $.jqx.dataAdapter(source, {
                    async: false,
                    autoBind: true,
                    loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error); }
                });

                // prepare jqxChart settings
                var settings = {
                    title: "Brand Popularity",
                    description: "",
                    enableAnimations: true,
                    showLegend: true,
                    showBorderLine: true,
                    legendLayout: { left: 700, top: 160, width: 300, height: 200, flow: 'vertical' },
                    padding: { left: 5, top: 5, right: 5, bottom: 5 },
                    titlePadding: { left: 0, top: 0, right: 0, bottom: 10 },
                    source: dataAdapter,
                    colorScheme: 'scheme02',
                    seriesGroups:
                        [
                            {
                                type: 'pie',
                                showLabels: true,
                                series:
                                    [
                                        {
                                            dataField: 'Share',
                                            displayText: 'Brand',
                                            labelRadius: 170,
                                            initialAngle: 15,
                                            radius: 70,
                                            centerOffset: 0,
                                            formatFunction: function (value) {
                                                if (isNaN(value))
                                                    return value;
                                                return parseFloat(value) + '%';
                                            },
                                        }
                                    ]
                            }
                        ]
                };

                // setup the chart
                $('#chartContainer').jqxChart(settings);
            });

        </script>
    </head>
    <body style="background:white;">
        <?php
            //session_start();
            require("connection.php");
            require("custHeader.php");
            $_SESSION['step'] = "first";
            $_SESSION['isCust'] = "true";
            include("custNav.html");

            $UserID = $_SESSION['UserID'];
            $uname = $_SESSION['uname'];
            $_SESSION['step'] = "first";
            echo "<h2><center>My Account - Customer $UserID - Welcome $uname!</center><br /></h2>";

            $sql = "SELECT COUNT(*) FROM ORDERS WHERE ORD_STATUS='APPROVED' AND OMODIFIED_DATE>(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."
                            AND LOG_DATE<(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."))";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $order = oci_result($result,"COUNT(*)");
            //var_dump($pending);

            $sql = "SELECT COUNT(*) FROM DEBIT_NOTES WHERE DCREATED_DATE>(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."
                            AND LOG_DATE<(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."))";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $debit = oci_result($result,"COUNT(*)");

            $sql = "SELECT R.AMT_OWED FROM RECEIVABLES R, CUSTOMERS C WHERE R.RECV_ID=C.RECV_ID AND C.CUST_ID=".$_SESSION['UserID'];
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $recv = oci_result($result,"AMT_OWED");
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-shopping-cart" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $order; ?></div>
                                    <div>Orders Approved!</div>
                                </div>
                            </div>
                        </div>
                        <a href="custOrd.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-folder-open" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $debit; ?></div>
                                    <div>New Debit Notes!</div>
                                </div>
                            </div>
                        </div>
                        <a href="viewDNote.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="glyphicon glyphicon-usd" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $recv; ?></div>
                                    <div>Receivable Amount!</div>
                                </div>
                            </div>
                        </div>
                        <a href="rcptSave.php">
                            <div class="panel-footer">
                                <span class="pull-left">Make a Payment</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--row-->
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <center>
                        <div id="jqxChart" style="width:550px; height:250px"></div>
                    </center>
                </div>
                <div class="col-lg-6 col-md-6">
                    <center>
                        <div id="chartContainer" style="width:550px; height:250px"></div>
                    </center>
                </div>
            </div>
        </div>
    </body>
</html>