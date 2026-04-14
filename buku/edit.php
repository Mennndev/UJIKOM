<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location:../index.php");
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
                <input type="text" name="id_buku" value="<?= $data['id_buku']; ?>" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" id="kategori" value="<?= $data['kategori']; ?>" class="form-control">
                <small id="err_kategori" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Nama Buku</label>
                <input type="text" name="nama_buku" id="nama" value="<?= $data['nama_buku']; ?>" class="form-control">
                <small id="err_nama" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="harga" id="harga" value="<?= $data['harga']; ?>" class="form-control">
                <small id="err_harga" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="text" name="stok" id="stok" value="<?= $data['stok']; ?>" class="form-control">
                <small id="err_stok" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Penerbit</label>
                <select name="id_penerbit" id="penerbit" class="form-control">
                    <?php
                    $p = mysqli_query($conn,"SELECT * FROM penerbit");
                    while($d = mysqli_fetch_array($p)){
                        $selected = ($d['id_penerbit'] == $data['id_penerbit']) ? "selected" : "";
                        echo "<option value='$d[id_penerbit]' $selected>$d[nama]</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-warning">
                <i class="fas fa-edit"></i> Update
            </button>

            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
</div>

<?php include '../template/footer.php'; ?>