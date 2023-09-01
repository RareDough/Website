<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Form variables
    $userWallet = $_POST['userWallet'];
    $imageData = $_POST['imgBase64'];
    $id = $_POST['id'];
    $suppy = $_POST['supply'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    echo $userWallet . '\n' . $imageData . '\n' . $id . '\n' . $supply . '\n' . $name . '\n' . $description;
?>