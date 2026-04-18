<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:../index.php");
    exit;
}

include 'fungsi_penerbit.php';

$id = $_GET['id'] ?? '';
if ($id === '') {
    header("Location:index.php");
    exit;
}

if (hapusPenerbit($id)) {
    echo "<script>
        alert('Data berhasil dihapus');
        window.location='index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal hapus data');
        window.location='index.php';
    </script>";
}
?>
