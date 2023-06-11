<?php
	generateImage($_POST['imgBase64']);

	function generateImage($img) {
        $folderPath = $_SERVER['DOCUMENT_ROOT'].'/custom-mint/creations/';
        $image_parts = explode(';base64,', $img);
        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.png';
        $result = file_put_contents($file, $image_base64);
        if ($result) :
        	echo json_encode(array('saved' => true, 'path' => $file, 'message' => 'Image saved successfully!'));
        else :
        	echo json_encode(array('saved' => false, 'message' => 'There was an error saving the image :('));
        endif;
    }
?>