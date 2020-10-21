<?php echo $form->messages();

$first_name = $username = $password = $streat = $email = $locality = $landmark = $pincode = $state = $country = $commision = $phone = $whatsapp = $telephone = $active =  $plan = $payment_mode = $start_date = $end_date = $logo = $last_name = $file = '';
$bnumber = 1;
if (isset($edit)) {
$first_name = $edit['first_name'];

$username = $edit['username'];
$password = $edit['password'];
$streat = $edit['streat'];
$email = $edit['email'];
$locality = $edit['locality'];
$landmark = $edit['landmark'];
$pincode = $edit['pincode'];
$state = $edit['state'];
$country = $edit['country'];
$commision = $edit['commision'];
$phone = $edit['phone'];
$whatsapp = $edit['whatsapp'];
$telephone = $edit['telephone'];
$first_name = $edit['first_name'];
$plan = $edit['plan'];
$payment_mode = $edit['payment_mode'];
$start_date = $edit['start_date'];
$end_date = $edit['end_date'];
$logo = $edit['logo'];
$active = $edit['active'];
}
$credit_fee = !empty($transaction_creadit_fee)? $transaction_creadit_fee[0]['meta_value']:'';
$debit_fee = !empty($transaction_debit_fee)? $transaction_debit_fee[0]['meta_value']:'';
$required = '';
$required1 = '';
?>
<div class="row clearfix">
	<div class="col-md-12">
		<div class="demo-masked-input">
	<?php echo $form->open(); ?>
		<h3 tabindex="1">Basic Information</h3>
		<fieldset class="my_fieldset" tabindex="1">
			<?php echo $form->bs3_text('*Name', 'first_name', $first_name, array($required => '')); ?>
			<!-- <div class="form-group form-float form-group-lg">
				<div class="form-line">
					<input name="email" placeholder="*Email" id="email" class="form-control " pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" type="text">
				</div>
			</div> -->

			<?php echo $form->bs3_email('*Email', 'email', $email, array($required => '', 'class' => 'chkemail', 'pattern' => '/^([a-zA-Z0-9_.+-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/')); ?>
			<div class="row">
				<div class="col-sm-6 ">
					<?php echo $form->bs3_text('*Streat', 'streat', $streat, array($required => '')); ?>
				</div>
				<div class="col-sm-6">
					<?php echo $form->bs3_text('*Locality', 'locality', $locality, array($required => '')); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 ">
					<?php echo $form->bs3_text('*Landmark', 'landmark', $landmark, array($required => '')); ?>
				</div>
				<div class="col-sm-6 ">
					<?php echo $form->bs3_text('*Postal code', 'pincode', $pincode, array($required => '', 'maxlength' => '10', 'minlength' => '3')); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 ">
					<?php echo $form->bs3_text('*State', 'state', $state, array($required => '')); ?>
				</div>
				<div class="col-sm-6 ">
					<?php echo $form->bs3_text('*Country', 'country', $country, array($required => '')); ?>
				</div>
			</div>
			<div class="col-sm-12 admin_crt">
			<label for="groups">Contact details</label>
			</div>
			<div class="col-sm-4 admin_crt">
				<?php echo $form->bs3_text('*Phone number', 'phone', $phone, array('pattern' => '.{7,10}',$required => '', 'onkeypress' => 'return isNumberKey(event)', 'maxlength' => '16', 'minlength' => '6')); ?>
			</div>
			<div class="col-sm-4 ">
				<?php echo $form->bs3_text('What\'s app number', 'whatsapp', $whatsapp, array('pattern' => '.{7,10}', 'onkeypress' => 'return isNumberKey(event)', 'maxlength' => '16', 'minlength' => '6')); ?>
			</div>
			<div class="col-sm-4 admin_crt">
				<?php echo $form->bs3_text('Telephone number', 'telephone', $telephone, array('pattern' => '.{7,10}', 'onkeypress' => 'return isNumberKey(event)', 'maxlength' => '16', 'minlength' => '6')); ?>
			</div>
			<div class="col-sm-12 admin_crt">
			<label for="groups">*Logo</label>
			</div>
			<div class="col-sm-3" style="padding-left: 15px;">
	            <input type="hidden" name="file_name" id="file_name" value="" required="required" />
	            <div class="col-25">
	                <div class="col-inner">
	                    <input type="file" id="file" class="vendor-img" data-min="3" data-max="6" value="" name="file" required="required" />
	                    <label for="file" class="file__drop" data-min="3" data-max="6" data-image-uploader>
	                        <div class="dis-div-img" id="img_div">
	                        <img data-image src="<?php echo base_url('assets/admin/seller_img/'); ?>" style="position: absolute; width: 100px;height: 70px;" id="dis_image" />
	                        <div class="preloader pl-size-l" id="img_loader">
			                    <div class="spinner-layer pl-light-green">
			                        <div class="circle-clipper left">
			                            <div class="circle"></div>
			                        </div>
			                        <div class="circle-clipper right">
			                            <div class="circle"></div>
			                        </div>
			                    </div>
			                </div>
	                        </div>
	                        <span class="choose-image" id="choose-image">Click here to choose Vendor Image</span>
	                    </label>
	                </div>
	                <p>image size must be <br>(w-1273 * h-244) for platinum</p>
	            </div>
	        </div>

			<div class="col-sm-3" style="padding-left: 15px;">
	            <input type="hidden" name="file_name_gold" id="file_name_gold" value="" required="required" />
	            <div class="col-25">
	                <div class="col-inner">
	                    <input type="file" data-min="1" data-max="2" data-display="_gold" id="file_gold" value="" name="file_gold" style="display: none;" required="" />
	                    <label for="file_gold" class="file__drop" data-min="1" data-max="2" data-display="_gold" data-image-uploader-gold>
	                        <div class="dis-div-img" id="img_div_gold">
	                        <img data-image_gold src="<?php echo base_url('assets/admin/seller_img/'); ?>" style="position: absolute; width: 100px;height: 70px;" id="dis_image_gold" />
	                        <div class="preloader pl-size-l" id="img_loader_gold">
			                    <div class="spinner-layer pl-light-green">
			                        <div class="circle-clipper left">
			                            <div class="circle"></div>
			                        </div>
			                        <div class="circle-clipper right">
			                            <div class="circle"></div>
			                        </div>
			                    </div>
			                </div>
	                        </div>
	                        <span class="choose-image" id="choose-image_gold">Click here to choose Vendor Image</span>
	                    </label>
	                </div>
	                <p>image size must be <br>(w-408 * h-267) for gold & silver</p>
	            </div>
	        </div>
		</fieldset>
		<h3 tabindex="2">Branch Details</h3>
		<fieldset class="my_fieldset" tabindex="2">
			<div class="row">
				<div class="col-sm-5" style="margin-top: 15px;">
					<label>Does the vendor have any branches?</label>

					<input type="radio" name="branch" value="1" id="byes" class="with-gap radio-col-green" required>
					<label for="byes">Yes</label>
					<input type="radio" name="branch" value="0" id="bno" checked=checked class="with-gap radio-col-green" required>
					<label for="bno">No</label>
				</div>
			</div>
			<div class="row br-name">
				<div class="col-sm-5" style="margin-top: 15px;">
					<label>Does the branches have different name?</label>

					<input type="radio" name="branch_name" value="1" id="b_name_yes" class="with-gap radio-col-green" required>
					<label for="b_name_yes">Yes</label>
					<input type="radio" name="branch_name" value="0" id="b_name_no" checked=checked class="with-gap radio-col-green" required>
					<label for="b_name_no">No</label>
				</div>
				<div class="col-sm-2">
					<?php echo $form->bs3_text('Number', 'bnumber', '', array('onkeypress' => 'return isNumberKey(event)')); ?>

				</div>
				<div class="col-sm-1">
					<button class="btn bg-teal form-control waves-effect" type="button" id="branchgo">GO</button>
				</div>
			</div>
			<input type="hidden" name="branch_count" id="branch_count" value="0">
			<input type="hidden" name="branch_name_save" id="branch_name_save" value="0">
			<div id="baddresses">
			</div>
		</fieldset>
		<h3>Registration Details</h3>
		<fieldset class="my_fieldset" tabindex="3">
			<label for="username">Login Details</label>
			<?php echo $form->bs3_text('*Username', 'username',$username , array($required => '', 'class' => 'chkusername')); ?>
			<?php echo $form->bs3_password('*Password', 'password', $password  , array($required => '','minlength' => '6')); ?>
			<div class="row">
		<?php	if ( !empty($groups) && 0): ?>
				<div class="col-sm-6">
					<label for="groups">*Groups</label>
					<div>
					<?php foreach ($groups as $group): 
							if($group->name == "vendor" ) { ?>
							<input type="checkbox" name="groups[]" <?php echo $required ?> class="filled-in chk-col-light-green" id="<?php echo $group->id; ?>" value="<?php echo $group->id; ?>">
						<label for="<?php echo $group->id; ?>" style="margin-right: 30px;">
								<?php echo $group->name; ?>
						</label>
					<?php } endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			<input type="hidden" name="groups[]" id="" value="5">
				<div class="col-sm-12">
					<label for="category">*Vendor Type</label>
					<div>
					<?php if ( !empty($categories) ):

							foreach ($categories as $category):
								?>
								<input type="radio" name="category" value="<?php echo $category->slug; ?>" id="<?php echo $category->slug; ?>" data-id="<?php echo $category->id; ?>" class="with-gap radio-col-green sel_cate" <?php echo $required ?> >
								<label for="<?php echo $category->slug; ?>"><?php echo $category->display_name ?></label>
								<?php
							endforeach;
						
						endif;
						?>
					</div>
					<input type="hidden" name="category_id" id="category_id" value="">
				</div>
			</div>
			<label for="category">Period</label>
            <div class="row">
                <div class="col-sm-6">
					<div class="form-group">
	                    <div class="form-line">
	                        <input type="text" name="start_date" class="startdatepicker form-control" placeholder="*Registration Date" value="<?php echo $start_date; ?>"  <?php echo $required ?> >
	                    </div>
	                </div>
                </div>
                <div class="col-sm-6">
					<div class="form-group">
	                    <div class="form-line">
	                        <input type="text" name="end_date" class="enddatepicker form-control" placeholder="*Expiry Date" value="<?php echo $end_date; ?>"  <?php echo $required ?> >
	                    </div>
	                </div>
                </div>
            </div>
			<div class="row">
				<div class="col-sm-6">
					<label for="groups">*Status</label>
					<div>
						<input type="radio" name="active" value="1" <?php if($active=='1') { ?> checked=checked <?php } ?> id="1" class="with-gap radio-col-green" <?php echo $required ?>>
						<label for="1">Active</label>
						<input type="radio" name="active" value="0" <?php if($active=='0') {?> checked=checked <?php } ?> id="0" class="with-gap radio-col-green" <?php echo $required ?>>
						<label for="0">Deactive</label>
					</div>
				</div>
				<div class="col-sm-6">
					<label for="groups">*Plans</label>
					<div>
						<input type="radio" name="plan" value="silver" checked=checked id="silver" class="with-gap radio-col-green sel_plan" required>
						<label for="silver">Silver</label>
					</div>
				</div>
			</div>
			<div id="branch_registration">
			</div>
		</fieldset>
		<h3>Charging / Commission</h3>
		<fieldset class="my_fieldset" tabindex="4">
			<div class="row">
				<div class="col-sm-6">
					<label for="groups">*Payment Mode</label>
					<div>
						<input type="radio" name="payment_mode" value="online"  <?php if($payment_mode=='online') { ?> checked=checked <?php } ?>  id="online" class="with-gap radio-col-green" required>
						<label for="online">Online</label>
						<input type="radio" name="payment_mode" value="offline" <?php if($payment_mode=='offline') { ?> checked=checked <?php } ?>  id="offline" class="with-gap radio-col-green" required>
						<label for="offline">Offline</label>
					</div>
				</div>
			<?php	if ( !empty($payment_option) ): ?>
				<div class="col-sm-6">
					<label for="groups">*Payment Method</label>
					<div>
					<?php foreach ($payment_option as $option){ 
							 ?>
							<input type="checkbox" name="payment_option[]" <?php echo $required ?> class="filled-in chk-col-light-green" id="pm<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>">
						<label for="pm<?php echo $option['id']; ?>" style="margin-right: 30px;">
								<?php echo $option['name']; ?>
						</label>
					<?php  } ?>
					</div>
				</div>
			<?php endif; ?>
            </div>
			<label for="category">Transaction Fees</label>
            <div class="row">
                <div class="col-sm-6">
					<?php echo $form->bs3_text('*Debit Card (%)', 'vendor_debit_card_fee', $debit_fee, array($required => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
                <div class="col-sm-6">
					<?php echo $form->bs3_text('*Credit Card (%)', 'vendor_credit_card_fee', $credit_fee, array($required => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
            </div>
			<label for="category">Initial Fee</label>
            <div class="row">
                <div class="col-sm-6">
					<?php echo $form->bs3_text('*Amount in '.CI_CURRENCY_SYMBOL, 'vendor_initial_fee', '', array($required => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
                <div class="col-sm-6">
					<div class="form-group form-float form-group-lg">
	                    <div class="form-line">
	                        <input type="text" name="vendor_initial_due_date" class="enddatepicker form-control" placeholder="*Due Date" value=""  <?php echo $required ?> >
	                    </div>
	                </div>
                </div>
            </div>
			<label for="category">Annual Fee</label>
            <div class="row">
                <div class="col-sm-6">
					<?php echo $form->bs3_text('*Amount in '.CI_CURRENCY_SYMBOL, 'vendor_annual_fee', '', array($required => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
                <div class="col-sm-6">
					<div class="form-group form-float form-group-lg">
	                    <div class="form-line">
	                        <input type="text" name="vendor_annual_due_date" class="enddatepicker form-control" placeholder="*Due Date" value=""  <?php echo $required ?> >
	                    </div>
	                </div>
                </div>
            </div>
			<label for="category">Vendor Commission</label>
            <div class="row">
                <div class="col-sm-12">
						<input type="radio" name="vendor_comm_type" value="default" id="Vdefault"  class="with-gap radio-col-green" checked=checked <?php echo $required ?> >
						<label for="Vdefault">Default</label>

						<input type="radio" name="vendor_comm_type" value="perCategory" id="VperCategory"  class="with-gap radio-col-green" <?php echo $required ?> >
						<label for="VperCategory">Per Category</label>
				</div>
			</div>
            <div class="row vendor-comm">
            </div>

            <div class="branch-detail">
            </div>
		</fieldset>
		
	<?php echo $form->close(); ?>
		</div>
	</div>
</div>
* These fields are required
<style type="text/css">
	.my_fieldset{
		min-height: 390px;
		max-height: 400px;
	}
</style>
<script type="text/javascript">

$( document ).ready(function() {

	$('a[role="menuitem"]').click(function(e){
		console.log(e);
		console.log(e['pageY']);
	})

	$('#img_loader').hide();
	$('#dis_image').hide();
	$('#img_div').hide();
	$('#img_loader_gold').hide();
	$('#dis_image_gold').hide();
	$('#img_div_gold').hide();
	$('.br-name').hide();

	var v_def_comm = '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="default_commission" value="<?php if(!empty($default_commission)) echo $default_commission[0]['meta_value']; ?>" placeholder="*Default Commission (%)" id="default_commission" required onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div>';
	var v_cat_comm = '';


	$('.vendor-comm').html(v_def_comm);

	$("#Vdefault").click(function(){
		$(".vendor-comm").html(v_def_comm);
	});

	$("#byes").click(function(){
		$('.br-name').show();
	});

	$('.sel_cate').click(function(){
		var category = $(this).data('id');

		$("#category_id").val(category);
	});

	$("#bno").click(function(){
		$('.br-name').hide();
		$('#baddresses').html('');
		$('#branch_count').val('0');
		$('#branch_name_save').val('0');
		$('#bnumber').val('0');
	});

	$("#branchgo").click(function(){
		var number = parseInt($("#bnumber").val());

	if(number > 0)
	{
		swal({
			title: "Are you sure?",
			text: "Do you want to create branches?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#8BC34A",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		},
		function(){
			swal("Created!", "", "success");
		
			// store number of branches created
			b_n = $("input[name='branch_name']:checked").val();

			$('#branch_name_save').val(b_n);
			$('#branch_count').val(number);

			if (b_n == '0')
			{
				$('.branch-detail').html('');
			}

			var output = br_reg = '';
			for (var i = 1; i <= number; i++)
			{
				output += '<div class="row" style="border-top: 1px dashed #000;padding-top: 25px;">';
				output += '<div class="col-sm-12">';
				output += '<label>Branch '+i+'</label> (silver plan)';
				output += '</div></div>';
				if(b_n == '1')
				{
					output += '<div class="row"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="ufirstname'+i+'" value="" placeholder="*Name" id="ufirstname'+i+'" tabindex="11" <?php echo $required ?> class="form-control branch_first_name" data-id="'+i+'" type="text"></div></div></div>'; 
					output += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="bemail'+i+'" value="" placeholder="*Email" id="bemail'+i+'" tabindex="12" <?php echo $required ?> class="form-control chkemail" type="email"></div></div></div></div>';
					output += '<div class="row"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="uname'+i+'" value="" placeholder="*Username" id="uname'+i+'" tabindex="13" <?php echo $required ?> class="form-control chkusername" type="text"></div></div></div>'; 
					output += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="pass'+i+'" value="" placeholder="*Password" id="pass'+i+'" tabindex="14" <?php echo $required ?> class="form-control " minlength="6" type="password"></div></div></div></div>';
				}

				output += '<div class="row"><div class="col-sm-6 "><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="st'+i+'" value="" tabindex="15" placeholder="*Streat" <?php echo $required ?> class="form-control " type="text">';
				output += '</div></div></div>';
				output += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="lty'+i+'" value="" placeholder="*Locality" <?php echo $required ?> class="form-control " type="text">';
				output += '</div></div></div></div>';

				output += '<div class="row"><div class="col-sm-6 "><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="ldmk'+i+'" value="" placeholder="*Landmark" <?php echo $required ?> class="form-control " type="text">';
				output += '</div></div></div>';
				output += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="pc'+i+'" value="" placeholder="*Postal code" <?php echo $required ?> class="form-control " maxlength="10" minlength="3" type="text">';
				output += '</div></div></div></div>';

				output += '<div class="row">';
				output += '<div class="col-sm-4"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="phone'+i+'" value="" id="con'+i+'" placeholder="*Phone number"  <?php echo $required ?> onkeypress="return isNumberKey(event)" maxlength="16" minlength="6" class="form-control " type="text">';
				output += '</div></div></div>';
				output += '<div class="col-sm-4"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="whatsapp'+i+'" value="" id="con'+i+'" placeholder="*What\'s app number"  <?php echo $required ?> onkeypress="return isNumberKey(event)" maxlength="16" minlength="6" class="form-control " type="text">';
				output += '</div></div></div>';
				output += '<div class="col-sm-4"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="telephone'+i+'" value="" id="con'+i+'" placeholder="*Telephone number"  <?php echo $required ?> onkeypress="return isNumberKey(event)" maxlength="16" minlength="6" class="form-control " type="text">';
				output += '</div></div></div>';
				/*output += '<div class="col-sm-4"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="startdate'+i+'" class="brstartdatepicker form-control" placeholder="*Start date" value="" <?php //echo $required ?> ></div></div></div>';
				output += '<div class="col-sm-4"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="expdate'+i+'" class="brexpdatepicker form-control" placeholder="*Expiry date" value="" <?php //echo $required ?> ></div></div></div>';
				output += '<div class="col-sm-3"><div class="form-group form-float form-group-lg"><div class="form-line">';
				output += '<input name="priority'+i+'" value="" id="pri'+i+'" placeholder="*Priority 1-10 (1 is max)" <?php //echo $required ?> onkeypress="return isNumberKey(event)" maxlength="2" minlength="1" class="form-control prio" type="text">';
				output += '</div></div></div>';*/
				output += '</div>';

				if (b_n == '1')
				{
					output += '<div class="row"><div class="col-sm-3" style="padding-left: 15px;">';
					output += '<input type="hidden" name="br_file_name'+i+'" id="br_file_name'+i+'" value="" <?php echo $required ?> />';
					output += '<div class="col-25"><div class="col-inner">';
					output += '<input type="file" id="file'+i+'" class="br-upload-img" data-min="3" data-max="6" value="" name="file'+i+'" data-id="'+i+'" <?php echo $required ?> style="display: none;" />';
					output += '<label for="file'+i+'" class="file__drop" data-id="'+i+'" data-min="3" data-max="6" data-image-uploader><div id="img_div'+i+'" class="div-img dis-div-img" ><img data-image-'+i+' src="<?php echo base_url('assets/admin/seller_img/'); ?>" style="width: 100px;height: 70px;" class="br-dis-img" id="dis_image'+i+'" /><div class="preloader brloader pl-size-l" id="img_loader'+i+'"><div class="spinner-layer pl-light-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div><span class="choose-image" id="choose-image'+i+'">Click here to choose Vendor Image</span></label></div><p>image size must be <br>(w-1273 * h-244) </p></div></div>';
					output += '<div class="col-sm-3" style="padding-left: 15px;"><input name="br_file_name_gold'+i+'" id="br_file_name_gold'+i+'" value="" required="required" aria-required="true" type="hidden"><div class="col-25"><div class="col-inner">';
	                output += '<input class="br-upload-img-gold" data-id="'+i+'" data-min="1" data-max="2" data-display="_gold" id="file_gold'+i+'" value="" name="file_gold'+i+'" style="display: none;" required="" aria-required="true" type="file">';
	                output += '<label for="file_gold'+i+'" class="file__drop" data-min="1" data-max="2" data-display="_gold" data-image-uploader-gold><div class="div-img dis-div-img" id="img_div_gold'+i+'" style="display: none;"><img data-image-_gold'+i+' src="<?php echo base_url('assets/admin/seller_img/'); ?>" style="width: 100px; height: 70px; display: none;" class="br-dis-img" id="dis_image_gold'+i+'"><div class="preloader brloader pl-size-l" id="img_loader_gold'+i+'" style="display: none;"><div class="spinner-layer pl-light-green"><div class="circle-clipper left"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div></div>';
	                output += '<span class="choose-image" id="choose-image_gold'+i+'">Click here to choose Vendor Image</span></label>';
	                output += '</div><p>image size must be <br>(w-408 * h-267) </p></div></div>';
					output += '</div>';
				}
				
			}
			$('#baddresses').html(output);
			$('.brloader').hide();
			$('.br-dis-img').hide();
			$('.div-img').hide();

			jQuery('body').on({'change': regularImageUpload}, '.br-upload-img');
			jQuery('body').on({'change': regularImageUpload1}, '.br-upload-img-gold');
							
			/*$(".prio").blur(function(){
				var num = $(this).val();
				if (num > 10)
				{
					swal("",'Priority should be less than or equal to 10');
					$(this).val('');
				}
				else if(num < 1)
				{
					swal("",'Priority should be greater than or equal to 1');
					$(this).val('');
				}
			});*/

			$(".chkusername").blur(function(){
				$this = $(this);
				var username = $this.val();
				$.ajax({
					type:'POST',
					url:'<?php echo base_url('admin/panel/check_user'); ?>',
					data:{username:username,parameter:'username'},
					success:function(response)
					{
						if (!response)
						{
							$this.val('');
							swal("",'Username is already taken.\nPlease enter different username.');
						}
						else if(response)
						{
							user_count = $('.chkusername').filter(function(){
							    return this.value === username;
							}).length;
							
							if (user_count > 1)
							{
								$this.val('');
								swal("",'Username is already taken.\nPlease enter different username.');
							}
						}
					}
				})
			});


			$(".branch_first_name").keyup(function(){
				var id = $(this).data('id');
				$(".branch-dis-name"+id).html($(this).val());
			})

			// Branch Registration Details
			if (b_n == '1')
			{
				br_reg += '<div class="row" style="border-top: 1px dashed #000;padding-top: 25px; text-align: center;"><div class="col-sm-12"><label><h4>Branch Registration Details</h4></label></div></div>';

				for (var i = 1; i <= number; i++)
				{
					br_reg += '<div class="row" style="border-top: 1px dashed #000;padding-top: 25px; text-align: center;"><div class="col-sm-12"><label class="branch-dis-name'+i+'" >Branch '+i+'</label></div></div>';
					br_reg += '<div class="row"><div class="col-sm-12"><label for="category">*Vendor Type</label><div>';
					<?php 
					if ( !empty($categories) ):

						foreach ($categories as $category):
								?>
							br_reg += '<input type="radio" name="bcategory'+i+'" value="<?php echo $category->slug; ?>" id="bcat<?php echo $category->slug; ?>'+i+'" data-id="<?php echo $category->id; ?>" data-count="'+i+'" class="with-gap radio-col-green br_sel_cate" <?php echo $required ?> >';
							br_reg +='<label for="bcat<?php echo $category->slug; ?>'+i+'"><?php echo $category->display_name ?></label>';
								<?php
						endforeach;
						
					endif;
						?>
					br_reg += '</div><input type="hidden" name="bcategory_id'+i+'" id="bcategory_id'+i+'" value=""></div></div>';
					br_reg += '<div class="row">';
					br_reg += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="startdate'+i+'" class="brdatepicker form-control" placeholder="*Start date" value="" <?php echo $required ?> ></div></div></div>';
					br_reg += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="expdate'+i+'" class="brdatepicker form-control" placeholder="*Expiry date" value="" <?php echo $required ?> ></div></div></div>';
					br_reg += '</div>';
				}

				$('#branch_registration').html(br_reg);

				$(".br_sel_cate").change(function(){
					var category = $(this).data('id');
					var count = $(this).data('count');
					var vendor_cat = $("#category_id").val();
					
					$("#bcategory_id"+count).val(category);

					if (category != vendor_cat)
					{
						$("#BperVendor"+count).hide();
						$("label[for='BperVendor"+count+"']").hide();
					}
					else{
						$("#BperVendor"+count).show();
						$("label[for='BperVendor"+count+"']").show();
					}
				});

				$('.brdatepicker').bootstrapMaterialDatePicker({
			        format: 'DD MMMM YYYY',
			        minDate : new Date(),
			        clearButton: true,
			        weekStart: 1,
			        time: false
			    });
			}

			// Branch Charging Details
			var branch_detail = '';
			branch_detail += '<div class="row" style="border-top: 1px dashed #000;padding-top: 25px; text-align: center;"><div class="col-sm-12"><label><h4>Branch Charging Details</h4></label></div></div>';

			for (var i = 1; i <= number; i++)
			{
				branch_detail += '<div class="row" style="border-top: 1px dashed #000;padding-top: 25px; text-align: center;"><div class="col-sm-12"><label class="branch-dis-name'+i+'" >Branch '+i+'</label></div></div>';
				branch_detail += '<label for="category">Transaction Fees</label><div class="row"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="branch_debit_card_fee['+i+']" value="<?php echo $debit_fee; ?>" placeholder="*Debit Card (%)" <?php echo $required ?> onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="branch_credit_card_fee['+i+']" value="<?php echo $credit_fee; ?>" placeholder="*Credit Card (%)" <?php echo $required ?> onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div></div>';

				branch_detail += '<label for="category">Initial Fee</label><div class="row"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="branch_initial_fee['+i+']" value="" placeholder="*Amount in <?php echo CI_CURRENCY_SYMBOL; ?>" <?php echo $required ?> onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div>';
				branch_detail += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="branch_initial_due_date['+i+']" class="branchdatepicker form-control" placeholder="*Due Date" value=""  <?php echo $required ?> ></div></div></div></div>';

				branch_detail += '<label for="category">Annual Fee</label><div class="row"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="branch_annual_fee['+i+']" value="" placeholder="*Amount in <?php echo CI_CURRENCY_SYMBOL; ?>" <?php echo $required ?> onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div>';
        		branch_detail += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="branch_annual_due_date['+i+']" class="branchdatepicker form-control" placeholder="*Due Date" value=""  <?php echo $required ?> ></div></div></div></div>';
        		<?php	if ( !empty($payment_option) ): ?>
				branch_detail += '<div class="row"><div class="col-sm-12"><label for="groups">*Payment Method</label><div>';
					<?php foreach ($payment_option as $option){ 
							 ?>
							branch_detail += '<input type="checkbox" name="branch_payment_option['+i+'][]" <?php echo $required ?> class="filled-in chk-col-light-green" id="br'+i+'_<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>"><label for="br'+i+'_<?php echo $option['id']; ?>" style="margin-right: 30px;"><?php echo $option['name']; ?></label>';
					<?php  } ?>
				branch_detail += '</div></div></div>';
			<?php endif; ?>

				branch_detail += '<label for="category">Branch Commission</label><div class="row"><div class="col-sm-12"><input type="radio" name="branch_comm_type['+i+']" data-id="'+i+'" value="default" id="Bdefault'+i+'"  class="with-gap radio-col-green bra_default" checked=checked <?php echo $required ?> ><label for="Bdefault'+i+'">Default</label>';
				branch_detail += '<input type="radio" name="branch_comm_type['+i+']" data-id="'+i+'" value="perCategory" id="BperCategory'+i+'"  class="with-gap radio-col-green bra_per_cat" <?php echo $required ?> ><label for="BperCategory'+i+'">As Per Category</label>';
				branch_detail += '<input type="radio" name="branch_comm_type['+i+']" data-id="'+i+'" value="perVendor" id="BperVendor'+i+'"  class="with-gap radio-col-green bra_per_vendor" <?php echo $required ?> ><label for="BperVendor'+i+'">AS Per Vendor</label></div></div>';
				branch_detail += '<div class="row bra-def-com-'+i+'"><div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="branch_default_commission['+i+']" value="<?php if(!empty($default_commission)) echo $default_commission[0]['meta_value']; ?>" placeholder="*Default Commission (%)" <?php echo $required1 ?> onkeypress="return isNumberdotKey(event)" class="form-control def-input-'+i+'" type="text"></div></div></div></div>';
				branch_detail += '<div class="row bra-cat-com-'+i+'">';

				/*$.each(data, function( index, value ) {

					branch_detail += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="bra_per_cat['+i+']['+value['id']+']" class="form-control cat-input-'+i+'" placeholder="*'+value['display_name']+' (%)" value="" onkeypress="return isNumberdotKey(event)"  ></div></div></div>';
				});*/

				branch_detail += '</div>';

			}

			$('.branch-detail').html(branch_detail);

			$('.branchdatepicker').bootstrapMaterialDatePicker({
		        format: 'DD MMMM YYYY',
				minDate : new Date(),
		        clearButton: true,
		        weekStart: 1,
		        time: false
		    });

			$('.bra_default').click(function(){
				var id = $(this).data('id');
				$('.bra-cat-com-'+id).hide();
				$('.bra-def-com-'+id).show();

				$('.cat-input-'+id).removeAttr('required');
				$('.def-input-'+id).attr('required','required');
			});

			$('.bra_per_cat').click(function(){
				var id = $(this).data('id');
				var category = $('#bcategory_id'+id).val();

				jQuery.ajax({
			       type: 'POST',
			       url: '<?php echo base_url('admin/panel/get_sub_category'); ?>',
			       data: {category:category},
			       success: function(response){
			        var data = jQuery.parseJSON(response);
		                  // console.log(data);
					if(data)
					{
						br_cat_comm = '';

						$.each(data, function( index, value ) {

							br_cat_comm += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="bra_per_cat['+id+']['+value['id']+']" class="form-control cat-input-'+id+'" placeholder="*'+value['display_name']+' (%)" value="" onkeypress="return isNumberdotKey(event)" <?php echo $required1 ?> ></div></div></div>';
						});
						$(".bra-cat-com-"+id).html(br_cat_comm);
					}
		                
			       }
			    });
				$('.bra-cat-com-'+id).show();
				$('.bra-def-com-'+id).hide();

				$('.def-input-'+id).removeAttr('required');
				$('.cat-input-'+id).attr('required','required');
			});

			$('.bra_per_vendor').click(function(){
				var id = $(this).data('id');
				$('.bra-cat-com-'+id).hide();
				$('.bra-def-com-'+id).hide();

				$('.cat-input-'+id).removeAttr('required');
				$('.def-input-'+id).removeAttr('required');
			});

		});
	}
	else{
		swal('','Please enter branch count');
	}
	});

	$("#username").blur(function(){
		$this = $(this);
		var username = $this.val();
		$.ajax({
			type:'POST',
			url:'<?php echo base_url('admin/panel/check_user'); ?>',
			data:{username:username,parameter:'username'},
			success:function(response)
			{
				if (!response)
				{
					$this.val('');
					swal("",'Username is already taken.\nPlease enter different username.');
				}
				else if(response)
				{
					user_count = $('.chkusername').filter(function(){
					    return this.value === username;
					}).length;
					
					if (user_count > 1)
					{
						$this.val('');
						swal("",'Username is already taken.\nPlease enter different username.');
					}
				}
			}
		})
	});

	$(".chkemail").blur(function(){
		var username = $("#email").val();
		var res = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(username);

		if(res)
		{
			$.ajax({
				type:'POST',
				url:'<?php echo base_url('admin/panel/check_user'); ?>',
				data:{username:username,parameter:'email'},
				success:function(response)
				{
					if (!response)
					{
						swal("",'Email is already registeres.\nPlease enter different email.');
						$("#email").val('');
					}
				}
			});
		}
		else{
			$(this).parent().addClass('focused error');
			$(this).attr('aria-invalid','true');
			$('#email-error').show();
			$("#email-error").html('Please enter a valid email address.');
			return false;
		}
	});

	$("#VperCategory").change(function(){

		var category = $('#category_id').val();

		jQuery.ajax({
	       type: 'POST',
	       url: '<?php echo base_url('admin/panel/get_sub_category'); ?>',
	       data: {category:category},
	       success: function(response){
	        var data = jQuery.parseJSON(response);
                  // console.log(data);
			if(data)
			{
				$('#category_id').val(category);
				v_cat_comm = '';

				$.each(data, function( index, value ) {

					v_cat_comm += '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="ven_per_cat['+value['id']+']" class="form-control" placeholder="*'+value['display_name']+' (%)" value="" onkeypress="return isNumberdotKey(event)" <?php echo $required1 ?> ></div></div></div>';
				});
				$(".vendor-comm").html(v_cat_comm);
			}
                
	       }
	    });
	});

	$(".sel_plan").change(function(){ 

		var plan = $(this).val();

		if (plan == 'platinum') {

		}
	/*	jQuery.ajax({
	       type: 'POST',
	       url: '<?php echo base_url('admin/panel/check_category'); ?>',
	       data: {category:category},
	       success: function(response){
	        var data = jQuery.parseJSON(response);
                  // console.log(data);
                  if(!data['platinum']){
                  	$('#platinum').attr('disabled', true);
                  }else{
                  	$('#platinum').attr('disabled', false);
                  }
                  if(!data['gold']){
                  	$('#gold').attr('disabled', true);
                  }else{
                  	$('#gold').attr('disabled', false);
                  }
                
	       }
	    });
	*/});
});

jQuery(document).ready(function($) {

    jQuery('.startdatepicker').bootstrapMaterialDatePicker({
        format: 'DD MMMM YYYY',
		minDate : new Date(),
        clearButton: true,
        weekStart: 1,
        time: false
    });

    jQuery('.enddatepicker').bootstrapMaterialDatePicker({
        format: 'DD MMMM YYYY',
		minDate : new Date(),
        clearButton: true,
        weekStart: 1,
        time: false
    });
});
</script>
<style type="text/css">
	.admin_crt{
		padding-left: 0px !important;
	}
</style>
<?php //include('image_upload.php');
$this->view('image_upload'); ?>