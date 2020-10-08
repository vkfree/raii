<link href='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.css' rel='stylesheet' media='screen'>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/jquery.dataTables.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/dataTables.buttons.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.flash.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/jszip.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/pdfmake.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.html5.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.print.min.js'></script>
<form action="<?php echo base_url(); ?>admin/panel/vendor_user" method="GET">
<div class="row">
  <div class="col-md-3">
      <select  name="category" class="form-control">
        <option value='' selected="selected">Select Category</option>
          <?php
          $cat_arr = array();
           foreach ($category_data as $vkey => $vvalue) {
            $cat_arr[$vvalue['slug']] = $vvalue['display_name'];
              $chseller_id = ($category == $vvalue['slug'] ) ? "selected" : "";
              ?>
              <option value="<?php echo $vvalue['slug']; ?>" <?php echo $chseller_id; ?>><?php echo $vvalue['display_name']; ?></option>
              <?php
          } ?>
      </select>
  </div>
  <div class="col-md-3">
      <select class="form-control show-tick"  name="plan">
        <option value='' selected="selected" >Select Plan</option>
        <option value='platinum' <?php if($plan == 'platinum') echo "selected";?> >Platinum</option>
        <option value='gold' <?php if($plan == 'gold') echo "selected";?> >Gold</option>
        <option value='silver' <?php if($plan == 'silver') echo "selected";?> >Silver</option>
      </select>
  </div>
  <div class="col-md-2">
    <button class="btn btn-success form-control waves-effect" style="height: 41px;" type="SUBMIT">SUBMIT</button>
  </div>
  <div class="col-md-1">
    <button onclick="location.href='<?php echo base_url();?>admin/panel/vendor_user'" class="btn bg-red waves-effect form-control" style="height: 41px;" type="reset"><i class="material-icons">close</i></button>
  </div>
</div>
</form>

<table class="table table-bordered table-striped table-hover dataTable js-exportable" style="overflow: auto;">
<thead>
<tr>
<th>Id</th>
<th>username</th>
<th>first_name</th>
<th>last_name</th>
<th>Email</th>

</tr>
</thead>

<tbody>
<?php
foreach($data_list as $row){
 ?>

<tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->username; ?></td>
<td><?php echo $row->first_name; ?></td>
<td><?php echo $row->last_name; ?></td>
<td><?php echo $row->email; ?></td>
<td><?php 
if ($row->active) {
  echo 'active';
}
else{
  echo "Deactive";
}  ?></td>
<td class="actions">
  <a href="<?php echo base_url();?>admin/panel/admin_user_reset_password/<?php echo $row->id; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float fa fa-repeat" role="button">
    <i class="material-icons">refresh</i>
  </a>
  <!-- <a href="<?php echo base_url();?>admin/panel/tedit/<?php echo $row->id; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float " role="button">
    <i class="material-icons">translate</i>
  </a> -->
 <!--  <a href="<?php echo base_url();?>admin/panel/edit/<?php echo $row->id; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float fa fa-repeat" role="button">
    <i class="material-icons">edit</i>
  </a> -->
  <!-- <a data-url="<?php echo base_url();?>admin/panel/delete/<?php echo $row->id; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float delete_row_re" role="button" data-type="cancel">
  <i class="material-icons">delete</i>
  </a> -->
</td>
</tr>

<?php } ?>
</tbody>
</table>


<script type="text/javascript">
// 	$(function () {
//     $('.js-basic-example').DataTable({
//         responsive: true
//     });

//     //Exportable table
//     $('.js-exportable').DataTable({
//         dom: 'Bfrtip',
//         responsive: true,
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print' 
//         ]
//     });
// });
</script>
<style type="text/css">
  form {
    display: none;
}
</style>