<?php echo $form->messages();
$title  = $active = $editor = '';
if (isset($edit)) {
$title = $edit['title'];

//$myimage = $edit['image'];
$active = $edit['status'] == 'active' ? 'checked' : '';
$deactive = $edit['status'] == 'deactive' ? 'checked' : '';
$editor = $edit['editor'];
}else{

$deactive = 'checked';
}

?>


<div class="row">

	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
			<!-- 	<h3 class="box-title">Title</h3> -->
			</div>
			<div class="box-body">
				<?php echo $form->open(); ?>
					<div class="form-group">
					    <label for="groups">Title</label>
					    <div>
					  <?php echo $form->bs3_text('title', 'title', $title, array('required' => '')); ?>
					    </div>
					</div>
					
					<div class="form-group">
						<label for="groups">Status</label>
						<div>
							<?php echo $form->bs3_radio('Active', 'status', 'active', array('required' => ''), $active); ?>
							<?php echo $form->bs3_radio('Deactive', 'status', 'deactive', array('required' => ''), $deactive); ?>


						</div>
					</div>
                    <div class="form-group">
                        <label for="groups">Editor</label>
                        <div>
                       <textarea name="editor" id="ckeditor2"><?php echo $editor; ?> </textarea>
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
