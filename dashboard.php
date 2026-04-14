<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location:index.php");
}

include 'koneksi.php';

// hitung buku
$buku = mysqli_query($conn, "SELECT * FROM buku");
$total_buku = mysqli_num_rows($buku);

// hitung penerbit
$penerbit = mysqli_query($conn, "SELECT * FROM penerbit");
$total_penerbit = mysqli_num_rows($penerbit);
?>

<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>

<h2>Dashboard</h2>

<div class="row">

    <!-- JUMLAH BUKU -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $total_buku; ?></h3>
                <p>Data Buku</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="buku/index.php" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- JUMLAH PENERBIT -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $total_penerbit; ?></h3>
                <p>Data Penerbit</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="penerbit/index.php" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>

<?php include 'template/footer.php'; ?>