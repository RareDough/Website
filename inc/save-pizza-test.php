<?php
    // Form variables
    $userWallet = $_POST['wallet'];

    echo json_encode( 
        array(
            'wallet' => $userWallet
        )
    );
?>