<?php 
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
}

include '../koneksi.php';
include 'fungsi_buku.php';

$id = $_GET['id'];
if (hapusBuku($id)) {
    echo "<script>
        alert('Data berhasil dihapus');
        window.location='index.php';
    </script>";
} else {
    echo "<script>alert('Gagal hapus data');
    window.location='index.php';
    </script>";
}
?>