<div class="row clearfix">

	<!-- <div class="col-md-4">
		<?php echo modules::run('adminlte/widget/box_open', 'Shortcuts'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-user', 'Account', 'panel/account'); ?>
			<?php echo modules::run('adminlte/widget/app_btn', 'fa fa-sign-out', 'Logout', 'panel/logout'); ?>
		<?php echo modules::run('adminlte/widget/box_close'); ?>
	</div>

	<div class="col-md-4">
		<?php echo modules::run('adminlte/widget/info_box', 'yellow', $count['users'], 'Users', 'fa fa-users', 'user'); ?>
	</div> -->
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-expand-effect">
            <div class="icon bg-light-green">
                <i class="material-icons">group</i>
            </div>
            <div class="content">
                <div class="text">USERS</div>
                <div class="number"><?php echo $count['users']; ?></div>
            </div>
        </div>
    </div>
    <?php if ($user->id == 1) {
    	
     ?>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-expand-effect">
            <div class="icon bg-light-green">
                <i class="material-icons">group</i>
            </div>
            <div class="content">
                <div class="text">VENDORS</div>
                <div class="number"><?php echo $count['admin_users']; ?></div>
            </div>
        </div>
    </div>
</div>
<?php } 
 ?>
