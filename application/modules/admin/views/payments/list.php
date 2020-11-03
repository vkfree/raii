
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
<th>Name of store</th>
<th>Price</th>
<th>User Name</th>
<th>Email</th>
<th>Phone</th>
<th>Created Ats</th>
</tr>
</thead>

<tbody>
<?php
if(!empty($store_order))
{
foreach($store_order as $row)
{
?>
<tr>
<td><?php echo @$row['id'];?></td>
<td><?php echo @$row['name_of_store'];?></td>
<td><?php echo @$row['price'];?></td>
<td><?php echo @$row['name_of_user'];?></td>
<td><?php echo @$row['email'];?></td>
<td><?php echo @$row['phone'];?></td>
<td><?php echo @$row['created_date'];?></td>
</tr>
<?php }}?>
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


