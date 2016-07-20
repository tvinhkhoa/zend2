<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Api\Controller;
/**
 * Description of IndexController
 *
 * @author USER
 */
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {
	//put your code here
	
	protected $acceptCriteria = array(
		'Zend\View\Model\JsonModel' => array(
			'application/json',
		),
		'My\View\XmlModel' => array(
			'application/xml',
		),
	);

	public function apiAction()
	{
		$model = $this->acceptableViewModelSelector($this->acceptCriteria);
	}
}
