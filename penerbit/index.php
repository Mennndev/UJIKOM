<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

$data = getDataPenerbit();
$msg = $_GET['msg'] ?? '';

$flashMap = [
    'tambah_sukses' => ['type' => 'success', 'text' => 'Data penerbit berhasil ditambah.'],
    'edit_sukses' => ['type' => 'success', 'text' => 'Data penerbit berhasil diperbarui.'],
    'hapus_sukses' => ['type' => 'success', 'text' => 'Data penerbit berhasil dihapus.'],
    'hapus_gagal' => ['type' => 'danger', 'text' => 'Data penerbit gagal dihapus.'],
    'data_tidak_ditemukan' => ['type' => 'danger', 'text' => 'Data penerbit tidak ditemukan.']
];
$flash = $flashMap[$msg] ?? null;
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Penerbit</h3>
    </div>

    <div class="card-body">
        <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']); ?>">
                <?= htmlspecialchars($flash['text']); ?>
            </div>
        <?php endif; ?>

        <a href="/UJIKOM/penerbit/tambah.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Penerbit
        </a>

        <table id="tabelPenerbit" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Penerbit</th>
                    <th>Nama Penerbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['id_penerbit']); ?></td>
                        <td><?= htmlspecialchars($d['nama']); ?></td>
                        <td>
                            <a href="/UJIKOM/penerbit/edit.php?id=<?= urlencode($d['id_penerbit']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/UJIKOM/penerbit/hapus.php?id=<?= urlencode($d['id_penerbit']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus data penerbit ini?');">
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
    $('#tabelPenerbit').DataTable();
});
</script>

<?php include '../template/footer.php'; ?>
