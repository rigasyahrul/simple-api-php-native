<?php
    // source
    // https://stackoverflow.com/questions/27941207/http-protocols-put-and-delete-and-their-usage-in-php
    include "../../connection/connection.php";
    include "../../func/main.php";
    require "../../func/session.php";
    require_once "../../func/response.php";

    // check method harus menggunakan DELETE
    $method = $_SERVER['REQUEST_METHOD'];
    if ('DELETE' === $method) {

    } else {
        errorResponse(400, 'MethodNotAllowed', 'Fungsi tidak dapat digunakan.');
    }

    // get user id dan id yang mau dihapus
    $user_id = $_SESSION['id'];
    $id = $_GET['id'];

    // periksa di database apakah ada data id-nya
    $sql = "SELECT * FROM notes WHERE id = '$id'";
    $result = $conn->query($sql);

    // jika tidak ada maka return error
    if ($result->num_rows < 1) {
        errorResponse(404, 'DataNotFound', 'Data tidak ditemukan.');
    }
    
    $sql = "DELETE FROM notes WHERE id = '$id'";
    // excecute query delete
    // jika berhasil return success
    // jika tidak return error
    if ($conn->query($sql) === TRUE) {
        successResponse(200, null, "DataSuccessfullyDeleted", "Data berhasil dihapus.");
    } else {
        errorResponse(400, 'DeletedFailed', 'Tidak dapat menghapus data.');
    }

