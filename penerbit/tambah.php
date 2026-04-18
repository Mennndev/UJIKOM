<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

$errors = [];
$id_penerbit = '';
$nama = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_penerbit = trim($_POST['id_penerbit'] ?? '');
    $nama = trim($_POST['nama'] ?? '');

    if ($id_penerbit === '') {
        $errors[] = 'ID penerbit wajib diisi.';
    }

    if ($nama === '') {
        $errors[] = 'Nama penerbit wajib diisi.';
    }

    if (empty($errors)) {
        $error = null;
        if (tambahPenerbit($id_penerbit, $nama, $error)) {
            header('Location: /UJIKOM/penerbit/index.php?msg=tambah_sukses');
            exit;
        }

        $errors[] = $error ?? 'Gagal menambah data penerbit.';
    }
}
?>

<div class="card">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">Tambah Penerbit</h3>
    </div>

    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>ID Penerbit</label>
                <input type="text" name="id_penerbit" class="form-control" value="<?= htmlspecialchars($id_penerbit); ?>">
            </div>

            <div class="form-group">
                <label>Nama Penerbit</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama); ?>">
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="/UJIKOM/penerbit/index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
