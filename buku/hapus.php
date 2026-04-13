<?php
include 'fungsi_buku.php';

$id = $_GET['id'];

if (hapusBuku($id)) {
    echo "<script>alert('Data Berhasil Dihapus'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal Menghapus Data'); window.location='index.php';</script>";
}
?>