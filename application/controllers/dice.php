<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dice extends CI_Controller {

	public function view(  $page = 'home' )
	{
		$this->load->helper('url');
	
		if(!file_exists('../codeigniter/application/views/dice/' . $page . '.php')) {
			show_404();
		}
	
		$data['title'] = $page;
		$data['folder'] = "diceroll";
		$data['version'] = "dice";
	
		$this->load->view('dice/' . $page, $data);
	}

}

/* End of file dice.php */
/* Location: ./application/controllers/dice.php */