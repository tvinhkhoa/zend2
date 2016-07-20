<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;
/**
 * Description of LoginController
 *
 * @author USER
 */
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

use Admin\Form\LoginForm;
use Admin\Form\Filter\LoginFilter;

class LoginController extends AbstractActionController {
	//put your code here
	
	protected $storage;
	protected $authservice;
	
	public function indexAction(){
		$request = $this->getRequest();

		$view = new ViewModel();
		$loginForm = new LoginForm('loginForm');       
		$loginForm->setInputFilter(new LoginFilter() );

		if( $request->isPost() ) {
			$data = $request->getPost();
			$loginForm->setData($data);

			if( $loginForm->isValid() ){
				$data = $loginForm->getData();        

//				$userPassword = new UserPassword();
//				$encyptPass = $userPassword->create($data['password']);

				//get DB Adapter
				$this	->getAuthService()
						->getAdapter()
						->setIdentity($data['email'])
						->setCredential($data['password']);
				
				$result = $this->getAuthService()->authenticate(); print_r($result);exit;
				if ($result->isValid()) {
					$session = $this->getSessionContainer();
					$session->offsetSet('email', $data['email']);

					$this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
					// Redirect to page after successful login
				}else{
					$this->flashMessenger()->addMessage(array('error' => 'Invalid credentials.'));
					// Redirect to page after login failure
				}
				return $this->redirect()->tourl('/admin/dashboard');
				// Logic for login authentication                
			}
			else{
				$errors = $loginForm->getMessages();
			}
		}else{
			$this->flashMessenger()->addMessage(array('default' => 'Vui lòng nhập vào những ô bắt buộc'));
		}

		$view->setVariable('loginForm', $loginForm);
		return $view;
	}
	
	private function &getAuthService()
	{
//		if (! $this->authservice) {
//			$this->authservice = $this->getServiceLocator()->get('AuthService');
//		}
//		return $this->authservice;
		
		$sm = $this->getServiceLocator();
		$dbAdapter = $sm->get('authdb');
		$dbAuthAdapter  = new \Zend\Authentication\Adapter\DbTable(
									$dbAdapter
								);
		
		//, 'MD5(?)'
		$auth = new \Zend\Authentication\AuthenticationService();
		$auth->setAdapter($dbAuthAdapter);
//		$auth->setStorage($sm->get('Admin\Model\AuthStorage'));
		return $auth;
	}
	
	private function &getSessionContainer()
	{
		$config = $this->getServiceLocator()->get('config');
		$namespace = $config['session']['namespace']['auth'];
		
		return (new Container($namespace));
	}
	
	public function logoutAction(){
		$session = $this->getSessionContainer();
		$session->getManager()->destroy();
		$this->getAuthService()->clearIdentity();
		return $this->redirect()->toUrl('/admin/login');
	}
}
