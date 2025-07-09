<?php
// Memulai session di setiap halaman
session_start();

// Memasukkan file koneksi database.
// __DIR__ memastikan path selalu benar tidak peduli dari mana file ini di-include.
include_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CelleBeads - Handmade Beads</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <!-- External CSS (Gunakan path absolut dari root jika ada masalah) -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="main-header">
        <nav class="container nav-container">
            <a href="index.php" class="nav-brand">CelleBeads</a>
            <div class="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="produk.php" class="nav-link">Produk</a>
            </div>
            <div class="nav-actions">
                <?php
                // Menghitung jumlah item di keranjang
                $jumlah_item_keranjang = 0;
                if (isset($_SESSION['keranjang'])) {
                    foreach ($_SESSION['keranjang'] as $item) {
                        $jumlah_item_keranjang += $item['kuantitas'];
                    }
                }
                ?>
                <a href="keranjang.php" class="cart-button">
                    Keranjang (<?php echo $jumlah_item_keranjang; ?>)
                </a>
            </div>
        </nav>
    </header>
    <main>
