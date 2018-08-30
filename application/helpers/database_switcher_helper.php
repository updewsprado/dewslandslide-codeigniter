<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function switch_db($name_db) {
	    $config_app['hostname'] = 'localhost';
		// $config_app['hostname'] = '192.168.150.72';
	    $config_app['username'] = 'root';
	    $config_app['password'] = 'senslope';
	    $config_app['database'] = $name_db;
	    $config_app['dbdriver'] = 'mysqli';
	    $config_app['dbprefix'] = '';
	    $config_app['pconnect'] = FALSE;
	    $config_app['db_debug'] = TRUE;
	    return $config_app;
	}
?>