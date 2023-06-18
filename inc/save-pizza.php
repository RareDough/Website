<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Form variables
    $tokenID = $_POST['id'];
    $tokenSupply = $_POST['supply'];
    $tokenName = $_POST['name'];
    $tokenDesc = $_POST['description'];
    $twitterUsername = $_POST['twitter'];
    $discordUsername = $_POST['discord'];
    $imageData = $_POST['imgBase64'];
    $userWallet = $_POST['userWallet'];
    $folderPath = null;
    $websitePath = null;

	function generateImage($img, $wallet) {
        global $folderPath;
        global $websitePath;

		// Set directory for saved images
        $folderPath = $_SERVER['DOCUMENT_ROOT'].'/custom-mint/creations/' . $wallet . '/';

        // If user's directory does not exist - create it
		if (!is_dir($folderPath)) {
			mkdir($folderPath);
		}

		// Break up the Base64 code
        $image_parts = explode(';base64,', $img);
        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1];

        // Decode the Base64 code
        $image_base64 = base64_decode($image_parts[1]);

        // Generate unique filename
        $filename = uniqid() . '.jpg';
        $file = $folderPath . $filename;

        // Store the image on the server
        $result = file_put_contents($file, $image_base64);

        // Check if successful
        if ($result) :
            // Set server path
            $websitePath = 'https://'.$_SERVER[HTTP_HOST].'/custom-mint/creations/'. $wallet .'/'. $filename;

        	echo json_encode( array('saved' => true, 'path' => $websitePath, 'message' => 'Image saved successfully!') );
        else :
        	echo json_encode( array('saved' => false, 'message' => 'There was an error saving the image :(') );
        endif;
    }

    // Generate the image and store it in the user's folder
    generateImage($imageData, $userWallet);

    // Add row to database
    include_once 'functions.php';
    $pdo = pdo_connect_mysql();

    // Get user ID
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
    $stmt->execute([$userWallet]);

    // Check if user exists or create new user if not
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userID = null;
    if ($user) {
        // User exists, get their database ID
        $userID = $user['ID'];
        $ownedTokens = json_decode($user['owned_tokens'], true);

        // If submitted token ID does not exist in user data, add it
        if ( !in_array($tokenID, $ownedTokens, true) ) {
            array_push($ownedTokens, $tokenID);
        }

        echo json_encode( array('user_status' => 'existing', 'message' => 'Existing user\'s token list updated.') );
    } else {
        // User doesn't exist, add them to the Database
        $ownedTokens = array($tokenID);
        $stmt = $pdo->prepare('INSERT INTO users (user_address, owned_tokens, twitter_username, discord_username, user_level) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([ $userWallet, json_encode($ownedTokens), $twitterUsername, $discordUsername, 0 ]);

        // Get the ID of the new user
        $userID = $pdo->lastInsertId();

        echo json_encode( array('user_status' => 'new', 'message' => 'New user has been added.') );
    }

    // Add/Update the submission in the database
    $stmt = $pdo->prepare('SELECT * FROM submissions WHERE token_id = ?');
    $stmt->execute([$tokenID]);
    $token = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($token) {
        // Token already exists, update it
        $stmt = $pdo->prepare('UPDATE submissions SET image_path = ?, name = ?, description = ?, submission_date = ?, status = ? WHERE token_id = ?');
        $stmt->execute([ $websitePath, $tokenName, $tokenDesc, date('Y-m-d H:i:s'), 'pending', $token['token_id'] ]);

        echo json_encode( array('token_status' => 'existing', 'message' => 'Existing token has been updated.') );
    } else {
        // New token, add it
        $stmt = $pdo->prepare('INSERT INTO submissions (user_id, token_id, image_path, supply, name, description, price, submission_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([ $userID, $tokenID, $websitePath, $tokenSupply, $tokenName, $tokenDesc, 500, date('Y-m-d H:i:s'), 'pending' ]);

        echo json_encode( array('token_status' => 'new', 'message' => 'New token has been added.') );
    }
?>