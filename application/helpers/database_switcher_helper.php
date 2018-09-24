<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function switch_db($name_db) {
	    $config_app['hostname'] = '192.168.150.75';
	    $config_app['username'] = 'contributor_lvl2';
	    $config_app['password'] = 'additionaldelete2018';
	    $config_app['database'] = $name_db;
	    $config_app['dbdriver'] = 'mysql';
	    $config_app['dbprefix'] = '';
	    $config_app['pconnect'] = FALSE;
	    $config_app['db_debug'] = TRUE;
	    return $config_app;
	}
?>