<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM petugas WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['login'] = true;
        $_SESSION['user'] = $username;
        header("location:dashboard.php");
    } else {
        echo "<script>alert('Username atau Password salah!'); window.location='index.php';</script>";
    }
}
?>