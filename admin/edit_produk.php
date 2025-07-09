<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    // Logika Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../img/";
    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi sederhana
    $check = getimagesize($_FILES['gambar']['tmp_name']);
    if($check !== false) {
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Gambar berhasil diupload, masukkan data ke database
            $sql = "INSERT INTO produk (nama_produk, deskripsi, harga, stok, gambar) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdis", $nama_produk, $deskripsi, $harga, $stok, $gambar);
            
            if ($stmt->execute()) {
                $message = "Produk baru berhasil ditambahkan!";
            } else {
                $message = "Error: " . $stmt->error;
            }
        } else {
            $message = "Maaf, terjadi kesalahan saat mengupload file.";
        }
    } else {
        $message = "File yang diupload bukan gambar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk Baru</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah Produk Baru</h1>
        <a href="dashboard.php" style="display: block; margin-bottom: 20px;">&larr; Kembali ke Dashboard</a>

        <?php if($message): ?>
            <p style="background: #e0fde0; padding: 10px; border-radius: 5px; text-align: center;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="tambah_produk.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" required></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" step="1000" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
