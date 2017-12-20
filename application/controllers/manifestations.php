<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manifestations extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('manifestations_model');
	}

	public function index()
	{
		$this->is_logged_in();

		$data['title'] = 'DEWS-L Manifestations of Movement Page';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");

		// $data['events'] = json_encode('null');
		// $data['sites'] = $this->monitoring_model->getSites();
		// $data['staff'] = $this->monitoring_model->getStaff();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('data_analysis/manifestations_view', $data);
		$this->load->view('templates/footer');
	}

	public function individual_site($site_code)
	{
		$this->is_logged_in();

		$data['title'] = 'DEWS-L Manifestations of Movement Page';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");

		$data['site_code'] = $site_code;
		$data['site_id'] = $this->manifestations_model->getSiteID($site_code);
		$data['event_status'] = $this->manifestations_model->getLastEventStatus($data['site_id']);
		$data['staff'] = $this->manifestations_model->getStaff();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('data_analysis/manifestations_individual', $data);
		$this->load->view('templates/footer');
	}

	public function getMOM($site_code = "all", $start = null, $end = null)
	{
		echo $this->manifestations_model->getMOMApi($site_code, $start, $end);
	}

	public function getLatestMOMperSite()
	{
		echo $this->manifestations_model->getLatestMOMperSite();
	}

	public function getAllMOMforASite($site_code)
	{
		$draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
		$orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
		$orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
		$orderType = $_POST['order'][0]['dir']; // ASC or DESC
		$start  = $_POST["start"];//Paging first record indicator.
		$length = $_POST['length'];//Number of records that the table can display in the 
		                           //current draw
		$extraFilter = $_POST['extra_filter'];

		$extraFilter['hasFilter'] = true;
		$site_id = $this->manifestations_model->getSiteID($site_code);
		$extraFilter['filterList']['site_id'] = $site_id;

		function addTableName($x)
		{
			switch ($x) {
				case 'manifestation_id':
				case 'ts_observance':
				case 'op_trigger':
					$x = "public_alert_manifestation." . $x;
					break;
				case 'site_id':
				case 'feature_type':
				case 'feature_name':
					$x = "manifestation_features." . $x;
					break;
			}

			return $x;
		}

		$filter = [];
        foreach ($extraFilter['filterList'] as $key => $value) {
        	if( $value != null ) $filter[ addTableName($key) ] = $value;
        }
        $filter = count($filter) == 0 ? null : $filter;

		$recordsTotal = $this->manifestations_model->getCount(null, $filter);

		$orderBy = addTableName($orderBy);

		if( !empty($_POST['search']['value']) || $extraFilter['hasFilter'] != false )
		{
			$search = [];
			if( $_POST['search']['value'] != '' )
			{
				for( $i=0; $i<count( $_POST['columns'] ); $i++ ) 
				{
					$data = $_POST['columns'][$i]['data'];
					if( $data != '' )
					{
						$x = addTableName( $data );
		            	$search[ $x ] = $_POST['search']['value'];
					}
		        }
		    }
	        $search = count($search) == 0 ? null : $search;

	        $recordsFiltered = $this->manifestations_model->getCount($search, $filter);
	        $data = $this->manifestations_model->getAllMOMforASite($search, $filter, $orderBy, $orderType, $start, $length);
		}
		else {
			$data = $this->manifestations_model->getAllMOMforASite(null, null, $orderBy, $orderType, $start, $length);
			$recordsFiltered = $recordsTotal;
		}

		$response = array (
	        "draw" => $draw,
	        "recordsTotal" => $recordsTotal,
	        "recordsFiltered" => $recordsFiltered,
	        "data" => $data
	    );

		// $result = $this->manifestations_model->getAllEvents();
		echo json_encode($response);
	}

	public function saveM0Manifestation()
	{	
		$feature = array(
			'site_id' => $_POST['site_id'],
			'feature_name' => isset($_POST['feature_name']) ? $_POST['feature_name'] : null,
			'feature_type' => $_POST['feature_type']
		);

		$feature_id = $this->manifestations_model->insertIfNotExists('manifestation_features', $feature);

		$manifestation = array(
			"release_id" => null,
			"feature_id" => $feature_id,
			"validator" => $_POST['manifestation_validator'],
			"op_trigger" => 0,
			"reporter" => $_POST['reporter'],
			"ts_observance" => $_POST["observance_timestamp"],
			"narrative" => isset($_POST['feature_narrative']) ? $_POST['feature_narrative'] : null,
			"remarks" => isset($_POST['feature_remarks']) ? $_POST['feature_remarks'] : null
		);

		$this->manifestations_model->insert('public_alert_manifestation', $manifestation);
	}

	public function getDistinctFeatureTypes()
	{
		echo $this->manifestations_model->getDistinctFeatureTypes();
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

/* End of file manifestations.php */
/* Location: ./application/controllers/manifestations.php */

?>
