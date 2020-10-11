<div class="row clearfix">
	<div class="col-md-12">
		<div class="right_col" role="main" id="order">

		    <?php if (!empty($msg)) { ?>
		    <div class="alert <?php echo $msg['response']; ?>">
		      <p><?php echo $msg['msg']; ?></p> 
		    </div>
		    <?php } ?>

		   <div class="clearfix"></div>
		   <div class="row">
		   	  <div style="text-align: right;">
              		<a class="service-image" href="<?php echo base_url("admin/user");?>"> <button type="submit" class="btn btn-success">Back to Users list </button> </a>
         	  </div>

		      <div class="col-md-12 col-sm-12 col-xs-12">
		         <div class="x_panel">
		            <div class="x_title">
		               <h3>User Name:
		               <span class="" style="font-size: 16px; color:#2A3F54"> <?php echo $target[0]['username']; ?></span></h3>               
		               <ul class="nav navbar-right panel_toolbox">
		                 <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		               </ul>
		               <div class="clearfix" ></div>
		            </div>
		            <div class="x_content row" >
		               <p class="text-muted font-13 m-b-30"></p>
		               <div class="col-md-6">
		                 <div class="panel panel-default " >
		                    <div class="panel-footer">Address Details</div>
		                    <div class="panel-body">
		                        <table class="table table-bordered">                              
		                               <tbody> 
		                                   <tr> 
		                                      <th>Name:</th>
		                                     <td><?php echo @$target[0]['first_name'].' '.$target[0]['last_name']; ?></td>
		                                  </tr>
		                                  <tr> 
		                                      <th>Email:</th>
		                                     <td><?php echo $target[0]['email']; ?></td>
		                                  </tr>

		                                   <tr>
		                                     <th>Mobile No.:</th>
		                                     <td><?php echo $target[0]['phone']; ?></td>
		                                   </tr>

                                          <?php if(!empty($target[0]['country'])){ ?>
		                                  <tr>
		                                     <th>Country:</th>
		                                     <td><?php echo $target[0]['country']; ?></td>
		                                   </tr>
                                          <?php }?>
                                          
                                        <?php if(!empty($target[0]['state'])){ ?>
		                                <tr>
		                                     <th>State:</th>
		                                     <td><?php echo $target[0]['state']; ?></td>
		                                </tr>
                                        <?php }?>
                                        
                                       <?php if(!empty($target[0]['source'])){ ?>
		                               <tr>
		                                     <th>Source:</th>
		                                     <td><?php echo $target[0]['source']; ?></td>
		                               </tr>
		                               <?php }?>
		                               
		                               </tbody>
		                             </table>
		                    </div>
		                 </div>
		               </div>
		               
		         </div>
		      </div>
		   </div>
		</div>
	</div>
</div>