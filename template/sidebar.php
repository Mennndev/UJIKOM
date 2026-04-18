<?php
$base_url = '/UJIKOM';
$displayName = trim($_SESSION['nama'] ?? $_SESSION['user'] ?? '');
$displayRole = trim($_SESSION['role'] ?? '');

if ($displayName === '') {
    $displayName = 'User';
}
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <span class="navbar-brand">📚 Toko Buku</span>
</nav>

<!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-light d-block"><?= htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8') ?></span>
        <?php if ($displayRole !== ''): ?>
            <small class="d-block text-white-50"><?= htmlspecialchars($displayRole, ENT_QUOTES, 'UTF-8') ?></small>
        <?php endif; ?>
    </a>

    <div class="sidebar">
        <nav>
            <ul class="nav nav-pills nav-sidebar flex-column">

                <li class="nav-item">
                    <a href="<?= $base_url ?>/dashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $base_url ?>/buku/index.php" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Data Buku</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $base_url ?>/peminjaman/index.php" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Peminjaman</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="<?= $base_url ?>/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<div class="content-wrapper p-4">
