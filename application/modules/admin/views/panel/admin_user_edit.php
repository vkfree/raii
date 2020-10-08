<?php echo $form->messages();

$first_name = $username = $password = $streat = $email = $locality = $landmark = $country = $commision = $phone = $active =  $plan = $payment_mode = $start_date = $end_date = $logo = $commission = $last_name = '';
if (isset($edit)) {
$first_name = $edit['first_name'];

$username = $edit['username'];
$password = $edit['password'];
$streat = $edit['streat'];
$email = $edit['email'];
$locality = $edit['locality'];
$landmark = $edit['landmark'];
$country = $edit['country'];
$commission = $commision = $edit['commision'];
if($commision == 'yes'){
    $commission = '';
}
$phone = $edit['phone'];
$first_name = $edit['first_name'];
$plan = $edit['plan'];
$payment_mode = $edit['payment_mode'];
$start_date = $edit['start_date'];
$end_date = $edit['end_date'];
$logo = $edit['logo'];
$banner = $edit['banner'];
$active = $edit['active']; //== '' ? 'checked' : '';
//$deactive = $edit['active'] == 'deactive' ? 'checked' : '';
$debit_fee = $edit['debit_card_fee'];
$credit_fee = $edit['credit_card_fee'];

}
 ?>
<div class="row">

	<div class="col-md-12">
		<div class="demo-masked-input">
			
	<?php echo $form->open(); ?>

			<?php echo $form->bs3_text('Name', 'first_name', $first_name, array('required' => '')); ?>
			<?php echo $form->bs3_email('Email', 'email', $email, array('required' => '')); ?>
			<div class="col-sm-6 admin_crt">
				<?php echo $form->bs3_text('Streat', 'streat', $streat, array('required' => '')); ?>
			</div>
			<div class="col-sm-6">
				<?php echo $form->bs3_text('Locality', 'locality', $locality, array('required' => '')); ?>
			</div>
			<div class="col-sm-6 admin_crt">
				<?php echo $form->bs3_text('Landmark', 'landmark', $landmark, array('required' => '')); ?>
			</div>
			<div class="col-sm-6">
				<?php echo $form->bs3_text('Country', 'country', $country, array('required' => '')); ?>
			</div>
            <div class="form-group">
                <div class="input-group">
                    <div class="form-line">
                        <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Ex: +00 (000) 000-00-00" id="phone"  class="form-control mobile-phone-number"  required >
                    </div>
                </div>
            </div>

            <?php if(!isset($type)){ ?>

            <label for="category">Transaction Fees</label>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->bs3_text('*Debit Card (%)', 'debit_card_fee', $debit_fee, array('required' => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->bs3_text('*Credit Card (%)', 'credit_card_fee', $credit_fee, array('required' => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
            </div>
            <label for="category">Vendor Commission</label>
            <div class="row">
                <div class="col-sm-12">
                    <input type="radio" name="vendor_comm_type" value="default" id="Vdefault"  class="with-gap radio-col-green" <?php if ($commision != 'yes') echo "checked=checked"; ?> required >
                        <label for="Vdefault">Default</label>

                        <input type="radio" name="vendor_comm_type" value="perCategory" id="VperCategory"  class="with-gap radio-col-green" <?php if ($commision == 'yes') echo "checked=checked"; ?> required >
                        <label for="VperCategory">Per Category</label>
                </div>
            </div>
            <div class="row vendor-comm">
                <div class="col-sm-3">
                    <?php echo $form->bs3_text('commision', 'commision', $commission, array('required' => '','onkeypress' => 'return isNumberdotKey(event)')); ?>
                </div>
            </div>

			<div class="form-group">
				<label for="groups">Status</label>
				<div>
					<input type="radio" name="active" value="1" <?php if($active=='1') { ?> checked=checked <?php } ?> id="1" class="with-gap radio-col-green" required>
					<label for="1">Active</label>
					<input type="radio" name="active" value="0" <?php if($active=='0') {?> checked=checked <?php } ?> id="0" class="with-gap radio-col-green" required>
					<label for="0">Deactive</label>
				</div>
			</div>
            <?php } ?>

        </div>
    </div>
</div>
		<!-- <div class="row" style="padding-left: 15px">
            <input type="hidden" id="photo_url" value="<?php echo base_url('admin/file_handling/uploadFiless'); ?>" />
            <input type="hidden" id="img_url" value="admin/seller_img/" />
            <input type="hidden" name="logo" id="file_name" value="<?php echo $logo; ?>" >
            <div class="col-25">
                <div class="col-inner">
                    <input type="file" id="file" value="" name="file" />
                    <label for="file" class="file__drop" data-image-uploader>
                        <span class="text">&nbsp;</span>
                        <img data-image src="<?php echo base_url('assets/admin/seller_img/'.$logo); ?>" style="width: 80px;height: 80px;padding: 10px 0;" />
                        
                    </label>
                </div>
                <p>image size must be (width-1273 * height-244) </p>
            </div>
        </div> -->
	<div class="row">
        <div class="col-sm-3" style="padding-left: 15px;">
                <input type="hidden" name="banner" id="file_name" value="<?php echo $banner; ?>" />
                <div class="col-25">
                    <div class="col-inner">
                        <input type="file" id="file" class="vendor-img" data-min="3" data-max="6" value="<?php echo $banner; ?>" name="file" />
                        <label for="file" class="file__drop" data-min="3" data-max="6" data-image-uploader>
                            <div class="dis-div-img" id="img_div">
                            <img data-image src="<?php echo base_url('assets/admin/seller_img/'.$banner); ?>" style="position: absolute; width: 100px;height: 70px;margin-left: -30px;" id="dis_image" />
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
                            <!-- <span class="choose-image" id="choose-image">Click here to choose Vendor Image</span> -->
                        </label>
                    </div>
                    <p>image size must be <br>(w-1273 * h-244) for platinum </p>
                </div>
            </div>

            <div class="col-sm-3" style="padding-left: 15px;">
                <input type="hidden" name="logo" id="file_name_gold" value="<?php echo $logo; ?>" />
                <div class="col-25">
                    <div class="col-inner">
                        <input type="file" data-min="1" data-max="2" data-display="_gold" id="file_gold" value="<?php echo $logo; ?>" name="file_gold" style="display: none;"  />
                        <label for="file_gold" class="file__drop" data-min="1" data-max="2" data-display="_gold" data-image-uploader-gold>
                            <div class="dis-div-img" id="img_div_gold">
                            <img data-image_gold src="<?php echo base_url('assets/admin/seller_img/'.$logo); ?>" style="position: absolute; width: 100px;height: 70px;margin-left: -30px;" id="dis_image_gold" />
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
                            <!-- <span class="choose-image" id="choose-image_gold">Click here to choose Vendor Image</span> -->
                        </label>
                    </div>
                    <p>image size must be <br>(w-408 * h-267) </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $form->bs3_submit(); ?>
            </div>
        </div>
 
		
	<?php echo $form->close(); ?>
<style type="text/css">
    .admin_crt{
        padding-left: 0px !important;
    }
</style>
<script type="text/javascript">
$( document ).ready(function() {
    $('.preloader').hide();

    $('.branch-detail').hide();

    var v_def_comm = '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input name="default_commission" value="<?php echo $commission; ?>" placeholder="*Default Commission (%)" id="default_commission" required onkeypress="return isNumberdotKey(event)" class="form-control " type="text"></div></div></div>';

    var v_cat_comm = '<?php 
    if (!isset($type))
    {
        foreach ($edit['sub_category'] as $key => $value)
        {
            echo '<div class="col-sm-6"><div class="form-group form-float form-group-lg"><div class="form-line"><input type="text" name="ven_per_cat['.$value['id'].']" class="form-control" placeholder="*'.$value['display_name'].' (%)" onkeypress="return isNumberdotKey(event)"  value="';
            if (isset($edit['all_com']) && isset($edit['all_com'][$value['id']]))
            {
                echo $edit['all_com'][$value['id']];
            }
            echo '" required ></div></div></div>';
        }
    }
    

?>';

    <?php 
    if ($commision == 'yes')
    { ?>
        $(".vendor-comm").html(v_cat_comm);
        <?php }else{ ?>
        $(".vendor-comm").html(v_def_comm);
        <?php } ?>

    $("#Vdefault").click(function(){
        $(".vendor-comm").html(v_def_comm);
    });


    $("#VperCategory").click(function(){
        $(".vendor-comm").html(v_cat_comm);
    });

	$(".sel_cate").change(function(){ 

		var category = $(this).val();

		jQuery.ajax({
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
	});
});

</script>
<?php //include('image_upload.php');
$this->view('image_upload'); ?>