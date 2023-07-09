<?php

$userWallet = $_POST['userWallet'];
$tokenID = $_POST['tokenID'];
$action = $_POST['action'];
$status = $_POST['status'];

// Connect to database and check wallet address
include_once 'functions.php';
$pdo = pdo_connect_mysql();
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
$stmt->execute([ $userWallet ]);

// Check if user exists
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
	$userLevel = $user['user_level'];

	if ($userLevel == 0) {
		// User is not a moderator
		$stmt = $pdo->prepare('SELECT * FROM submissions WHERE token_id = ?');
        $stmt->execute([$tokenID]);
        $token = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($token) {
        	// Get token details
        	$tokenName = $token['name'];
        	$tokenDesc = $token['description'];

        	// Copy image and generate JSON
			$path = $_SERVER['DOCUMENT_ROOT'].'/assets/' . $tokenID . '.json';
		    $jsonData = [
	            "name" => $tokenName,
	            "symbol" => $tokenName,
	            "description" => $tokenDesc,
	            "image" => "https://raredough.com/assets/images/" . $tokenID . ".jpg",
	            "external_link" => "https://raredough.com/custom-pizza?id=" . $tokenID,
	            "attributes" => [
	                [
	                    "trait_type" => "Category",
	                    "value" => "custom pizza"
	                ],
	                [
	                    "trait_type" => "Price",
	                    "value" => "100 BREAD"
	                ],
	                [
	                    "trait_type" => "Utility",
	                    "value" => "Honorary"
	                ],
	                [
	                    "trait_type" => "URL",
	                    "value" => ""
	                ]
	            ]
	        ];
		    // Convert JSON
		    $jsonString = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		    // Save JSON file
		    $fp = fopen($path, 'w');
		    fwrite($fp, $jsonString);
		    fclose($fp);
		    echo json_encode( array('token_activated' => true, 'message' => 'Token JSON and image have been generated') );
		}
	} else if ($userLevel == 10) {
		// User is a moderator
		$stmt = $pdo->prepare('SELECT * FROM submissions WHERE token_id = ?');
        $stmt->execute([$tokenID]);
        $token = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($token) {
            // Update the token database entry
            $stmt = $pdo->prepare('UPDATE submissions SET status = ? WHERE token_id = ?');
            $stmt->execute([ $status, $token['token_id'] ]);

            echo json_encode( array('token_updated' => true, 'message' => 'Token #' . $tokenID . ' status has been changed to ' . $status) );
        } else {
            echo json_encode( array('token_updated' => false, 'message' => 'Token ID not found.') );
        }
	} else {
		// User is not a moderator
		echo json_encode( array('token_updated' => false, 'message' => 'User not authorized to make this change') );
	}
} else {
	exit('User not found');
}