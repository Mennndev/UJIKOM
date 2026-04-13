<?php
include 'fungsi_buku.php';

// Mengambil data penerbit untuk pilihan di dropdown
$penerbit_query = mysqli_query($conn, "SELECT * FROM penerbit");

if (isset($_POST['simpan'])) {
    if (tambahBuku($_POST['id_buku'], $_POST['kategori'], $_POST['nama_buku'], $_POST['harga'], $_POST['stok'], $_POST['id_penerbit'])) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
</head>
<body>
    <h2>Form Tambah Buku</h2>
    <form action="" method="POST">
        <label>ID Buku:</label><br>
        <input type="text" name="id_buku" required><br>
        
        <label>Kategori:</label><br>
        <input type="text" name="kategori" required><br>
        
        <label>Nama Buku:</label><br>
        <input type="text" name="nama_buku" required><br>
        
        <label>Harga:</label><br>
        <input type="number" name="harga" required><br>
        
        <label>Stok:</label><br>
        <input type="number" name="stok" required><br>
        
        <label>Penerbit:</label><br>
        <select name="id_penerbit">
            <?php while($p = mysqli_fetch_assoc($penerbit_query)) : ?>
                <option value="<?= $p['id_penerbit']; ?>"><?= $p['nama_penerbit']; ?></option>
            <?php endwhile; ?>
        </select><br><br>
        
        <button type="submit" name="simpan">Simpan Data</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>