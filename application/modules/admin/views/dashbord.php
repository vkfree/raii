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
                            <div class="text">Total Users </div>
                            <div class="number"><?php echo @$user_count;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec2">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">access_alarm</i>
                        </div>
                        <div class="content">
                            <div class="text">Reward</div>
                            <div class="number"><?php echo @$reward_count;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec3">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">poll</i>
                        </div>
                        <div class="content">
                            <div class="text">Survey</div>
                            <div class="number"><?php echo @$store_count;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec4">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">insert_invitation</i>
                        </div>
                        <div class="content">
                            <div class="text">Orders</div>
                            <div class="number"><?php echo @$orders_count;?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                </div>    
                <div class="col-md-4">
                    <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
                </div>    
            </div>

            <div class="row" style="margin: 100px 10px;">
                <div class="mytable">
                    <div class="row heading">
                        <h2 style="text-align: center;padding: 30px 0px;color: #5c56a0;">Recent Bookings</h2>
                    </div>
                    <div class="row">    
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Phone</th>
                              <th scope="col">Store</th>
                              <th scope="col">Price</th>
                              <th scope="col">Order Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(!empty(@$store_order)){ foreach($store_order as $key=>$value){?>
                            <tr>
                              <th scope="row"><?php echo $key+1;?></th>
                              <td><?php echo @$value['user_name'];?></td>
                              <td><?php echo @$value['email'];?></td>
                              <td><?php echo @$value['phone'];?></td>
                              <td><?php echo @$value['store_name'];?></td>
                              <td><?php echo @$value['price'];?></td>
                              <td><?php echo @$value['created_date'];?></td>
                            </tr>
                            <?php }}?>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>    
          
        </div>
    </div>
</div>

<style type="text/css">
    /* Main Styles */

    .chart {
      display: grid;
      grid-template-rows: repeat(100, 1fr);
      grid-column-gap: 10px;
      width: 410px;
      max-width: 100%;
      height: 30vh;
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
        width: 90%;
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
      height: 100px;
      left: 25%;
      padding-top: 20px;
      text-align: center;
    }
    .canvasjs-chart-credit{
        display: none;
    }
    table.table.table-striped{
            height: 353px;
    overflow: hidden;
    display: block;
    width: 100%;
    overflow-y: auto;
    }

.tag-danger {
    background-color: #f44236;
}
.tag {
     display: inline-block;
    padding: .25em .4em;
    font-size: 12px;
    letter-spacing: 1px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    border-radius: .25rem;
}
.tag-success {
    background-color: #43b968;
}
.tag-info {
    background-color: #20b9ae;
}



.panel-green {
    border-color: #5cb85c;
}

.panel-green .panel-heading {
    border-color: #5cb85c;
    color: #fff;
    background-color: #5cb85c;
}

.panel-green a {
    color: #5cb85c;
}

.panel-green a:hover {
    color: #3d8b3d;
}

.panel-red {
    border-color: #d9534f;
}

.panel-red .panel-heading {
    border-color: #d9534f;
    color: #fff;
    background-color: #d9534f;
}

.panel-red a {
    color: #d9534f;
}

.panel-red a:hover {
    color: #b52b27;
}

.panel-yellow {
    border-color: #f0ad4e;
}

.panel-yellow .panel-heading {
    border-color: #f0ad4e;
    color: #fff;
    background-color: #f0ad4e;
}

.panel-yellow a {
    color: #f0ad4e;
}

.panel-yellow a:hover {
    color: #df8a13;
}

.row{
    width: 100%;
    margin: 0px;
}
span.capital{
    text-transform: capitalize;
}
.huge {
    font-size: 35px;
}

 .table.table.table-striped::-webkit-scrollbar {
    width: 0px;
    height: 12px;
}
.table.table.table-striped::-webkit-scrollbar-thumb {
    background: rgb(42, 39, 75);
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
<script>
    window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer1", {
        theme: "light1", // "light1", "light2", "dark1", "dark2"
        exportEnabled: false,
        animationEnabled: true,
        title: {
            text: ""
        },
        data: [{
            type: "pie",
            startAngle: 25,
            toolTipContent: "<b>{label}</b>: {y}%",
            showInLegend: "true",
            legendText: "{label}",
            indexLabelFontSize: 14,
            indexLabel: "{label} - {y}%",
            dataPoints: [
                { y: 30, label: " Jan - Mar ", exploded: true }, 
                { y: 20, label: " Apr - Jun " },
                { y: 35, label: " Jul - Sep " },
                { y: 15, label: " Oct - Dec " }
            ]
        }]
    });
    chart.render();

    var dataPoints = [];

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "Daily Sales Data"
        },
        axisY: {
            title: "Units",
            titleFontSize: 24,
            includeZero: true
        },
        data: [{
            type: "column",
            yValueFormatString: "#,### Units",
            dataPoints: dataPoints
        }]
    });

    function addData(data) {
        for (var i = 0; i < data.length; i++) {
            dataPoints.push({
                x: new Date(data[i].date),
                y: data[i].units
            });
    }
    chart.render();

}

$.getJSON("https://canvasjs.com/data/gallery/javascript/daily-sales-data.json", addData);

}
</script>

<!-- <script src="../../canvasjs.min.js"></script> -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
