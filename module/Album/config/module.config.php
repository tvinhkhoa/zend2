<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
//	'controllers' => array(
//		'invokables' => array(
//			'Album\Controller\Album' => 'Album\Controller\AlbumController',
//		),
//	),
	'router' => array(
		'routes'	=> array(
			'album'		=> array(
				'type'    => 'Literal',
                'options' => array(
                    'route'    => '/album',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Album\Controller',
                        'controller'    => 'Album',
                        'action'        => 'index',
                    ),
                ),
				'may_terminate'=> true,
				'child_routes' => array(
					'default'		=> array(
						'type'			=> 'Segment',
						'options'		=> array(
//							'route'		=> '/[:controller][/][:action][/][:id]',
							'route'    => '/[:controller[/:action]]',
							'contraints'=> array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'	=> array(
							),
						),
					),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'album' => __DIR__ . '/../view',
		),
	),
);