<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin;
/**
 * Description of Module
 *
 * @author USER
 */
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Session\Container as Container;

class Module {
	//put your code here
	
/* Offline pages not needed authentication */  
	protected $whiteList = array(
		'Admin\Controller\Login'
	);
	
	public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
	{
		// Remember to keep the init() method as lightweight as possible
//		$events = $moduleManager->getEventManager();
//		$events->attach('loadModules.post', array($this, 'modulesLoaded'));
		
//		$sharedManager = $moduleManager->getEventManager()->getSharedManager();
//		$events->attach('loadModules.post', array($this, 'modulesLoaded'));
		
//		$modules = $moduleManager->getModules();
//		print_r($modules);exit;
		//echo '<pre>';print_r(get_class_methods($moduleManager));exit;
		//die('init');
	}
	
//    public function modulesLoaded(Event $e)
//    {
//        // This method is called once all modules are loaded.
//        $moduleManager = $e->getTarget();
//        $loadedModules = $moduleManager->getLoadedModules();
//        // To get the configuration from another module named 'FooModule'
//        $config = $moduleManager->getModule('FooModule')->getConfig();
//    }
	
	public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__,
//					'Auth'	=> dirname(__DIR__) . '/../vendor/Core/Auth',
                ),
            ),
        );
    }
	
    public function getServiceConfig()
	{
        return array(			
			'abstract_factories' => array(
				'Admin\Service\TableAbstractFactory',
			),
						
			'factories' => array(				
				'AuthenticationService' => function($sm) {
//					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					$dbAdapter = $sm->get('authdb');
					$dbTableAuthAdapter  = new \Zend\Authentication\Adapter\DbTable(
													$dbAdapter, 
													'users', 'email', 'password');

					$auth = new AuthenticationService();
					$auth->setAdapter($dbTableAuthAdapter);
//					$auth->setStorage($sm->get('Admin\Model\AuthStorage'));
					return $auth;
				},
//				Session C2
				'Zend\Session\SessionManager' => function($serviceManager){
					$config = $serviceManager->get('config');
					if (isset($config['session'])){
						$session_config = $config['session'];
						
						$sessionConfig = null;
						if (isset($session_config['config'])){
							$class = isset($session_config['config']['class']) ? $session_config['config']['class'] : 'Zend\Session\Config\SessionConfig';
							$options = isset($session_config['config']['options']) ? $session_config['config']['options'] : array();
							
							$sessionConfig = new $class;
							$sessionConfig->setOptions($options);
						}
						
						$sessionStorage = null;
						if (isset($session_config['storage'])){
							$class = $session_config['storage'];
							$sessionStorage = new $class();
						}
						
						$sessionSaveHandler = null;
						if (isset($session_config['save_handler'])){
							$sessionSaveHandler = $serviceManager->get($session_config['save_handler']);
						}
						
						$sessionManager = new \Zend\Session\SessionManager(
							$sessionConfig, $sessionStorage, $sessionSaveHandler
						);
						
						if (isset($session_config['validator'])){
							$chain = $sessionManager->getValidatorChain();
							foreach ($session_config['validator'] as $validator){
								$validator = new $validator();
								$chain->attach('session.validate', array(
									$validator, 'isValid'
								));
							}
						}
					} else{
						$sessionManager = new \Zend\Session\SessionManager();
					}
					Container::setDefaultManager($sessionManager);
					return $sessionManager;
				},
			)
        );
    }
	
	public function onBootstrap(MvcEvent $e)
    {
		//application
		$application		= $e->getApplication();
		//event
        $eventManager		= $application->getEventManager();
		$eventManager -> attach(
			MvcEvent::EVENT_DISPATCH,
			// Add dispatch error event only if you want to change your layout in your error views. A few lines more are required in that case.
			// MvcEvent::EVENT_DISPATCH | MvcEvent::EVENT_DISPATCH_ERROR
			array($this, 'boforeDispatch'), // Callback defined as boforeDispatch() method on $this object
			100 // Note that you don't have to set this parameter if you're managing layouts only
        );
		$eventManager->attach(
			MvcEvent::EVENT_DISPATCH,
			array($this, 'afterDispatch'), 
			100
		);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
		$this->bootstrapSession($e);
    }
	
