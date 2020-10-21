<?php if ( !empty($available_languages) ): ?>
	<ul class=" languagepicker roundborders large top-nav-ul" style="position: absolute;top: 0px;right: -8%;width: 120px;z-index: 8;">
		<li><a onclick="return false;"><?php echo lang('current_language'); ?>: <?php echo $language; ?></a></li>
		<li class="dropdown">
			<!-- <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
				<i class="fa fa-globe"></i>
				<span class='caret'></span>
			</a> -->
			<ul role='menu' class='dropdown-menu' style="">
				<?php foreach ($available_languages as $abbr => $item):?>
				<li><a href="<?php echo lang_url($abbr); ?>">
<?php 
if ($item['value'] == 'english') {
	echo '<img src="'.base_url().'assets/frontend/images/US.png" style="width: 15px; height: 11px;padding-right: 5px;">&nbsp;&nbsp;';
}elseif ($item['value'] == 'arabic') {
	echo '<img src="'.base_url().'assets/frontend/images/Aribic.png" style="width: 15px; height: 11px;padding-right: 5px;">&nbsp;&nbsp;';
}
echo $item['label'];
 ?>
				</a></li>
				<?php endforeach; ?>
			</ul>
		</li>
	</ul>

	<style type="text/css">
		.languagepicker {
	background-color: #9bc03c;
	display: inline-block;
	padding: 0;
	height: 28px;
	overflow: hidden;
	
	margin-top: -10px;
}

.languagepicker:hover {
	/* don't forget the 1px border */
	height: 81px;
}

.languagepicker a{
	color: #fff;
	text-decoration: none;
}

.languagepicker li {
	display: block;	
	line-height: 40px;
	
}

.languagepicker li:hover{
	background-color:#9bc03c;
}

.languagepicker a:first-child li {
	border: none;
	background: #FFF !important;
}


.large:hover {
	
	height:148px;
}
	</style>
<?php endif; ?>