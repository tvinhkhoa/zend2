<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;
/**
 * Description of IndexController
 *
 * @author USER
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NoteController extends AbstractActionController
{
	//put your code here
	protected $authAdapter;
	
	public function __construct() {
		;
	}
	
	public function indexAction()
	{
		echo '<br>'.__NAMESPACE__;
		echo '<br>'.__METHOD__.'<br>';
	}
	
	protected function getAuthAdapter()
	{
		if (!$this->authAdapter) {
            $sm = $this->getServiceLocator();
            $this->authAdapter = $sm->get('authAdapter');
        }
	}
}
