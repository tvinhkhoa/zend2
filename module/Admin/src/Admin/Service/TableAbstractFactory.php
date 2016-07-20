<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Service;
/**
 * Description of TableAbstractFactory
 *
 * @author USER
 */
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableAbstractFactory implements AbstractFactoryInterface {
	//put your code here
	
	public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
	{
//		return preg_match('/Admin\\Model\\(.+)Table/', $name);
		return (fnmatch('*Table', $requestedName)) ? true : false;
	}
	
	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
		$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		//$dbAdapter = $serviceLocator->get('authdb');
		if (class_exists($requestedName)) {
//            $tableGateway = $requestedName . "Gateway";
//            return new $requestedName($tableGateway);
			return new $requestedName($dbAdapter);
        }
        return false;
	}
}
