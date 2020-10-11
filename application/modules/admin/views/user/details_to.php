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
		      <div class="col-md-12 col-sm-12 col-xs-12">
		         <div class="x_panel">
		            <div class="x_title">
		               <h3>User Name:
		               <span class="" style="font-size: 16px; color:#2A3F54"> <?php echo $target->username; ?></span></h3>               
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
		                                     <td><?php echo @$target->first_name.' '.$target->last_name; ?></td>
		                                  </tr>
		                                  <tr> 
		                                      <th>Email:</th>
		                                     <td><?php echo $target->email; ?></td>
		                                  </tr>

		                                   <tr>
		                                     <th>Mobile No.:</th>
		                                     <td>+<?php  echo $target->country_code; ?> <?php echo $target->phone; ?></td>
		                                   </tr>

		                                  <tr>
		                                     <th>Address:</th>
		                                     <td><?php echo $target->address_1; ?><br/><?php echo $target->address_2; ?></td>
		                                   </tr>

		                                    <tr>
		                                     <th>Country:</th>
		                                     <td><?php echo $target->country; ?></td>
		                                   </tr>

		                                    <tr>
		                                     <th>State:</th>
		                                     <td><?php echo $target->state; ?></td>
		                                   </tr>

		                                   <tr>
		                                     <th>City:</th>
		                                     <td><?php echo $target->city; ?></td>
		                                   </tr>  
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