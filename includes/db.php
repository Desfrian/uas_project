<?php
// File: includes/db.php

// PENTING: Ganti detail ini sesuai dengan konfigurasi XAMPP Anda.
$db_host = 'localhost';
$db_user = 'root'; // Username database Anda
$db_pass = '';     // Password database Anda (biasanya kosong di XAMPP)
$db_name = 'cellebeads_db';

// Membuat koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mengatur charset ke utf8
$conn->set_charset("utf8");
?>