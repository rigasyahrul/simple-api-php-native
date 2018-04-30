<?php
    // kode ini diperuntukkan membaca session
    // apakah session sudah expired atau belum.
    // mohon maaf belum dirubah jadi b.indo.
    // ada juga beberapa tambahan yang dimasukkan ke dalam kode ini



    // this code got it from this source
    // http://thisinterestsme.com/expire-php-sessions/

    include "../../func/token.php";
    include "../../func/response.php";

    //Start our session.
    session_start();
    
    //Expire the session if user is inactive for 30
    //minutes or more.
    $expireAfter = 0;
    
    //Check to see if our "last action" session
    //variable has been set.
    if(isset($_SESSION['last_action'])){
        
        //Figure out how many seconds have passed
        //since the user was last active.
        $secondsInactive = time() - $_SESSION['last_action'];
        
        //Convert our minutes into seconds.
        $expireAfterSeconds = $expireAfter * 60;
        
        //Check to see if they have been inactive for too long.
        if($secondsInactive >= $expireAfterSeconds){
            //User has been inactive for too long.
            //Kill their session.
            session_unset();
            session_destroy();
            // tambahkan return token expired
            errorResponse(400, 'TokenExpired', 'Token telah kadaluarsa.');
        }
        
    } else {
        // karena jika expired token sudah habis, maka token tidak dapat digunakan kembali
        // tampilkan token tidak di sediakan
        errorResponse(400, 'TokenNotProvided', 'Token tidak disediakan.');
    }


    // extending code dari hasil comot di stackoverflow
    // periksa ada token yang dikirimkan atau tidak di PARAMETER di URL api
    // kalo gak ada kasi token required
    if(isset($_GET['token']) && !empty($_GET['token'])){
        $token = $_GET['token'];
    } else {
        errorResponse(400, 'TokenRequired', 'Token dibutuhkan.');
    }

    // periksa apakah token sama yang dibuat ketika login sama 
    // dengan token ketika kita HIT ke URL yang diinginkan
    if ($_SESSION['token'] != $token) {
        errorResponse(400, 'TokenInvalid', 'Token tidak dapat digunakan.');
    }

    // kode ini tidak diperlukan
    //Assign the current timestamp as the user's
    //latest activity
    // $_SESSION['last_action'] = time();