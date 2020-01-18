<div class="container">
	

	<div class="omb_login">
		<h3 class="omb_authTitle"> <?php echo $texts['ui_create_account'] ?> </h3>
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
				<span class="omb_spanOr"><?php echo $texts['ui_or']; ?></span>
			</div>
		</div>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">	
				<form class="omb_loginForm" action="<?php echo base_url('users/do_signup'); ?>" autocomplete="off" method="POST">

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="name" value="" placeholder="<?php echo $texts['ui_your_name']; ?>">
					</div>
					
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope-open "></i></span>
						<input type="text" class="form-control" name="email" value="" placeholder="<?php echo $texts['ui_your_mail']; ?>">
					</div>
										
					<div class="input-group input-password">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="password" value="" placeholder="<?php echo $texts['ui_password']; ?>">
						<i class="fa fa-eye"></i>
					</div>
					
					<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $texts['ui_register'] ?></button>
					
					<div id="termsAndConditions" class="col-xs-12">
						<input type="checkbox" required /><?php echo $texts['ui_confirm_tos'] ?> <a href="<?php echo base_url('pages/terms_of_service') ?>"><?php echo $texts['ui_terms_of_service'] ?></a> <?php echo $texts['ui_and'] ?> <a href="<?php echo base_url('pages/privacy_policy') ?>"><?php echo $texts['ui_privacy_policy'] ?></a>. <?php echo $texts['ui_no_agree_with_tos']; ?>. 
					</div>
			
				</form>
			</div>
		</div>
		
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">

			</div>
			<div class="col-xs-12 col-sm-3">
				<p class="omb_footer_text_right"> 
					<?php echo $texts['ui_already_registered'] ?> <br/> <a href="<?php echo base_url('users/login') ?>"><?php echo $texts['ui_please_sign_in'] ?></a> 
				</p>
			</div>		
			
		</div>
		
	</div>

</div>