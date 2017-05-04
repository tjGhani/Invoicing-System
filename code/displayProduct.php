<html lang="en">
<head>
    <title id='Description'>Orders by Product</title>
    <link rel="stylesheet" href="jqwidgets-ver3.9.1/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdata.js"></script>

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
                title: "Orders by Product",
                showLegend: true,
                padding: { left: 5, top: 5, right: 50, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: dataAdapter,
                categoryAxis:
                {
                    text: 'Category Axis',
                    textRotationAngle: 0,
                    dataField: 'ProductName',
                    showTickMarks: true,
                    tickMarksInterval: Math.round(dataAdapter.records.length / 15),
                    tickMarksColor: '#888888',
                    unitInterval: Math.round(dataAdapter.records.length / 15),
                    showGridLines: true,
                    gridLinesInterval: Math.round(dataAdapter.records.length / 15),
                    gridLinesColor: '#888888',
                    axisSize: 'auto'
                },
                colorScheme: 'scheme05',
                seriesGroups:
                    [
                        {
                            type: 'line',
                            valueAxis:
                            {
                                displayValueAxis: true,
                                description: 'Quantity',
                                //descriptionClass: 'css-class-name',
                                axisSize: 'auto',
                                tickMarksColor: '#888888',
                                unitInterval :5,
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

</head>
<body style="background:white;">
<div id='jqxChart' style="width:1000px; height: 500px"/>
</body>
</html>