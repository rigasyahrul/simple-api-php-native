<?php

    include "../../connection/connection.php";
    include "../../func/main.php";
    require "../../func/session.php";
    require_once "../../func/response.php";

    // get user id dan id notes
    $user_id = $_SESSION["id"];
    $id = $_GET['id'];

    // buat query
    $sql = "SELECT * FROM notes WHERE user_id = '$user_id' AND id = '$id'";

    // excecute query ke database
    $result = $conn->query($sql);

    // periksa apakah datanya?
    // jika iya return data-nya hanya 1 row
    // jika tidak return error
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        successResponse(200, $data, "DataSuccessfullyLoaded", "Data berhasil diambil.");
    } else {
        errorResponse(404, 'DataNotFound', 'Data tidak ditemukan.');
    }