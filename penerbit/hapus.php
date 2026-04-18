<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include 'fungsi_penerbit.php';

$id = trim($_GET['id'] ?? '');
if ($id === '') {
    header('Location: /UJIKOM/penerbit/index.php?msg=hapus_gagal');
    exit;
}

$error = null;
if (hapusPenerbit($id, $error)) {
    header('Location: /UJIKOM/penerbit/index.php?msg=hapus_sukses');
    exit;
}

header('Location: /UJIKOM/penerbit/index.php?msg=hapus_gagal');
exit;
?>
