<!-- <nav class="navbar">
	<a href="" class="logo"><b><?php echo $site_name; ?></b></a>
	<div class="navbar-header" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?php echo $user->first_name; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<p><?php echo $user->first_name; ?></p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="panel/account" class="btn btn-default btn-flat">Account</a>
							</div>
							<div class="pull-right">
								<a href="panel/logout" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
brand-logo			</ul>
		</div>
	</div>
</nav> -->
<!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
            	<img src="<?php echo base_url(); ?>assets/admin/images/100.png" height="50" width="50" > 
                <a class="navbar-brand " href="">
                	<?php echo $site_name; ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?php echo $user->first_name ; ?></span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">
							<p><?php echo $user->first_name ; ?></p>
						</li>
						<li class="footer">
							<div class="pull-left leftaln">
								<a href="panel/account" class="btn btn-info waves-effect t">Account</a>
							</div>
							<div class="pull-right rightaln">
								<a href="panel/logout" class="btn btn-danger waves-effect t">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->