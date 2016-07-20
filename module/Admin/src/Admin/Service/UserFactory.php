<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Service;
/**
 * Description of UserFactory
 *
 * @author USER
 */
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface {
	//put your code here
	
	public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$dbAdapter = $serviceLocator->get('authdb');
//        $dependencyService = $serviceLocator->get('Application\Service\ServiceOne');
//        $translator = $serviceLocator->get('Translator');
//
//        return new MyService($dependencyService, $translator);
		 return new \Admin\Model\UserTable($dbAdapter);
    }
}
