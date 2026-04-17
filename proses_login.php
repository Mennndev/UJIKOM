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

$query = mysqli_query($conn, "SELECT * FROM akun_petugas WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $_SESSION['login'] = true;
    $_SESSION['user'] = $username;
    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>alert('Username atau Password salah!'); window.location='index.php';</script>";
    exit;
}