<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: /UJIKOM/index.php");
    exit;
}

include '../koneksi.php';
include '../template/header.php';
include '../template/sidebar.php';
include 'fungsi_peminjaman.php';

$id = (int)($_GET['id'] ?? 0);
$dataLama = getPeminjamanById($id);

if (!$dataLama) {
    echo "<div class='alert alert-danger'>Data peminjaman tidak ditemukan.</div>";
    include '../template/footer.php';
    exit;
}

$errors = [];
$nama_peminjam = $dataLama['nama_peminjam'];
$id_buku       = $dataLama['id_buku']; // string
$tgl_pinjam    = $dataLama['tgl_pinjam'];
$jumlah        = (int)$dataLama['jumlah'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_peminjam = trim($_POST['nama_peminjam'] ?? '');
    $id_buku_baru  = trim($_POST['id_buku'] ?? ''); // VARCHAR(10)
    $tgl_pinjam    = $_POST['tgl_pinjam'] ?? '';
    $jumlah_baru   = (int)($_POST['jumlah'] ?? 0);

    if ($nama_peminjam === '') $errors[] = "Nama peminjam wajib diisi.";
    if (strlen($nama_peminjam) < 3) $errors[] = "Nama peminjam minimal 3 karakter.";
    if ($id_buku_baru === '') $errors[] = "Buku wajib dipilih.";
    if (!$tgl_pinjam) $errors[] = "Tanggal pinjam wajib diisi.";
    if ($jumlah_baru <= 0) $errors[] = "Jumlah pinjam harus lebih dari 0.";

    if (empty($errors)) {
        if ($id_buku_baru === $dataLama['id_buku']) {
            $selisih = $jumlah_baru - (int)$dataLama['jumlah'];
            if ($selisih > 0) {
                $stmt = mysqli_prepare($conn, "SELECT stok FROM buku WHERE id_buku = ?");
                mysqli_stmt_bind_param($stmt, "s", $id_buku_baru);
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($res);
                mysqli_stmt_close($stmt);

                if (!$row || $selisih > (int)$row['stok']) $errors[] = "Stok tidak cukup untuk perubahan jumlah.";
            }
        } else {
            $stmt = mysqli_prepare($conn, "SELECT stok FROM buku WHERE id_buku = ?");
            mysqli_stmt_bind_param($stmt, "s", $id_buku_baru);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($res);
            mysqli_stmt_close($stmt);

            if (!$row || $jumlah_baru > (int)$row['stok']) $errors[] = "Stok buku baru tidak mencukupi.";
        }
    }

    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        try {
            $id_buku_lama = $dataLama['id_buku']; // string
            $jumlah_lama  = (int)$dataLama['jumlah'];

            $stmtBack = mysqli_prepare($conn, "UPDATE buku SET stok = stok + ? WHERE id_buku = ?");
            mysqli_stmt_bind_param($stmtBack, "is", $jumlah_lama, $id_buku_lama);
            mysqli_stmt_execute($stmtBack);
            mysqli_stmt_close($stmtBack);

            $stmtUpdPinjam = mysqli_prepare($conn, "UPDATE peminjaman SET nama_peminjam=?, id_buku=?, tgl_pinjam=?, jumlah=? WHERE id_peminjaman=?");
            mysqli_stmt_bind_param($stmtUpdPinjam, "sssii", $nama_peminjam, $id_buku_baru, $tgl_pinjam, $jumlah_baru, $id);
            mysqli_stmt_execute($stmtUpdPinjam);
            mysqli_stmt_close($stmtUpdPinjam);

            $stmtMin = mysqli_prepare($conn, "UPDATE buku SET stok = stok - ? WHERE id_buku = ?");
            mysqli_stmt_bind_param($stmtMin, "is", $jumlah_baru, $id_buku_baru);
            mysqli_stmt_execute($stmtMin);
            mysqli_stmt_close($stmtMin);

            mysqli_commit($conn);
            header("Location: /UJIKOM/peminjaman/index.php?msg=edit_sukses");
            exit;
        } catch (Throwable $e) {
            mysqli_rollback($conn);
            $errors[] = "Gagal memperbarui data peminjaman.";
        }
    }

    $id_buku = $id_buku_baru;
    $jumlah = $jumlah_baru;
}

$bukuOptions = getBukuOptions();
?>

<div class="card">
    <div class="card-header bg-warning"><h3 class="card-title">Edit Peminjaman</h3></div>
    <div class="card-body">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger"><ul class="mb-0"><?php foreach ($errors as $err): ?><li><?= htmlspecialchars($err); ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validasiForm();">
            <div class="form-group">
                <label>Nama Peminjam</label>
                <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" value="<?= htmlspecialchars($nama_peminjam); ?>">
                <small id="err_nama_peminjam" style="color:red"></small>
            </div>

            <div class="form-group">
                <label>Buku</label>
                <select name="id_buku" id="id_buku" class="form-control">
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($bukuOptions as $b): ?>
                        <option value="<?= htmlspecialchars($b['id_buku']); ?>" <?= ($id_buku === $b['id_buku']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($b['nama_buku']); ?> (Stok saat ini: <?= (int)$b['stok']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small id="err_id_buku" style="color:red"></small>
            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" value="<?= htmlspecialchars($tgl_pinjam); ?>">
                <small id="err_tgl_pinjam" style="color:red"></small>
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="<?= (int)$jumlah; ?>">
                <small id="err_jumlah" style="color:red"></small>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/UJIKOM/peminjaman/index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script src="/UJIKOM/assets/js/validasi_peminjaman.js"></script>
<?php include '../template/footer.php'; ?>