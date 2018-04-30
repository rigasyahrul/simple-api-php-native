<?php

    include "../../connection/connection.php";
    include "../../func/main.php";
    require "../../func/session.php";
    require_once "../../func/response.php";

    // get user id dari session
    $user_id = $_SESSION["id"];
    
    // quary select dari database
    $sql = "SELECT * FROM notes WHERE user_id = '$user_id'";

    // execute query
    $result = $conn->query($sql);

    // periksa apakah data return lebih dari 1
    // jika iya
    // lakukan perulangan yang akan kita masukkan ke dalam array
    // jika tidak
    // return error
    if ($result->num_rows > 0) {
        $data = array();
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        successResponse(200, $data, "DataSuccessfullyLoaded", "Data berhasil diambil.");
    } else {
        errorResponse(404, 'DataNotFound', 'Data tidak ditemukan.');
    }