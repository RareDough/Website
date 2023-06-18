<?php

$userWallet = $_POST['userWallet'];

// Connect to database and check wallet address
include_once 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
$stmt->execute([ $userWallet ]);

// Check if user exists
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
	echo json_encode( array('return_user' => true) );
}