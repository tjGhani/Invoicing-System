<html lang="en">
<head>
    <title id='Description'>Orders by Product</title>
    <link rel="stylesheet" href="jqwidgets-ver3.9.1/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdatatable.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/scripts/demos.js"></script>


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
                    height: 370,
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
        }
    </script>
    <script src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</head>
<body style="background:white;">
<div id="dataTable" style="width:1000px; height: 500px"></div>
</body>
</html>