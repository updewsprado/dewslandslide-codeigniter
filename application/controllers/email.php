<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'senslopenotification@gmail.com',
			'smtp_pass' => 'september172013'
		);
		
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		
		$this->email->from('senslopenotification@gmail.com', 'Senslope Notification');
		$this->email->to('updews.prado@gmail.com');
		$this->email->subject('This is an email test');
		$this->email->message('It is working. Great!');
		
		//$path = $this->config->item('server_root');
		//$file = $path . '/attachments/yourInfo.txt';
		
		//$this->email->attach($file);
		
		if ($this->email->send()) {
			echo "Your email was sent, handsome";
		}
		else {
			show_error($this->email->print_debugger());
		}
	}
	
	public function alertcol()
	{
		//Load Required Models
		$this->load->model('Alert_model');
		$columnLinks = array();
		$ctr = 0;
		
		$data['nodeAlerts'] = $this->Alert_model->getColumnAlerts();
		
		//echo $data['nodeAlerts'];
		//echo count($data['nodeAlerts']);
		
		$count = count($data['nodeAlerts']);
		
		foreach ($data['nodeAlerts'] as $site) {
			//echo $nodeStatus['site'] . " " . $nodeStatus['node'] . "<Br/>";
			$columnLinks[$ctr++] = "www.dewslandslide.com/gold/site/" . $site;
		}
		 
		//echo json_encode($data['nodeAlerts']);
		foreach ($columnLinks as $col) {
			//echo $nodeStatus['site'] . " " . $nodeStatus['node'] . "<Br/>";
			echo "www.dewslandslide.com/gold/site/" . $col . "<Br/>";
		}
	}

    public function html()
	{       
	    $config = array(
	        'protocol' => 'smtp',
	        'smtp_host' => 'tls://smtp.gmail.com',
	        'smtp_port' => 465,
	        'smtp_user' => 'senslopenotification@gmail.com',
			'smtp_pass' => 'september172013',
	        'mailtype'  => 'html',
	        'charset'   => 'utf-8'
	    );
	
		$this->load->helper('url');
		$this->load->model('Alert_model');
		$this->load->model('Data_presence_Model');
	    $this->load->library('email', $config);
	    $this->email->set_newline("\r\n");
		
	    $this->email->from('senslopenotification@gmail.com', 'Senslope Notification');
		$this->email->to('updews.prado@gmail.com');
	
	    $this->email->subject('Test Email');
	
		$this->load->model('Weather_station_Model');
		$body = $this->Weather_station_Model->getRawAll('blcw', '2010-01-01', null);
	
	    $this->email->message($body);
	
	    if (!$this->email->send()){
	        echo 'fail to load html email';
	    }
	    else {
	        echo 'success to send html email';
	    }
	}
	
	public function multi()
	{       
	    $config = array(
	        'protocol' => 'smtp',
	        'smtp_host' => 'tls://smtp.gmail.com',
	        'smtp_port' => 465,
	        'smtp_user' => 'senslopenotification@gmail.com',
			'smtp_pass' => 'september172013',
	        'mailtype'  => 'html',
	        'charset'   => 'utf-8'
	    );
	
		$this->load->helper('url');
		$this->load->model('Alert_model');
		$this->load->model('Data_presence_Model');
	    $this->load->library('email', $config);
	    $this->email->set_newline("\r\n");
		
		$mailList = ['updews.prado@gmail.com', 'senslopenotification@gmail.com'];
		
	    $this->email->from('senslopenotification@gmail.com', 'Senslope Notification');
		$this->email->to($mailList);
		//$this->email->to('updews.prado@gmail.com');
	
	    $this->email->subject('Test Email');
	
		$this->load->model('Weather_station_Model');
		$body = $this->Weather_station_Model->getRawAll('blcw', '2010-01-01', null);
	
	    $this->email->message($body);
	
	    if (!$this->email->send()){
	        echo 'fail to load html email';
	    }
	    else {
	        echo 'success to send html email';
	    }
	}

	public function alertcolumn()
	{       
	    $config = array(
	        'protocol' => 'smtp',
	        'smtp_host' => 'tls://smtp.gmail.com',
	        'smtp_port' => 465,
	        'smtp_user' => 'senslopenotification@gmail.com',
			'smtp_pass' => 'september172013',
	        'mailtype'  => 'html',
	        'charset'   => 'utf-8'
	    );
	
		$this->load->helper('url');
		$this->load->model('Alert_model');
	    $this->load->library('email', $config);
	    $this->email->set_newline("\r\n");
		
		//$mailList = ['updews.prado@gmail.com', 'senslopenotification@gmail.com'];

		$mailList = ['earl.mendoza@gmail.com',
					'ricsatjr@gmail.com',
					//'piereluya@gmail.com',
					'kennexrazon@gmail.com',
					'mizpah.capina@gmail.com',
					'marklaurence07@gmail.com',
					'updews.prado@gmail.com'];
		
	    $this->email->from('senslopenotification@gmail.com', 'Senslope Notification');
		$this->email->to($mailList);
	
	    $this->email->subject('Senslope Column Alert (' . date("Y-m-d") . ')');
	
		$data['nodeAlerts'] = $this->Alert_model->getColumnAlerts();
		
		if ($data['nodeAlerts'] == null) {
			echo "no data found, no email was sent";
		} else {
			$body = '<p>Good Day Senslope and Dynaslope!</p>
					<p>You received this email because there are possible movements that have been detected by our system.
					Please check the links below to verify the validity of the movements or to give an early warning to the
					locals residing in the areas of concern.</p><br/>
					<p>Regards,</p>
					<p>Senslope Automated Alert Notification</p><br/>
					<p><a href="http://www.dewslandslide.com">Visit Main Monitoring Page</a></p>';
					
			foreach ($data['nodeAlerts'] as $col) {
				$body = $body . '<p><a href="http://www.dewslandslide.com/gold/site/' . $col . '">Visit ' . $col . '</a></p>';
			}
		
		    $this->email->message($body);
		
		    if (!$this->email->send()){
		        echo 'fail to load html email';
		    }
		    else {
		        echo 'succeeded to send html email';
		    }
		}
	}

	public function alertdatapres()
	{       
	    $config = array(
	        'protocol' => 'smtp',
	        'smtp_host' => 'tls://smtp.gmail.com',
	        'smtp_port' => 465,
	        'smtp_user' => 'senslopenotification@gmail.com',
			'smtp_pass' => 'september172013',
	        'mailtype'  => 'html',
	        'charset'   => 'utf-8'
	    );
	
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
	    $this->load->library('email', $config);
	    $this->email->set_newline("\r\n");
		
		/*
		$mailList = ['updews.prado@gmail.com', 'senslopenotification@gmail.com'];
		 */
		 
		$mailList = ['ggilbertluis@gmail.com'];
		
	    $this->email->from('senslopenotification@gmail.com', 'Senslope Notification');
		$this->email->to($mailList);
	
	    $this->email->subject('Senslope No Data Alert (' . date("Y-m-d") . ')');
	
		$data['noData'] = $this->Data_presence_Model->getAllDataPresAlert();
		
		/*
		foreach ($data['noData'] as $col) {
			echo "Column: " . $col['site'] . ", Last Data Received: " . $col['timestamp'] . "\n";
		}
		 */
		
		if ($data['noData'] == null) {
			echo "no data found, no email was sent";
		} else {
			$body = '<p>Good Day Senslope and Dynaslope!</p>
					<p>You received this email because the system has detected columns that are not sending data.
					Please check the links below to verify the conditions of the detected columns or to give an early warning to the
					locals residing in the areas of concern.</p><br/>
					<p>Regards,</p>
					<p>Senslope Automated Alert Notification</p><br/>
					<p><a href="http://www.dewslandslide.com">Visit Main Monitoring Page</a></p>';
					
			foreach ($data['noData'] as $col) {
				$body = $body . '<p><a href="http://www.dewslandslide.com/gold/site/' . $col['site'] . '">' . 
						$col['site'] . '</a>' . ': no data received for ' . $col['timestamp'] . ' days</p>';
			}
		
		    $this->email->message($body);
		
		    if (!$this->email->send()){
		        echo 'fail to load html email';
		    }
		    else {
		        echo 'succeeded to send html email';
		    }
		}

	}
}

/* End of file email.php */
/* Location: ./application/controllers/email.php */


































