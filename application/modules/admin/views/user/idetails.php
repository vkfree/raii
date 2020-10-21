



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
		                    <div class="panel-footer">Profile</div>
		                    <div class="panel-body">
		                        <table class="table table-bordered">  

		                               <tbody> 
		                                <?php
		                               foreach($order_history as $row){

		                             
		                               	$name = $row['name'];
		                               	$email = $row['email'];
		                               	$mobile_no = $row['mobile_no'];
		                               	$delivery_address = $row['delivery_address'];
		                               	$delivery_locality = $row['delivery_locality'];
		                               	$delivery_city = $row['delivery_city'];
		                               	$delivery_state = $row['delivery_state'];
		                               	$delivery_country = $row['delivery_country'];
		                               	$patient_height = $row['patient_height'];
		                               	$patient_weight = $row['patient_weight'];
		                               	$dateof_birth = $row['patient_birth_of_date'];
		                                   //print_r($name);
		                              

		                                ?> 
		                                   <tr> 
		                                      <th>Name:</th>
		                                     <td><?php echo $name; ?></td>
		                                  </tr>
		                                  <tr> 
		                                      <th>Email:</th>
		                                     <td><?php echo $email; ?></td>
		                                  </tr>

		                                   <tr>
		                                     <th>Mobile No.:</th>
		                                     <td>+<?php  echo $mobile_no; ?> <?php echo $target->phone; ?></td>
		                                   </tr>

		                                  <tr>
		                                     <th>Address:</th>
		                                     <td><?php echo $delivery_address; ?><br/><?php echo $delivery_locality; ?></td>
		                                   </tr>

		                                    <tr>
		                                     <th>Country:</th>
		                                     <td><?php echo $delivery_country; ?></td>
		                                   </tr>

		                                    <tr>
		                                     <th>State:</th>
		                                     <td><?php echo $delivery_state; ?></td>
		                                   </tr>

		                                   <tr>
		                                     <th>City:</th>
		                                     <td><?php echo $delivery_city; ?></td>
		                                   </tr> 
		                                   <tr>
		                                   	<th>Date Of Birth</th>
		                                   	<td><?php echo $dateof_birth;?></td>
		                                   	<tr>
		                                   		<th>Height</th>
		                                   		<td><?php echo $patient_height;?></td>
		                                   	</tr>
		                                   </tr>
		                                   <tr>
		                                   	<th>Weight</th>
		                                   	<td><?php echo 	$patient_weight;?></td>
		                                   </tr>
		                                   <?php } ?>
		                               </tbody>
		                             </table>       
			                    </div>
			                 </div>
			               </div>
			               <div class="col-md-6">
			                <div class="panel panel-default " >
			                    <div class="panel-footer">Order History</div>
			                    <div class="panel-body">
			                        <table class="table table-bordered">                              
			                               <tbody> 
			                               <tr>
			                                      <th>Order Date:</th>
			                                      <th>Name Of Order:</th>
			                                      <th>Quantity:</th>
			                                      <th>Order Notes:</th>
			                               </tr>
                                          <?php
                                          // print_r($insurance_data);
                                        
                                          
			                               foreach($order_history as $row){

			                               	//print_r($row);
			                               	$order_datetime = $row['order_datetime'];
			                               	$name = $row['name_of_order'];
			                               	$qty = $row['qty_dosage'];
			                               	$notes = $row['order_notes'];
			                                   //print_r($name);
			                               

			                                ?>

 
			                                    <tr> 
			                               
			                                     <td style="background-color: #2196F3; color: white;"><?php echo date('d M Y', strtotime($order_datetime)); ?></td>
			                                 
			                                    
			                                     <td><?php echo $name; ?></td>
			                                

			                                     <td><?php echo $qty; ?></td>
			                                 
			                                    
			                                     <td><?php  echo $notes; ?></td>
			                                   </tr>
			                                   <?php }  ?>
			                               </tbody>
			                             </table>		                             
					                    </div>
					                 </div>
					               </div>
					               
					         </div>

		            <div class="x_content row" >
		               <p class="text-muted font-13 m-b-30"></p>
		         
		               <div class="col-md-6">
		              		                 <div class="panel panel-default " >
		              		                    <div class="panel-footer">Prescription Images</div>
		              		                    <div class="panel-body">


		              		                    	<script type="text/javascript">$(document).ready(function(){ options = ['button','navbar','title','toolbar','tooltop','movable','zoomable','rotatable','scalable','transition','fullscreen','keyboard']; $('.images').viewer({url: 'data-original',navbar : false}); });</script>


		              		                       <div>
		              		                       <ul class="images">
		              		                        <?php 

		              		                        //print_r($prescription_Pre);

		              		                        foreach($prescription_Pre as $row1){

		              		                        	//print_r($row);
		              		                          $prescription_img = $row1['prescription_img']; 

                                                       }
		              		                          if (!empty($prescription_img)) {
		              		                          	# code...
		              		                          

		              		                          $b = explode(",", $prescription_img) ;	

		              		                          foreach ($b as  $prescription_img1) {

		              		                          	//print_r($insurance_img);
		                                                   

		              		                          ?>
		              		                     
		              		                         <img class="image" src="<?php echo base_url('assets/admin/prescription/')?><?php echo $prescription_img1; ?>" alt="Images Not Available" style="max-width: 28%; height: 30%;">
		              		                     
		              		                       <?php } } ?>
		              		                        </ul>
		              		                       </div>
		                 

		              		                     <!--   <div>
		              		                         <ul class="images">
		              		                           <li><img src="<?php echo base_url('assets/admin/prescription/')?>pre.jpg"  alt="Picture"></li>
		              		                         </ul>
		              		                       </div> -->
		              		                            
		              		                    </div>
		              		                 </div>
		              <!-- 		                 <div class="panel panel-default " >
		              		                    <div class="panel-footer">Insurance Images</div>
		              		                    <div class="panel-body">


		              		                    	<script type="text/javascript">$(document).ready(function(){ options = ['button','navbar','title','toolbar','tooltop','movable','zoomable','rotatable','scalable','transition','fullscreen','keyboard']; $('.images').viewer({url: 'data-original',navbar : false}); });</script>
		              		                    	
		              		                       <div>
		              		                          <ul class="images">
		              		                          <?php  


		                                              //print_r($data_insur);
		              								foreach($data_insur as $row){

		              								$front_view = $row['front_view'];
		              								$back_view = $row['back_view'];
		              		                               

		              		                         }   
		               
		              		                         if (!empty($front_view))

		              		                         {

		              		                          $a = explode(",", $front_view) ;	

		              		                          foreach ($a as  $front_view) { 

		              		                          	//print_r($insurance_img);
		                                                   

		              		                          ?> 
		              		                          <label>front image</label>
		              		                       
		              		                         <img class="image" src="<?php echo base_url('assets/admin/insurance/')?><?php echo $front_view; ?>" alt="Images Not Available" style="max-width: 28%; height: 30%;">
		              		                         
		                                                 <?php } }

		                                                 if (!empty($back_view))

		                                                 {

		                                                 $b = explode(",", $back_view) ;	

		                                                 foreach ($b as  $back_view) { 

		                                                 ?> 
		                                                   <label>Back image</label>
		              		                           
		              		                         <img class="image" src="<?php echo base_url('assets/admin/insurance/')?><?php echo $back_view; ?>" alt="Images Not Available" style="max-width: 28%; height: 30%;">
		              		                        
		              		                         <br><br>
		              		                        <?php } }?>
		              		                          </ul>
		              		                       </div>
		              		                 

		              		                     <!--   <div>
		              		                         <ul class="images">
		              		                           <li><img src="<?php echo base_url('assets/admin/prescription/')?>pre.jpg"  alt="Picture"></li>
		              		                         </ul>
		              		                       </div> -->
		              		                            
		              		                    </div>
                              

        		                 <div class="col-md-6">
        		                 <div class="panel panel-default " >
        		                    <div class="panel-footer">Insurance Information</div>
        		                    <div class="panel-body">
        		                      <table class="table table-bordered">  
        		                      <tr>    
        		                      <th>Insurance Name</th>
        		                      <th>Insurance Number</th>
        		                      <th>Front Image</th>
        		                      <th>Back Image</th>				                      	
        		                      </tr> 
        		                
                                     <tbody> 
                                      <?php //print_r($data_insur);

                                      if (!empty($insurance_data)) {
                                      	# code...
                                      

                                      foreach($insurance_data as $row){

                                      	//print_r($row);
                                      	$name = $row['name'];
                                      	$number = $row['number'];
                                      	$front_view = $row['front_view'];
                                      	$back_view = $row['back_view'];
                                          //print_r($name);
                                      

                                       ?>
        								<tr>
        								<td><?php echo $name; ?></td>
        								<td><?php echo $number; ?></td>
        								<td><?php echo $front_view; ?></td>
        								<td><?php echo $back_view; ?></td>
        								</tr>
                                      <?php } } ?>
                                     </tbody>
                                   </table>
                                   </div>
           		                    <div class="panel-body">


           		                    	<script type="text/javascript">$(document).ready(function(){ options = ['button','navbar','title','toolbar','tooltop','movable','zoomable','rotatable','scalable','transition','fullscreen','keyboard']; $('.images').viewer({url: 'data-original',navbar : false}); });</script>
           		                    	
           		                       <div>
           		                          <ul class="images">
           		                          <?php  


                                           //print_r($data_insur);
           								foreach($insurance_data as $row){

           								$front_view = $row['front_view'];
           								$back_view = $row['back_view'];
           		                               

           		                         }   
            
           		                         if (!empty($front_view))

           		                         {

           		                          $a = explode(",", $front_view) ;	

           		                          foreach ($a as  $front_view) { 

           		                          	//print_r($insurance_img);
                                                

           		                          ?> 
           		                          <label>front image</label>
           		                       
           		                         <img class="image" src="<?php echo base_url('assets/admin/insurance/')?><?php echo $front_view; ?>" alt="Images Not Available" style="max-width: 28%; height: 30%;">
           		                         
                                              <?php } }

                                              if (!empty($back_view))

                                              {

                                              $b = explode(",", $back_view) ;	

                                              foreach ($b as  $back_view) { 

                                              ?> 
                                                <label>Back image</label>
           		                           
           		                         <img class="image" src="<?php echo base_url('assets/admin/insurance/')?><?php echo $back_view; ?>" alt="Images Not Available" style="max-width: 28%; height: 30%;">
           		                        
           		                         <br><br>
           		                        <?php } }?>
           		                          </ul>
           		                       </div>
           		                 

           		                     <!--   <div>
           		                         <ul class="images">
           		                           <li><img src="<?php echo base_url('assets/admin/prescription/')?>pre.jpg"  alt="Picture"></li>
           		                         </ul>
           		                       </div> -->
           		                            
           		                    </div>
        		                 </div>
        		               </div>

					               
					         </div>

					      </div>
					   </div>

					</div>
				</div>
			</div>
		</div>
