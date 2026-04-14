<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_peminjaman.php';

$data = getDataPeminjaman();
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Peminjaman</h3>
    </div>

    <div class="card-body">
        <a href="/UJIKOM/peminjaman/tambah.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>

        <table id="tabelPeminjaman" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?= (int)$d['id_peminjaman']; ?></td>
                    <td><?= htmlspecialchars($d['nama_peminjam']); ?></td>
                    <td><?= htmlspecialchars($d['nama_buku']); ?></td>
                    <td><?= htmlspecialchars($d['tgl_pinjam']); ?></td>
                    <td><?= (int)$d['jumlah']; ?></td>
                    <td>
                        <a href="/UJIKOM/peminjaman/edit.php?id=<?= (int)$d['id_peminjaman']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/UJIKOM/peminjaman/hapus.php?id=<?= (int)$d['id_peminjaman']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus data peminjaman ini?');">
                        <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#tabelPeminjaman').DataTable();
});
</script>

<?php include '../template/footer.php'; ?>