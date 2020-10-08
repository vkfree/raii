<div class="login_box_inner">
<div class="login-box login_box_back">
	
	<div class="login-logo img-circular" ><b><?php 
	echo'<img src="'.base_url().'assets/admin/images/header-logo.png" alt="Login-header-logo" style="width: 100px;">';
	?></b></div>

	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session  </p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? '' : '', ['class' => 'text_user_form']); ?>
			<?php echo $form->bs3_password('Password', 'password', ENVIRONMENT==='development' ? '' : '', ['class' => 'text_pass_form']); ?>
			<div class="row">
				<div class="col-xs-12 remembr_me_div">
					<div class="checkbox">
						<label><input type="checkbox" name="remember"> Remember Me</label>
					</div>
				</div>
				<div class="col-xs-12 btn_login_submt">
					<?php echo $form->bs3_submit('Sign In', 'btn btn-primary btn-block btn-flat'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>		
	</div>
</div>

</div>

<style type="text/css">
        input#password {
    background-image: url(http://www.khedma.appristine.in/assets/admin/images/user_pass.png);
    background-size: 22px;
    background-repeat: no-repeat;
    background-position: 10px 9px;
	}
	
	.login-box{
		background-color:#fff;
		width:100%;
		padding: 10%;
		 box-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.4), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
		
		 margin-top: 30%;
	}
	.login-logo{
		    text-align: center;
    width: 100%;
    box-sizing: border-box;
	}
	.login-box-msg{
		font-size: 17px;
		color: #fff;
    	text-align: center;
    	margin-bottom: 30px;
	}
		.img-circular{
 width: 200px;
 height: 200px;
 /*background-color:black;*/
 background-size: cover;
 display: block;
 border-radius: 100px;
 -webkit-border-radius: 100px;
 -moz-border-radius: 100px;
}

.img-circular {
    width: 60px;
    height: 60px;
    /*background-color: black;*/
    display: block;
    border-radius: 100px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    vertical-align: center;
    margin-left: 30%;
    margin-bottom: 5%;
}
</style>