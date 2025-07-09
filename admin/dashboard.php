<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container { max-width: 1000px; margin: 20px auto; padding: 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th, .admin-table td { padding: 10px; border: 1px solid #ddd; text-align: left;}
        .admin-table img { max-width: 80px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Selamat Datang, Admin!</h1>
            <a href="logout.php">Logout</a>
        </div>
        
        <a href="tambah_produk.php" class="btn">Tambah Produk Baru</a>
        
        <h2 style="margin-top: 30px;">Daftar Produk</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM produk ORDER BY id DESC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><img src="../img/<?php echo htmlspecialchars($row['gambar']); ?>" alt=""></td>
                    <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                    <td>Rp <?php echo number_format($row['harga']); ?></td>
                    <td><?php echo $row['stok']; ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="hapus_produk.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
