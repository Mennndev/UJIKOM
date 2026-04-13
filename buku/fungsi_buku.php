<?php
include '../koneksi.php';

function getDataBuku() {
    global $conn;
    $query = "SELECT buku.*, penerbit.nama_penerbit FROM buku 
              JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit";
    return mysqli_query($conn, $query);
}

function tambahBuku($id, $kat, $nama, $harga, $stok, $penerbit) {
    global $conn;
    $query = "INSERT INTO buku VALUES ('$id', '$kat', '$nama', '$harga', '$stok', '$penerbit')";
    return mysqli_query($conn, $query);
}

function editBuku($id, $kat, $nama, $harga, $stok, $penerbit) {
    global $conn;
    $query = "UPDATE buku SET kategori='$kat', nama_buku='$nama', harga='$harga', 
              stok='$stok', id_penerbit='$penerbit' WHERE id_buku='$id'";
    return mysqli_query($conn, $query);
}

function hapusBuku($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    
    // 1. Hapus dulu semua data di tabel peminjaman yang memakai id_buku ini
    mysqli_query($conn, "DELETE FROM peminjaman WHERE id_buku = '$id'");
    
    // 2. Baru hapus data di tabel buku
    return mysqli_query($conn, "DELETE FROM buku WHERE id_buku = '$id'");
}
?>