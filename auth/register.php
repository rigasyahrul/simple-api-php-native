<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include "../connection/connection.php";
    include "../func/response.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // TODO: 1
    // validasi input
    if (empty($name)) {
        errorResponse(400, 'NameRequired', 'Nama harus diisi');
    }

    if (empty($email) ) {
        errorResponse(400, 'EmailRequired', 'Email harus diisi');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        errorResponse(400, 'InvalidFormatEmail', 'Format email salah');
    }

    if (empty($password)) {
        errorResponse(400, 'Password', 'Password harus diisi');
    } elseif ($password != $confirm_password) {
        errorResponse(400, 'ConfirmPasswordNotMatch', 'Konfirmasi password tidak sama dengan password');
    }

    // TODO: 2
    // cek email telah digunakan atau belum
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    if($result = $conn->query($sql)){
        $number = $result->num_rows;

        if($number > 0){
            errorResponse(409, 'EmailAlreadyTaken', 'Email telah digunakan');
        }
    }

    // TODO: 3
    // kalau belum digunakan
    // buat user baru
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $id_user = $conn->insert_id;
        successResponse(200, null, 'RegisterSuccessful', 'Registrasi berhasil!');
    }

    errorResponse(400, 'RegisterFailed', 'Registrasi Gagal');

/*
    NB :
    PASSWORD BISA DIBUAT DENGAN MENGGUNAKAN ENKRIPSI YANG TELAHD DISEDIAKAN OLEH
    PHP, SALAH SATUA DENGAN MENGGUNAKAN SALT

    $options = [
        'cost' => 12,
    ];
    $password = password_hash($username, PASSWORD_BCRYPT, $options);
*/