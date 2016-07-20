<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=dotproject2;host=localhost;port=3306',
        'driver_option' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF-8\'',
        ),

		//other adapter when it need
		'adapters' => array(
			'authdb' => array(
				'driver' => 'Pdo',
				'dsn' => 'mysql:dbname=test;host=localhost;port=3306',
				'driver_option' => array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF-8\'',
				),
			)
		),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			'Zend\Session\SessionManager',
        ),
		'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
//	Session C1
//	'session_config' => [
//		'remember_me_seconds' => 2419200,
//		'use_cookies' => true,
//		'cookie_httponly' => true,
//	],
//	Session C2
	'session' => array(
        'config' => array(
            'class' => 'Zend\Session\Config\SessionConfig',
            'options' => array(
                'name' => 'ZF2',
				'remember_me_seconds' => 2419200,
				'use_cookies' => true,
				'cookie_httponly' => true,
            ),
        ),
        'storage' => 'Zend\Session\Storage\SessionArrayStorage',
//		'save_handler' => '',
        'validators' => array(
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ),
		'namespace' => array(
			'auth' => 'AuthZF'
		),
    ),
);