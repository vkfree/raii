<style type="text/css">
  .table-image{
    width: 100px;
    height: 100px;
  }
  #imgdiv{
    display: none;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
        $('#upload_csv_file').change(function(e){
            var validExtensions = ['csv'];
            var fileName = e.target.files[0].name;
            var fileNameExt = fileName.substr(fileName.lastIndexOf('.') + 1);
            if ($.inArray(fileNameExt, validExtensions) == -1){
               swal("warning","Invalid File type please select csv only");
               $('#upload_csv_file').val('');
               $("#upload_csv_file").uploadifyCancel(q);
               return false;
            }
        });

});

      $(document).on('change', '#category_image', function(){
          var name = document.getElementById('category_image').files[0].name;
          var oFReader = new FileReader();
          var form_data = new FormData();
          oFReader.readAsDataURL(document.getElementById('category_image').files[0]);
          var f = document.getElementById('category_image').files[0];
          var fsize = f.size||f.fileSize;
          if(fsize > 90000000)
            {
                alert("Image File Size is very big");
            }
          else
            {
             
              form_data.append("file", document.getElementById('category_image').files[0]);
              $.ajax({
                 url:"<?php echo base_url('home/uploadImageDataCategory');?>",
                 method:"POST",
                 data: form_data,
                 contentType: false,
                 cache: false,
                 processData: false,
                 beforeSend:function(){
                    
                    // $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                  },
                 
                 success:function(data){
                 if(data=="Error"){
                   swal("Invalid File !", "Please Choose Image Only !", "error");
                 }
                 else{
                          $("#imgdiv").toggle();
                          var path="<?php echo base_url('assets/frontend/images/category/')?>"+data;
                          $("#myImageDiv").html('<img src="'+path+'" style="width: 200px;height: 200px;padding: 30px;">');
                          swal({
                                      title: "Following image selected",
                                      text: "<img src='" +path+ "' style='width:150px;'>",
                                      html: true,
                              });
                   } 
                 } 

              });
            }
      });


</script>
<div class="row">
       <?php if($this->session->flashdata('msg')=="success"){ ?>
                  <div class="alert-success-123">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> <?php echo $this->session->flashdata('msg_text');?>
                  </div>
                  <?php }else if($this->session->flashdata('msg')=="error"){ ?>
                         <div class="alert-danger-123">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> <?php echo $this->session->flashdata('msg_text');?>
                        </div>
                  <?php }else if($this->session->flashdata('msg')=="image_error"){?>
                          <div class="alert-primary-123">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> <?php echo $this->session->flashdata('msg_text');?>
                        </div>
                  <?php }?> 

   <div class="col-sm-6">
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading">
            <div class="panel-title">
                <?php if(!isset($_GET['id'])):?>
                     <h4>Add User </h4>
                <?php else:?>
                    <h4>Edit User </h4>
                     <div style="text-align: right;">
                        <a class="service-image" href="<?php echo base_url("admin/user/user");?>"> <button type="submit" class="btn btn-success">Back to list </button> </a>
                     </div>  
                <?php endif;?>
            </div>
         </div>
         <form action="" class="form-vertical" id="validate" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
            <div class="panel-body">
              <div class="form-group row">
                  <label for="full_name" class="col-sm-3 col-form-label">Full Name / Traders Name<i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="name" id="name" type="text" placeholder="Full Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->name; }?>" class="full_name space" required="" autocomplete="off">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="address" class="col-sm-3 col-form-label">Address <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="address" id="address" type="text" placeholder="address Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->address; }?>" class="address space" required="" autocomplete="off">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="phone" class="col-sm-3 col-form-label">Phone <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="phone" id="phone" type="text" placeholder="phone Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->phone; }?>" class="phone space" required="" autocomplete="off">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="city" class="col-sm-3 col-form-label">city <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="city" id="city" type="text" placeholder="city Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->city; }?>" class="city space" required="" autocomplete="off">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="country" class="col-sm-3 col-form-label">Country Name <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="country" id="country" type="text" placeholder="Category Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->country; }?>" class="country space" required="" autocomplete="off">
                  </div>
               </div>

               <div class="form-group row">
                  <label for="state" class="col-sm-3 col-form-label">State Name <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];} ?>">
                     <input name="state" id="state" type="text" placeholder="Category Name" value="<?php if(isset($_GET['id'])){ echo $users[0]->state; }?>" class="state space" required="" autocomplete="off">
                  </div>
               </div>
                
                <div class="form-group row">
                  <label for="state" class="col-sm-3 col-form-label">Type <i class="text-danger">*</i></label>
                  <div class="col-sm-6">
                     <select class="form-control" name="type">
                       <option value="0">Select</option>
                       <option value="traders">Traders</option>
                       <option value="user">User</option>
                     </select>
                  </div>
               </div>
                
                

               <div class="form-group row">
                  <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-6">
                     <input type="submit" id="add-customer" class="btn btn-success btn-large add_customer" name="add-customer" value="<?php if(!isset($_GET{'id'})){ ?>Save<?php }else{?>Update<?php }?>" autocomplete="off">
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div> 
   <div class="col-sm-6" style="<?php if(!empty($_GET['id'])){ ?>display: none;<?php }?>">
       <div class="panel panel-bd lobidrag manage_height">
         <div class="panel-heading">
            <div class="panel-title">
                <h4>Import Categories</h4>
            </div>
         </div>
         <form action="<?php echo site_url('admin/medicine/import');?>" class="form-vertical" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <div class="panel-body">
               <div class="form-group row" style="padding-top: 12px;">
                  <label for="category_name" class="col-sm-3 col-form-label">Upload CSV<i class="text-danger">*</i></label>
                  <div class="col-sm-6 upload_csvimg">
                  <input type="hidden" name="type" value="category">
                  <input class="form-control" name="upload_csv_file" type="file" id="upload_csv_file" placeholder="Upload CSV File"  autocomplete="off" accept=".csv" required>
                  </div>
               </div>
               <div class="form-group row">
                 <div class="col-sm-3">
                  </div>
                  <div class="col-sm-8">
                    <input type="submit" id="add-customer" class="btn btn-success btn-large import_cat" name="import" value="Import" autocomplete="off">
                    <a class="btn btn-warning csv_format" href="<?php echo site_url("assets/category.csv")?>" donload>Download CSV Format To Upload</a>
                  </div>
               </div>
          </div>     
         </form>
        </div>  
   </div>
