<?php

$conn = new mysqli("localhost", "root", "", "note_db_dev");

if ($conn->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}