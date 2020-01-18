<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>App Title</title>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" >
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" >
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">	
</head>
<body style="display:none">

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	  <div class="container">

	  	<?php if ( !isset($user) ) { ?> 
			<a class="navbar-brand" href="<?php echo base_url(); ?>">My App</a>
		<?php } else { ?>
			<a class="navbar-brand" href="<?php echo base_url('/users/profile'); ?>">My App</a>
		<?php } ?>
					   
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse" id="navbarResponsive" style="">
		  <ul class="navbar-nav ml-auto">

			<li class="nav-item">
			  <a class="nav-link" href="<?php echo base_url('/pages/about'); ?>"><?php echo $texts['ui_about']; ?></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo base_url('/pages/help'); ?>"><?php echo $texts['ui_help']; ?></a>
			</li>

			<?php if ( !isset($user) ) { ?>
				
				<li class="nav-item">
				  <a class="nav-link" href="<?php echo base_url('users/login') ?>"><?php echo $texts['ui_sign_in']; ?></a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="<?php echo base_url('users/signup') ?>"><?php echo $texts['ui_create_account']; ?></a>
				</li>
				
			<?php } else { ?>
			
				<li class="nav-item">
				  <a class="nav-link" href="<?php echo base_url('users/logout') ?>"><?php echo $texts['ui_log_out']; ?></a>
				</li>
				
				<?php if ( $user['role'] == 'admin' ) { ?>

				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $texts['ui_administration']; ?><span class="caret"></span></a>
					<ul class="dropdown-menu bg-dark">
					  <li><a class="nav-link" href="<?php echo base_url('admin_users/listing') ?>"><?php echo $texts['ui_users'] ?></a></li>
					</ul>  
				</li>		   
								
				<?php } ?>
				
			<?php } ?>
		  </ul>
		</div>
	  </div>
	</nav>
	
	<main role="main">
