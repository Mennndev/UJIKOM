// validasi form tambah/edit peminjaman
function validasiForm() {
    let valid = true;

    let namaPeminjam = document.getElementById("nama_peminjam").value.trim();
    let idBuku       = document.getElementById("id_buku").value;
    let tglPinjam    = document.getElementById("tgl_pinjam").value;
    let jumlah       = document.getElementById("jumlah").value.trim();

    // reset error
    document.getElementById("err_nama_peminjam").innerHTML = "";
    document.getElementById("err_id_buku").innerHTML = "";
    document.getElementById("err_tgl_pinjam").innerHTML = "";
    document.getElementById("err_jumlah").innerHTML = "";

    // validasi nama peminjam
    if (namaPeminjam === "") {
        document.getElementById("err_nama_peminjam").innerHTML = "Wajib diisi!";
        valid = false;
    } else if (namaPeminjam.length < 3) {
        document.getElementById("err_nama_peminjam").innerHTML = "Minimal 3 karakter!";
        valid = false;
    }

    // validasi buku
    if (idBuku === "") {
        document.getElementById("err_id_buku").innerHTML = "Pilih buku!";
        valid = false;
    }

    // validasi tanggal pinjam
    if (tglPinjam === "") {
        document.getElementById("err_tgl_pinjam").innerHTML = "Wajib diisi!";
        valid = false;
    }

    // validasi jumlah
    if (jumlah === "") {
        document.getElementById("err_jumlah").innerHTML = "Wajib diisi!";
        valid = false;
    } else if (/[^0-9]/.test(jumlah)) {
        document.getElementById("err_jumlah").innerHTML = "Harus angka!";
        valid = false;
    } else if (parseInt(jumlah) <= 0) {
        document.getElementById("err_jumlah").innerHTML = "Harus lebih dari 0!";
        valid = false;
    }

    return valid;
}