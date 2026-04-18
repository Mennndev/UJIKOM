<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:../index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

$id = $_GET['id'] ?? '';
$data = getPenerbitById($id);

if (!$data) {
    echo "<script>
        alert('Data penerbit tidak ditemukan');
        window.location='index.php';
    </script>";
    exit;
}

if (isset($_POST['update'])) {
    if (
        trim($_POST['id_penerbit'] ?? '') === '' ||
        trim($_POST['nama'] ?? '') === '' ||
        trim($_POST['alamat'] ?? '') === '' ||
        trim($_POST['kota'] ?? '') === '' ||
        trim($_POST['telepon'] ?? '') === ''
    ) {
        echo "<script>alert('Data tidak boleh kosong');</script>";
    } else {
        if (editPenerbit($_POST)) {
            echo "<script>
                alert('Data berhasil diupdate');
                window.location='index.php';
            </script>";
        } else {
            echo "<script>alert('Gagal update data');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">Edit Penerbit</h3>
    </div>

    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label>ID Penerbit</label>
                <input type="text" name="id_penerbit" class="form-control" value="<?= htmlspecialchars($data['id_penerbit']); ?>" readonly>
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($data['alamat']); ?>">
            </div>

            <div class="form-group">
                <label>Kota</label>
                <input type="text" name="kota" class="form-control" value="<?= htmlspecialchars($data['kota']); ?>">
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($data['telepon']); ?>">
            </div>

            <button type="submit" name="update" class="btn btn-warning">
                <i class="fas fa-edit"></i> Update
            </button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
