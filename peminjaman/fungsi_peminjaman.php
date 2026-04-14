<?php
include_once __DIR__ . '/../koneksi.php';

function getDataPeminjaman()
{
    global $conn;
    $sql = "SELECT p.id_peminjaman, p.nama_peminjam, p.id_buku, b.nama_buku, p.tgl_pinjam, p.jumlah
            FROM peminjaman p
            JOIN buku b ON p.id_buku = b.id_buku
            ORDER BY p.id_peminjaman DESC";
    $res = mysqli_query($conn, $sql);

    $rows = [];
    if ($res) {
        while ($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }
    }
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