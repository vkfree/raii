<div class="container page_iner_contr_main" style="max-width: 100%;">
    <div class="row">
        <div class="col-sm-12 clearfix">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec1">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">shopping_cart</i>
                        </div>
                        <div class="content">
                            <div class="text">Today's Orders</div>
                            <div class="number"><?php echo @$today_order; ?>11</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec2">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">access_alarm</i>
                        </div>
                        <div class="content">
                            <div class="text">Pending Orders</div>
                            <div class="number"><?php echo @$today_pending; ?>23</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec3">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">poll</i>
                        </div>
                        <div class="content">
                            <div class="text">Today's Sales</div>
                            <div class="number">KD <?php echo @$today_sell[0]['total']; ?>34</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec4">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">insert_invitation</i>
                        </div>
                        <div class="content">
                            <div class="text">Month Sale</div>
                            <div class="number">Kd <?php echo @$month_sell[0]['total']; ?>42</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 dash_brd_thml">
                    <div class="card">
                        <div class="header pading_top_header">
                            <h4>Chart</h4>
                        </div>
                        <div class="body user_chart_js">

  <div class="chart">
    
    <div class="bar">
        <div class="bar-percent">33%</div>
        <div class="bar-name">Egypt</div>
    </div>

    <div class="bar">
        <div class="bar-percent">52%</div>
        <div class="bar-name">China</div>
    </div>

    <div class="bar">
        <div class="bar-percent">88%</div>
        <div class="bar-name">USA</div>
    </div>

    <div class="bar">
        <div class="bar-percent">71%</div>
        <div class="bar-name">Russia</div>
    </div>

    <div class="bar">
        <div class="bar-percent">28%</div>
        <div class="bar-name">Afghanistan</div>
    </div>

    <div class="bar">
        <div class="bar-percent">45%</div>
        <div class="bar-name">Kenya</div>
    </div>

  </div> <!-- chart -->
                        </div>
                    </div>
                    <!-- <?php if (isset($top_pro[0]['product_image']))
                    {
                    ?>
                    <?php } ?> -->
                </div>
                <div class="col-sm-4 dash_brd_thml">
                    <div class="thumbnail card top_seling_sectn">
                        <div class="header pading_top_header header_with_desrctpn">
                            <h4>Top selling product</h4>
                            <p>
                                <!-- <?php echo @$top_pro[0]['product_name'].' sold '.@$top_pro[0]['pr_count'].' items.'; ?> -->
                            </p>
                            <div class="clear"></div>
                        </div>
                        <img class="top_seling_img" src="http://master.appristine.in/assets/admin/products/93e21276168ee941a720423eea511cdc.jpg">
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 dash_brd_thml">
                    <div class="card">
                        <div class="header pading_top_header">
                            <h4>Sales </h4>
                        </div>
                        <div class="body">
                            <canvas id="line_chart" height="180"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 ">
                    <div class="card" style="height: 440px;">
                        <div class="header pading_top_header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h4>Daily Orders</h4>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <a href="<?php echo base_url(); ?>admin/orders" class="btn btn-primary more_btn pull-right">
                                        More
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="body body_tabl_orders">
                            <table class="table " >
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Net total</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <?php
                                    foreach (@$dailyor as $orkey => $orvalue)
                                    {
                                    echo "<tr>";
                                        echo "<td>".@$orvalue['display_order_id']."</td>";
                                        echo "<td>".@$orvalue['name']."</td>";
                                        echo "<td> KD ".@$orvalue['net_total']."</td>";
                                        echo '<td class="actions">
                                            <a href="'.base_url().'admin/orders/view/'.@$orvalue['order_master_id'].'" class="btn bg-light-blue btn-circle waves-effect waves-circle waves-float " role="button">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                        </td>';
                                    echo "</tr>";
                                    }
                                    ?> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

	


