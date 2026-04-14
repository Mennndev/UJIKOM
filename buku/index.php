<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location:../index.php");
}

include '../koneksi.php';
include 'fungsi_buku.php';
include '../template/header.php';
include '../template/sidebar.php';

$data = getDataBuku();
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Buku</h3>
    </div>

    <div class="card-body">

        <a href="tambah.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>

        <table id="tabelBuku" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama Buku</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Nama Penerbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($data as $d){ ?>
                <tr>
                    <td><?= $d['id_buku']; ?></td>
                    <td><?= $d['nama_buku']; ?></td>
                    <td><?= $d['kategori']; ?></td>
                    <td>Rp <?= number_format($d['harga']); ?></td>
                    <td><?= $d['stok']; ?></td>
                    <td><?= $d['nama_penerbit']; ?></td>
                    <td>
                        <a href="edit.php?id=<?= $d['id_buku']; ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="hapus.php?id=<?= $d['id_buku']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus data?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>

        </table>

    </div>
</div>

<script>
$(document).ready(function () {
    $('#tabelBuku').DataTable();
});
</script>

<?php include '../template/footer.php'; ?>