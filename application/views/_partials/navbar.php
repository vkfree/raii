<!DOCTYPE html>
<html>
<head>
	<title>404</title>
	<?php 
		foreach ($stylesheets as $media => $files)
		{
			foreach ($files as $file)
			{
				$url = starts_with($file, 'http') ? $file : base_url($file);
				echo "<link href='$url' rel='stylesheet' media='$media'>".PHP_EOL;	
			}
		}
		
		foreach ($scripts['head'] as $file)
		{
			$url = starts_with($file, 'http') ? $file : base_url($file);
			echo "<script src='$url'></script>".PHP_EOL;
		} ?>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<div class="container">

		<?php $this->load->view('_partials/unavbar'); ?>
</div>
</nav>
<style type="text/css">.container{min-height:270px;text-align: center;}</style>
