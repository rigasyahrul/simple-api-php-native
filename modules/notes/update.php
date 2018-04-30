<?php

// source
// https://stackoverflow.com/questions/27941207/http-protocols-put-and-delete-and-their-usage-in-php
    include "../../connection/connection.php";
    include "../../func/main.php";
    require "../../func/session.php";
    require_once "../../func/response.php";

    // check method harus menggunakan PUT
    $method = $_SERVER['REQUEST_METHOD'];
    if ('PUT' === $method) {
        parse_str(file_get_contents('php://input'), $_PUT);
    } else {
        errorResponse(400, 'MethodNotAllowed', 'Fungsi tidak dapat digunakan.');
    }

    // get input
    $title = $_PUT['title'];
    $text = $_PUT['text'];

    // TODO: 1 validasi input
    if (empty($title)) {
        errorResponse(400, 'TitleRequired', 'Judul harus diisi');
    }
    
    if (empty($text)) {
        errorResponse(400, 'TextRequired', 'Teks harus diisi');
    }

    $user_id = $_SESSION['id'];
    $id = $_GET['id'];
    // TODO: 2 periksa apakah notes ada di databse?
    $sql = "SELECT * FROM notes WHERE user_id = '$user_id' AND id = '$id'";
    $result = $conn->query($sql);

    // jika tidak ada maka return error
    if ($result->num_rows < 1) {
        errorResponse(404, 'DataNotFound', 'Data tidak ditemukan.');
    }

    // jika ada, maka lanjutkan proses update
    $sql = "UPDATE notes SET title = '$title', text = '$text' WHERE user_id = '$user_id' AND id = '$id'";
    $update = false;
    // update database
    if ($conn->query($sql) === TRUE) {
        $update = true;
    }

    // jika update berhasil
    // return success
    // jika tidak
    // return error
    if ($update) {
        $sql = "SELECT * FROM notes WHERE user_id = '$user_id' AND id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            successResponse(200, $data, "DataSuccessfullyUpdated", "Data berhasil diperbarui.");
        } else {
            errorResponse(404, 'DataNotFound', 'Data tidak ditemukan.');
        }
    }