<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Api;

return array(
	'controllers' => array(
        'invokables' => array(
			'Api\Controller\Index' => Controller\IndexController::class,
        ),
    ),
	'router' => array(
		'routes'	=> array (
			'api'	=> array(
				'type'		=> 'Literal',
				'options'	=> array(
					'route'			=> '/api',
					'defaults'		=> array(
						'__NAMESPACE__'	=> 'Api\Controller',
						'controller'	=> 'Index',
						'action'		=> 'index'
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
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
//		'template_map' => array(
//            'message'           => __DIR__ . '/../view/layout/message.phtml',
//        ),
//		'template_path_stack' => array(
//			'admin'	=> __DIR__ .'/../view' ,
//		),
	),
	'service_manager' => array(
		'factories' => array(
		),
	),
);