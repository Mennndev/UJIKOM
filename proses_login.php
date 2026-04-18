<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '') {
    echo "<script>alert('Username dan Password wajib diisi!'); window.location='index.php';</script>";
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM akun_petugas WHERE username = ? AND password = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $username, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);

if ($userData) {
    $displayName = trim($userData['nama'] ?? $userData['nama_petugas'] ?? $userData['username'] ?? $username);
    $role = trim($userData['role'] ?? $userData['level'] ?? $userData['jabatan'] ?? '');

    $_SESSION['login'] = true;
    $_SESSION['user'] = $username;
    $_SESSION['nama'] = $displayName !== '' ? $displayName : $username;
    if ($role !== '') {
        $_SESSION['role'] = $role;
    }
    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>alert('Username atau Password salah!'); window.location='index.php';</script>";
    exit;
}
