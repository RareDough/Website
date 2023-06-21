<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userWallet = $_POST['userWallet'];
$tokenID = $_POST['tokenID'];
$tokenSupply = $_POST['supply'];

// Connect to database and check wallet address
include_once 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
$stmt->execute([$userWallet]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = null;

if (!$user) {
	// User does not exist - add them and get their ID
	$stmt = $pdo->prepare('INSERT INTO users (user_address, user_level) VALUES (?, ?)');
    $stmt->execute([ $userWallet, 0 ]);

    // Get their database ID
    $userID = $pdo->lastInsertId();
} else {
	// User exists - get their database ID
	$userID = $user['ID'];
}

// Add their newly created token to the database
$stmt = $pdo->prepare('INSERT INTO submissions (user_id, token_id, supply, status) VALUES (?, ?, ?, ?)');
$createToken = $stmt->execute([ $userID, $tokenID, $tokenSupply, 'created' ]);

if ($createToken) {
	echo json_encode( array('token_created' => true, 'token_id' => $tokenID, 'token_supply' => $tokenSupply) );
}