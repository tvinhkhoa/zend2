<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;
/**
 * Description of DashboardController
 *
 * @author USER
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Router\Http\TreeRouteStack;

class DashboardController extends AbstractActionController {
	//put your code here
	
//	public function __construct(TreeRouteStack $router)
//    {
//        $this->router = $router;
//		print_r($this->router);exit;
//    }
    
	protected $_userTable;
	
	public function indexAction()
	{
		echo '<br>'.__NAMESPACE__;
		echo '<br>'.__METHOD__.'<br>';

//		return new ViewModel(array(
//					'users' => $this->getModelTable('\Admin\Model\UserTable')->fetchAll(),
//				));
		
//		return new ViewModel(array(
//			'users' => $this->checkLogin('\Admin\Model\UserTable')->fetchAll(),
//		));
	}
	
	private function getModelTable($modelTable = null) {
		if (!$this->_userTable) {
			$sm = $this->getServiceLocator();
			$this->_userTable = $sm->get($modelTable);
		}
		return $this->_userTable;
	}
	
	private function checkLogin()
	{
		if (!$this->_userTable) {
			$sm = $this->getServiceLocator();
			$this->_userTable = new \Admin\Model\UserTable($sm);
		}
		return $this->_userTable;
	}

	public function addAction() {
		$request = $this->getRequest();
		$response = $this->getResponse();
		if ($request->isPost()) {
			$new_note = new \StickyNotes\Model\Entity\StickyNote();
			if (!$note_id = $this->getStickyNotesTable()->saveStickyNote($new_note))
				$response->setContent(\Zend\Json\Json::encode(array('response' => false)));
			else {
				$response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
			}
		}
		return $response;
	}
	
	public function onDispatch(\Zend\Mvc\MvcEvent $e) {
//		$serviceManager = $e->getApplication ()->getServiceManager ();
//		$auth = $serviceManager->get ( 'LdapAuth\Client\Ldap' );
//		if (! $auth->hasIdentity ()) {
//			$uri = $e->getRequest()->getRequestUri();
//			$callBackFunction = $this->getLdap ()->getCallBackFunction (); // = new SessionData();
//			$callBackFunction::setOriginalUri($uri); // function to store temporarly the uri
//			return $this->redirect ()->toRoute ( 'ldap-login-route' );
//		}
		return parent::onDispatch ( $e );
	}
}
