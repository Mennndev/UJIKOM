<?php
include 'fungsi_peminjaman.php';

// Ambil data buku untuk dropdown
$data_buku = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0");

if (isset($_POST['simpan'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_peminjam']);
    $id_buku = $_POST['id_buku'];
    $tgl    = $_POST['tgl_pinjam'];
    $jml    = intval($_POST['jumlah']);

    // Validasi PHP: Cek stok buku sebelum memproses
    $query_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    $b = mysqli_fetch_assoc($query_stok);

    if ($jml > $b['stok']) {
        echo "<script>alert('Gagal! Stok tidak mencukupi. Stok tersedia: " . $b['stok'] . "');</script>";
    } else {
        if (tambahPeminjaman($nama, $id_buku, $tgl, $jml)) {
            // Logika tambahan: Kurangi stok buku setelah berhasil pinjam
            mysqli_query($conn, "UPDATE buku SET stok = stok - $jml WHERE id_buku = '$id_buku'");
            echo "<script>alert('Peminjaman Berhasil!'); window.location='index.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peminjaman</title>
    <script src="validasi_pinjam.js"></script>
</head>
<body>
    <h2>Tambah Peminjaman</h2>
    <form name="formPinjam" action="" method="POST" onsubmit="return validasiPinjam()">
        <table>
            <tr>
                <td>Nama Peminjam</td>
                <td><input type="text" name="nama_peminjam"></td>
            </tr>
            <tr>
                <td>Pilih Buku</td>
                <td>
                    <select name="id_buku">
                        <option value="">-- Pilih Buku --</option>
                        <?php while($b = mysqli_fetch_assoc($data_buku)) : ?>
                            <option value="<?= $b['id_buku']; ?>"><?= $b['nama_buku']; ?> (Stok: <?= $b['stok']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><input type="date" name="tgl_pinjam" value="<?= date('Y-m-d'); ?>"></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><input type="number" name="jumlah"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="simpan">Simpan</button>
                    <a href="index.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>