<?php
include_once 'MyController.php';

class Tests extends MyController {

	public function mails(){
		
		die();
		$this->load->library('my_mail');
		
		$mail = array('subject' => 'Probando', 'message' => 'Texto de prueba. Enviando <b>OK</b>');
		$this->my_mail->sendMail( 'a.l.aparicio.gomez@gmail.com', $mail );
	}
	
	public function users() {
		die('¡Cuidado! ¡No ejecutes esto contra una base de datos de producción, ya que la base de datos será borrada!');
		
		$this->_clean_database();
		
		$this->load->model('User');
		$this->load->library('unit_test');
		
	
		$tests = array();
			
		//Test 1
		$test = array(
			'name' => 'Registro password corto',
			'test' => $this->User->register( array('email' => 'a.l.aparicio.gomez@gmail.com', 'name' => 'Angel', 'password' => '1234') ),
			'result' => array( 'result' => $this->User::PASSWORD_TOO_SHORT, 'user' => array() ),
		);
		array_push($tests, $test);
		

		//Test 2
		$test = array(
			'name' => 'Registro mail incorrecto',
			'test' => $this->User->register( array('email' => 'a.l.aparicio.gomez', 'name' => 'Angel', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::MAIL_INCORRECT, 'user' => array() ),
		);
		array_push($tests, $test);

		
		//Test 3
		$test = array(
			'name' => 'Registro nombre incorrecto',
			'test' => $this->User->register( array('email' => 'a.l.aparicio.gomez@gmail.com', 'name' => sprintf('%050d', 0), 'password' => '123456') ),
			'result' => array( 'result' => $this->User::NAME_TOO_LONG, 'user' => array() ),
		);
		array_push($tests, $test);


		//Test 4
		$test = array(
			'name' => 'Registro correcto',
			'test' => $this->User->register( array('email' => 'a.l.aparicio.gomez@gmail.com', 'name' => 'Angel', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'a.l.aparicio.gomez@gmail.com', 'name' => 'Angel', 'active' => 0, 'role' => 'user') ),
		);
		array_push($tests, $test);		


		//Test 5
		$test = array(
			'name' => 'Registro con correo duplicado',
			'test' => $this->User->register( array('email' => 'a.l.aparicio.gomez@gmail.com', 'name' => 'Angel', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::MAIL_DUPLICATE, 'user' => array() ),
		);
		array_push($tests, $test);
				

		//Test 6		
		$test = array(
			'name' => 'Login con usuario inexistente',
			'test' => $this->User->login( array('email' => 'angel@gmail.com', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::MAIL_INCORRECT, 'user' => array() ),
		);
		array_push($tests, $test);


		//Test 7
		$test = array(
			'name' => 'Login con usuario inactivo',
			'test' => $this->User->login( array('email' => 'a.l.aparicio.gomez@gmail.com', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::INACTIVE_USER, 'user' => array() ),
		);
		array_push($tests, $test);
		
		
		//Test 8		
		$id_user = 1;
		$activation_key = 'aaaa';
		$test = array(
			'name' => 'Activacion con código erroneo',
			'test' => $this->User->activateUser( $id_user, $activation_key ),
			'result' => $this->User::INVALID_KEY,
		);
		array_push($tests, $test);
		
		$users = $this->db->get_where('users', array('email' => 'a.l.aparicio.gomez@gmail.com') )->result();
		$activation_key = $users[0]->activation_key;


		//Test 9		
		$test = array(
			'name' => 'Activacion con codigo correcto',
			'test' => $this->User->activateUser( $id_user, $activation_key ),
			'result' => $this->User::OK,
		);
		array_push($tests, $test);
		

		//Test 10
		$test = array(
			'name' => 'Login con usuario activo',
			'test' => $this->User->login( array('email' => 'a.l.aparicio.gomez@gmail.com', 'password' => '123456') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'a.l.aparicio.gomez@gmail.com', 'profile_image' => 'default_profile_image.png', 'name' => 'Angel', 'active' => 1, 'role' => 'user', 'id' => 1) ),
		);
		array_push($tests, $test);		


		//Test 11
		$test = array(
			'name' => 'Modificar usuario, sin id',
			'test' => $this->User->update( array('name' => 'Angelito') ),
			'result' => false
		);
		array_push($tests, $test);
		
		
		//Test 12
		$test = array(
			'name' => 'Modificar nombre usuario',
			'test' => $this->User->update( array('id' => 1, 'name' => 'Angelito') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'a.l.aparicio.gomez@gmail.com', 'profile_image' => 'default_profile_image.png', 'name' => 'Angelito', 'active' => 1, 'role' => 'user', 'id' => 1) ),
		);
		array_push($tests, $test);

		//Test 13
		$test = array(
			'name' => 'Modificar email incorrecto',
			'test' => $this->User->update( array('id' => 1, 'email' => 'a.l.aparicio.gomez') ),
			'result' => array( 'result' => $this->User::MAIL_INCORRECT ),
		);
		array_push($tests, $test);
		
		
		//Test 14
		$test = array(
			'name' => 'Modificar email',
			'test' => $this->User->update( array('id' => 1, 'email' => 'angel.aparicio.gomez@hotmail.com') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'angel.aparicio.gomez@hotmail.com', 'profile_image' => 'default_profile_image.png', 'name' => 'Angelito', 'active' => 1, 'role' => 'user', 'id' => 1) ),
		);
		array_push($tests, $test);
		

		//Test 15
		$test = array(
			'name' => 'Modificar contraseña usuario, muy corta',
			'test' => $this->User->update( array('id' => 1, 'password' => '123') ),
			'result' => array( 'result' => $this->User::PASSWORD_TOO_SHORT ),
		);
		array_push($tests, $test);

	
		//Test 16
		$test = array(
			'name' => 'Modificar contraseña usuario',
			'test' => $this->User->update( array('id' => 1, 'password' => '123456!') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'angel.aparicio.gomez@hotmail.com', 'profile_image' => 'default_profile_image.png', 'name' => 'Angelito', 'active' => 1, 'role' => 'user', 'id' => 1) ),
		);
		array_push($tests, $test);


		//Test 17
		$test = array(
			'name' => 'Modificar usuario completo',
			'test' => $this->User->update( array('id' => 1, 'password' => '123456', 'name' => 'Angel', 'email' => 'a.l.aparicio.gomez@gmail.com') ),
			'result' => array( 'result' => $this->User::OK, 'user' => array('email' => 'a.l.aparicio.gomez@gmail.com', 'profile_image' => 'default_profile_image.png', 'name' => 'Angel', 'active' => 1, 'role' => 'user', 'id' => 1) ),
		);
		array_push($tests, $test);


		foreach ( $tests as $test ){
			$this->unit->run($test['test'], $test['result'], $test['name']);
		}
		
		
		//Extra
		$this->db->where('id', 1);
		$this->db->update('users', array('role' => 'admin' ));
		
		for ( $id_user = 2; $id_user <= 50; $id_user++ ){
			
			$this->User->register( array(
				'email' => uniqid().'@mailtest.com', 
				'name' => 'User '.$id_user, 
				'password' => uniqid()) 
			);
			
			$this->db->where('id', $id_user);
			$this->db->update('users', array('active' => 1, 'activation_key' => ''));
		}

		$this->view_data['results'] = $this->unit->result();		
		$this->loadView('tests/results', $this->view_data);
		
	}
	
	
	
	public function _clean_database(){
		
		$this->db->query('TRUNCATE users');
		
	}
	
}
