<?php
include_once __DIR__ . '/../koneksi.php';

function getDataPeminjaman($tanggalDari = null, $tanggalSampai = null)
{
    global $conn;
    $sql = "SELECT p.id_peminjaman, p.nama_peminjam, p.id_buku, b.nama_buku, p.tgl_pinjam, p.jumlah
            FROM peminjaman p
            JOIN buku b ON p.id_buku = b.id_buku";

    if ($tanggalDari !== null && $tanggalSampai !== null) {
        $sql .= " WHERE p.tgl_pinjam >= ? AND p.tgl_pinjam <= ?";
    } elseif ($tanggalDari !== null) {
        $sql .= " WHERE p.tgl_pinjam >= ?";
    } elseif ($tanggalSampai !== null) {
        $sql .= " WHERE p.tgl_pinjam <= ?";
    }

    $sql .= " ORDER BY p.id_peminjaman DESC";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log('Gagal menyiapkan query getDataPeminjaman: ' . mysqli_error($conn));
        return [];
    }

    if ($tanggalDari !== null && $tanggalSampai !== null) {
        mysqli_stmt_bind_param($stmt, "ss", $tanggalDari, $tanggalSampai);
    } elseif ($tanggalDari !== null) {
        mysqli_stmt_bind_param($stmt, "s", $tanggalDari);
    } elseif ($tanggalSampai !== null) {
        mysqli_stmt_bind_param($stmt, "s", $tanggalSampai);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    $rows = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }
    }
    mysqli_stmt_close($stmt);

    return $rows;
}

function getBukuOptions()
{
    global $conn;
    $sql = "SELECT id_buku, nama_buku, stok FROM buku ORDER BY nama_buku ASC";
    $res = mysqli_query($conn, $sql);

    $rows = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }
    }
    return $rows;
}

function getPeminjamanById($id)
{
    global $conn;
    $id = (int)$id;

    $stmt = mysqli_prepare($conn, "SELECT * FROM peminjaman WHERE id_peminjaman = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    return $data;
}
