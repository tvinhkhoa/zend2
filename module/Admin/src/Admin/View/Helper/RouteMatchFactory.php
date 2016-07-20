<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
/**
 * Description of RouteMatchFactory
 *
 * @author USER
 */

class RouteMatchFactory implements FactoryInterface {
	//put your code here
	
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $router = $container->get('router');
        $request = $container->get('request');

        return new RouteMatch($router, $request);
    }
}
