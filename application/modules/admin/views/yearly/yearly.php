<h3><span class="capital"></span> Yearly Statement -  <?php $now = date('F j, Y' ,strtotime($now));
		echo $now;  ?> - To - <?php $last_year_listing = date('F j, Y' ,strtotime($last_year_listing));
		echo $last_year_listing;  ?>
</h3>

<div style="text-align: center;padding: 20px;color: #3379b7;font-family: Droid Sans; font-size: 24px;">
	<p>
		<span>Over All Earning : <?php echo $cod; ?></span>
		<br>
		<span>Over All Cancel Rides : <?php echo @$cancel_count1; ?></span>
	</p>
</div>
<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3"><i class="fa fa-truck fa-5x"></i></div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo $total_count1; ?></div>
						<div>TOTAL NO. OF RIDES</div>
					</div>
				</div>
			</div><a>
			<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
			<div class="clearfix"></div>
		</div></a>
	</div>
</div>
<div class="col-lg-3 col-md-6">
	<div class="panel panel-green">
		<div class="panel-heading">
			<div class="row">
				<div class="col-xs-3"><i class="fa fa-5x"><img height="60" style="margin-top: 10px" src="<?php echo base_url();?>assets/admin/images/wallet.png" alt="" "> </i></div>
				<div class="col-xs-9 text-right">
					<div class="huge"><?php echo @$cod; ?></div>
					<div>TOTAl REVENUE !</div>
				</div>
			</div>
		</div><a>
		<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		<div class="clearfix"></div>
	</div></a>
</div>
</div>
<div class="col-lg-3 col-md-6">
<div class="panel panel-yellow">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-3"><i class="fa fa-5x"> <img height="60" style="margin-top: 10px" src="<?php echo base_url();?>assets/admin/images/cancel-event.png" alt="" "> </i></div>
			<div class="col-xs-9 text-right">
				<div class="huge"><?php echo @$cancel_count1; ?></div>
				<div>CANCELLED RIDES !</div>
			</div>
		</div>
	</div><a>
	<div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	<div class="clearfix"></div>
</div></a>
</div>
</div>
<div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3"><i class="fa fa-5x"><img height="60" style="margin-top: 10px" src="<?php echo base_url();?>assets/admin/images/task-complete.png" alt="" "></i></div>
              <div class="col-xs-9 text-right">
                <div class="huge"><?php echo $complete_count1; ?></div>
                <div>COMPLETE RIDES !</div>
              </div>
            </div>
          </div><a>
            <div class="panel-footer"><span class="pull-left">View Details</span><span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div></a>
        </div>
      </div>
</div>
<br><br><br>

<div class="container" style="width: 100%;overflow: hidden;">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover dataTable js-exportable">
				<thead>
					<tr>
						<th>ID e</th>
						<th>Picked Up</th>
						<th>Dropped</th>
						<th>Date on</th>
						<th>Status</th>
						<th>Earned Price</th>
						<th>Actions</th>
					</tr>
				</thead>
				<!-- <pre>
				<?php print_r($response); ?>
				</pre> -->
				<tbody>
					<?php if (!empty($response)) {
					foreach ($response as $key => $value) { ?>
					<tr>
						<td><?php echo $value->id ?></td>

						<td>
							<?php if ($value->status == "cancel" || ($value->status == 'booked') || ($value->status == "pending"))  {
								echo $value->pick_address;
							}
							elseif ($value->status == "complete") {
							 	echo $value->start_address;
							 } ?>
						</td>

						<td>
							<?php if ($value->status == "cancel" || ($value->status == 'booked') || ($value->status == "pending"))  {
								echo $value->drop_address;
							}
							elseif ($value->status == "complete") {
							 	echo $value->end_address;
							 } ?>
						</td>						
						<td style="    width: 10%;">
							<?php if ($value->status == "cancel" || ($value->status == 'booked') || ($value->status == "pending"))  {
								$date = date('F j, Y', strtotime($value->user_booking_time));
							 	echo $date;
							}
							elseif ($value->status == "complete") {
							 	$date = date('F j, Y, g:i a', strtotime($value->book_date_time));
							 	echo $date;
							} ?>

							<?php //echo $value->book_date_time ?>
						</td>
						<td style="    width: 10%;">
							<?php if ($value->status == "cancel") {
								echo "<span class='tag tag-danger'>CANCELLED</span>";
							}
							elseif ($value->status == "complete") {
							 	echo "<span class='tag tag-success'>COMPLETED</span>";
							}
							elseif ($value->status == "pending") {
							 	echo "<span class='tag tag-success'>PENDING</span>";
							}
							elseif ($value->status == "booked") {
							 	echo "<span class='tag tag-info'>PICKEDUP</span>";
							} ?>
						</td>

						<td style="    width: 10%;">
							<?php if ($value->status == "cancel" || ($value->status == 'booked') || ($value->status == "pending"))  {
								echo $value->estimated_price." SAR";
							}
							elseif ($value->status == "complete") {
							 	echo $value->final_price." SAR";
							}?>
						</td>
						<td style="    width: 10%;">
							<a href="<?php echo base_url('/admin/booking/details/'). $value->id ; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" role="button"><i class="material-icons">remove_red_eye</i></a>
						</td>
					</tr>
					<?php }} ?>
				</tbody>
			</table>
			
		</div>
	</div>
</div>

<link href='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.css' rel='stylesheet' media='screen'>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/jquery.dataTables.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/dataTables.buttons.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.flash.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/jszip.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/pdfmake.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.html5.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.print.min.js'></script>
<div class="form-group">
</div>


<script type="text/javascript">
$(function () {
$('.js-basic-example').DataTable({
responsive: true
});
//Exportable table
$('.js-exportable').DataTable({
dom: 'Bfrtip',
order:[[0,"DESC"]],
responsive: true,
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]
});
});
</script>

<style type="text/css">
.dataTables_wrapper .dt-buttons {
    float: left;
    display: block;
}
.pagination > li:first-child > a, .pagination > li:last-child > a{
    height: 34px;
}
.pagination>li:first-child>a, .pagination>li:first-child>span {
    margin-left: 0;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    }
.pagination > li > a {
    border: none;
    font-weight: bold;
    color: #555;
}

.pagination > li > a, .pagination > li > span {
    position: relative;
    float: left;
    padding: 6px 12px;
    margin-left: -1px;
    line-height: 1.42857143;
    color: #337ab7;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #ddd;
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
</style>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">