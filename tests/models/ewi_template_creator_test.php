<?php

class Ewi_template_model_test extends CIUnit_TestCase {

	public function setUp() {
		parent::setUp();
		$this->CI->load->model('Ewi_template_model');
		$this->__ewi_template_obj = $this->CI->Ewi_template_model;
		$this->first_id = "";
		$this->second_id = "";
		$this->bb_id = "";
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
	  	$this->first_id = $ids[0]->id;
	  	$this->second_id = $ids[1]->id;
	}

	public function testUpdateAlertStatusTemplate() {
		$data = new stdClass();
		$data->id = $this->first_id;
		$data->alert_symbols = 'TEST';
		$data->techinfo_template = 'Test Technical info';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_level = 'TEST';
		$data->response_template = 'Test Response';
	  	$data->alert_status = 'TEST UPDATE';
	  	$updateTemplate = $this->__ewi_template_obj->update($data);
	  	$this->assertTrue($updateTemplate);
	}

	public function testUpdateAlertSymbolTemplate() {
		$data = new stdClass();
		$data->id = $this->second_id;
		$data->techinfo_template = 'Test Technical info';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = 'TEST';
		$data->alert_level = 'TEST';
		$data->response_template = 'Test Response';
	  	$data->alert_symbols = 'TEST UPDATE';
	  	$updateTemplate = $this->__ewi_template_obj->update($data);
	  	$this->assertTrue($updateTemplate);
	}

	public function testUpdateAlertLevelTemplate() {

		$data = new stdClass();
		$data->id = $this->first_id;
		$data->alert_symbols = 'TEST';
		$data->techinfo_template = 'Test Technical info';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = 'TEST';
		$data->response_template = 'Test Response';
	  	$data->alert_level = 'TEST UPDATE';
	  	$updateTemplate = $this->__ewi_template_obj->update($data);
	  	$this->assertTrue($updateTemplate);
	}

	public function testUpdateTechInfoTemplate() {
		$data = new stdClass();
		$data->id = $this->second_id;
		$data->alert_symbols = 'TEST';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = 'TEST';
		$data->response_template = 'Test Response';
	  	$data->alert_level = 'TEST UPDATE';
	  	$data->techinfo_template = 'Updated test Technical info';
	  	$updateTemplate = $this->__ewi_template_obj->update($data);
	  	$this->assertTrue($updateTemplate);
	}

	public function testUpdateRecommResponseTemplate() {
		$data = new stdClass();
		$data->id = $this->first_id;
		$data->alert_symbols = 'TEST';
		$data->techinfo_template = 'Test Technical info';
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = 'TEST';
	  	$data->alert_level = 'TEST UPDATE';
	  	$data->response_template = 'Updated test Response';
	  	$updateTemplate = $this->__ewi_template_obj->update($data);
	  	$this->assertTrue($updateTemplate);
	}

	public function testGetKeyViaTriggerType() {
		$key_input = $this->__ewi_template_obj->getKeyViaTriggerType('TEST');
		$this->assertInternalType('array',$key_input);
	}

	public function testDeleteAlertLevelTemplate() {
		$data = new stdClass();
		$data->id = $this->first_id;
		$deleteTemplate = $this->__ewi_template_obj->delete($data);
		$this->assertTrue($deleteTemplate); 
	}

	public function testDeleteAlertStatusTemplate() {
		$data = new stdClass();
		$data->id = $this->second_id;
		$deleteTemplate = $this->__ewi_template_obj->delete($data);
		$this->assertTrue($deleteTemplate); 
	}

	public function testInsertNewBackbone() {
		$data = new stdClass();
		$data->alert_status = "TEST";
		$data->backbone_message = "TEST BACKBONE MESSAGE";
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$newBackbone = $this->__ewi_template_obj->addBackbone($data);
		$this->assertTrue($newBackbone);
	  	// For cleanup
	  	$ids = $this->__ewi_template_obj->getLastInsertedBBForTesting();
	  	$this->bb_id = $ids[0]->id;
	}

	public function testGetBackBoneViaAlertStatus() {
		$backbone_template = $this->__ewi_template_obj->getBbViaAlertStatus('TEST');
		$this->assertInternalType('array',$backbone_template);
	}

	public function testUpdateBackboneTemplate() {
		$data = new stdClass();
		$data->id = $this->bb_id;
		$data->backbone_message = "TEST BACKBONE MESSAGE";
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = "TEST UPDATE STATUS";
		$update_backbone_template = $this->__ewi_template_obj->updateBackbone($data);
		$this->assertTrue($update_backbone_template);
	}

	public function testUpdateAlertStatusBackbone() {
		$data = new stdClass();
		$data->id = $this->bb_id;
		$data->last_modified = '3013-01-01 04:20 AM/John/56';
		$data->alert_status = "TEST UPDATE STATUS";
		$data->backbone_message = "TEST UPDATE TEMPLATE";
		$update_backbone_template = $this->__ewi_template_obj->updateBackbone($data);
		$this->assertTrue($update_backbone_template);
	}

	public function testDeleteBackbone() {
		$data = new stdClass();
		$data->id = $this->bb_id;
		$delete_backbone_template = $this->__ewi_template_obj->deleteBackbone($data);
		$this->assertTrue($delete_backbone_template);
	}

	public function testGetAlertStatuses() {
		$status = $this->__ewi_template_obj->getAlertStatuses();
		$this->assertInternalType('array',$status);
	}

	// Invalid input section.
	public function testInsertInvalidBackbone() {

	}

	public function testInvalidTemplate() {

	}

}

?>