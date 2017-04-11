<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Issues_and_reminders extends CI_Controller {

		public function __construct() {
			parent::__construct();
			//$this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('issues_model');
		}

		public function index()
		{
			$data['title'] = 'DEWS-L Monitoring Issues And Reminders Page';
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$data['user_id'] = $this->session->userdata("id");

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('public_alert/issues_and_reminders_page', $data);
			$this->load->view('templates/footer');
		}

		public function modal()
		{
			$data['locked'] = isset($_GET['locked']) ? json_encode($_GET['locked']) : $this->issues_model->getAllRowsByStatus('locked');
			$data['normal'] = isset($_GET['normal']) ? json_encode($_GET['normal']) : $this->issues_model->getAllRowsByStatus('normal');
			return $this->load->view('public_alert/issues_and_reminders_modal', $data);
		}

		public function panel_div()
		{
			$locked = isset($_GET['locked']) ? $_GET['locked'] : $this->issues_model->getAllRowsByStatus('locked');
			$normal = isset($_GET['normal']) ? $_GET['normal'] : $this->issues_model->getAllRowsByStatus('normal');
			$data['locked_and_normal'] = json_encode(array_merge($locked, $normal));
			$data['archived'] = isset($_GET['archived']) ? json_encode($_GET['archived']) : $this->issues_model->getAllRowsByStatus('archived');
			return $this->load->view('public_alert/issues_and_reminders_builder', $data);
		}

		public function test()
		{
			$data['title'] = 'DEWS-L Test Page';
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$data['user_id'] = $this->session->userdata("id");

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('public_alert/test', $data);
			$this->load->view('templates/footer');
		}

		public function getAllLocked()
		{
			$data = $this->issues_model->getAllRowsByStatus('locked');
			echo $data;
		}

		public function getAllNormal()
		{
			$data = $this->issues_model->getAllRowsByStatus('normal');
			echo $data;
		}

		public function getAllArchived()
		{
			$data = $this->issues_model->getAllRowsByStatus('archived');
			echo $data;
		}

		public function insert()
		{
			$data = array(
				'detail' => $_POST['issue_detail'],
				'ts_posted' => $_POST['ts_posted'],
				'user_id' => $_POST['poster_id'],
				'validity' => $_POST['isLocked'] == 1 ? null : $_POST['issue_validity'],
				'status' => $_POST['isLocked'] == 1 ? "locked" : "normal"
			);

			$this->issues_model->insert_row("issues_and_reminders", $data);

			echo json_encode($data);
		}

		public function update()
		{
			$data = array(
				'detail' => $_POST['issue_detail'],
				'user_id' => $_POST['poster_id'],
				'validity' => $_POST['isLocked'] == 1 ? null : $_POST['issue_validity'],
				'status' => $_POST['isLocked'] == 1 ? "locked" : "normal"
			);

			$this->issues_model->update_row("iar_id", $_POST['iar_id'], "issues_and_reminders", $data);
		}

		public function archive()
		{
			$data = array(
				'status' => "archived"
			);

			$this->issues_model->update_row("iar_id", $_POST['iar_id'], "issues_and_reminders", $data);
		}

		public function is_logged_in() 
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
				echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
				die();
			}
			else {
			}
		}

	}

?>