<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecurityPlugin
 *
 * @author USER
 */

if( !ini_get('session.use_cookies') )
	ini_set('session.use_cookies', 1);

if( !ini_get('session.use_only_cookies') )
	ini_set('session.use_only_cookies', 1);


ini_set('session.auto_start', 0);

ini_set('session.cookie_httponly', 1);