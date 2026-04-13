<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Toko Buku</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo $_SESSION['user']; ?></h1>
    <nav>
        <a href="buku/index.php">Data Buku</a> | 
        <a href="peminjaman/index.php">Peminjaman</a> | 
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>