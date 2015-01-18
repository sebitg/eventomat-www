<?php

namespace Application\Models;

use Zend\Form\Form;

class AddCommunityForm extends Form {
	
	public function __construct($name = null) {
		parent::__construct('index');
		
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'commName',
				'type' => 'Text',
				'options' => array(
						'label' => 'Community name',
				),
		));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
	}
	
}