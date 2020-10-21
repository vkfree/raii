
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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

<a style="width:150px;border-radius:5px;padding: 5px 0px;background-color:#e75982 !important;font-weight: bold;" href="<?php echo base_url();?>admin/user/export_users" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"  style="font-weight: bold;">Export Users Data</a>
</div>

<table class="table table-bordered table-striped table-hover dataTable js-exportable">
<thead>
<tr>
<th>Id</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Source</th>
<th>Total Orders</th>
<th>Last Order</th>
<th style="width: 66px;">Actions</th>
<th>Exports</th>
</tr>
</thead>

<tbody>
<?php
foreach($udata as $row)
{
?>
<tr>
<td><?php echo $row['id'];?></td>
<td><?php echo $row['first_name']." ".$row['last_name'];?></td>
<td><?php echo $row['email'];?></td>
<td><?php echo $row['phone'];?></td>
<td><?php echo $row['source'];?></td>
<td><?php echo $row['orders_count'];?></td>
<?php if($row['last_order'] != ''){ ?>
<td><?php echo date("Y-m-d ",strtotime(@$row['last_order'])); ?></td>
<?php } else { ?>
  <td>--</td>
<?php } ?>
<td class="actions">
   <a style="width: 30px;" href="<?php echo base_url();?>admin/user/details/<?php echo $row['id']?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-eye-open"></i></a>
</td>
<td>
  <a style="width:100px" href="<?php echo base_url();?>admin/user/export_user_orders/<?php echo $row['id']?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"  style="font-weight: bold;">Export Order</a>  
</td>
</tr>
<?php }?>
</tbody>
</table>


<script type="text/javascript">
//onClick="window.print()"

  $(function () {
    $('.js-basic-example').DataTable({
        responsive: true,
        "order": [[ 0, "desc" ]],
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "order": [[ 5, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
<style type="text/css">
  .card .body .col-xs-6{
    margin-bottom: 0px;
  }
</style>


