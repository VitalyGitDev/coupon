<?php
ini_set('display_errors',1);
ini_set('register_globals',0);
ini_set('error_reporting',E_ALL);
ini_set('session.cookie_httponly',true);

require_once('../vendor/autoload.php');

(new Application\Core\Router)->start();
