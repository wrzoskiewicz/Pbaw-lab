<?php

$conf->server_name = 'localhost:80';
$conf->server_url = 'http://'.$conf->server_name;
$conf->app_root = '/php_05_namespaces';
$conf->action_root = $conf->app_root.'/ctrl.php?action=';


$conf->root_path = dirname(__FILE__);
$conf->action_url = $conf->server_url.$conf->action_root;
$conf->app_url = $conf->server_url.$conf->app_root;