<?php

class Gintags_manager_model_test extends CIUnit_TestCase {

	public function setUp() {
		parent::setUp();
		$this->CI->load->model("Gintags_manager_model");
		$this->__gintags_manager_obj = $this->CI->Gintags_manager_model;
	}

	public function testSampleTest() {
		$this->assertTrue(true);
	}

	public function testGetAllTags() {
		$gintags = $this->__gintags_manager_obj->getAllTags();
		// $this->assertInternalType('array', $gintags);
		var_dump($gintags);
	}

	public function testInsertGintagNarrative() {
		$data->tag = "Sample Tag";
		$data->tag_description = "Sample Description";
		$data->narrative_input = "Sample Narrative Input";
		$data->user = 56;
		$gintags = $this->__gintags_manager_obj->insertGintagNarrative($data);
		$this->assertTrue(true);
	}




}

