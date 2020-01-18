<?php
include_once 'MyController.php';

class Pages extends MyController {
	
	public function about(){
		$this->loadView('pages/about', $this->view_data);
	}
	
	public function help(){
		$this->loadView('pages/help', $this->view_data);
	}
	
	public function terms_of_service(){
		$this->loadView('pages/terms_of_service', $this->view_data);
	}
	
	public function privacy_policy(){
		$this->loadView('pages/privacy_policy', $this->view_data);
	}
	
	public function error_404(){
		$this->loadView('errors/html/error_404', $this->view_data);
	}

}


