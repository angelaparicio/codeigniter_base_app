<div class="container">
	

	<div class="omb_login">
		<h3 class="omb_authTitle"> <?php echo $texts['ui_sign_in'] ?> <?php echo $texts['ui_or'] ?> <a href="<?php echo base_url('users/signup') ?>"><?php echo $texts['ui_create_account'] ?></a></h3>
		<div class="row omb_row-sm-offset-3 omb_socialButtons">
			<div class="col-xs-4 col-sm-2">
				<a href="#" class="btn btn-lg btn-block omb_btn-facebook">
					<i class="fa fa-facebook visible-xs"></i>
					<span class="hidden-xs">Facebook</span>
				</a>
			</div>
			<div class="col-xs-4 col-sm-2">
				<a href="#" class="btn btn-lg btn-block omb_btn-twitter">
					<i class="fa fa-twitter visible-xs"></i>
					<span class="hidden-xs">Twitter</span>
				</a>
			</div>	
			<div class="col-xs-4 col-sm-2">
				<a href="#" class="btn btn-lg btn-block omb_btn-google">
					<i class="fa fa-google-plus visible-xs"></i>
					<span class="hidden-xs">Google+</span>
				</a>
			</div>	
		</div>

		<div class="row omb_row-sm-offset-3 omb_loginOr">
			<div class="col-xs-12 col-sm-6">
				<hr class="omb_hrOr">
				<span class="omb_spanOr"><?php echo $texts['ui_or'] ?></span>
			</div>
		</div>

		<form class="omb_loginForm" action="<?php echo base_url('users/do_login'); ?>" autocomplete="off" method="POST">
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">	
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="email" value="a.l.aparicio.gomez@gmail.com" placeholder="<?php echo $texts['ui_your_mail']; ?>" required>
					</div>
										
					<div class="input-group input-password">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="password" value="123456" placeholder="<?php echo $texts['ui_password']; ?>" required>
						<i class="fa fa-eye"></i>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $texts['ui_sign_in'] ?></button>
			</div>
		</div>
		
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">
				<p class="omb_footer_text_left">
					<label class="checkbox">
						<input type="checkbox" name="remember_me" value="yes"><?php echo $texts['ui_remember_me'] ?>
					</label>
				</p>
			</div>
			<div class="col-xs-12 col-sm-3">
				<p class="omb_footer_text_right"> 
					<a href="<?php echo base_url('users/recover_password'); ?>"><?php echo $texts['ui_forgot_password'] ?></a> 
				</p>
			</div>
		</div>
		</form>
		
	</div>


</div>