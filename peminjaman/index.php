<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_peminjaman.php';

$tanggalDari = trim($_GET['tanggal_dari'] ?? '');
$tanggalSampai = trim($_GET['tanggal_sampai'] ?? '');
$errors = [];

$isTanggalValid = function ($tanggal) {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
        return false;
    }

    $date = DateTime::createFromFormat('Y-m-d', $tanggal);
    return $date && $date->format('Y-m-d') === $tanggal;
};

$filterTanggalDari = null;
$filterTanggalSampai = null;

if ($tanggalDari !== '') {
    if ($isTanggalValid($tanggalDari)) {
        $filterTanggalDari = $tanggalDari;
    } else {
        $errors[] = "Format tanggal dari tidak valid.";
    }
}

if ($tanggalSampai !== '') {
    if ($isTanggalValid($tanggalSampai)) {
        $filterTanggalSampai = $tanggalSampai;
    } else {
        $errors[] = "Format tanggal sampai tidak valid.";
    }
}

if (empty($errors) && $filterTanggalDari !== null && $filterTanggalSampai !== null) {
    $tanggalDariObj = DateTime::createFromFormat('Y-m-d', $filterTanggalDari);
    $tanggalSampaiObj = DateTime::createFromFormat('Y-m-d', $filterTanggalSampai);
    if ($tanggalDariObj > $tanggalSampaiObj) {
        $errors[] = "Tanggal dari tidak boleh lebih besar dari tanggal sampai.";
    }
}

if (empty($errors)) {
    $data = getDataPeminjaman($filterTanggalDari, $filterTanggalSampai);
} else {
    $data = getDataPeminjaman();
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Peminjaman</h3>
    </div>

    <div class="card-body">
        <a href="/UJIKOM/peminjaman/tambah.php" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <label for="tanggal_dari">Tanggal Dari</label>
                    <input
                        type="date"
                        id="tanggal_dari"
                        name="tanggal_dari"
                        class="form-control"
                        value="<?= htmlspecialchars($tanggalDari); ?>">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_sampai">Tanggal Sampai</label>
                    <input
                        type="date"
                        id="tanggal_sampai"
                        name="tanggal_sampai"
                        class="form-control"
                        value="<?= htmlspecialchars($tanggalSampai); ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">Filter</button>
                    <a href="/UJIKOM/peminjaman/index.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

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
