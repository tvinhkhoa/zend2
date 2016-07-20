<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\View\Helper;

use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch as MvcRouteMatch;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\View\Exception;
use Zend\View\Helper\AbstractHelper;

/**
 * Helper to get the RouteMatch
 */
/**
 * Description of RouteMatch
 *
 * @author USER
 */
class RouteMatch extends AbstractHelper {
	//put your code here
	
	/**
     * RouteStackInterface instance.
     *
     * @var RouteStackInterface
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    /**
     * RouteMatch constructor.
     * @param RouteStackInterface $router
     * @param Request $request
     */
    public function __construct(RouteStackInterface $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * @return MvcRouteMatch
     */
    public function __invoke()
    {
        return $this->router->match($this->request);
    }
}
