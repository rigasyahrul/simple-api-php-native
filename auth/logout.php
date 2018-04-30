<?php

    include "../func/main.php";
    require_once "../func/response.php";

    // Logout kita hanya menghapus session dari aplikasi
    session_start();

    session_unset();
    session_destroy();

    successResponse(200, null, 'LogoutSuccesful', 'User telah logout.');