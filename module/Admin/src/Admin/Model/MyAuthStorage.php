<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Model;
/**
 * Description of MyAuthStorage
 *
 * @author USER
 */
use Zend\Authentication\Storage;

class MyAuthStorage extends Storage\Session {
	//put your code here
	
	public function setRememberMe($rememberMe = 0, $time = 1209600)
	{
		if ($rememberMe == 1) {
			$this->session->getManager()->rememberMe($time);
		}
	}

	public function forgetMe()
	{
		$this->session->getManager()->forgetMe();
	}
}
