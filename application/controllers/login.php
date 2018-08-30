<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index() {
		echo "testing lang";
		$data['main_content'] = 'login_form';
		$this->load->view('includes/template', $data);
	}

	public function validate_credentials() {
		$this->load->model('membership_model');
		$query = $this->membership_model->validate();
		
		if ($query) {	//if the user's credentials validated
			$result = $this->membership_model->get_first_name();
		
			$data = array (
				'username' => $this->input->post('username'),
				'first_name' => $result,
				'is_logged_in' => true
			);
			
			$this->session->set_userdata($data);
			redirect('mempage/members_area');
		}
		else {
			$this->index();
		}
	}

}































