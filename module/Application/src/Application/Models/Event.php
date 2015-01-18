<?php

namespace Application\Models;

use Zend\Form\Form;

class Event {
	
	private $id;
	private $name;
	private $community;
	
	public function __construct($id, $name, $community) {
		$this->id = $id;
		$this->name = $name;
		$this->community = $community;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getCommunity() {
		return $this->community;
	}
	
}