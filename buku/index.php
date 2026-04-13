<?php
include 'fungsi_buku.php';
$data_buku = getDataBuku();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>
</head>
<body>
    <h2>Daftar Buku</h2>
    <a href="tambah.php">Tambah Buku</a> | <a href="../dashboard.php">Kembali</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID Buku</th>
            <th>Kategori</th>
            <th>Nama Buku</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Penerbit</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($data_buku)) : ?>
        <tr>
            <td><?= $row['id_buku']; ?></td>
            <td><?= $row['kategori']; ?></td>
            <td><?= $row['nama_buku']; ?></td>
            <td><?= number_format($row['harga']); ?></td>
            <td><?= $row['stok']; ?></td>
            <td><?= $row['nama_penerbit']; ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_buku']; ?>">Edit</a> | 
                <a href="hapus.php?id=<?= $row['id_buku']; ?>" onclick="return confirm('Yakin?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>