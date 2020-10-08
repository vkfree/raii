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
		<section class="content page_inner_wrapper">
			<div class="container-fluid">
	            <div class="row clearfix">
					<?php $this->load->view($inner_view); ?>
					<?php $this->load->view('_partials/back_btn'); ?>
				</div>
			</div>
		</section>
	</div>

	<?php // Footer ?>
	<?php $this->load->view('_partials/footer'); ?>

</div>
