<div class="wrapper">

	<?php $this->load->view('_partials/navbar'); ?>

	<?php // Left side column. contains the logo and sidebar ?>
	<aside id="leftsidebar">
		<section class="sidebar sidebar_left">
			<?php // (Optional) Add Search box here ?>
			<?php //$this->load->view('_partials/sidemenu_search'); ?>
			<?php $this->load->view('_partials/sidemenu'); ?>
		</section>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page ?>
	<div class="content-wrapper">
		<section class="content page_inner_wrapper ">
			<div class="container-fluid">
	            <div class="row clearfix ">
	                <!-- Basic Examples -->
	                <div class="col-lg-12">
	                    <div class="card">
	                    	<div class="header">
	                    		<h2 style="display: inline;" class="pull-left" ><?php echo $page_title; ?></h2>
	                    	 	<div class="clearfix"></div>
	                    	 	<ol class="breadcmb_wrap_ol breadcrumb pull-left" style="display: inline;">
									<?php $this->load->view('_partials/breadcrumb'); ?>
								</ol>

								<div class="clearfix"></div>
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