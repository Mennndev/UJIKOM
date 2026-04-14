<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../koneksi.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: /UJIKOM/peminjaman/index.php?msg=id_tidak_valid");
    exit;
}

// ambil data peminjaman
$stmt = mysqli_prepare($conn, "SELECT id_buku, jumlah FROM peminjaman WHERE id_peminjaman = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$data) {
    header("Location: /UJIKOM/peminjaman/index.php?msg=data_tidak_ditemukan");
    exit;
}

$id_buku = (int)$data['id_buku'];
$jumlah  = (int)$data['jumlah'];

mysqli_begin_transaction($conn);

try {
    // kembalikan stok
    $stmtStok = mysqli_prepare($conn, "UPDATE buku SET stok = stok + ? WHERE id_buku = ?");
    mysqli_stmt_bind_param($stmtStok, "ii", $jumlah, $id_buku);
    mysqli_stmt_execute($stmtStok);
    mysqli_stmt_close($stmtStok);

    // hapus peminjaman
    $stmtDel = mysqli_prepare($conn, "DELETE FROM peminjaman WHERE id_peminjaman = ?");
    mysqli_stmt_bind_param($stmtDel, "i", $id);
    mysqli_stmt_execute($stmtDel);
    mysqli_stmt_close($stmtDel);

    mysqli_commit($conn);
    header("Location: /UJIKOM/peminjaman/index.php?msg=hapus_sukses");
    exit;
} catch (Throwable $e) {
    mysqli_rollback($conn);
    header("Location: /UJIKOM/peminjaman/index.php?msg=hapus_gagal");
    exit;
}