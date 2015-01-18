<?php
namespace Application\Services;

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParsePush;

use Application\Models\Community;
use Application\Models\Event;


/**
 * Parse service class
 * @author mody
 *
 */
class ParseService {
	
	/**
	 * Logging in
	 */
	public function logIn($username, $password) {
		return null;
	}
	
	public function getCommunities() {
		$communities = array();
		$query = new ParseQuery("Community");
		$results = $query->find();
		for ($i = 0; $i < count($results); $i++) {
			$object = $results[$i];
			//echo $object->getObjectId() . ' - ' . $object->get('playerName');
			$communities[$i] = new Community($object->getObjectId(), $object->get('name'));
		}
		return $communities;
	}
	
	public function getCommunity($communityId) {
		$query = new ParseQuery("Community");
		try {
			return $query->get($communityId);
			// The object was retrieved successfully.
		} catch (ParseException $ex) {
			return null;
		}
	}
	
	public function addCommunity($communityObject) {
		$community = new ParseObject("Community");
		$community->set("name", $communityObject->getName());
		return $this->sendObject($community);
	}
	
	public function addEvent($eventObject) {
		$event = new ParseObject("Events");
		$event->set("name", $eventObject->getName());
		$event->set("communityId", $eventObject->getCommunity());
		return $this->sendObject($event);
	}
		
	public function getEvents() {
		$communities = array();
		$query = new ParseQuery("Events");
		$results = $query->find();
		for ($i = 0; $i < count($results); $i++) {
			$object = $results[$i];
			$communities[$i] = new Event($object->getObjectId(), $object->get('name'), $object->get('communityId'));
		}
		return $communities;
	}
	
	/**
	 * Send push
	 * @param unknown $message
	 */
	public function sendPushNotification($message) {
		$data = array("alert" => $message);
		ParsePush::send(array(
			"channel" => "default",
			"data" => $data,
			'type' => 'android'
		));
	}
	
	protected function sendObject($object) {
		try {
			$object->save();
			return true;
		} catch (ParseException $ex) {
			echo 'Failed to create new object, with error message: ' . $ex->getMessage();
			return false;
		}
	}
	
}