<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Controller;
/**
 * Description of AlbumController
 *
 * @author USER
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController {
	//put your code here
	
	public function indexAction()
	{
		return array(
			'welcome' => 'Hello List Controller Zend Framework 2.2 - By Goweb.vn',
		);
	}
	
	public function showAction()
	{
		return array(
			'welcome' => 'Action show from Zend Framework 2.2 - By Goweb.vn',
		);
	}
}
