<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Album;
/**
 * Description of Module
 *
 * @author USER
 */
class Module {
	//put your code here
	
	public function getAutoloaderConfig()
	{
		return array(
//			'Zend\Loader\ClassMapAutoloader' => array(
//				__DIR__ . '/autoload_classmap.php',
//			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}
 
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
}
