<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Form;
/**
 * Description of LoginForm
 *
 * @author USER
 */
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class LoginForm extends Form {
	//put your code here
    public function __construct($name) {
        
        parent::__construct($name);
        $this->setAttribute('method', 'post');
 
        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email',
                'id' => 'email',
                'placeholder' => 'example@example.com'             
            )
        ));
 
       $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
                'id' => 'password',
                'placeholder' => '**********'
            )
       ));
       
       $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'loginCsrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 3600
                )
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit',
            ),
        ));
    }
}
