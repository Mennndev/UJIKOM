<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:../index.php");
    exit;
}

include 'fungsi_penerbit.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location:index.php");
    exit;
}

$token = $_POST['csrf_token'] ?? '';
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    echo "<script>
        alert('Permintaan tidak valid');
        window.location='index.php';
    </script>";
    exit;
}

$id = $_POST['id'] ?? '';
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
