<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class api_testing extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('api_modal');
	}

		public function SitesData(){ // example  http://localhost/api_testing/SitesData
			$result = $this->api_modal->getSiteNames();
			print json_encode($result);
		}

		public function SpecificSiteDetails($site){ // example  http://localhost/api_testing/SpecificSiteDetails/agb
			$result = $this->api_modal->getSpecificSiteDetails($site);
			print json_encode($result);
		}

		public function ColumnNames(){ // example  http://localhost/api_testing/ColumnNames
			$result = $this->api_modal->getColumnNames();
			print json_encode($result);
		}

		public function SpecificColumnNames($site){ // example  http://localhost/api_testing/SpecificColumnNames/agb
			$result = $this->api_modal->getSpecificColumnNames($site);
			print json_encode($result);
		}

		public function PerNodeTimestamp($site,$from,$to){ // example  http://localhost/api_testing/PerNodeTimestamp/cudtb/2017-02-01 10:01:00/2017-02-01 13:31:00
			$result = $this->api_modal->getPerNodeTimestamp($site,str_replace("%20"," ",$from),str_replace("%20"," ",$to));
			print json_encode($result);
		}


		public function SpecificSiteRainGauge($site){ // example  http://localhost/api_testing/SpecificSiteRainGauge/agb
			$result = $this->api_modal->getSpecificSiteRainGauge($site);
			print json_encode($result);
		}

		public function EarthquakeEvent($from,$to){ 
			$result = $this->api_modal->getEarthquakeEvent($to,$from);
			print json_encode($result);
		}
	}
?>