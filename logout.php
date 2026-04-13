<?php
// Memulai session agar bisa menghapusnya
session_start();

// Menghapus semua variabel session
session_unset();

// Menghancurkan session yang sedang berjalan
session_destroy();

// Menampilkan pesan sukses dan mengarahkan kembali ke halaman login
echo "<script>
        alert('Anda telah berhasil logout.');
        window.location='index.php';
      </script>";
exit;
?>