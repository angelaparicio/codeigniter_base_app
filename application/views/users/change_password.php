<div class="container">
	
	<div class="omb_login">

		<h3 class="omb_authTitle"> <?php echo $texts['ui_introduce_a_new_password'] ?> </h3>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">	
				<form class="omb_loginForm" action="<?php echo base_url('users/do_change_password'); ?>" autocomplete="off" method="POST">
										
					<div class="input-group input-password">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="password" value="" placeholder="<?php echo $texts['ui_password']; ?>" required>
						<i class="fa fa-eye"></i>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $texts['ui_change_password']; ?></button>
				</form>
			</div>
		</div>
		
	</div>

</div>