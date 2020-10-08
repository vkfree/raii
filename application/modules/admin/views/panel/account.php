<?php echo $form1->messages(); ?>

<div class="row">

	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Account Info</h3>
			</div>
			<div class="box-body">
				<?php echo $form1->open(); ?>
					<?php echo $form1->bs3_text('First Name', 'first_name', $user->first_name); ?>
					<?php echo $form1->bs3_text('Last Name', 'last_name', $user->last_name); ?>
					<?php echo $form1->bs3_submit('Update'); ?>
				<?php echo $form1->close(); ?>
			</div>
		</div>
	</div>
	<?php print_r($user->social); ?>
		


	<?php if (!empty($user->social=='gmail' && $user->social=='facebook')) { ?>
			You cant change your password because you login through social .
	<?php } ?>

<?php if (empty($user->social)) { ?>
	<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header">
					<h3 class="box-title">Change Password</h3>
				</div>
				<div class="box-body">
					<?php echo $form2->open(); ?>
						<?php echo $form2->bs3_password('New Password', 'new_password', '', array('minlength' => '6', 'required' => '', 'autocomplete' => 'off')); ?>
						<?php echo $form2->bs3_password('Retype Password', 'retype_password', '', array('minlength' => '6', 'required' => '')); ?>
						<?php echo $form2->bs3_submit(); ?>
					<?php echo $form2->close(); ?>
				</div>
			</div>
		</div>
<?php } ?>


	
</div>