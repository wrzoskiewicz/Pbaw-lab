<?php
require_once dirname(__FILE__).'/../../config.php';
function getParamsLogin(&$form){
	$form['login'] = isset ($_REQUEST ['login']) ? $_REQUEST ['login'] : null;
	$form['haslo'] = isset ($_REQUEST ['haslo']) ? $_REQUEST ['haslo'] : null;
}
function validateLogin(&$form,&$messages){

	if ( ! (isset($form['login']) && isset($form['haslo']))) {
		return false;
	}
	if ( $form['login'] == "") {
		$messages [] = 'Nie podano loginu';
	}
	if ( $form['haslo'] == "") {
		$messages [] = 'Nie podano hasła';
	}
	if (count ( $messages ) > 0) return false;
	if ($form['login'] == "admin" && $form['haslo'] == "admin") {
		session_start();
		$_SESSION['role'] = 'admin';
		return true;
	}
	if ($form['login'] == "user" && $form['haslo'] == "user") {
		session_start();
		$_SESSION['role'] = 'user';
		return true;
	}
	
	$messages [] = 'Niepoprawny login lub hasło';
	return false; 
}
$form = array();
$messages = array();
getParamsLogin($form);

if (!validateLogin($form,$messages)) {
	include $conf->root_path.'/app/security/login_view.php';
} else { 
	header("Location: ".$conf->app_url);
}