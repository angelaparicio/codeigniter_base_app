<div id="modalMessage" class="modal" tabindex="-1" role="dialog">
  
  <div class="modal-dialog" role="document">
	<div class="modal-content">
			
	  <div class="modal-body">
		<p><?php echo $_SESSION['message'] ?></p>
	  </div>
	  
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $texts['ui_close']; ?></button>
	  </div>
	  
	</div>
  </div>
  
</div>

<script> $(document).ready( function(){ $('#modalMessage').modal('show'); } ); </script>

<?php unset( $_SESSION['message'] ); ?>