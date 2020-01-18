<?php
include_once 'MyModel.php';

class User extends MyModel {
	
	const OK = 1;
		
	const PASSWORD_TOO_SHORT = 2;
	const MAIL_INCORRECT = 3;
	const MAIL_DUPLICATE = 4;
	const INVALID_KEY = 5;
	const INACTIVE_USER = 6;
	const PASSWORD_INCORRECT = 7;
	const NAME_TOO_LONG = 8;
	const IMAGE_FORMAT_INCORRECT = 9;

	protected $table = 'users';
	
	public function register($data){

		$result = array(
			'result' => 0,
			'user' => array(),
		);
		
		if ( !$this->checkPassword($data['password']) ){
			$result['result'] = $this::PASSWORD_TOO_SHORT;
		}
		else 
		if ( $this->isMailInvalid($data['email']) ) {
			$result['result'] = $this->isMailInvalid($data['email']);
		}		
		else
		if ( strlen($data['name']) > 32 ) { 
			$result['result'] = $this::NAME_TOO_LONG;	
		}
		else {

    		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    		$data['activation_key'] = md5( uniqid() );
    		$data['ts_register'] = date("Y-m-d H:i:s");
    		$data['profile_image'] = 'default_profile_image.png';
    		
    		$this->db->insert($this->table, $data);
    		$result['user'] = array(
    			'active' => 0,
    			'role' => 'user',
    			'name' =>  $data['name'],
    			'email' => $data['email'],
    		);
    		
    		$result['result'] = $this::OK;
    	}
						
		return $result;
	}
	
	
	public function login($data){

		$user = $this->getUserByMail( $data['email'] );
	
		if ( empty($user) ){
			return array(
				'user' => array(),
				'result' => $this::MAIL_INCORRECT,
			);
		}

		if ( password_verify($data['password'], $user['password']) ){
			
			if ( !$user['active'] ){
				return array(
					'user' => array(),
					'result' => $this::INACTIVE_USER,
				);
				
			}
			else {
				$this->db->where('id', $user['id']);
		        $this->db->update('users', array('ts_last_login' => date("Y-m-d H:i:s") ));

				return array(
					'user' => array('email' => $user['email'], 'profile_image' => $user['profile_image'], 'name' => $user['name'], 'active' => $user['active'], 'role' => $user['role'], 'id' => $user['id']),
					'result' => $this::OK,
				);
				
			}
			
		}
		else {
			return array(
				'user' => array(),
				'result' => $this::PASSWORD_INCORRECT,
			);

		}
		
		return $result;
	
	}
	
	public function activateUser( $id_user, $activation_key ){
		
		$user = $this->getById( $id_user );
		
		if ( $user['activation_key'] == $activation_key ) {
			$this->db->where('id', $id_user);
			$this->db->update('users', array('active' => 1, 'activation_key' => ''));
			
			return $this::OK;
		}
		else {
			return $this::INVALID_KEY;
		}
		
	}
	
		
	public function isMailInvalid($email){
		
		if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			return $this::MAIL_INCORRECT;
		}
		
		$usuarios = $this->getWhere( array('email' => $email));
		if ( count($usuarios) ){
			return $this::MAIL_DUPLICATE;
		}

		return false;
	}


	public function checkPassword($pass){		
		$is_correct = ( strlen($pass) >= 6 );	
		
		return $is_correct;
	}	
	
	public function getUserByMail($email){
		$user = $this->getWhere( array('email' => $email) );	
		
		if ( isset($user[0]) ){
			$user = $user[0];
		}
		
		return $user;
	}
	
	public function update($user){
		
		if ( !isset($user['id']) ){
			return false;
		}
		
		if ( empty($user['password']) ){
			unset($user['password']);
		}
		
		if ( isset($user['password']) && !$this->checkPassword($user['password']) ){
			return array('result' => $this::PASSWORD_TOO_SHORT);
		}
		
		if ( isset($user['password']) ){
			$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
		}
		
		if ( isset($user['email']) && !filter_var($user['email'], FILTER_VALIDATE_EMAIL) ){
			return array('result' => $this->User::MAIL_INCORRECT);
		}
		  	
		//Change user
		$this->db->where('id', $user['id']);
		$this->db->update('users', $user);
		
		//Return user
		$user = $this->getById($user['id']);
		
		return array(
			'user' => array('email' => $user['email'], 'profile_image' => $user['profile_image'], 'name' => $user['name'], 'active' => $user['active'], 'role' => $user['role'], 'id' => $user['id']),
			'result' => $this::OK,
		);
		
	}
	
	
	public function delete($user){
	
		if ( $user['profile_image'] != 'default_profile_image.png' ){		
			$dir_profile_photos = $this->config->item('dir_profile_photos');
			unlink( getcwd().'/'.$dir_profile_photos.$user['profile_image'] );
		}
		
		$this->db->delete('users', array('id' => $user['id']) );
	
	}
	
	public function loadByCookie(){
	
		$user_aux = $this->getWhere( array('remember_key' => $_COOKIE['remember_me']) );
		
		if ( isset($user_aux[0]['id']) ){
			$aux = explode('_', $_COOKIE['remember_me']);
			$id_encoded = base64_encode( $user_aux[0]['id'].$user_aux[0]['email'] );
			
			if ( $aux[0] == $id_encoded ){
			
				$user = array(
					'email' => $user_aux[0]['email'],
					'profile_image' => $user_aux[0]['profile_image'],
					'name' => $user_aux[0]['name'],
					'active' => $user_aux[0]['active'],
					'role' => $user_aux[0]['role'],
					'id' => $user_aux[0]['id'],
				);
				
				if ( $user['active'] ){
					return $user;
				}
				
			}

		}
		
	}
	
	public function getErrorTexts(){
		
		$this->lang->load('authentication');
		
		$error_texts = array(
			$this::PASSWORD_TOO_SHORT => $this->lang->language['auth_password_too_short'],
			$this::MAIL_INCORRECT => $this->lang->language['auth_mail_incorrect'],
			$this::MAIL_DUPLICATE => $this->lang->language['auth_mail_duplicate'],
			$this::INVALID_KEY => $this->lang->language['auth_invalid_key'],
			$this::INACTIVE_USER => $this->lang->language['auth_inactive_user'],
			$this::PASSWORD_INCORRECT => $this->lang->language['auth_password_incorrect'],
			$this::NAME_TOO_LONG => $this->lang->language['auth_name_too_long'],
			$this::IMAGE_FORMAT_INCORRECT => $this->lang->language['auth_image_format_incorrect']
		);	
		
		return $error_texts;
	}
	
}
?>