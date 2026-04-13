function validasiPinjam() {
    let nama = document.forms["formPinjam"]["nama_peminjam"].value;
    let buku = document.forms["formPinjam"]["id_buku"].value;
    let tgl  = document.forms["formPinjam"]["tgl_pinjam"].value;
    let jml  = document.forms["formPinjam"]["jumlah"].value;

    if (nama.trim() == "") {
        alert("Nama peminjam tidak boleh kosong!");
        return false;
    }
    if (buku == "") {
        alert("Silakan pilih buku yang akan dipinjam!");
        return false;
    }
    if (tgl == "") {
        alert("Tanggal pinjam harus diisi!");
        return false;
    }
    if (jml == "" || parseInt(jml) <= 0) {
        alert("Jumlah pinjam minimal 1!");
        return false;
    }
    return true;
}