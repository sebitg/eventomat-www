<?php

namespace Application\Models;

use Zend\Form\Form;

class Community {
	
	private $id;
	private $name;
	
	public function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
}