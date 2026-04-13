/**
 * validasi.js
 * Fungsi untuk memvalidasi input form buku secara client-side
 */

function validasiBuku() {
    // Mengambil nilai dari input berdasarkan atribut 'name'
    let idBuku   = document.forms["formBuku"]["id_buku"].value;
    let namaBuku = document.forms["formBuku"]["nama_buku"].value;
    let kategori = document.forms["formBuku"]["kategori"].value;
    let harga    = document.forms["formBuku"]["harga"].value;
    let stok     = document.forms["formBuku"]["stok"].value;
    let penerbit = document.forms["formBuku"]["id_penerbit"].value;

    // 1. Validasi tidak boleh kosong (Trim untuk menghapus spasi kosong)
    if (idBuku.trim() == "" || namaBuku.trim() == "" || kategori.trim() == "") {
        alert("Semua kolom teks harus diisi!");
        return false;
    }

    // 2. Validasi Harga (harus angka positif dan minimal 1000 misalnya)
    if (harga == "" || parseInt(harga) < 1000) {
        alert("Harga tidak valid! Minimal Rp 1.000");
        return false;
    }

    // 3. Validasi Stok (tidak boleh negatif)
    if (stok == "" || parseInt(stok) < 0) {
        alert("Stok tidak boleh kosong atau negatif!");
        return false;
    }

    // 4. Validasi Dropdown Penerbit
    if (penerbit == "") {
        alert("Silakan pilih penerbit terlebih dahulu!");
        return false;
    }

    // Jika semua lolos, form akan dikirim
    return confirm("Apakah data yang Anda masukkan sudah benar?");
}