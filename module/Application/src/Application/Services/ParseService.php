<?php
namespace Application\Services;

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParsePush;

use Application\Models\Community;
use Application\Models\Event;
use Application\Models\News;
use Application\Models\Schedule;
use Application\Models\Feedback;


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
	
	
	public function getNews() {
		$communities = array();
		$query = new ParseQuery("News");
		$query->descending("createdAt");
		$results = $query->find();
		for ($i = 0; $i < count($results); $i++) {
			$object = $results[$i];
			$communities[$i] = new News($object->getObjectId(), $object->get('message'));
		}
		return $communities;
	}
	
	public function getSchedules($day) {
		$communities = array();
		$query = new ParseQuery("Schedule");
		if($day!=null) {
			$query->equalTo("Day", $day);
		}
		$query->ascending("Time");
		$results = $query->find();
		for ($i = 0; $i < count($results); $i++) {
			$object = $results[$i];
			$communities[$i] = new Schedule($object->getObjectId(), $object->get('Name'), $object->get('Day'), $object->get('Time'));
		}
		return $communities;
	}
	
	public function deleteSchedule($scheduleId) {
		$query = new ParseQuery("Schedule");
		try {
			$object = $query->get($scheduleId);
			$object->destroy();
			return true;
			// The object was retrieved successfully.
		} catch (ParseException $ex) {
			return false;
		}
	}
	
	public function getEvent($eventId) {
		$query = new ParseQuery("Events");
		try {
			$object = $query->get($eventId);
			return new Event($object->getObjectId(), $object->get('name'), $object->get('communityId'));
			// The object was retrieved successfully.
		} catch (ParseException $ex) {
			return null;
		}
	}
	
	public function getFeedbacks() {
		$query = new ParseQuery("Feedback");
		$query->descending("createdAt");
		$results = $query->find();
		try {
			$feedbacks = array();
			for ($i = 0; $i < count($results); $i++) {
				$object = $results[$i];
				$feedbacks[$i] = new Feedback($object->getObjectId(), $object->get('author'), $object->get('comment'));
			}
			return $feedbacks;
		} catch (ParseException $ex) {
			return null;
		}
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