<?php

namespace Application\Models;

use Zend\Form\Form;

class Feedback {
	
	private $id;
	private $author;
	private $comment;
	
	public function __construct($id, $author, $comment) {
		$this->id = $id;
		$this->author = $author;
		$this->comment = $comment;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getComment() {
		return $this->comment;
	}
	
}