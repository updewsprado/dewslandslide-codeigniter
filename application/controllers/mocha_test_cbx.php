<?php
	class Mocha_test_cbx extends CI_Controller {
		public function index() {
			echo "TEST";
		}

		public function dewschatterbox_helperTest() {
			$data['title'] = 'dewschatterbox_beta.js Test';
			$this->load->view('templates/header', $data);
			$this->load->view('test/cbx_test', $data);
		}
	}
?>