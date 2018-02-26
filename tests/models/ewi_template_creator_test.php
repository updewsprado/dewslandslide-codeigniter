<?php

class Ewi_template_model_test extends CIUnit_TestCase {

	public $first_id;
	public $second_id;

	public function setUp() {
		parent::setUp();
		$this->CI->load->model('Ewi_template_model');
		$this->__ewi_template_obj = $this->CI->Ewi_template_model;
	}
	
	public function tearDown() {
		parent::tearDown();
		//Clean db.
	}

	public function testGetAllTemplates() {
		$templates = $this->__ewi_template_obj->getAll();
		//return false if query failed.
		$this->assertInternalType('array',$templates);
	}

	public function testGetAllBackboneTemplates() {
		$templates = $this->__ewi_template_obj->getAllBackbone();
		$this->assertInternalType('array',$templates);
	}

	public function testInsertNewTemplate() {
		
		$data = new stdClass();
		$data->alert_symbols = 'TEST';
		$data->techinfo_template = 'Test Technical info';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = 'TEST';
		$data->alert_level = 'TEST';
		$data->response_template = 'Test Response';
	  	$newTemplate = $this->__ewi_template_obj->add($data);
	  	$this->assertTrue(true,$newTemplate);

	  	// For cleanup
	  	$ids = $this->__ewi_template_obj->getLastTwoIds();
	  	$first_id = $ids[0]->id;
	  	$second_id = $ids[1]->id;
	}

	public function testUpdateAlertStatusTemplate() {
	  	$data->alert_status = 'TEST UPDATE';
	}

	public function testUpdateAlertSymbolTemplate() {
	  	$data->alert_symbols = 'TEST UPDATE';
	}

	public function testUpdateAlertLevelTemplate() {
	  	$data->alert_level = 'TEST UPDATE';
	}

	public function testUpdateTechInfoTemplate() {
	  	$data->techinfo_template = 'Updated test Technical info';
	}

	public function testUpdateRecommResponseTemplate() {
	  	$data->response_template = 'Updated test Response';
	}

	public function testDeleteTemplate() {

	}

	public function testInsertNewBackbone() {

	}

	public function testUpdateBackbone() {

	}

	public function testUpdateAlertStatusBackbone() {

	}
}

?>