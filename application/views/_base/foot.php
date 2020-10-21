<script type="text/javascript">
	function isNumberKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

	function isNumberdotKey(evt){
	    var charCode = (evt.which) ? evt.which : event.keyCode
	    if (charCode > 31 && ((charCode < 48 || charCode > 57) && charCode != 46))
	        return false;
	    return true;
	}
</script>

<script type="text/javascript">
				document.getElementsByTagName( "html" )[0].classList.remove( "loading" );
				// All browsers
				document.getElementsByTagName( "html" )[0].className.replace( /loading/, "" );
				// Or with jQuery
				$( "html" ).removeClass( "loading" );
			</script>
			
			
	<?php
		foreach ($scripts['foot'] as $file)
		{
			$url = starts_with($file, 'http') ? $file : base_url($file);
			echo "<script src='$url'></script>".PHP_EOL;
		}
	?>

	<?php // Google Analytics ?>
	<?php $this->load->view('_partials/ga') ?>
</body>
</html>