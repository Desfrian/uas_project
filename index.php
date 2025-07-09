<?php 
include 'includes/header.php'; 
include 'includes/db.php';
?>

<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">Selamat datang di CelleBeads</h1>
        <p class="hero-subtitle">Temukan keindahan dalam setiap manik buatan tangan kami.</p>
        <a href="produk.php" class="btn">Mulai Belanja</a>
    </div>
</section>

<div class="container">
    <h2 class="section-title">Produk Unggulan</h2>
    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM produk ORDER BY RAND() LIMIT 4";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="product-card">
                <img src="img/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                <div class="product-card-content">
                    <h3><?php echo htmlspecialchars($row['nama_produk']); ?></h3>
                    <p><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                    <div class="product-card-footer">
                        <span class="product-price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                        <form action="keranjang.php" method="post">
                            <input type="hidden" name="id_produk" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="tambah_keranjang" class="btn">Beli</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p>Belum ada produk unggulan.</p>";
        }
        ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>