<html lang="en">
<head>
    <title id='Description'>Orders by Product</title>
    <link rel="stylesheet" href="jqwidgets-ver3.9.1/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="bootstrap-3.3.5-dist/js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets-ver3.9.1/jqwidgets/jqxdata.js"></script>

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
                colorScheme: 'scheme03',
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
                                        radius: 145,
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
<div id='chartContainer' style="width:1000px; height: 500px"/>
</body>
</html>