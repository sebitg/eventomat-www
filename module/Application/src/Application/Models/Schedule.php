<?php

namespace Application\Models;

use Zend\Form\Form;

class Schedule {
	
	private $id;
	private $day;
	private $time;
	private $name;
	
	public function __construct($id, $name, $day, $time) {
		$this->id = $id;
		$this->name = $name;
		$this->day = $day;
		$this->time = $time;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDay() {
		return $this->day;
	}
	
	public function getTime() {
		return $this->time;
	}
	
}