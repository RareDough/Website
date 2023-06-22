<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userID = $_POST['userID'];

// Connect to database and check wallet address
include_once 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM submissions WHERE user_id = ? AND status = ?');
$stmt->execute([ $userID, 'created' ]);

// Get user's tokens with status "created"
$tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($tokens) {
	echo json_encode( array('created_tokens' => $tokens) );
}