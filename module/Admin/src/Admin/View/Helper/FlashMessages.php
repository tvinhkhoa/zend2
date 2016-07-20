<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\View\Helper;
/**
 * Description of FlashMessages
 *
 * @author USER
 */
use Zend\View\Helper\AbstractHelper;

class FlashMessages extends AbstractHelper {
	//put your code here
	protected $flashMessenger;

	public function setFlashMessenger( $flashMessenger )
	{
			$this->flashMessenger = $flashMessenger ;
	}

	public function __invoke( )
	{
		$namespaces = array( 
			'error' ,'success', 
			'info','warning' 
		);

		// messages as string
		$messageString = '';

		foreach ( $namespaces as $ns ) {

			$this->flashMessenger->setNamespace( $ns );

			$messages = array_merge(
					 $this->flashMessenger->getMessages(),
					 $this->flashMessenger->getCurrentMessages()
			);


			if ( ! $messages ) continue;

			$messageString .= "<div class='$ns'>"
							. implode( '<br />', $messages )
						.'</div>';
		}

		return $messageString ;
	}
}
