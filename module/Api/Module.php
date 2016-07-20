<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Api;
/**
 * Description of Module
 *
 * @author USER
 */
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

//use Zend\Authentication\AuthenticationService;
//use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


class Module {
	//put your code here
		
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
                ),
            ),
        );
    }
	
    public function getServiceConfig()
	{
        return array(			
			'abstract_factories' => array(

			),		
			'factories' => array(				
				
			)
        );
    }
}
