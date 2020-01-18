<?php
include_once 'MyController.php';

class Users extends MyController {

	public function __construct() {
		parent::__construct();

		$this->lang->load('authentication');
		$this->load->model('user');
	}
		
	public function login(){
		$this->loadView('users/login', $this->view_data);
	}
	
	public function do_login(){
		
		$user_data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
		);
		
		$result = $this->user->login($user_data);
		
		if ( $result['result'] == $this->user::OK ){

			$this->session->set_userdata('user', $result['user']);
			$url = base_url('/users/profile/');
			
			if ( $this->input->post('remember_me') ){

				$remember_key = base64_encode( uniqid() );
				$id_encoded = base64_encode( $result['user']['id'].$result['user']['email'] );
				
				$result = $this->user->update( array('id' => $result['user']['id'], 'remember_key' => $id_encoded.'_'.$remember_key) );
				
				$this->load->helper('cookie');
				set_cookie('remember_me', $id_encoded.'_'.$remember_key, 60*60*24*30 );
			}
			
		}
		else {
			$url = base_url('users/login/');
			$texts = $this->user->getErrorTexts();
			
			$this->session->set_flashdata( array(
				'message' => $texts[ $result['result'] ]
			));
		}		
		
		redirect( $url );
	}
	
	public function signup(){
		$this->loadView('users/signup', $this->view_data);	
	}
	
	public function do_signup(){
						
		$url = base_url();

		$user_data = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);

		$result = $this->user->register($user_data);

		if ( $result['result'] == $this->user::OK ){
			
			$users = $this->db->get_where('users', array('email' => $result['user']['email']) )->result();
			$user_data = $users[0];

			$this->load->library('my_mail');
			$mail = $this->my_mail->getValidationMailTemplate($user_data);
			
			$this->my_mail->sendMail( $user_data->email, $mail );

			$message = $this->lang->language['auth_confirmation_mail_sended'];
			
		}
		else {
			$url = base_url().'users/signup/';
			$texts = $this->user->getErrorTexts();
			$message = $texts[ $result['result'] ];
		} 

		$this->session->set_flashdata( array('message' => $message));
		redirect( $url );
	}

	public function profile(){
		$user = $this->checkIsLogged();		
		$this->loadView('users/profile', $this->view_data);	
	}	
	
	public function do_profile(){
		$user = $this->checkIsLogged();

		$data = array();
		$data['id'] = $user['id'];
		foreach ( $_POST as $key => $value ){
			$data[ $key ] = $this->input->post($key);
		}
		
		$result = $this->user->update($data);
		
		if ( $result['result'] == $this->user::OK ) {			
			$message = $this->lang->language['auth_profile_updated'];
			$this->session->set_userdata('user', $result['user']);
			
		}
		else {
			$texts = $this->user->getErrorTexts();
			$message = $texts[ $result['result'] ];
			
		}
		
		$this->session->set_flashdata( array('message' => $message));
		$this->redirectPrevious();
		 
	}
	
	public function do_validation($activation_key, $id_user){
		
		$result = $this->user->activateUser( $id_user, $activation_key );
		
		if ( $result == $this->user::INVALID_KEY ){
			$url = base_url();
			$message = $this->lang->language['auth_invalid_key'];
		}
		else 
		if ( $result == $this->user::OK ){
			$url = base_url().'users/login';
			$message = $this->lang->language['auth_user_activated'];
		}
		
		$this->session->set_flashdata( array('message' => $message));
		redirect( $url );
	}
	
	public function do_change_profile_photo(){
		$user = $this->checkIsLogged();
		
		if ( isset($_FILES['profilephoto']['error']) && $_FILES['profilephoto']['error'] == 0) {
		
			$ext = strtolower( pathinfo($_FILES['profilephoto']['name'], PATHINFO_EXTENSION) );
			
			if ( $ext == 'png' || $ext == 'jpeg' || $ext == 'jpg' || $ext == 'gif' ) {
				
				$dir_profile_photos = $this->config->item('dir_profile_photos');
				$file_name = uniqid().'.'.$ext;
				
				if ( $user['profile_image'] != 'default_profile_image.png' ){		
					$dir_profile_photos = $this->config->item('dir_profile_photos');
					if ( file_exists(getcwd().'/'.$dir_profile_photos.$user['profile_image']) ){
						unlink( getcwd().'/'.$dir_profile_photos.$user['profile_image'] );
					}
				}
		
				move_uploaded_file( $_FILES['profilephoto']['tmp_name'], getcwd().'/'.$dir_profile_photos.$file_name );
				
				$user['profile_image'] = $file_name;
				$result = $this->user->update($user);
				
				$message = $this->lang->language['auth_profile_updated'];
				$this->session->set_userdata('user', $result['user']);
			
			}
			else {
				$texts = $this->user->getErrorTexts();
				$message = $texts[ $this->user::IMAGE_FORMAT_INCORRECT ];
			}
				
		}
				
		$this->session->set_flashdata( array('message' => $message) );
		$this->redirectPrevious();
		
	}
	
	public function logout(){
		$this->session->sess_destroy();

		$this->load->helper('cookie');
		set_cookie('remember_me');
				
	    redirect( base_url() );
	}
	
	public function do_delete(){
		
		$user = $this->checkIsLogged();
		$this->user->delete( $user );
		
		$this->session->set_userdata('user', null);
		$this->session->set_flashdata( array(
			'message' => $this->lang->language['auth_user_delated']
		));
		
	    redirect( base_url() );

	}
	
	public function recover_password(){
		$this->loadView('users/recover_password', $this->view_data);          
    }

	public function do_recover_password(){
	
		$user = $this->user->getUserByMail( $this->input->post('email'));

		if ( isset($user['id']) ){
			
			$temp_code = md5( time() );
			
			$this->db->where('id', $user['id']);
			$this->db->update('users', array('activation_key' => $temp_code) );
			
			$url = base_url('/users/change_password/'.$temp_code.'/'. sha1($user['id']) );

			$this->load->library('my_mail');
			$mail = $this->my_mail->getRecoverPasswordTemplate($user, $url);
			
			$this->my_mail->sendMail( $user['email'], $mail);
			
			$this->session->set_flashdata( array(
				'message' => $this->lang->language['auth_change_pass_mail_sended']
			));
			
			$redirect = base_url();

		}
		else {
			$this->session->set_flashdata( array(
				'message' => $this->lang->language['auth_mail_incorrect']
			));
			
			$redirect = base_url('users/recover_password');
		}
		
		redirect($redirect);

	}
	
	public function change_password($temp_code, $id_crypted){
		$user = $this->user->getWhere( array('activation_key' => $temp_code));
		
		if ( $user[0]['activation_key'] == $temp_code && sha1($user[0]['id']) == $id_crypted ){
			$this->session->set_userdata('id_user', $user[0]['id']);
			
			$this->loadView('users/change_password', $this->view_data);          
		}
		else {
		    $this->session->set_flashdata( array('message' =>$this->lang->language['auth_inactive_user'] ));
		    redirect( base_url('users/login'));
		}
	}
	
	public function do_change_password(){
	
		$id_user = $this->session->userdata('id_user');		
	
		$result = $this->user->update( array('id' => $id_user, 'password' => $this->input->post('password')) );				
		
		if ( $result['result'] == $this->user::OK ) {
			$message = $this->lang->language['auth_password_changed'];
			$redirect = base_url('users/login');
		}
		else {
			$texts = $this->user->getErrorTexts();
			$message = $texts[ $result['result'] ];
			$redirect = $_SERVER['HTTP_REFERER'];
		}
		
		$this->session->set_flashdata( array('message' => $message));	
		redirect($redirect);
	}

}

?>