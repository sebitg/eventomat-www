<?php

namespace Application\Models;

use Zend\Form\Form;

class LoginForm extends Form {
	
	public function __construct($name = null) {
		parent::__construct('index');
		
		$this->add(array(
				'name' => 'email',
				'type' => 'Text',
				'options' => array(
						'label' => 'Email',
				),
		));
		
		$this->add(array(
				'name' => 'password',
				'type' => 'Password',
				'options' => array(
						'label' => 'Password',
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Log in',
						'id' => 'submitbutton',
				),
		));
	}
	
}