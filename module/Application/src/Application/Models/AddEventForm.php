<?php

namespace Application\Models;

use Zend\Form\Form;

class AddEventForm extends Form {
	
	public function __construct($name = null) {
		parent::__construct('index');
		
		$this->add(array(
				'name' => 'eventName',
				'type' => 'Text',
				'options' => array(
						'label' => 'Event name',
				),
		));
		
		$this->add(array(
				'name' => 'communityId',
				'type' => 'Select',
				'options' => array(
						'label' => 'Community',
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