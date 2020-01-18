$(document).ready( function(){	
	
	$('body').css('display','block');
	$('#launchModalMessage').trigger('click');
	
	$('.input-password .fa-eye').click( function(){
		var type = $('.input-password input').attr('type');
		if ( type == 'password' ){
			$('.input-password input').attr('type', 'text');
		}
		else {
			$('.input-password input').attr('type', 'password');
		}
		
	});
	
});