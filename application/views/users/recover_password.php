<div class="container">

	<div class="omb_login">
		
		<h3 class="omb_authTitle"> <?php echo $texts['ui_your_mail'] ?> </h3>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">	
				<form class="omb_loginForm" action="<?php echo base_url('users/do_recover_password'); ?>" autocomplete="off" method="POST">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="email" value="a.l.aparicio.gomez@gmail.com" placeholder="<?php echo $texts['ui_your_mail']; ?>" required>
					</div>	

					<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $texts['ui_recover_my_password'] ?></button>
				</form>
			</div>
		</div>
		
	</div>

</div>