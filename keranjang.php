<?php
// File ini menangani penambahan item, pembaruan, dan tampilan keranjang
include 'includes/header.php';
include 'includes/db.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// --- LOGIKA KERANJANG ---

// 1. Menambah produk ke keranjang
if (isset($_POST['tambah_keranjang'])) {
    $id_produk = $_POST['id_produk'];
    
    // Ambil info produk dari DB
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if ($produk) {
        $item_ditemukan = false;
        // Cek jika produk sudah ada di keranjang
        foreach ($_SESSION['keranjang'] as $index => $item) {
            if ($item['id'] == $id_produk) {
                $_SESSION['keranjang'][$index]['kuantitas']++;
                $item_ditemukan = true;
                break;
            }
        }
        // Jika produk belum ada, tambahkan baru
        if (!$item_ditemukan) {
            $_SESSION['keranjang'][] = [
                "id" => $id_produk,
                "nama" => $produk['nama_produk'],
                "harga" => $produk['harga'],
                "gambar" => $produk['gambar'],
                "kuantitas" => 1
            ];
        }
    }
    // Redirect untuk mencegah re-submit form saat refresh
    header("Location: produk.php?status=sukses");
    exit();
}

// 2. Menghapus produk dari keranjang
if (isset($_GET['hapus'])) {
    $index_hapus = $_GET['hapus'];
    if (isset($_SESSION['keranjang'][$index_hapus])) {
        unset($_SESSION['keranjang'][$index_hapus]);
        // Re-index array
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
    header("Location: keranjang.php");
    exit();
}

// --- TAMPILAN KERANJANG ---
?>

<div class="container">
    <h1 class="page-title">Keranjang Belanja Anda</h1>

    <?php if (empty($_SESSION['keranjang'])): ?>
        <p style="text-align: center;">Keranjang Anda masih kosong. Yuk, mulai <a href="produk.php">belanja</a>!</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_harga = 0;
                foreach ($_SESSION['keranjang'] as $index => $item):
                    $subtotal = $item['harga'] * $item['kuantitas'];
                    $total_harga += $subtotal;
                ?>
                <tr>
                    <td><img src="img/<?php echo htmlspecialchars($item['gambar']); ?>" alt="" width="80"></td>
                    <td><?php echo htmlspecialchars($item['nama']); ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['kuantitas']; ?></td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td><a href="keranjang.php?hapus=<?php echo $index; ?>" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="cart-total">
            Total: Rp <?php echo number_format($total_harga, 0, ',', '.'); ?>
        </div>

        <div class="checkout-button-container">
            <?php
            // Menyiapkan pesan untuk WhatsApp
            $pesan_wa = "Halo, saya ingin memesan:\n";
            foreach ($_SESSION['keranjang'] as $item) {
                $pesan_wa .= "- " . $item['nama'] . " (" . $item['kuantitas'] . " pcs)\n";
            }
            $pesan_wa .= "\nTotal: Rp " . number_format($total_harga, 0, ',', '.');
            
            // Nomor WhatsApp Anda (ganti dengan nomor Anda)
            $nomor_wa = "6295602983145"; // Format: 62... tanpa + atau 0 di depan
            
            $link_wa = "https://wa.me/" . $nomor_wa . "?text=" . urlencode($pesan_wa);
            ?>
            <a href="<?php echo $link_wa; ?>" class="btn" target="_blank">Checkout via WhatsApp</a>
        </div>
    <?php endif; ?>
</div>

<?php 
$conn->close();
include 'includes/footer.php'; 
?>
