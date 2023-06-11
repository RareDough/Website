<?php
	generateImage($_POST['imgBase64'], $_POST['userWallet']);

	function generateImage($img, $wallet) {
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
        $file = $folderPath . uniqid() . '.jpg';

        // Store the image on the server
        $result = file_put_contents($file, $image_base64);

        // Check if successful
        if ($result) :
        	echo json_encode(array('saved' => true, 'path' => $file, 'message' => 'Image saved successfully!'));
        else :
        	echo json_encode(array('saved' => false, 'message' => 'There was an error saving the image :('));
        endif;
    }
?>