<?php
include_once 'MyController.php';

class Admin_users extends MyController {
	
	public function __construct() {
		parent::__construct();
		
		$this->checkIsAdmin();
		$this->load->model('user');
	}
	
	function listing($offset = 0){
		
		$per_page = 20;
		$this->load->library('pagination');

		$this->pagination->initialize( array(
			'base_url' => base_url('admin_users/listing'),
			'total_rows' => $this->db->count_all_results('users'),
			'per_page' => $per_page,
		));
		
		$this->view_data['users'] = $this->user->getPaginated($offset, $per_page);		
		$this->view_data['pagination'] = $this->pagination->create_links();
		
		
		$this->loadView('admin/users/listing', $this->view_data);
	}

	function do_delete($id_user){
		$user = $this->user->getById($id_user);
		$this->user->delete( $user );
		
		redirect('admin_users/listing');
	}
	
	function edit($id_user){
		$this->view_data['user_data'] = $this->user->getById($id_user);
		$this->loadView('admin/users/edit', $this->view_data);	
			
	}
	
	public function do_profile(){
	
		$data = array();
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
		redirect('admin_users/listing');
		 
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
				
				$user_data = array(
					'id' => $this->input->post('id'),
					'profile_image' => $file_name,
				);
				
				$result = $this->user->update($user_data);
				
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
	
}