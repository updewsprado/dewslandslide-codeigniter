<?php

class Gintags_manager_model_test extends CIUnit_TestCase {

	public function setUp() {
		parent::setUp();
		$this->CI->load->model("Gintags_manager_model");
		$this->__gintags_manager_obj = $this->CI->Gintags_manager_model;
		$this->last_id = '';
	}

	public function testSampleTest() {
		$this->assertTrue(true);
	}

	public function testGetAllTags() {
		$gintags = $this->__gintags_manager_obj->getAllTags();
		$this->assertInternalType('array', $gintags);
		echo "Successfully get all tags";
	}

	public function testInsertGintagNarrative() {
		$data['tag'] = "Sample Tag Inserted";
		$data['communications'] = "communications";
		$data['tag_description'] = "Sample Tag Inserted";
		$data['narrative_input'] = "Sample Tag Inserted";
		$data['user'] = 56;
		$insertGintagNarrative = $this->__gintags_manager_obj->insertGintagNarrative($data);
		$this->assertTrue(true,$insertGintagNarrative);
		echo "Successfully Inserted";
	}

	public function testGetLastInsertedId(){
		$getLastInsertedId = $this->__gintags_manager_obj->getLastIdInserted();
		foreach ($getLastInsertedId as $key) {
			$this->last_id = $key->id;
		}
		$this->testUpdateGintagNarrative($this->last_id);
		$this->testDeleteGintagNarrative($this->last_id);
	}

	public function testUpdateGintagNarrative() {
		$data['tag_id'] = $this->last_id;
		$data['tag'] = "Sample Tag Updated";
		$data['communications'] = "communications";
		$data['tag_description'] = "Sample Description Updated";
		$data['narrative_input'] = "Sample Narrative Input Updated";
		$data['user'] = 56;
		$updateGintagNarrative = $this->__gintags_manager_obj->updateGintagNarrative($data);
		$this->assertTrue(true,$updateGintagNarrative);
		echo "Successfully Updated1 " . $this->last_id;
	}

	public function testGetAllGintagsNarrative() {
		$getAllGintagsNarrative = $this->__gintags_manager_obj->getAllGintagsNarrative();
		$this->assertInternalType('array', $getAllGintagsNarrative);
		echo "Successfully get all gintag narrative";
	}

	public function testDeleteGintagNarrative() {
		$data['id'] = $this->last_id;
		$deleteGintagNarrative = $this->__gintags_manager_obj->deleteGintagNarrative($data);
		$this->assertTrue(true,$deleteGintagNarrative);
		echo "Successfully Deleted";
	}
	
	public function testCheckMultipleSite() {
		$numbers = array(
			9178733301,
			9178722201,
			9178744401,
			9178723401,
		);
		$checkMultipleSite = $this->__gintags_manager_obj->checkMultipleSite($numbers);
		$this->assertInternalType('array', $checkMultipleSite);
		echo "Successfully check multiple site";
	}

	public function testGetGintagDetails() {
		$tag = array(
			'GroundMeas',
			'EwiResponse',
			'GroundObs'
		);
		$getGintagDetails = $this->__gintags_manager_obj->getGintagDetails($tag);
		$this->assertInternalType('array', $getGintagDetails);
		echo "Successfully get gintag details";
	}

	public function testCleanUpTestDatabase() {
		$this->__gintags_manager_obj->deleteLastAddedInGintagsManager();
		$this->__gintags_manager_obj->deleteLastAddedInGintagsReference();
	}

	//Testing for invalid inputs

	// public function testInvalidUpdateGintagNarrative() {
	// 	$data['tag_id'] = "A";
	// 	$data['tag'] = "TagForInvalid";
	// 	$data['tag_description'] = "TagDescriptionForInvalid";
	// 	$data['narrative_input'] = "TagNarrativeInputForInvalid";
	// 	$data['user'] = "56";
	// 	$insertGintagNarrative = $this->__gintags_manager_obj->updateGintagNarrative($data);
	// 	$this->assertInternalType('string',$insertGintagNarrative);
	// }

	// public function testInvalidUpdateReference() {
	// 	$data['tag_id'] = "A";
	// 	$data['tag'] = "TagForInvalid";
	// 	$insertGintagNarrative = $this->__gintags_manager_obj->updateGintagReference($data);
	// 	$this->assertInternalType('string',$insertGintagNarrative);
	// }

	

	// public function testInvalidDeleteGintagNarrative() {
	// 	$data['id'] = "X";
	// 	$deleteGintagNarrative = $this->__gintags_manager_obj->deleteGintagNarrative($data);
	// 	$this->assertInternalType('string',$deleteGintagNarrative);
	// }

	// public function testInvalidCheckMultipleSite() {
	// 	$numbers = array(
	// 		"YYY",
	// 		"AAA",
	// 		"mmm",
	// 		"hhh",
	// 	);
	// 	$checkMultipleSite = $this->__gintags_manager_obj->checkMultipleSite($numbers);
	// 	$this->assertInternalType('array', $checkMultipleSite);
	// }

	// public function testInvalidGetGintagDetails() {
	// 	$tag = array(
	// 		"",
	// 		"",
	// 		""
	// 	);
	// 	$getGintagDetails = $this->__gintags_manager_obj->getGintagDetails($tag);
	// 	$this->assertInternalType('array', $getGintagDetails);
	// }




}

