
<div class="container" style="width: 100%;overflow: hidden;">
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-hover dataTable js-exportable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Driver Name</th>
						<th>Available</th>
						<th>Vehicle type</th>
						<th>Mobile</th>
						<th>Total Rides</th> 
						<th>Total Earning</th>
<!--					<th>Joined at</th>-->
                        <th style=" width: 10%;">Details</th>
					</tr>
				</thead>
				<?php //print_r($response); ?>
				<tbody>
					<?php if (!empty($response)) {
					foreach ($response as $key => $value) { ?>
					<tr>
						<td><?php echo $value['id'] ?></td>
						<td><?php echo $value['first_name'] ?></td>
						<td>
							<?php if ($value['notification'] == "available") { ?>
								<span class="tag tag-success">
								<?php echo $value['notification']; ?>
								</span>
							<?php } ?>
							<?php if ($value['notification'] == "unavailable") { ?>
								<span class="tag tag-info">
								<?php echo $value['notification']; ?>
								</span>
							<?php } ?>
						</td>
						<td><?php echo $value['vehicle'] ?></td>
						<td><?php echo $value['phone'] ?></td>
						<td><?php echo $value['total_rides']; ?></td>
						<td><?php echo $value['total_price']; ?></td>
						<!--<td> <?php // echo $value['created_on']; ?> </td>-->
						<td style="">
							<a href="<?php echo base_url('/admin/statement/driver_details/'). $value['id'] ; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" role="button">
								<i class="material-icons">remove_red_eye</i>
							</a>
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
.tag-success {
    background-color: #43b968;
}
.tag-info {
    background-color: #5bc0de;
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
</style>



