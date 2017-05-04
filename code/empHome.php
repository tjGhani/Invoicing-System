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
        <title>Employee Home</title>
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
        <!--top 3 products-->

        <!--range of receivables-->
        <script type="text/javascript">
            $(document).ready(function () {
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Amount'},
                        { name: 'No. of Customers'}
                    ],
                    url: 'empDashRecvs.php'
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
                    title: "Range of Receivables",
                    description: "",
                    showLegend: true,
                    padding: { left: 5, top: 5, right: 50, bottom: 5 },
                    titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                    source: dataAdapter,
                    categoryAxis:
                    {
                        dataField: 'Amount',
                        showGridLines: false
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
                                    description: 'No. of Customers',
                                    unitInterval :10,
                                    minValue: 0,
                                    maxValue: 50
                                },
                                series: [
                                    { dataField: 'No. of Customers', displayText: 'Amount' }
                                ]
                            }
                        ]
                };

                // setup the chart
                $('#jqxChart1').jqxChart(settings);
            });
        </script>
        <!--percentage share of brands-->
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
                    title: "Sales of Brands Distribution",
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
        <!--datatable-->
        <script type="text/javascript">
            $(document).ready(function () {
                var source =
                {
                    dataType: "json",
                    dataFields: [
                        { name: 'InvID', type: 'string' },
                        { name: 'Date', type: 'string' },
                        { name: 'Amount', type: 'string' }
                    ],

                    url: 'empDashOrd.php'
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                $("#dataTable").jqxDataTable(
                    {
                        height: 250,
                        pageable: true,
                        pagerButtonsCount: 10,
                        altRows: true,
                        filterable: true,

                        filterMode: 'simple',
                        source: dataAdapter,
                        columnsResize: true,
                        columns: [
                            { text: 'InvID', dataField: 'InvID', width: 110 },
                            { text: 'Date', dataField: 'Date', width: 110 },
                            { text: 'Amount', dataField: 'Amount', width: 110 }
                        ]
                    });
            });
        </script>
    </head>
    <body style="background:white;">
        <?php
            //session_start();
            require("connection.php");
            require("empHeader.php");
            include("empNav.html");

            $UserID = $_SESSION['UserID'];
            $uname = $_SESSION['uname'];

            echo "<h2><center>My Account - Employee $UserID - Welcome $uname!</center><br /></h2>";
            $sql = "SELECT COUNT(*) FROM ORDERS WHERE ORD_STATUS='PENDING'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $order = oci_result($result,"COUNT(*)");
            //var_dump($pending);

            $sql = "SELECT COUNT(*) FROM CREDIT_NOTES WHERE CR_STATUS='PENDING'";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $credit = oci_result($result,"COUNT(*)");

            $sql = "SELECT COUNT(*) FROM RECEIPTS WHERE RCREATED_DATE > (SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."
                        AND LOG_DATE<(SELECT MAX(LOG_DATE) FROM LOGIN_LOG WHERE USER_ID=".$_SESSION['UserID']."))";
            $result = oci_parse($conn, $sql);
            oci_execute($result);
            oci_fetch($result);
            $receipts = oci_result($result,"COUNT(*)");
            //var_dump($receipts);
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
                                    <div>Pending Orders!</div>
                                </div>
                            </div>
                        </div>
                        <a href="empApprOrd.php">
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
                                    <div class="huge"><?php echo $credit; ?></div>
                                    <div>Pending Credit Notes!</div>
                                </div>
                            </div>
                        </div>
                        <a href="viewCNote.php">
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
                                    <span class="glyphicon glyphicon-tags" style="font-size:50px"></span>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $receipts; ?></div>
                                    <div>Payments Made (since last logon)!</div>
                                </div>
                            </div>
                        </div>
                        <a href="viewRcpt.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right glyphicon glyphicon-circle-arrow-right"></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <center>
                    <div id="chartContainer" style="width:350px; height:250px"></div>
                    </center>
                </div>
                <div class="col-lg-4 col-md-6">
                    <center>
                    <div id="dataTable" style="width:350px; height:250px"></div>
                    </center>
                </div>
                <div class="col-lg-4 col-md-6">
                    <center>
                    <div id="jqxChart1" style="width:350px; height:250px"></div>
                    </center>
                </div>

            </div>
            <!-- /. row -->

        </div>
    </body>
</html>