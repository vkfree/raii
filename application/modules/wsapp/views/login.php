<div class="login-box">

	<div class="login-logo img-circular" ><b><?php 
	echo'<img src="'.base_url().'assets/admin/images/header-logo.png" alt="Login-header-logo">';
	?></b></div>

	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Username', 'username', ENVIRONMENT==='development' ? '' : ''); ?>
			<?php echo $form->bs3_password('Password', 'password', ENVIRONMENT==='development' ? '' : ''); ?>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox">
						<label><input type="checkbox" name="remember"> Remember Me</label>
					</div>
				</div>
				<div class="col-xs-4">
					<?php echo $form->bs3_submit('Sign In', 'btn btn-primary btn-block btn-flat'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>		
	</div>

</div>

<style type="text/css">
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
		font-size: 16px;
    	text-align: center;
	}
		.img-circular{
 width: 200px;
 height: 200px;
 background-color:black;
 background-size: cover;
 display: block;
 border-radius: 100px;
 -webkit-border-radius: 100px;
 -moz-border-radius: 100px;
}

.img-circular {
    width: 60px;
    height: 60px;
    background-color: black;
    display: block;
    border-radius: 100px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    vertical-align: center;
    margin-left: 38%;
    margin-bottom: 5%;
}
</style>