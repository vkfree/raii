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
                            <div class="text">Total </div>
                            <div class="number">12</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec2">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">access_alarm</i>
                        </div>
                        <div class="content">
                            <div class="text">Pending </div>
                            <div class="number">21</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec3">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">poll</i>
                        </div>
                        <div class="content">
                            <div class="text">Deactive User</div>
                            <div class="number">34</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 dashbord_up_4 dashh_sec4">
                    <div class="info-box hover-zoom-effect">
                        <div class="icon bg-light-blue">
                            <i class="material-icons">insert_invitation</i>
                        </div>
                        <div class="content">
                            <div class="text">Unknown</div>
                            <div class="number">21</div>
                        </div>
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
    var chart = new CanvasJS.Chart("chartContainer", {
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
                { y: <?php echo $u_count; ?>, label: " Driver ", exploded: true }, 
                { y: <?php echo $d_count; ?>, label: " User " }
            ]
        }]
    });
    chart.render();
    }
</script>

<!-- <script src="../../canvasjs.min.js"></script> -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