</div>
<!-- Manage Category -->

<div class="row display_data" <?php if(isset($_GET['id'])){?> style="display:none;"<?php } ?>>
   <div class="col-sm-12">
      <div class="panel panel-bd lobidrag">
         <div class="panel-heading">
            <div class="panel-title">
               <h4>Manage Category</h4>
            </div>
         </div>
         <div class="panel-body">
          
            <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
              <thead>
              <tr>
                  <th>Sr</th>
                  <th>User Name</th>
                  <th>Phone</th>
                  <th>City</th>
                  <th>Country</th>
                  <th>State</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
                <?php if(!empty($users)){$cnt=0;?>
                <?php foreach($users as $row): $cnt++;?>
                  <tr>
                    <td><?php echo $cnt;?></td>
                    <td><?php echo $row->name;?></td>
                    <td><?php echo $row->address;?></td>
                    <td><?php echo $row->phone;?></td>
                    <td><?php echo $row->city;?></td>
                    <td><?php echo $row->country;?></td>
                    <td><?php echo $row->state;?></td>
                  </tr>  
                <?php endforeach;?> 
                <?php }?> 
              </tbody>
            </table>    

           
         </div>
      </div>
   </div>
</div>

<!-- css page -->
<style type="text/css">
    input.category_name,.full_name,.address,.phone,.city,.country,.state,.type{
        width: 100%;
        padding: 10px 10px;
        margin-top: 00px;
        border: 1px solid #cdcdcd;
        border-radius: 4px;
    }
    .lobidrag{
         border: 1px solid #e1e6ef;

    }
    .image_upload{
          width: 46%;
          padding: 10px 10px;
          margin-left: 13px;
          border: 1px solid #cdcdcd;
          border-radius: 4px;
        }
      .add_customer{
          width: 24%;
          font-size: 14px;
          padding: 9px 10px;
          font-weight: 400;
          line-height: 1.42857143;
          text-align: center;
          white-space: nowrap;
          vertical-align: middle;
        }
        .upload_csvimg{
          padding: 5px 10px 5px 13px;
          border: 1px solid #cdcdcd;
          border-radius: 4px;
        }
        .manage_height{
          height: 350px;
          max-height: 350px;
        }
        .import_cat{
          width: 24%;
          font-size: 14px;
          padding: 9px 10px;
          font-weight: 400;
          line-height: 1.42857143;
          text-align: center;
          white-space: nowrap;
          vertical-align: middle;
          margin-left: -10px;
        }
        .csv_format{
          font-size: 14px;
          padding: 10px;
          width: 64%;
        }
</style>

<link href='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.css' rel='stylesheet' media='screen'>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/jquery.dataTables.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/dataTables.bootstrap.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/dataTables.buttons.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.flash.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/jszip.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/pdfmake.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.html5.min.js'></script>
<script src='<?php echo base_url(); ?>assets/grocery_crud/themes/datatables/jquery-datatable/extensions/buttons.print.min.js'></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.dataTable').dataTable( {
  "lengthChange": false,
  "order": [[ 0, "desc" ]]
});
} );

</script>