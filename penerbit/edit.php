<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

$id = trim($_GET['id'] ?? '');
$data = ($id !== '') ? getPenerbitById($id) : null;

if (!$data) {
    header('Location: /UJIKOM/penerbit/index.php?msg=data_tidak_ditemukan');
    exit;
}

$errors = [];
$nama = $data['nama'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');

    if ($nama === '') {
        $errors[] = 'Nama penerbit wajib diisi.';
    }

    if (empty($errors)) {
        $error = null;
        if (updatePenerbit($id, $nama, $error)) {
            header('Location: /UJIKOM/penerbit/index.php?msg=edit_sukses');
            exit;
        }

        $errors[] = $error ?? 'Gagal memperbarui data penerbit.';
    }
}
?>

<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">Edit Penerbit</h3>
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
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['id_penerbit']); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama Penerbit</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama); ?>">
            </div>

            <button type="submit" class="btn btn-warning">
                <i class="fas fa-edit"></i> Update
            </button>
            <a href="/UJIKOM/penerbit/index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
