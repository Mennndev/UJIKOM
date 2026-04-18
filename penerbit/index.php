<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:../index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$data = getDataPenerbit();
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Penerbit</h3>
    </div>

    <div class="card-body">
        <a href="tambah.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Penerbit
        </a>

        <table id="tabelPenerbit" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Kota</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['id_penerbit']); ?></td>
                        <td><?= htmlspecialchars($d['nama']); ?></td>
                        <td><?= htmlspecialchars($d['alamat']); ?></td>
                        <td><?= htmlspecialchars($d['kota']); ?></td>
                        <td><?= htmlspecialchars($d['telepon']); ?></td>
                        <td>
                            <a href="edit.php?id=<?= urlencode($d['id_penerbit']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="hapus.php" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($d['id_penerbit']); ?>">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#tabelPenerbit').DataTable();
});
</script>

<?php include '../template/footer.php'; ?>
