<?php
include_once 'MyController.php';

class Welcome extends MyController {

	public function index() {
		$this->loadView('home', $this->view_data);
	}
}
