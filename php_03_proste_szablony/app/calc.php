<?php
require_once dirname(__FILE__).'/../config.php';
include _ROOT_PATH.'/app/security/sprawdz.php';
error_reporting(0);
$kw = $_REQUEST ['kwota'];
$pr = $_REQUEST ['procent'];
$lt = $_REQUEST ['lata'];

if ( ! (isset($kw) && isset($pr) && isset($lt))) {
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

if ( $kw == "") {
	$messages [] = 'Nie podano kwoty pożyczki';
}
if ( $pr == "") {
	$messages [] = 'Nie podano oprocentowania';
}
if ( $lt == "") {
	$messages [] = 'Nie podano okresu pozyczki';
}

if (empty( $messages )) {
	if (! is_numeric( $kw )) {
		$messages [] = 'Kwota pożyczki nie jest liczbą';
	}
	
	if (! is_numeric( $pr )) {
		$messages [] = 'Oprocentowanie nie jest liczbą';
	}

	if (! is_numeric( $lt )) {
		$messages [] = 'Ilość lat nie jest liczbą';
	}	
}

if (empty ( $messages )) {
	
	$kw = intval($kw);
	$pr = intval($pr)/100;
	$lt = intval($lt);
	for($i=0;$i<$lt;$i++){
		$kw=$kw*(1+$pr);
	}
	$wynik = $kw/(12*$lt);
}

$page_title = 'KALKULATOR';
$page_description = 'kalkulator kredytowy';
$page_header = 'ENIGMA';
$page_footer = 'Czy wiesz, że Jedi jest oficjalną religią 70 tys. Australijczyków.';

include 'calc_view.php';