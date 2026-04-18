<?php
include_once __DIR__ . '/../koneksi.php';

function getDataPenerbit()
{
    global $conn;
    $data = mysqli_query($conn, "SELECT * FROM penerbit ORDER BY nama ASC");
    $result = [];

    if ($data) {
        while ($row = mysqli_fetch_assoc($data)) {
            $result[] = $row;
        }
    }

    return $result;
}

function getPenerbitById($id)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM penerbit WHERE id_penerbit = ?");
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($res);
    mysqli_stmt_close($stmt);

    return $data ?: null;
}

function tambahPenerbit($data)
{
    global $conn;

    $id = trim($data['id_penerbit'] ?? '');
    $nama = trim($data['nama'] ?? '');
    $alamat = trim($data['alamat'] ?? '');
    $kota = trim($data['kota'] ?? '');
    $telepon = trim($data['telepon'] ?? '');

    $stmt = mysqli_prepare($conn, "INSERT INTO penerbit (id_penerbit, nama, alamat, kota, telepon) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $id, $nama, $alamat, $kota, $telepon);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function editPenerbit($data)
{
    global $conn;

    $id = trim($data['id_penerbit'] ?? '');
    $nama = trim($data['nama'] ?? '');
    $alamat = trim($data['alamat'] ?? '');
    $kota = trim($data['kota'] ?? '');
    $telepon = trim($data['telepon'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE penerbit SET nama = ?, alamat = ?, kota = ?, telepon = ? WHERE id_penerbit = ?");
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "sssss", $nama, $alamat, $kota, $telepon, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function hapusPenerbit($id)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "DELETE FROM penerbit WHERE id_penerbit = ?");
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}
?>
