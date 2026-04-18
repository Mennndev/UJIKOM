<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:../index.php");
    exit;
}

include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_penerbit.php';

if (isset($_POST['simpan'])) {
    if (
        trim($_POST['id_penerbit'] ?? '') === '' ||
        trim($_POST['nama'] ?? '') === '' ||
        trim($_POST['alamat'] ?? '') === '' ||
        trim($_POST['kota'] ?? '') === '' ||
        trim($_POST['telepon'] ?? '') === ''
    ) {
        echo "<script>alert('Data tidak boleh kosong');</script>";
    } else {
        if (tambahPenerbit($_POST)) {
            echo "<script>
                alert('Data berhasil ditambah');
                window.location='index.php';
            </script>";
        } else {
            echo "<script>alert('Gagal tambah data');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Tambah Penerbit</h3>
    </div>

    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label>ID Penerbit</label>
                <input type="text" name="id_penerbit" class="form-control" value="<?= htmlspecialchars($_POST['id_penerbit'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($_POST['alamat'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Kota</label>
                <input type="text" name="kota" class="form-control" value="<?= htmlspecialchars($_POST['kota'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Telepon</label>
                <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($_POST['telepon'] ?? ''); ?>">
            </div>

            <button type="submit" name="simpan" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </form>
    </div>
</div>

<?php include '../template/footer.php'; ?>
