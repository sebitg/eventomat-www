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
use Parse\ParseObject;
use Application\Models\LoginForm;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
//     	$testObject = ParseObject::create("TestObject");
//     	$testObject->set("foo", "bar");
//     	$testObject->save();

//     	$form  = new LoginForm();
//     	$form->get('submit')->setAttribute('value', 'Log in');
//     	$request = $this->getRequest();
//     	if ($request->isPost()) {
//     		$form->setData($request->getPost());
//     		if ($form->isValid()) {
//     			$_SESSION["username"] = $form->get("email");
//     			return $this->redirect()->toUrl("/application/index/loggedin?msg=success");
//     		}
//     	}
//     	return array(
//     			'form' => $form,
//     	);
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
    	
    	
    	// Get the Album with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
//     	try {
//     		$album = $this->getAlbumTable()->getAlbum($id);
//     	}
//     	catch (\Exception $ex) {
//     		return $this->redirect()->toRoute('album', array(
//     				'action' => 'index'
//     		));
//     	}
    	
//     	$form  = new AlbumForm();
//     	$form->bind($album);
//     	$form->get('submit')->setAttribute('value', 'Edit');
    	
//     	$request = $this->getRequest();
//     	if ($request->isPost()) {
//     		$form->setInputFilter($album->getInputFilter());
//     		$form->setData($request->getPost());
    	
//     		if ($form->isValid()) {
//     			$this->getAlbumTable()->saveAlbum($album);
    	
//     			// Redirect to list of albums
//     			return $this->redirect()->toRoute('album');
//     		}
//     	}
    	
//     	return array(
//     			'id' => $id,
//     			'form' => $form,
//     	);
    	
    }
    
    public function addCommunityAction() {
    	$form  = new AddCommunityForm();
    	$form->get('submit')->setAttribute('value', 'Add');
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    		    return $this->redirect()->toUrl("/application/index/loggedin?msg=success");
    		}
  	  	}
    	return array(
    		'form' => $form,
    	);
    }
    
    public function modifyCommunityAction() {
    	
    }
    
    public function addEventAction() {
    	$form  = new AddEventForm();
    	$form->get('submit')->setAttribute('value', 'Add');
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			return $this->redirect()->toUrl("/application/index/loggedin?msg=success");
    		}
    	}
    	return array(
    			'form' => $form,
    	);
    }
    
    public function logoutAction() {
    	$_SESSION["username"] = null;
    	return $this->redirect()->toUrl("/application/index/index?msg=loggedOut");
    }

}