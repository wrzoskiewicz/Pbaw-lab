<?php
require_once 'init.php';


//2. wykonanie akcji
switch ($action) {
	default : // 'calcView'
		$ctrl = new app\controllers\CalcCtrl(); //autoloader
		$ctrl->generateView ();
	break;
	case 'calcCompute' :
		$ctrl = new app\controllers\CalcCtrl(); //autoloader
		$ctrl->process ();
	break;
}