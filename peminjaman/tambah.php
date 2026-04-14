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

$errors = [];
$nama_peminjam = '';
$id_buku = '';
$tgl_pinjam = date('Y-m-d');
$jumlah = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_peminjam = trim($_POST['nama_peminjam'] ?? '');
    $id_buku       = trim($_POST['id_buku'] ?? ''); // VARCHAR(10)
    $tgl_pinjam    = $_POST['tgl_pinjam'] ?? '';
    $jumlah        = (int)($_POST['jumlah'] ?? 0);

    if ($nama_peminjam === '') $errors[] = "Nama peminjam wajib diisi.";
    if (strlen($nama_peminjam) < 3) $errors[] = "Nama peminjam minimal 3 karakter.";
    if ($id_buku === '') $errors[] = "Buku wajib dipilih.";
    if (!$tgl_pinjam) $errors[] = "Tanggal pinjam wajib diisi.";
    if ($jumlah <= 0) $errors[] = "Jumlah pinjam harus lebih dari 0.";

    if ($id_buku !== '' && $jumlah > 0) {
        $stmtStok = mysqli_prepare($conn, "SELECT stok FROM buku WHERE id_buku = ?");
        mysqli_stmt_bind_param($stmtStok, "s", $id_buku); // s (string)
        mysqli_stmt_execute($stmtStok);
        $resStok = mysqli_stmt_get_result($stmtStok);
        $rowStok = mysqli_fetch_assoc($resStok);
        mysqli_stmt_close($stmtStok);

        if (!$rowStok) {
            $errors[] = "Data buku tidak ditemukan.";
        } else {
            $stok = (int)$rowStok['stok'];
            if ($jumlah > $stok) $errors[] = "Jumlah pinjam melebihi stok. Stok tersedia: {$stok}.";
        }
    }

    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO peminjaman (nama_peminjam, id_buku, tgl_pinjam, jumlah) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssi", $nama_peminjam, $id_buku, $tgl_pinjam, $jumlah);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmtUpd = mysqli_prepare($conn, "UPDATE buku SET stok = stok - ? WHERE id_buku = ?");
            mysqli_stmt_bind_param($stmtUpd, "is", $jumlah, $id_buku); // is
            mysqli_stmt_execute($stmtUpd);
            mysqli_stmt_close($stmtUpd);

            mysqli_commit($conn);
            header("Location: /UJIKOM/peminjaman/index.php?msg=tambah_sukses");
            exit;
        } catch (Throwable $e) {
            mysqli_rollback($conn);
            $errors[] = "Gagal menyimpan data peminjaman.";
        }
    }
}

$bukuOptions = getBukuOptions();
?>

<div class="card">
    <div class="card-header bg-success text-white"><h3 class="card-title">Tambah Peminjaman</h3></div>
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
                            <?= htmlspecialchars($b['nama_buku']); ?> (Stok: <?= (int)$b['stok']; ?>)
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
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="<?= htmlspecialchars((string)$jumlah); ?>">
                <small id="err_jumlah" style="color:red"></small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/UJIKOM/peminjaman/index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script src="/UJIKOM/assets/js/validasi_peminjaman.js"></script>
<?php include '../template/footer.php'; ?>