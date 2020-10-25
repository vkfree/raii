
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

<table class="table table-bordered table-striped table-hover dataTable js-exportable">
<thead>
<tr>
<th>Id</th>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Status</th>
<th>Created Ats</th>
<th style="width: 90px;">Actions</th>
</tr>
</thead>

<tbody>
<?php
foreach($udata as $row)
{
?>
<tr>
<td><?php echo @$row['id'];?></td>
<td><img src="<?php echo base_url('assets/admin/store/').@$row['image'];?>" width="100" height="100"></td>
<td><?php echo @$row['name'];?></td>
<td><?php echo @$row['price'];?></td>
<td><?php echo @$row['status'];?></td>
<td><?php echo @$row['created_at'];?></td>
<td class="actions">
   <a style="width: 30px;" href="<?php echo base_url();?>admin/rewards/edit/<?php echo en_de_crypt($row['id'],'e');?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-pencil"></i></a>
   <a style="width: 30px;" onclick="return confirm('Are you Sure');" href="<?php echo base_url();?>admin/rewards/deleteSurvey/<?php echo en_de_crypt($row['id'],'e');?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-trash"></i></a>
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


