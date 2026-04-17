<?php
include '../koneksi.php';

function getDataBuku() {
    global $conn;

    $data = mysqli_query($conn, "SELECT buku.*, penerbit.nama AS nama_penerbit 
    FROM buku
    JOIN penerbit ON buku.id_penerbit = penerbit.id_penerbit");
    $result = [];

    while ($row = mysqli_fetch_assoc($data)) {
        $result[] = $row;
    }
    return $result;
}

function tambahBuku($data) {
    global $conn;

    $id = $data['id_buku'];
    $kategori = $data['kategori'];
    $nama = $data['nama_buku'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $penerbit = $data['id_penerbit'];
    
    $query = "INSERT INTO buku 
    VALUES ('$id', '$kategori', '$nama', '$harga', '$stok', '$penerbit')";
    
    return mysqli_query($conn, $query);
}

function editBuku($data) {
    global $conn;

    $id = $data['id_buku'];
    $kategori = $data['kategori'];
    $nama = $data['nama_buku'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $penerbit = $data['id_penerbit'];

    $query = "UPDATE buku SET
    kategori = '$kategori',
    nama_buku = '$nama',
    harga = '$harga',
    stok = '$stok',
    id_penerbit = '$penerbit'
    WHERE id_buku = '$id'";

    return mysqli_query($conn, $query);
}

function hapusBuku($id) {
    global $conn;
    $query = "DELETE FROM buku WHERE id_buku = '$id'";
    return mysqli_query($conn, $query);
}
?>