(function ($) {
    "use strict";
    var main_url = $("#url").val();

    function revenue(result) {
        var revenueChartoptions = {
            series: [
                {
                    name: result?.income?.label,
                    data: result?.income?.data,
                },
                {
                    name: result?.expense?.label,
                    data: result?.expense?.data,
                },
            ],

            colors: ["#6CD6FD", "#DEF6FF"],
            chart: {
                type: "bar",
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },

            legend: {
                itemMargin: {
                    horizontal: 5,
                    vertical: 5,
                },
                horizontalAlign: "center",
                verticalAlign: "center",
                position: "bottom",
                fontSize: "14px",
                fontWight: "bold",
                markers: {
                    radius: 5,
                    height: 14,
                    width: 14,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: result?.labels,
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " " + result?.currency;
                    },
                },
            },
        };

        var revenueChart = new ApexCharts(
            document.querySelector("#revenueChart"),
            revenueChartoptions
        );
        revenueChart.render();
    }

    if ($("#revenueChart").length) {
        $.ajax({
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: main_url + "/admin/revenue",
            success: function (response) {
                if (response?.result) {
                    revenue(response?.data);
                }
            },
        });
    }

    function salesChart(result) {
        var options = {
            series: [
                {
                    data: result?.info,
                },
            ],
            chart: {
                height: 350,
                type: "bar",
                events: {
                    click: function (chart, w, e) {
                        // console.log(chart, w, e)
                    },
                },
            },
            plotOptions: {
                bar: {
                    columnWidth: "45%",
                    distributed: true,
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            xaxis: {
                categories: result?.labels,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " " + result?.currency;
                    },
                },
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#sales_chart"),
            options
        );
        chart.render();
    }
    if ($("#sales_chart").length) {
        $.ajax({
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: main_url + "/admin/sales",
            success: function (response) {
                if (response?.result) {
                    salesChart(response?.data);
                }
            },
        });
    }
})(jQuery);
