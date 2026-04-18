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
$tgl_pinjam = date('Y-m-d');
$rows = [
    ['id_buku' => '', 'jumlah' => '']
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_peminjam = trim($_POST['nama_peminjam'] ?? '');
    $tgl_pinjam    = $_POST['tgl_pinjam'] ?? '';
    $id_buku_arr   = $_POST['id_buku'] ?? [];
    $jumlah_arr    = $_POST['jumlah'] ?? [];

    if ($nama_peminjam === '') $errors[] = "Nama peminjam wajib diisi.";
    if (strlen($nama_peminjam) < 3) $errors[] = "Nama peminjam minimal 3 karakter.";
    if (!$tgl_pinjam) $errors[] = "Tanggal pinjam wajib diisi.";

    if (!is_array($id_buku_arr)) $id_buku_arr = [$id_buku_arr];
    if (!is_array($jumlah_arr)) $jumlah_arr = [$jumlah_arr];

    $rows = [];
    $validRows = [];
    $kebutuhanPerBuku = [];
    $rowCount = max(count($id_buku_arr), count($jumlah_arr), 1);

    for ($i = 0; $i < $rowCount; $i++) {
        $id_buku = trim((string)($id_buku_arr[$i] ?? '')); // VARCHAR(10)
        $jumlahRaw = trim((string)($jumlah_arr[$i] ?? ''));

        $rows[] = ['id_buku' => $id_buku, 'jumlah' => $jumlahRaw];

        $rowError = false;
        if ($id_buku === '') {
            $errors[] = "Baris buku ke-" . ($i + 1) . ": Buku wajib dipilih.";
            $rowError = true;
        }

        if ($jumlahRaw === '') {
            $errors[] = "Baris buku ke-" . ($i + 1) . ": Jumlah wajib diisi.";
            $rowError = true;
        } elseif (!ctype_digit($jumlahRaw)) {
            $errors[] = "Baris buku ke-" . ($i + 1) . ": Jumlah harus angka.";
            $rowError = true;
        } elseif ((int)$jumlahRaw <= 0) {
            $errors[] = "Baris buku ke-" . ($i + 1) . ": Jumlah harus lebih dari 0.";
            $rowError = true;
        }

        if (!$rowError) {
            $jumlah = (int)$jumlahRaw;
            $validRows[] = ['id_buku' => $id_buku, 'jumlah' => $jumlah];
            if (!isset($kebutuhanPerBuku[$id_buku])) {
                $kebutuhanPerBuku[$id_buku] = 0;
            }
            $kebutuhanPerBuku[$id_buku] += $jumlah;
        }
    }

    if (empty($validRows)) {
        $errors[] = "Minimal satu buku dengan jumlah valid harus diisi.";
    }

    if (empty($errors) && !empty($kebutuhanPerBuku)) {
        $stmtStok = mysqli_prepare($conn, "SELECT stok FROM buku WHERE id_buku = ?");
        if (!$stmtStok) {
            $errors[] = "Gagal menyiapkan pengecekan stok.";
        } else {
            foreach ($kebutuhanPerBuku as $idBukuStok => $totalJumlah) {
                mysqli_stmt_bind_param($stmtStok, "s", $idBukuStok); // s (string)
                if (!mysqli_stmt_execute($stmtStok)) {
                    $errors[] = "Gagal mengecek stok buku.";
                    break;
                }

                $resStok = mysqli_stmt_get_result($stmtStok);
                $rowStok = mysqli_fetch_assoc($resStok);

                if (!$rowStok) {
                    $errors[] = "Data buku dengan ID {$idBukuStok} tidak ditemukan.";
                } else {
                    $stok = (int)$rowStok['stok'];
                    if ($totalJumlah > $stok) {
                        $errors[] = "Stok buku ID {$idBukuStok} tidak mencukupi. Dibutuhkan {$totalJumlah}, tersedia {$stok}.";
                    }
                }
            }

            mysqli_stmt_close($stmtStok);
        }
    }

    if (empty($errors)) {
        mysqli_begin_transaction($conn);
        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO peminjaman (nama_peminjam, id_buku, tgl_pinjam, jumlah) VALUES (?, ?, ?, ?)");
            if (!$stmt) throw new Exception("Gagal menyiapkan simpan peminjaman.");
            mysqli_stmt_bind_param($stmt, "sssi", $nama_peminjam, $id_buku_insert, $tgl_pinjam, $jumlah_insert);
            foreach ($validRows as $row) {
                $id_buku_insert = $row['id_buku'];
                $jumlah_insert = $row['jumlah'];
                if (!mysqli_stmt_execute($stmt)) throw new Exception("Gagal menyimpan detail peminjaman.");
            }
            mysqli_stmt_close($stmt);

            $stmtUpd = mysqli_prepare($conn, "UPDATE buku SET stok = stok - ? WHERE id_buku = ?");
            if (!$stmtUpd) throw new Exception("Gagal menyiapkan update stok.");
            mysqli_stmt_bind_param($stmtUpd, "is", $jumlah_kurang, $id_buku_kurang); // is
            foreach ($kebutuhanPerBuku as $id_buku_kurang => $jumlah_kurang) {
                if (!mysqli_stmt_execute($stmtUpd)) throw new Exception("Gagal mengurangi stok buku.");
            }
            mysqli_stmt_close($stmtUpd);

            mysqli_commit($conn);
            header("Location: /UJIKOM/peminjaman/index.php?msg=tambah_sukses");
            exit;
        } catch (Throwable $e) {
            mysqli_rollback($conn);
            $errors[] = "Gagal menyimpan data peminjaman. Silakan coba lagi.";
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
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" value="<?= htmlspecialchars($tgl_pinjam); ?>">
                <small id="err_tgl_pinjam" style="color:red"></small>
            </div>

            <div class="form-group">
                <label>Daftar Buku</label>
                <div id="bukuRowsContainer">
                    <?php foreach ($rows as $row): ?>
                        <div class="row align-items-end buku-row mb-2">
                            <div class="col-md-6">
                                <select name="id_buku[]" class="form-control">
                                    <option value="">-- Pilih Buku --</option>
                                    <?php foreach ($bukuOptions as $b): ?>
                                        <option value="<?= htmlspecialchars($b['id_buku']); ?>" <?= ($row['id_buku'] === $b['id_buku']) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($b['nama_buku']); ?> (Stok: <?= (int)$b['stok']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger err_id_buku_row"></small>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="jumlah[]" class="form-control" min="1" value="<?= htmlspecialchars((string)$row['jumlah']); ?>">
                                <small class="text-danger err_jumlah_row"></small>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm btn-remove-row">Hapus</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" id="btnTambahBuku" class="btn btn-success btn-sm mt-2">+ Tambah Buku</button>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/UJIKOM/peminjaman/index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<template id="bukuRowTemplate">
    <div class="row align-items-end buku-row mb-2">
        <div class="col-md-6">
            <select name="id_buku[]" class="form-control">
                <option value="">-- Pilih Buku --</option>
                <?php foreach ($bukuOptions as $b): ?>
                    <option value="<?= htmlspecialchars($b['id_buku']); ?>">
                        <?= htmlspecialchars($b['nama_buku']); ?> (Stok: <?= (int)$b['stok']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="text-danger err_id_buku_row"></small>
        </div>
        <div class="col-md-4">
            <input type="number" name="jumlah[]" class="form-control" min="1">
            <small class="text-danger err_jumlah_row"></small>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm btn-remove-row">Hapus</button>
        </div>
    </div>
</template>

<script>
(function () {
    const container = document.getElementById("bukuRowsContainer");
    const addBtn = document.getElementById("btnTambahBuku");
    const template = document.getElementById("bukuRowTemplate");
    if (!container || !addBtn || !template) return;

    const updateRemoveButtonState = () => {
        const rows = container.querySelectorAll(".buku-row");
        const disable = rows.length <= 1;
        rows.forEach((row) => {
            const btn = row.querySelector(".btn-remove-row");
            if (btn) btn.disabled = disable;
        });
    };

    const bindRemoveButton = (rowEl) => {
        const removeBtn = rowEl.querySelector(".btn-remove-row");
        if (!removeBtn) return;

        removeBtn.addEventListener("click", function () {
            if (container.querySelectorAll(".buku-row").length <= 1) return;
            rowEl.remove();
            updateRemoveButtonState();
        });
    };

    container.querySelectorAll(".buku-row").forEach(bindRemoveButton);
    updateRemoveButtonState();

    addBtn.addEventListener("click", function () {
        const newRow = template.content.firstElementChild.cloneNode(true);
        bindRemoveButton(newRow);
        container.appendChild(newRow);
        updateRemoveButtonState();
    });
})();
</script>

<script src="/UJIKOM/assets/js/validasi_pinjam.js"></script>
<?php include '../template/footer.php'; ?>
