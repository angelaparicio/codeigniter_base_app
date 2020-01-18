<div style="margin: 5em 30%;">
<?php
		
	foreach ($results as $result){
		
		$color = ( $result['Result'] == 'Failed' ) ? 'red' : 'darkgreen';
		
		echo '<p>';
		echo '<strong>'.$result['Test Name'].'</strong>: ';
		echo '<span style="color:'.$color.'">'.$result['Result'].'</span>';
		echo '</p>';		
	
	}

?>
</div>