$( document ).ready(function() {

//metrial pie chart
var pieChartData = [], pieChartSeries = 3;
    var pieChartLabels = ['Web', 'Android', 'IOS'];
    var pieChartColors = ['#E91E63', '#03A9F4', '#FFC107'];
    var pieChartDatas = [<?php echo $source.','.$sourcea.','.$sourcei; ?>];

    for (var i = 0; i < pieChartSeries; i++) {
        pieChartData[i] = {
            label: pieChartLabels[i],
            data: pieChartDatas[i],
            color: pieChartColors[i]
        }
    }
    /*$.plot('#pie_chart', pieChartData, {
        series: {
            pie: {
                show: true,
                radius: 1,
                width:50,
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
    });*/
    function labelFormatter(label, series) {
        return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
    }
//End metrial pie chart
});




$(function () {
    new Chart(document.getElementById("line_chart").getContext("2d"), getChartJs('line'));
    /*new Chart(document.getElementById("bar_chart").getContext("2d"), getChartJs('bar'));
    new Chart(document.getElementById("radar_chart").getContext("2d"), getChartJs('radar'));*/
    new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));
});

function getChartJs(type) {
    var config = null;

    if (type === 'line') {
        config = {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }, {
                        label: "My Second dataset",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        borderColor: 'rgba(233, 30, 99, 0.75)',
                        backgroundColor: 'rgba(233, 30, 99, 0.3)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                        pointBorderWidth: 1
                    }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    /*else if (type === 'bar') {
        config = {
            type: 'bar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
                }, {
                        label: "My Second dataset",
                        data: [28, 48, 40, 19, 86, 27, 90],
                        backgroundColor: 'rgba(233, 30, 99, 0.8)'
                    }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    else if (type === 'radar') {
        config = {
            type: 'radar',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "My First dataset",
                    data: [65, 25, 90, 81, 56, 55, 40],
                    borderColor: 'rgba(0, 188, 212, 0.8)',
                    backgroundColor: 'rgba(0, 188, 212, 0.5)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.8)',
                    pointBorderWidth: 1
                }, {
                        label: "My Second dataset",
                        data: [72, 48, 40, 19, 96, 27, 100],
                        borderColor: 'rgba(233, 30, 99, 0.8)',
                        backgroundColor: 'rgba(233, 30, 99, 0.5)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.8)',
                        pointBorderWidth: 1
                    }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    */
    else if (type === 'pie') {
        config = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [140, 100, 120],
                    backgroundColor: [
                        "#3999da",
                        "#e54d42",
                        "#2d3e4e"
                         
                    ],
                }],
                labels: [
                    "Website",
                    "Android",
                    "ios",
                    
                ]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
    }
    return config;
}




</script>
<style type="text/css">
    /* Main Styles */

.chart {
  display: grid;
  grid-template-rows: repeat(100, 1fr);
  grid-column-gap: 10px;
  width: 410px;
  max-width: 100%;
  height: 20vh;
  max-height: 1000px;
  border-bottom: 5px solid orangered;
}
.bar {
  grid-row-end: 102;
  position: relative;
  background: #10a5d5;
  border-radius: 5px 5px 0 0;
}
.body.user_chart_js{
    text-align: center;
    width: 80%;
    margin: 0px auto;
}

.bar-percent {
  position: relative;
  top: -20px;
  text-align: center;
}

.bar-name {
  position: relative;
  writing-mode: vertical-rl;
  transform: rotate(180deg);
  bottom: -99%;
  left: 25%;
  padding-top: 20px;
  text-align: center;
}

</style>
<script type="text/javascript">
    const chart = document.querySelector('.chart');
const totalBars = document.querySelectorAll('.bar').length;
const percentDivs = document.querySelectorAll('.bar-percent');

//Automatically adjust bar's height based on its percentage with 'grid-row-start' property
percentDivs.forEach(percentDiv => {
  const barPercent = Math.floor(percentDiv.textContent.replace('%', ''));
  
  percentDiv.parentNode.style.setProperty('grid-row-start', 100 - `${barPercent}`);
});

//Automatically set 'grid-template-columns' value depending on no. of bars
chart.style.setProperty('grid-template-columns', `repeat(${totalBars}, 1fr)`);
</script>