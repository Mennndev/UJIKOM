<?php
include 'fungsi_peminjaman.php';
$data_pinjam = getDataPeminjaman();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Peminjaman</title>
</head>
<body>
    <h2>Daftar Peminjaman Buku</h2>
    <a href="tambah.php">Tambah Peminjaman</a> | <a href="../dashboard.php">Kembali</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr bgcolor="#eee">
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Jumlah</th>
        </tr>
        <?php 
        $no = 1;
        while($row = mysqli_fetch_assoc($data_pinjam)) : 
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama_peminjam']; ?></td>
            <td><?= $row['nama_buku']; ?></td>
            <td><?= $row['tgl_pinjam']; ?></td>
            <td><?= $row['jumlah']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>