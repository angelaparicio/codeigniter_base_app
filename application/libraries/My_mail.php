<?php

class My_mail {

	private $CI;
	private $mail_enable;

	
	public function getValidationMailTemplate($data){
		$config = & get_config();
		
		$text = file_get_contents( APPPATH.'views/mails/'.$config['language'].'/validation_by_mail.html' );
		$text = str_replace('%LINK%', base_url('users/do_validation/'.$data->activation_key.'/'.$data->id), $text );
		
		$mail = array(
			'subject' => 'Please, validate your email',
			'message' => $text, 
		);
		
		return $mail;
	}
	
	public function getRecoverPasswordTemplate($user, $url){
		$config = & get_config();
		
		$text = file_get_contents( APPPATH.'views/mails/'.$config['language'].'/recover_password.html' );
		$text = str_replace('%LINK%', $url, $text );
		
		$mail = array(
			'subject' => 'Recover Password',
			'message' => $text, 
		);
		
		return $mail;
	}
	
	public function sendMail($to_email, $data, $options = array()){

		if ( filter_var($to_email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $to_email) ) { 
			
			require ( getcwd().'/application/libraries/phpMailer5/PHPMailerAutoload.php' );
					
			$this->CI = & get_instance();
			$this->CI->config->load('email');
			
			$config = array(
				'smtp_host' => $this->CI->config->item('smtp_host'),
				'smtp_user' => $this->CI->config->item('smtp_user'),
				'smtp_pass' => $this->CI->config->item('smtp_pass'),
				'from_mail' => $this->CI->config->item('from_mail'),
				'from_name' => $this->CI->config->item('from_name'),
				'smtp_port' => $this->CI->config->item('smtp_port')			
			);
			
			$mail = new PHPMailer;
			$mail->SMTPDebug = 0;
			
			$mail->IsSMTP();  
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			                    
			$mail->SMTPAuth = true;
			//$mail->SMTPSecure = 'ssl';
			$mail->Host = $config['smtp_host'];
			$mail->Port = $config['smtp_port'];
			$mail->Username = $config['smtp_user'];; 
			$mail->Password = $config['smtp_pass'];;           
			
			$mail->From = $config['from_mail'];
			$mail->FromName = $config['from_name'];
			$mail->addAddress($to_email);  
			
			$mail->Subject = $data['subject'];
			$mail->MsgHTML( $data['message'] );
			
			$result = $mail->Send();

			return $result;
			
		}
		else {
			return false; //The email is not correct
		}
		
	}
}
?>