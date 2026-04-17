<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location:../index.php");
    exit;
}

include '../koneksi.php';
include 'fungsi_buku.php';
include '../template/header.php';
include '../template/sidebar.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM buku WHERE id_buku='$id'"
));

if(isset($_POST['update'])){

    if(editBuku($_POST)){
        echo "<script>
            alert('Data berhasil diupdate');
            window.location='index.php';
        </script>";
    }else{
        echo "<script>alert('Gagal update');</script>";
    }
}
?>

<div class="card">
    <div class="card-header bg-warning">
        <h3 class="card-title">Edit Buku</h3>
    </div>

    <div class="card-body">

        <form method="POST" onsubmit="return validasiForm()">

            <div class="form-group">
                <label>ID Buku</label>
                <input type="text" name="id_buku" id="id_buku" value="<?= htmlspecialchars($data['id_buku']); ?>" class="form-control" readonly>
                <small id="err_id" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" id="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" class="form-control">
                <small id="err_kategori" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Nama Buku</label>
                <input type="text" name="nama_buku" id="nama_buku" value="<?= htmlspecialchars($data['nama_buku']); ?>" class="form-control">
                <small id="err_nama" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="harga" id="harga" value="<?= htmlspecialchars($data['harga']); ?>" class="form-control">
                <small id="err_harga" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="text" name="stok" id="stok" value="<?= htmlspecialchars($data['stok']); ?>" class="form-control">
                <small id="err_stok" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Penerbit</label>
                <select name="id_penerbit" id="id_penerbit" class="form-control">
                    <option value="">--Pilih Penerbit--</option>
                    <?php
                    $p = mysqli_query($conn, "SELECT id_penerbit, nama FROM penerbit ORDER BY nama ASC");
                    while($d = mysqli_fetch_assoc($p)){
                        $selected = ($d['id_penerbit'] == $data['id_penerbit']) ? "selected" : "";
                        echo "<option value='".htmlspecialchars($d['id_penerbit'])."' $selected>".htmlspecialchars($d['nama'])."</option>";
                    }
                    ?>
                </select>
                <small id="err_penerbit" class="text-danger"></small>
            </div>

            <button type="submit" name="update" class="btn btn-warning">
                <i class="fas fa-edit"></i> Update
            </button>

            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

<script src="/UJIKOM/assets/js/validasi.js"></script>
<?php include '../template/footer.php'; ?>