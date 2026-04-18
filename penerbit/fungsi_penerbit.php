<?php
include_once __DIR__ . '/../koneksi.php';

function getDataPenerbit()
{
    global $conn;

    $result = mysqli_query($conn, "SELECT id_penerbit, nama FROM penerbit ORDER BY nama ASC");
    if (!$result) {
        return [];
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function getPenerbitById($id)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT id_penerbit, nama FROM penerbit WHERE id_penerbit = ?");
    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    return $row ?: null;
}

function tambahPenerbit($idPenerbit, $nama, &$error = null)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "INSERT INTO penerbit (id_penerbit, nama) VALUES (?, ?)");
    if (!$stmt) {
        $error = 'Gagal menyiapkan query simpan penerbit.';
        return false;
    }
    mysqli_stmt_bind_param($stmt, "ss", $idPenerbit, $nama);

    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) {
        $error = 'Gagal menambah data penerbit.';
    }
    mysqli_stmt_close($stmt);

    return $ok;
}

function updatePenerbit($idPenerbit, $nama, &$error = null)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "UPDATE penerbit SET nama = ? WHERE id_penerbit = ?");
    if (!$stmt) {
        $error = 'Gagal menyiapkan query update penerbit.';
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ss", $nama, $idPenerbit);
    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) {
        $error = 'Gagal memperbarui data penerbit.';
    }
    mysqli_stmt_close($stmt);

    return $ok;
}

function hapusPenerbit($idPenerbit, &$error = null)
{
    global $conn;

    $stmt = mysqli_prepare($conn, "DELETE FROM penerbit WHERE id_penerbit = ?");
    if (!$stmt) {
        $error = 'Gagal menyiapkan query hapus penerbit.';
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $idPenerbit);
    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) {
        $error = 'Gagal menghapus data penerbit. Pastikan penerbit tidak sedang dipakai data buku.';
    }
    mysqli_stmt_close($stmt);

    return $ok;
}
?>
