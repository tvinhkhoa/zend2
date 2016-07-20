<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin;

return array(
	'controllers' => array(
        'invokables' => array(
			'Admin\Controller\Login' => Controller\LoginController::class,
            'Admin\Controller\Dashboard' => Controller\DashboardController::class,
			'Admin\Controller\Note' => Controller\NoteController::class
        ),
    ),
	'router' => array(
		'routes'	=> array (
			'admin'	=> array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/admin',
					'defaults'		=> array(
						'__NAMESPACE__'	=> 'Admin\Controller',
						'controller'	=> 'Dashboard',
						'action'		=> 'index'
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
//							'route'			=> '/[:controller][/][:action][/][:params]',
							'route'    => '/[:controller[/:action]]',
							'contraints'	=> array(
								'controller'	=> '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'		=> '[a-zA-Z][a-zA-Z0-9_-]*',
//								'params'		=> '.*'
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_map' => array(
            'message'           => __DIR__ . '/../view/layout/message.phtml',
        ),
		'template_path_stack' => array(
			'admin'	=> __DIR__ .'/../view' ,
		),
	),
	'service_manager' => array(
		'factories' => array(
//			Session C1
//			'Zend\Session\SessionManager' => 'Zend\Session\Service\SessionManagerFactory',
//			'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
		),
		'abstract_fatories' => array(
			'Admin\Service\TableAbstractFactory'
		),
		'authenticate_basic' => array(
			'Zend\Authentication' => 'Zend\Authentication\AuthenticationService',
		),
	),
);