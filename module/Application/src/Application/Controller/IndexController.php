<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\ParseService;
use Application\Models\AddCommunityForm;
use Application\Models\AddEventForm;
use Application\Models\Community;
use Application\Models\Event;
use Parse\ParseObject;
use Parse\ParsePush;
use Application\Models\LoginForm;



class IndexController extends AbstractActionController
{
	
	private $logger;
	private $parseService;
	
	public function __construct() {
		$this->parseService = new ParseService();
	}
	
    public function indexAction()
    {
    	if($_SESSION["username"]!=null && $_SESSION["username"]!="") {
    		return $this->redirect()->toUrl("/application/index/loggedin");
    	}
    	$request = $this->getRequest();
    	if($request->isPost()) {
    		$_SESSION["username"] = $request->getPost('email');
    		return $this->redirect()->toUrl("/application/index/loggedin?msg=success");
    	}
        return new ViewModel();
    }
    
    /**
     * Log into the system
     */
    public function loggedinAction() {
    	if($_SESSION["username"]!=null && $_SESSION["username"]!="") {
    		return new ViewModel();
    	}
    	return $this->redirect()->toUrl("/application/index/index?msg=logRequired");
    }
    
    public function addCommunityAction() {
    	$form  = new AddCommunityForm();
    	$form->get('submit')->setAttribute('value', 'Add');
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			
    			//Using ParseService
    			$communityObject = new Community(null, $request->getPost('commName'));
    			$result = $this->parseService->addCommunity($communityObject);
    			
    		    return ($result) ? $this->redirect()->toUrl("/application/index/loggedin?msg=community-added") : 
    		    		$this->redirect()->toUrl("/application/index/loggedin?msg=community-not-added");
    		}
  	  	}
    	return array(
    		'form' => $form,
    	);
    }
    
    public function modifyCommunityAction() {
    	$items = $this->parseService->getCommunities();
    	return array(
    		"items" => $items	
    	);
    }
    
    public function modifyEventsAction() {
    	$items = $this->parseService->getEvents();
    	return array(
    			"items" => $items
    	);
    }
    
    public function addEventAction() {
    	$form  = new AddEventForm();
    	$form->get('submit')->setAttribute('value', 'Add');
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		//Using ParseService
    		$community = $this->parseService->getCommunity($request->getPost('communityId'));
    		if($community!=null) {
    			$eventObject = new Event(null, $request->getPost('eventName'), $community);
    			$result = $this->parseService->addEvent($eventObject);
    			return $this->redirect()->toUrl("/application/index/loggedin?msg=event-add-success");
    		}
    		return $this->redirect()->toUrl("/application/index/loggedin?msg=event-add-failure");
    	}
    	$communities = $this->parseService->getCommunities();
    	$form->setCommunities($communities);
    	return array(
    			'form' => $form,
    			'communities' => $communities
    	);
    }
    
    public function logoutAction() {
    	$_SESSION["username"] = null;
    	return $this->redirect()->toUrl("/application/index/index?msg=logged-out");
    }
    
    public function sendPushAction() {
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$message = $request->getPost('message');
    		if($message!=null && $message!="") {
    			$this->parseService->sendPushNotification($message);
    			return $this->redirect()->toUrl("/application/index/loggedin?msg=push-success");
    		}
    	}
    	return new ViewModel();
    }
    
    public function notificationsAction() {
    	$items = $this->parseService->getNews();
    	return array(
    		"items" => $items	
    	);
    }
    
    public function scheduleDeleteAction() {
    	$event   = $this->getEvent();
    	$matches = $event->getRouteMatch();
    	$scheduleId = $event->getRouteMatch()->getParam('id');
    	$items = $this->parseService->deleteSchedule($scheduleId);
    	return $this->redirect()->toUrl("/application/index/loggedin?msg=schedule-deleted-success");
    }
    
    public function getFeedbacksAction() {
    	$items = $this->parseService->getFeedbacks();
    	return array(
    			"items" => $items
    	);
    }
    
    
    public function eventDetailsAction() {
    	$request = $this->getRequest();
    	$event   = $this->getEvent();
    	$matches = $event->getRouteMatch();
    	$eventId = $event->getRouteMatch()->getParam('id');
    	
    	$event = $this->parseService->getEvent($eventId);
    	$schedules1 = $this->parseService->getSchedules("Friday");
    	$schedules2 = $this->parseService->getSchedules("Saturday");
    	$schedules3 = $this->parseService->getSchedules("Sunday");
    	return array(
    			"event" => $event,
    			"schedules1" => $schedules1,
    			"schedules2" => $schedules2,
    			"schedules3" => $schedules3,
    	);
    }

}