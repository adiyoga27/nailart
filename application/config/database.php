<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'port' => '3306',
	'username' => 'root',
	'password' => 'lucakerz1996',
	'database' => 'project_nailart',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'tb_',
	'pconnect' => FALSE,
	// 'db_debug' => (ENVIRONMENT !== 'production'),
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
