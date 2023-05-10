<?php
function getConnection()
{
	include_once $_SERVER['DOCUMENT_ROOT'] . '/include/db_params.php';
	static $connection = null;
	if (null === $connection) {
		$connection = mysqli_connect($params['host'], $params['user'], $params['password'], $params['dbname'], $params['port']);
	}
	return $connection;
}
