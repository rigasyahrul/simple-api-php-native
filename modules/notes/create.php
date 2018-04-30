<?php

    include "../../connection/connection.php";
    include "../../func/main.php";
    require "../../func/session.php";
    require_once "../../func/response.php";

    $title = $_POST['title'];
    $text = $_POST['text'];

    // TODO: 1
    // validasi input
    if (empty($title)) {
        errorResponse(400, 'TitleRequired', 'Judul harus diisi');
    }
    
    if (empty($text)) {
        errorResponse(400, 'TextRequired', 'Teks harus diisi');
    }

    // TODO: 2
    // ambil data user_id sesion yang sedang login
    $user_id = $_SESSION["id"];

    // TODO: 4
    // buat user baru
    $sql = "INSERT INTO notes (title, text, user_id) 
    VALUES ('$title', '$text', '$user_id')";
    $note_id = 0;
    if ($conn->query($sql) === TRUE) {
        $note_id = $conn->insert_id;
    }

    // TODO: 5
    // ambil data yang baru disimpan
    $sql = "SELECT * FROM notes WHERE id='$note_id' LIMIT 1";
    if($result = $conn->query($sql)){
        $number = $result->num_rows;

        if($number > 0){
            $row = $result->fetch_assoc();
            successResponse(200, $row, 'NoteCreated', 'Note berhasil dibuat!');
        }
    }

    errorResponse(400, 'NoteCreateFailed', 'Note gagal dibuat');