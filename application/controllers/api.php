<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class API extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_level_model');
		$this->load->model('node_level_model');
		$this->load->model('comm_health_model');
	}

		public function PiezometerAllData($site){ // example  http://localhost/api/PiezometerAllData/ltesapzpz
			$result = $this->site_level_model->getPiezometer($site);
			print json_encode($result);
		}

		public function CommunicationHealthColumn($site){ // example  http://localhost/api/CommunicationHealthColumn/agbsb
			$result = $this->comm_health_model->getHealth($site);
			print json_encode($result);
		}

		public function TotalHealth($site){ // example  http://localhost/api/TotalHealth/agbsb
			$result = $this->comm_health_model->getHealthTotal($site, 'json');
			print json_encode($result);
		}

		public function DataPresence($site){ // example  http://localhost/api/DataPresence/agbsb
			$result = $this->comm_health_model->getDataPresenceTotal($site, 'json');
			print json_encode($result);
		}

		public function AllSiteNames(){ // example  http://localhost/api/AllSiteNames
			$result = $this->site_level_model->getSiteNames();
			print json_encode($result);
		}

		public function SiteDetails($site){ // example http://localhost/api/SiteDetails/agb
			$result = $this->site_level_model->getSiteColumn($site);
			print json_encode($result);

		}

		public function NodeNumberPerSite($site){ // example http://localhost/api/NodeNumberPerSite/agbta
			$result = $this->site_level_model->getSiteNodeNumber($site);
			print json_encode($result);

		}

		public function AllSiteDetails(){ // example http://localhost/api/AllSiteDetails
			$result = $this->site_level_model->getAllSiteColumn();
			print json_encode($result);

		}
		public function RainSenslope($rsite,$fdate,$tdate){ // example http://localhost/api/RainSenslope/blcw/2016-05-25/2016-06-25
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\rainfallNewGetData.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/rainfallNewGetData.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$rsite.' '.$fdate.' '.$tdate;

			exec($command, $output, $return);
			print json_encode($output);

		}

		public function RainNoah($rsite,$fdate,$tdate){ // example http://localhost/api/RainNoah/1104/2014-05-25/2016-06-25
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\rainfallNewGetDataNoah.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/rainfallNewGetDataNoah.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$rsite.' '.$fdate.' '.$tdate;

			exec($command, $output, $return);
			print json_encode($output);

		}

		public function RainARQ($rsite,$fdate,$tdate){ //example http://localhost/api/RainARQ/agbtaw/2014-05-25/2016-06-25
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\rainfallNewGetDataARQ.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/rainfallNewGetDataARQ.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$rsite.' '.$fdate.' '.$tdate;

			exec($command, $output, $return);
			print json_encode($output);

		}

		public function AccelUnfilteredData($site,$fdate,$tdate,$nid,$ms){ //example http://localhost/api/AccelUnfilteredData/cudtb/2014-05-25/2016-06-25/1/32
			$result = $this->node_level_model->getAccelRaw($site,$fdate,$tdate,$ms,$nid);
			print json_encode($result);
		}



		public function SomsUnfilteredData($site,$fdate,$tdate,$nid,$ms){ // example http://localhost/api/SomsUnfilteredData/laysb/2014-05-25/2016-06-25/1/11
			$result = $this->node_level_model->getSomsRaw($site,$fdate,$tdate,$ms,$nid);
			print json_encode($result);
		}

		public function AccelfilteredData($site,$fdate,$tdate,$nid,$ms){// example http://localhost/api/AccelfilteredData/cudtb/2014-05-25/2016-06-25/1/32
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\accelfilteredData.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/accelfilteredData.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command =$pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid.' '.$ms;
			exec($command, $output, $return);
			print json_encode($output);

		}

		public function AccelfilteredDataIn($site,$fdate,$tdate,$nid,$ms){// example http://localhost/api/AccelfilteredDataIn/cudtb/2014-05-25/2016-06-25/1-2-3/32
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\accelfilteredDataIn.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/accelfilteredDataIn.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command =$pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid.' '.$ms;
			exec($command, $output, $return);
			print json_encode($output);

		}
		public function AccelfilteredVersion1($site,$fdate,$tdate,$nid){// example http://localhost/api/AccelfilteredVersion1/blcb/2014-05-25/2016-06-25/1
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\accelfiteredVersion1.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/accelfiteredVersion1.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command =$pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid;
			exec($command, $output, $return);
			print json_encode($output);

		}

		public function AccelfilteredVersion1In($site,$fdate,$tdate,$nid){// example http://localhost/api/AccelfilteredVersion1In/blcb/2014-05-25/2016-06-25/1-2-3
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\accelfiteredVersion1In.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/accelfiteredVersion1In.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command =$pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid;
			exec($command, $output, $return);
			print json_encode($output);

		}

		public function SomsfilteredData($site,$fdate,$tdate,$nid,$mode){ //example http://localhost/api/SomsfilteredData/laysb/2014-05-25/2016-06-25/2/0

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\somsFilter.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/somsFilter.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid.' '.$mode;

			exec($command, $output, $return);
			print json_encode($output);

			
		}

		public function SomsfilteredDataIn($site,$fdate,$tdate,$mode){ //example http://localhost/api/SomsfilteredData/laysb/2014-05-25/2016-06-25/0

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\somsFilterIn.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/somsFilterIn.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$mode;

			exec($command, $output, $return);
			print json_encode($output);

			
		}

		public function SomsVS2($site,$fdate,$tdate,$nid,$mode){ // example http://localhost/api/SomsVS2/agbsb/2014-05-25/2016-06-25/2/0

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\somsV2.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/somsV2.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate.' '.$nid.' '.$mode;

			exec($command, $output, $return);
			print json_encode($output);

			
		}

		public function GroundDataFromLEWS($gsite){ // example http://localhost/api/GroundDataFromLEWS/AGB
			$os = PHP_OS;
			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\gndmeasfull.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/gndmeasfull.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$gsite;

			exec($command, $output, $return);
			print json_encode($output);
		}

		public function GroundDataFromLEWSInRange($gsite,$fdate,$tdate){ // example http://localhost/api/GroundDataFromLEWSInRange/AGB/2013-01-01/2017-01-01
			$os = PHP_OS;
			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\gndmeasInRange.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/gndmeasInRange.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$gsite.' '.$fdate.' '.$tdate;

			exec($command, $output, $return);
			print json_encode($output);
		}


		public function GroundVelocityDisplacementData($site,$cid){ // example http://localhost/api/GroundVelocityDisplacementData/AGB/A

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\ground.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/ground.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$site.' '.$cid;

			exec($command, $output, $return);
			print json_encode($output[0]);
			
		}

		public function SensorColumnPosition($site,$fdate,$tdate){ // example http://localhost/api/SensorColumnPosition/agbsb/2016-04-25/2016-05-25

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\colposgen.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/colposgen.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate;
			exec($command, $output, $return);
			print json_encode($output[0]);
			
		}

		public function SensorAllAnalysisData($site,$fdate,$tdate){ // example http://localhost/api/SensorAllAnalysisData/agbsb/2016-04-25/2016-05-25

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\allDataGen.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/allDataGen.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate;
			exec($command, $output, $return);
			print json_encode($output);
			
		}

		public function SensorDisplacementPosition($site,$fdate,$tdate){ // example http://localhost/api/SensorDisplacementPosition/agbsb/2016-04-25/2016-05-25

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\disgen.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/disgen.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate;
			exec($command, $output, $return);
			print json_encode($output);
			
		}

		public function SensorVelocity($site,$fdate,$tdate){ // example http://localhost/api/SensorVelocity/agbsb/2016-04-25/2016-05-25

			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\velocitygen.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/html/ajax/velocitygen.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}

			$command = $pythonPath.' '.$fileName.' '.$site.' '.$fdate.' '.$tdate;
			exec($command, $output, $return);
			print json_encode($output[0]);
			
		}

		public function last10GroundData($site){ //example http://localhost/api/last10GroundData/agb
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\lastGroundData.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/lastGroundData.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site;

			exec($command, $output, $return);
			print json_encode($output[0]);

		}

		public function heatmap($site,$tdate,$days){ //example http://localhost/api/heatmap/agb
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\heatmap-visual.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Analysis/Soms/heatmap.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site.' '.$tdate.' '.$days;

			exec($command, $output, $return);
			print json_encode($output[0]);

		}
		public function rainfallScanner(){ //example http://localhost/api/rainfallScanner
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\rainfallScanner.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/rainfallScanner.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName;

			exec($command, $output, $return);
			print json_encode($output);

		}


	}
	?>