<div class="wrapper">

	<?php $this->load->view('_partials/navbar'); ?>

	<?php // Left side column. contains the logo and sidebar ?>
	<aside id="leftsidebar">
		<section class="sidebar">
			<div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url(); ?>assets/admin/images/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user->first_name; ?></div>
                    <div class="email"><?php echo $user->email; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="panel/account"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="panel/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
				<!-- <div class="pull-left info" style="left:5px">
					<p><?php echo $user->first_name; ?></p>
					<a href="panel/account"><i class="fa fa-circle text-success"></i> Online</a>
				</div> -->
			</div>
			<?php // (Optional) Add Search box here ?>
			<?php //$this->load->view('_partials/sidemenu_search'); ?>
			<?php $this->load->view('_partials/sidemenu'); ?>
		</section>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page ?>
	<div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
	            <div class="row clearfix">
	                <!-- Basic Examples -->
	                <div class="col-lg-12">
	                    <div class="card">
	                    	<div class="header">
	                    		<h2 style="display: inline;"><?php echo $page_title; ?></h2>
	                    	 	<ol class="breadcrumb pull-right" style="display: inline;">
									<?php $this->load->view('_partials/breadcrumb'); ?>
								</ol>
	                    	</div>
	                    	 <div class="body">
								<?php $this->load->view($inner_view); ?>
								<?php $this->load->view('_partials/back_btn'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<?php // Footer ?>
	<?php $this->load->view('_partials/footer'); ?>

</div>