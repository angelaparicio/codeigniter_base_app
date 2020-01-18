<div class="container control_panel">
	
	<h1><?php echo $texts['ui_users_administration']; ?></h1>

	<table class="table">
	<tr>
		<th><?php echo $texts['ui_name']; ?></th>
		<th><?php echo $texts['ui_email']; ?></th>
		<th><?php echo $texts['ui_role']; ?></th>
		<th><?php echo $texts['ui_active']; ?></th>
		<th><?php echo $texts['ui_actions']; ?></th>
	</tr>
	<?php foreach ( $users as $user ) { ?>
	<tr>
		<td> <?php echo $user['name'] ?> </td>
		<td> <?php echo $user['email'] ?> </td>
		<td> <?php echo $user['role'] ?> </td>
		<td> 
		<?php 
		if ( $user['active'] ) { 
			echo $texts['ui_yes'];
		} else {
			echo $texts['ui_no']; 
		}
		?> 
		</td>
		<td> 
			<a href="<?php echo base_url('admin_users/edit/'.$user['id'].'/') ?>"> <?php echo $texts['ui_edit']; ?> </a> - 
			<a href="<?php echo base_url('admin_users/do_delete/'.$user['id'].'/') ?>" onclick="return confirm('<?php echo $texts['ui_cannot_be_undone'] ?>');"> <?php echo $texts['ui_delete']; ?> </a>
		</td>
	</tr>
	<?php } ?>
	</table>
	
	<div class="pagination_links">
		<?php echo $pagination ?>
	</div>
</div>