//-------------------------------------------------------------
//	Session C2
    public function bootstrapSession($e)
    {
		$serviceManager = $e->getApplication()
							->getServiceManager();
        $session = $serviceManager->get('Zend\Session\SessionManager');
        $session->start();
		
		$config = $serviceManager->get('config');
		if (!isset($config['session'])) {
			return;
		}
		else
			$session_config = $config['session'];
		
		if( !isset($session_config['namespace']['auth']) )
			throw new \Exception('Not exists Session namespace with key \'auth\'');
		
		$namespace = $session_config['namespace']['auth'];
        $container = new Container($namespace);
        if (!isset($container->init)) {
			$request = $serviceManager->get('Request');
			$session->regenerateId(true);
			$container->init = 1;
			$container->remoteAddr    = $request->getServer()->get('REMOTE_ADDR');
			$container->httpUserAgent = $request->getServer()->get('HTTP_USER_AGENT');
		}
    }
	
    function boforeDispatch(MvcEvent $event)
	{
		$request	= $event->getRequest();
		$response	= $event->getResponse();
		$target		= $event->getTarget ();

		$requestUri = $request->getRequestUri();
		$controller	= $event->getRouteMatch ()->getParam ( 'controller' );
		$action		= $event->getRouteMatch ()->getParam ( 'action' );

		$requestedResourse = $controller;

		//Get Session with namespace
		$serviceManager = $event->getApplication()
								->getServiceManager();
		
		$config = $serviceManager->get('config');
		if (!isset($config['session'])) {
			throw new Exception('Have problem initalize authorticate access');
		}
		else
			$namespace = $config['session']['namespace']['auth'];
		
		$session = new Container($namespace);
		if ($session->offsetExists ( 'email' )) {
			$endTime = (float) array_sum(explode(' ', microtime()));
			
			if ( !$session->offsetExists ( 'endTime' ) || !$session->endTime  )
				$session->endTime = $endTime;
			else
				$session->endTime = (float) $session->endTime;
			
			if ($endTime - $session->endTime > 1000){
				$session->getManager()->destroy();
				$url = '/admin/login';                
				$response->setHeaders ( $response->getHeaders ()->addHeaderLine ( 'Location', $url ) );
				$response->setStatusCode ( 302 ); 
			}
			
			if ($requestedResourse == 'Admin\Controller\Login') {
				$url = '/admin/dashboard';
				$response->setHeaders ( $response->getHeaders ()->addHeaderLine ( 'Location', $url ) );
				$response->setStatusCode ( 302 );
			}
		}else{
			if ( ! in_array ( $requestedResourse, $this->whiteList )) {
				$url = '/admin/login';                
				$response->setHeaders ( $response->getHeaders ()->addHeaderLine ( 'Location', $url ) );
				$response->setStatusCode ( 302 ); 
			}
			$response->sendHeaders ();
		}
	   //print "Called before any controller action called. Do any operation.";
    }
		
	public function afterDispatch(MvcEvent $event)
    {
		$target = $event->getTarget();		
		$controller	= $event->getRouteMatch ()->getParam ( 'controller' );
		$action		= $event->getRouteMatch ()->getParam ( 'action' );
		
		//echo $controller;exit;
		
//		switch ($routeParams['__CONTROLLER__']) {
//			// You may use $routeParams['controller'] if you need to check the Fully Qualified Class Name of your controller
//			case 'MyController':
//				$e -> getViewModel() -> setTemplate('my-first-layout');
//				break;
//			case 'OtherController':
//				$e -> getViewModel() -> setTemplate('my-other-layout');
//				break;
//			default:
//				// Ignore
//				break;
//		}
    }
	
    public function setLayout(MvcEvent $e)
    {
        $matches    = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        if (false !== strpos($controller, __NAMESPACE__)) {
            // not a controller from this module
            return;
        }

        // Set the layout template
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('content/layout');
    }
	
//	public function getViewHelperConfig()
//	{
//		return array(                    
//			'factories' => array(                                               
//				'flashMessage' => function($sm) {      
//
//					$flashmessenger = $sm->getServiceLocator()
//										  ->get('ControllerPluginManager')
//										  ->get('flashmessenger');                                   
//
//					$message    = new \Admin\View\Helper\FlashMessages() ;
//					$message->setFlashMessenger( $flashmessenger );
//
//					return $message ;
//				}
//			),
//		);
//	}
}
