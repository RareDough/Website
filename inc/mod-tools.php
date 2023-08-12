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
	$userID = $user['ID'];
	$userLevel = $user['user_level'];
	$userTwitter = $user['twitter_username'];

	// Get token from database
	$stmt = $pdo->prepare('SELECT * FROM submissions WHERE token_id = ?');
	$stmt->execute([$tokenID]);
	$token = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($token) {
		$ownerID = $token['user_id'];
		$jsonPath = $_SERVER['DOCUMENT_ROOT'].'/assets/community/' . $tokenID . '.json';

		if ($action == 'enable') {
			if ($userLevel == 10) {
				// User is a moderator
				$tokenName = $token['name'];
				$tokenDesc = $token['description'];

				// Generate JSON and transfer image file if enabling
				$source = $_SERVER['DOCUMENT_ROOT'].'/'.explode('/', $token['image_path'], 4)[3];
				$destination = $_SERVER['DOCUMENT_ROOT'].'/assets/community/images/'.$tokenID.'.jpg';
				copy($source, $destination);

				$jsonData = [
					"name" => $tokenName,
					"symbol" => $tokenID,
					"description" => $tokenDesc,
					"image" => "https://raredough.com/assets/community/images/" . $tokenID . ".jpg",
					"external_link" => "https://raredough.com/shop-item?type=community&id=" . $tokenID,
					"attributes" => [
						[
							"trait_type" => "Status",
							"value" => "active",
							"soldout" => false
						],
						[
							"trait_type" => "Category",
							"value" => "community pizza"
						],
						[
							"trait_type" => "Price",
							"value" => "100 BREAD"
						]
					]
				];
				// Convert JSON
				$jsonString = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				// Save JSON file
				$fp = fopen($jsonPath, 'w');
				fwrite($fp, $jsonString);
				fclose($fp);

				// Update the token database entry
				$stmt = $pdo->prepare('UPDATE submissions SET status = ? WHERE token_id = ?');
				$stmt->execute([ $status, $token['token_id'] ]);

				// Response
				echo json_encode( array('token_updated' => true, 'message' => 'Token #' . $tokenID . ' status has been changed to ' . $status) );
			} else {
				// User is not a moderator
				exit('User is not permitted to call this action');
			}
		} else {
			$jsonString = file_get_contents($jsonPath);
			$jsonData = json_decode($jsonString, true);

			// Change status to disabled
			$jsonData['attributes'][0]['value'] = $status;

			// Write to file
			$newJsonString = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
			file_put_contents($jsonPath, $newJsonString);

			// Update the token database entry
			$stmt = $pdo->prepare('UPDATE submissions SET status = ? WHERE token_id = ?');
			$stmt->execute([ $status, $token['token_id'] ]);
			
			// Response
			echo json_encode( array('token_updated' => true, 'message' => 'Token #' . $tokenID . ' status has been changed to ' . $status) );
		}
	} else {
		// Response
		echo json_encode( array('token_updated' => false, 'message' => 'Token ID not found.') );
	}
} else {
	exit('User not found');
}