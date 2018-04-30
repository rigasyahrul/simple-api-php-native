<?php

    include "../connection/connection.php";
    include "../func/response.php";
    include "../func/main.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    // TODO: 1
    // validasi input
    if (empty($email)) {
        errorResponse(400, 'EmailRequired', 'Email harus diisi');
    }
    
    if (empty($password)) {
        errorResponse(400, 'PasswordRequired', 'Password harus diisi');
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result->num_rows === 1) {
        session_start();
    
        $row = $result->fetch_assoc();
        
        $token = generateRandomString();
        $row['token'] = $token;
        
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['token'] = $token;
        $_SESSION['last_action'] = time();

        successResponse(200, $row, 'LoginSuccessful', 'Login berhasil.');
    }
    else {
        errorResponse(404, 'UserNotFound', 'User tidak terdaftar.');
    }

    errorResponse(400, 'LoginFailed', 'Login gagal.');

/*
    NB:
    UNTUK MENYAMAKAN PASSWORD YANG SUDAH DI HASH KETIKA REGISTER, MAKA PERLU UNTUK
    MENGGUNAKAN PASSWORD VERIFY YANG DISEDIAKAN PHP UNTUK MENYAMAKAN APAKAH PASSWORD
    SAMA ATAU TIDAK DENGAN SYNTAX :
    $verified = password_verify($password, $row["password"]);
    if($verified === TRUE) {
        JIKA PASSWORD MATCH MAKA
    }
*/
