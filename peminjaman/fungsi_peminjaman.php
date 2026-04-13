<?php
include '../koneksi.php';

function getDataPeminjaman() {
    global $conn;
    $query = "SELECT peminjaman.*, buku.nama_buku FROM peminjaman 
              JOIN buku ON peminjaman.id_buku = buku.id_buku";
    return mysqli_query($conn, $query);
}

function tambahPeminjaman($nama, $id_buku, $tgl, $jml) {
    global $conn;
    // Sanitasi data
    $nama = mysqli_real_escape_string($conn, $nama);
    $query = "INSERT INTO peminjaman (nama_peminjam, id_buku, tgl_pinjam, jumlah) 
              VALUES ('$nama', '$id_buku', '$tgl', '$jml')";
    return mysqli_query($conn, $query);
}
?>