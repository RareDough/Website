<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Form variables
    $userWallet = $_POST['userWallet'];
    $imageData = $_POST['imgBase64'];
    $id = $_POST['id'];
    $supply = $_POST['supply'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    echo json_encode( 
        array(
            'wallet' => $userWallet,
            'image' => $imageData,
            'id' => $id,
            'supply' => $supply,
            'name' => $name,
            'desc' => $description
        )
    );
?>