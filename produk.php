<?php 
include 'includes/header.php'; 
?>

<div class="container">
    <h1 class="page-title">Semua Produk Kami</h1>
    
    <?php
    if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
        echo '<p style="color: green; text-align: center;">Produk berhasil ditambahkan ke keranjang!</p>';
    }
    ?>

    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM produk ORDER BY created_at DESC";
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
                            <button type="submit" name="tambah_keranjang" class="btn">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p>Tidak ada produk yang tersedia saat ini.</p>";
        }
        ?>
    </div>
</div>

<?php 
include 'includes/footer.php'; 
?>