var data = [], totalPoints = 110;
var updateInterval = 320;
var realtime = 'on';

$(function () {
    //PIE CHART ==========================================================================================
    var pieChartData = [], pieChartSeries = 4;
    var pieChartColors = ['#E91E63', '#03A9F4', '#FFC107', '#009688'];
    var pieChartDatas = [45, 17, 28, 10];

    for (var i = 0; i < pieChartSeries; i++) {
        pieChartData[i] = {
            label: 'Serie = ' + (i + 1),
            data: pieChartDatas[i],
            color: pieChartColors[i]
        }
    }
    console.log(pieChartData);
    $.plot('#pie_chart', pieChartData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 3 / 4,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.5
                    }
                }
            }
        },
        legend: {
            show: false
        }
    });
    function labelFormatter(label, series) {
        return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
    }
    //====================================================================================================
});

function getRandomData() {
    if (data.length > 0) data = data.slice(1);

    while (data.length < totalPoints) {
        var prev = data.length > 0 ? data[data.length - 1] : 50, y = prev + Math.random() * 10 - 5;
        if (y < 0) { y = 0; } else if (y > 100) { y = 100; }

        data.push(y);
    }

    var res = [];
    for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]])
    }

    return res;
}