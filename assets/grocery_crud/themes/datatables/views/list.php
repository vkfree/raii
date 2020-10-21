<div style="clear: both;max-width: 100%;overflow:auto; ">
	
<table class="table table-bordered table-striped table-hover dataTable js-exportable" style="clear: both;max-width: 100% !important;overflow:auto; " id="<?php echo uniqid(); ?>">
	<thead>
		<tr>
			<?php foreach($columns as $column){?>
				<th><?php echo $column->display_as; ?></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<th class='actions'><?php echo $this->l('list_actions'); ?></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $num_row => $row){ ?>
		<tr id='row-<?php echo $num_row?>'>
			<?php foreach($columns as $column){?>
				<td><?php echo $row->{$column->field_name}?></td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td class='actions'>
				<?php
				if(!empty($row->action_urls)){
					foreach($row->action_urls as $action_unique_id => $action_url){
						$action = $actions[$action_unique_id];
				?>
						<!-- <a href="<?php //echo $action_url; ?>" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
							<span class="ui-button-icon-primary ui-icon <?php //echo $action->css_class; ?> <?php //echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php //echo $action->label?></span>
						</a> -->
						<a href="<?php echo $action_url; ?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float <?php echo $action->css_class; ?>" role="button">
							<i class="material-icons"><?php echo $action->label; ?></i>
						</a>
				<?php }
				}
				?>
				<?php if(!$unset_read){?>
					<a href="<?php echo $row->read_url?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" role="button">
						<i class="material-icons">remove_red_eye<?php //echo $this->l('list_view'); ?></i>
					</a>
				<?php }?>

				<?php if(!$unset_edit){?>
					<a href="<?php echo $row->edit_url?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float" role="button">
						<i class="material-icons">edit<?php //echo $this->l('list_edit'); ?></i>
					</a>
				<?php }?>
				<?php if(!$unset_delete){?>
					<a data-url= "<?php echo $row->delete_url?>" class="btn bg-light-green btn-circle waves-effect waves-circle waves-float delete_row_re" role="button" data-type="cancel">
						<i class="material-icons">delete<?php //echo $this->l('list_delete'); ?></i>
					</a>
				<?php }?>
			</td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
	<!-- <tfoot>
		<tr>
			<?php //foreach($columns as $column){?>
				<th><input type="text" name="<?php //echo $column->field_name; ?>" placeholder="<?php //echo $this->l('list_search').' '.$column->display_as; ?>" class="search_<?php //echo $column->field_name; ?>" /></th>
			<?php //}?>
			<?php //if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
				<th>
					<button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only floatR refresh-data" role="button" data-url="<?php //echo $ajax_list_url; ?>">
						<span class="ui-button-icon-primary ui-icon ui-icon-refresh"></span><span class="ui-button-text">&nbsp;</span>
					</button>
					<a href="javascript:void(0)" role="button" class="clear-filtering ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary floatR">
						<span class="ui-button-icon-primary ui-icon ui-icon-arrowrefresh-1-e"></span>
						<span class="ui-button-text"><?php //echo $this->l('list_clear_filtering');?></span>
					</a>
				</th>
			<?php //}?>
		</tr>
	</tfoot> -->
</table>
</div>