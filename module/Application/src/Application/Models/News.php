<?php

namespace Application\Models;

use Zend\Form\Form;

class News {
	
	private $id;
	private $message;
	
	public function __construct($id, $message) {
		$this->id = $id;
		$this->message = $message;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
}