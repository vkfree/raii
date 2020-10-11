
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

<a style="width:150px;border-radius:5px;padding: 5px 0px;background-color:#e75982 !important;font-weight: bold;" href="<?php echo base_url();?>admin/user/export_users" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"  style="font-weight: bold;">Export Survey Data</a>
</div>

<table class="table table-bordered table-striped table-hover dataTable js-exportable">
<thead>
<tr>
<th>Id</th>
<th>Name</th>
<th>Rewards</th>
<th>Question Count</th>
<th>Type</th>
<th>Created At</th>
<th style="width: 90px;">Actions</th>
</tr>
</thead>

<tbody>
<?php
foreach($udata as $row)
{
?>
<tr>
<td><?php echo $row['survey_id'];?></td>
<td><?php echo $row['survey_name'];?></td>
<td><?php echo $row['rewards'];?></td>
<td><?php echo $row['question_count'];?></td>
<td><?php echo $row['type'];?></td>
<td><?php echo $row['created_at'];?></td>
<td class="actions">
   <a style="width: 30px;" href="<?php echo base_url();?>admin/survey/edit/<?php echo en_de_crypt($row['id'],'e');?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-pencil"></i></a>
   <a style="width: 30px;" onclick="return confirm('Are you Sure');" href="<?php echo base_url();?>admin/survey/deleteSurvey/<?php echo en_de_crypt($row['id'],'e');?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button"> <i class="glyphicon glyphicon-trash"></i></a>
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


