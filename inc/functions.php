<?php

include_once 'config.php';

function pdo_connect_mysql() {
	try {
		$pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=' . db_charset, db_user, db_pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch ( PDOException $exception ) {
		exit('Failed to connect to the database');
	}
	return $pdo;
}