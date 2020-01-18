<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyController extends CI_Controller {

	public $view_data;

	public function __construct() {

		parent::__construct();
		
		$this->view_data = array();

		$this->load->database();		
		$this->load->helper('url');		
		$this->load->library('session');
				
		$user = $this->session->userdata("user");
		if ( isset($user['id']) ){
			$this->view_data['user'] = $user;
		}
		else 
		if ( isset($_COOKIE['remember_me']) ){
			$this->load->model('user');
			$user = $this->user->loadByCookie();
			if ( isset($user['id']) ){
				$this->view_data['user'] = $user;
				$this->session->set_userdata('user', $user);
			}	
		}
		
		$this->lang->load('user_interface');
		$this->view_data['texts'] = $this->lang->language;
				
		$this->view_data['dir_profile_photos'] = $this->config->item('dir_profile_photos');	
	}
			
	public function loadView($view_name, $view_data = array()){

		$this->load->view('templates/header', $view_data);
		$this->load->view($view_name, $view_data);
		$this->load->view('templates/footer', $view_data);
		
	}
	
	public function redirectPrevious(){
		if ( isset($_SERVER['HTTP_REFERER']) ){
			redirect($_SERVER['HTTP_REFERER']);
		}
		else {
			redirect(base_url());
		}
	}
	
	
	public function checkIsLogged(){
	
		$user = $this->session->userdata('user');	
		
		if ( !isset($user['id']) ){

			$this->lang->load('authentication');		
			$this->session->set_flashdata( array('message' => $this->lang->language['auth_create_account']) );
			redirect( base_url('/users/login/') );
			die();			
		}
		
		return $user;
	}
	
	public function checkIsAdmin(){
	
		$user = $this->session->userdata('user');	
		
		if ( !isset($user['id']) || $user['role'] != 'admin' ){ 
			redirect( base_url('/') );
			die();			
		}
		
		return $user;
	}
			
}