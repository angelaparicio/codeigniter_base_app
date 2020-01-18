<div id="user_control_panel" class="container control_panel">

	<h1><?php echo $texts['ui_edit_user']; ?>: <?php echo $user_data['name'] ?></h1>
	
	<div class="row">

		<div class="col-md-4">
			<img width="250" height="250" src="<?php echo base_url($dir_profile_photos.$user_data['profile_image']); ?>" alt="Profile photo" /><br/>
			<span class="form_field cursor-pointer text-secondary" data-toggle="modal" data-target="#changeProfilePhoto"><?php echo $texts['ui_change_profile_photo']; ?></span>
		</div>
		
		<div class="col-md-8">
		<form action="<?php echo base_url('admin_users/do_profile'); ?>" method="post">
			<input type="hidden" name="id" value="<?php echo $user_data['id'] ?>" />
			
			<div class="form_field">
				<label><?php echo $texts['ui_name']; ?></label>
				<input class="double_size" type="text" name="name" value="<?php echo $user_data['name'] ?>" />
			</div>
			
			<div class="form_field">
				<label><?php echo $texts['ui_email']; ?></label>
				<input class="double_size" type="text" name="email" value="<?php echo $user_data['email'] ?>" />
			</div>

			<div class="form_field input-password">
				<label><?php echo $texts['ui_change_password']; ?></label>
				<input class="double_size" type="password" name="password" />
				<i class="fa fa-eye"></i>
			</div>
						
			<div class="form_field">
				<input type="submit" class="btn btn-primary" value="<?php echo $texts['ui_save_data']; ?>" /> 
			</div>
			
		</form>	
		
			<div class="form_field">
				<span class="cursor-pointer text-danger" data-toggle="modal" data-target="#deleteAccount"><?php echo $texts['ui_delete_account']; ?></span>
			</div>
			
			<div class="form_field">
				<a href="<?php echo base_url('admin_users/listing'); ?>"><?php echo $texts['ui_cancel']; ?></span>
			</div>
					
		</div>
		
	</div>	
</div>	


<div class="modal fade" id="changeProfilePhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	<form id="formProfilePhoto" enctype="multipart/form-data" method="post" action="<?php echo base_url('admin_users/do_change_profile_photo'); ?>">
	  <input type="hidden" name="id" value="<?php echo $user_data['id'] ?>" />	  
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"><?php echo $texts['ui_change_profile_photo']; ?></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<label class="btn btn-default btn-file">
			<?php echo $texts['ui_choose_a_photo_from_your_computer']; ?> <input type="file" accept="image/*" name="profilephoto" onchange="document.getElementById('formProfilePhoto').submit();" style="display: none;">
		</label>
	  </div>
	  <div class="modal-footer">
		<button role="button" class="btn btn-secundary" data-dismiss="modal"><?php echo $texts['ui_cancel'] ?></button>
	  </div>	  
	</form>	  
	</div>	
  </div>
</div>


<div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"><?php echo $texts['ui_delete_account']; ?></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		<?php echo $texts['ui_cannot_be_undone']; ?>
	  </div>
	  <div class="modal-footer">
		<button role="button" class="btn btn-primary" data-dismiss="modal"><?php echo $texts['ui_cancel'] ?></button>
		<a href="<?php echo base_url('/admin_users/do_delete/'.$user_data['id']); ?>" role="button" class="btn btn-danger"><?php echo $texts['ui_yes'] ?></a>
	  </div>
	</div>
  </div>
</div>