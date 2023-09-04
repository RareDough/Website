<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Form variables
    $data = json_decode(file_get_contents('php://input'));
    $userWallet = $request = $data->userWallet;
    $imageData = $request = $data->imgBase64;

	function generateImage($img, $wallet) {
        global $data;
        global $userWallet;
        global $imageData;

        $tokenID = $data->id;
        $tokenName = $data->name;
        $tokenDesc = $data->description;
        $folderPath = null;
        $websitePath = null;
        $userTwitter = $data->twitter;
        $userDiscord = $data->discord;

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
            // Set web path
            $websitePath = 'https://'.$_SERVER['HTTP_HOST'].'/custom-mint/creations/'. $wallet .'/'. $filename;

            // Add row to database
            include_once 'functions.php';
            $pdo = pdo_connect_mysql();

            // Get user ID
            $stmt = $pdo->prepare('SELECT * FROM users WHERE user_address = ?');
            $stmt->execute([ $userWallet ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $userID = $user['ID'];

            // Update user socials
            if ($userTwitter || $userDiscord) {
                $stmt = $pdo->prepare('UPDATE users SET twitter_username = ?, discord_username = ? WHERE ID = ?');
                $stmt->execute([ $userTwitter, $userDiscord, $userID ]);
            }

            // Update the submission in the database
            $stmt = $pdo->prepare('SELECT * FROM submissions WHERE token_id = ?');
            $stmt->execute([$tokenID]);
            $token = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($token) {
                // Update the token database entry
                $stmt = $pdo->prepare('UPDATE submissions SET image_path = ?, name = ?, description = ?, price = ?, submission_date = ?, status = ? WHERE token_id = ?');
                $stmt->execute([ $websitePath, $tokenName, $tokenDesc, 100, date('Y-m-d H:i:s'), 'pending', $token['token_id'] ]);

                echo json_encode( array('token_updated' => true, 'message' => 'Token has been updated.') );
            } else {
                echo json_encode( array('token_updated' => false, 'message' => 'Token ID not found or not owned by user.') );
            }
        else :
        	echo json_encode( array('token_updated' => false, 'message' => 'There was an error saving the image :(') );
        endif;
    }

    // Generate the image and store it in the user's folder
    generateImage($imageData, $userWallet);
?>