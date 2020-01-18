

	  </div> <!-- /container -->

	</main>

	<footer>
		<div class="container">
			<p>&copy; Company 2017</p>
		</div>
	</footer>
	
	<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
	
	<?php if ( isset($_SESSION['message']) ) { include( APPPATH. 'views/templates/message.php' ); } ?>
		
</body>
</html>