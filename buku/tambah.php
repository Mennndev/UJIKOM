<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location:../index.php");
}

include '../koneksi.php';
include 'fungsi_buku.php';
include '../template/header.php';
include '../template/sidebar.php';

// PROSES SIMPAN
if(isset($_POST['simpan'])){

    // VALIDASI BACKEND
    if($_POST['id_buku']=="" || $_POST['nama_buku']==""){
        echo "<script>alert('Data tidak boleh kosong');</script>";
    }else{

        if(tambahBuku($_POST)){
            echo "<script>
                alert('Data berhasil ditambah');
                window.location='index.php';
            </script>";
        }else{
            echo "<script>alert('Gagal tambah data');</script>";
        }
    }
}
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Tambah Buku</h3>
    </div>

    <div class="card-body">

        <form method="POST" onsubmit="return validasiForm()">

            <div class="form-group">
                <label>ID Buku</label>
                <input type="text" name="id_buku" id="id_buku" class="form-control">
                <small id="err_id" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control">
                <small id="err_kategori" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Nama Buku</label>
                <input type="text" name="nama_buku" id="nama" class="form-control">
                <small id="err_nama" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="text" name="harga" id="harga" class="form-control">
                <small id="err_harga" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="text" name="stok" id="stok" class="form-control">
                <small id="err_stok" class="text-danger"></small>
            </div>

            <div class="form-group">
                <label>Penerbit</label>
                <select name="id_penerbit" id="penerbit" class="form-control">
                    <option value="">--Pilih Penerbit--</option>
                    <?php 
                    $p = mysqli_query($conn, "SELECT * FROM penerbit");
                    while($d = mysqli_fetch_array($p)){
                        echo "<option value='$d[id_penerbit]'>$d[nama]</option>";
                    }
                    ?>
                </select>
                <small id="err_penerbit" class="text-danger"></small>
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

<script src="/UJIKOM/assets/js/validasi.js"></script>
<?php include '../template/footer.php'; ?>