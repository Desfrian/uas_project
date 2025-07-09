<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: Hapus file gambar dari server
    $sql_select = "SELECT gambar FROM produk WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($row = $result->fetch_assoc()) {
        $file_path = '../img/' . $row['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Hapus data dari database
    $sql_delete = "DELETE FROM produk WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        header('Location: dashboard.php?status=hapus_sukses');
    } else {
        header('Location: dashboard.php?status=hapus_gagal');
    }
} else {
    header('Location: dashboard.php');
}
exit();
?>
