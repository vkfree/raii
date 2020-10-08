<?php echo $form->messages();
//$email  = $first_name = $editor = '';

//print_r($email);
  
 ?>


<div class="row">

	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
			<!-- 	<h3 class="box-title">Title</h3> -->
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>
					<!--<div class="form-group">
					    <label for="groups">To</label>
					</div>---->
					
					<div class="form-group">
						<label for="groups">Subject</label>
						<div>
						 <?php echo $form->bs3_text('subject', 'subject'); ?>

						</div>
					</div>
                    <div class="form-group">
                        <label for="groups">Massage</label>
                        <div>
                      <textarea name="message" id="ckeditor2"></textarea>
                        </div>
                    </div>
					
                  
				<br><br><br>
					<?php echo $form->bs3_submit(); ?>
					
				<?php echo $form->close(); ?>
			</div>
		</div>
	</div>
	
</div>
<script type="text/javascript">

$(function () {CKEDITOR.replace('ckeditor2');CKEDITOR.config.height = 300;});


</script>

