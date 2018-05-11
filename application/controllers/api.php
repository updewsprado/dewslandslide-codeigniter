<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class API extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_level_model');
		$this->load->model('node_level_model');
		$this->load->model('comm_health_model');
		$this->load->model('pubrelease_model');
	}
		public function latestSensorData($site){ // example http://localhost/api/latestSensorData/agbsb
			$result = $this->node_level_model->getlatestSensorData($site);
			print json_encode($result);
		}
		public function latestGroundData($site){ // example http://localhost/api/latestGroundData/agbsb
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
			$result = $this->node_level_model->getlatestGroundData($site_name);
			print json_encode($result);
		}
		public function AccelBatteryThreshold($site,$node){ // example  http://localhost/api/AccelBatteryThreshold/agbsb/2
			$result = $this->node_level_model->getAccelBatteryThreshold($site,$node);
			print json_encode($result);
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

		public function SpecificSiteNum($site){ // example http://localhost/api/SpecificSiteNum/mag
			$result = $this->site_level_model->getSiteidNum($site);
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

		public function GroundDataFromLEWS($site){ // example http://localhost/api/GroundDataFromLEWS/AGB
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
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

			$command = $pythonPath.' '.$fileName.' '.$site_name;

			exec($command, $output, $return);
			print json_encode($output);
		}

		public function GroundDataFromLEWSInRange($site,$fdate,$tdate){ // example http://localhost/api/GroundDataFromLEWSInRange/AGB/2013-01-01/2017-01-01
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
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

			$command = $pythonPath.' '.$fileName.' '.$site_name.' '.$fdate.' '.$tdate;

			exec($command, $output, $return);
			print json_encode($output);
		}


		public function GroundVelocityDisplacementData($site,$cid){ // example http://localhost/api/GroundVelocityDisplacementData/AGB/A
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
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

			$command = $pythonPath.' '.$fileName.' '.$site_name.' '.$cid;

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
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
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
			
			$command = $pythonPath.' '.$fileName.' '.$site_name;

			exec($command, $output, $return);
			print json_encode($output[0]);

		}

		public function last10Computation($site){ //example http://localhost/api/last10Computation/agb
			if($site == "mng"){
				$site_name = "man";
			}else if( $site == "png"){
				$site_name = "pan";
			}else if($site == "bto"){
				$site_name = "bat";
			}else if($site == "jor"){
				$site_name = "pob";
			}else{
				$site_name = $site;
			}
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Liaison-mysql\gndmeasComputation.py';
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$pythonPath = '/home/ubuntu/anaconda2/bin/python';
				$fileName = '/var/www/updews-pycodes/Liaison/gndmeasComputation.py';
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			
			$command = $pythonPath.' '.$fileName.' '.$site_name;

			exec($command, $output, $return);
			print json_encode($output[0]);

		}

		public function heatmap($site,$tdate,$days){ //example http://localhost/api/heatmap/agb
			$os = PHP_OS;

			if (strpos($os,'WIN') !== false) {
				$pythonPath = 'c:\Users\USER\Anaconda2\python.exe';
				$fileName = 'C:\xampp\updews-pycodes\Analysis\Soms\heatmap.py';
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
			print json_encode($output[sizeof($output)-1]);

		}

		public function time_execution(){
			$data_result = $_POST['data'];

			$os = PHP_OS;
			if (strpos($os,'WIN') !== false) {
				$file = fopen('C:\xampp\htdocs\temp\data\sub_runtime_js.csv', 'a');
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$file = fopen('/var/www/html/temp/data/sub_runtime_js.csv', 'a');
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			foreach ($data_result as $row){fputcsv($file, $row);}
			fclose($file);
			print json_encode($data_result);

		}

		public function time_execution_all(){
			$data_result = $_POST['data'];
			$os = PHP_OS;
			if (strpos($os,'WIN') !== false) {
				$file = fopen('C:\xampp\htdocs\temp\data\sub_runtime_all.csv', 'a');
			}
			elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
				$file = fopen('/var/www/html/temp/data/sub_runtime_all.csv', 'a');
			}
			else {
				echo "Unknown OS for execution... Script discontinued";
				return;
			}
			$data = array(
				array($data_result[0], $data_result[1]),
			);
			foreach ($data as $row)
			{
				fputcsv($file, $row);
			}
			print json_encode($data_result);

		}
	
	public function getStaff()
	{
		echo $this->pubrelease_model->getStaff();
	}

	public function getAllReleasesWithEventDetails()
	{
		echo $this->pubrelease_model->getAllReleasesWithEventDetails();
	}

	public function getMOM($site_code = "all", $start = null, $end = null)
	{
		$this->load->model('manifestations_model');
		echo $this->manifestations_model->getMOMApi($site_code, $start, $end);
	}

	}
	?>
