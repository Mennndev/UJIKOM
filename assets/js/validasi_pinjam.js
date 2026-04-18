// validasi form tambah/edit peminjaman
function validasiForm() {
    let valid = true;

    let namaEl = document.getElementById("nama_peminjam");
    let tglEl = document.getElementById("tgl_pinjam");
    let namaPeminjam = namaEl ? namaEl.value.trim() : "";
    let tglPinjam = tglEl ? tglEl.value : "";
    let rowsContainer = document.getElementById("bukuRowsContainer");

    // reset error
    let errNama = document.getElementById("err_nama_peminjam");
    let errIdBuku = document.getElementById("err_id_buku");
    let errTgl = document.getElementById("err_tgl_pinjam");
    let errJumlah = document.getElementById("err_jumlah");
    let errRows = document.getElementById("err_rows");

    if (errNama) errNama.innerHTML = "";
    if (errIdBuku) errIdBuku.innerHTML = "";
    if (errTgl) errTgl.innerHTML = "";
    if (errJumlah) errJumlah.innerHTML = "";
    if (errRows) errRows.innerHTML = "";

    if (rowsContainer) {
        rowsContainer.querySelectorAll(".err_id_buku_row").forEach(function (el) { el.innerHTML = ""; });
        rowsContainer.querySelectorAll(".err_jumlah_row").forEach(function (el) { el.innerHTML = ""; });
    }

    // validasi nama peminjam
    if (namaPeminjam === "") {
        if (errNama) errNama.innerHTML = "Wajib diisi!";
        valid = false;
    } else if (namaPeminjam.length < 3) {
        if (errNama) errNama.innerHTML = "Minimal 3 karakter!";
        valid = false;
    }

    // validasi tanggal pinjam
    if (tglPinjam === "") {
        if (errTgl) errTgl.innerHTML = "Wajib diisi!";
        valid = false;
    }

    // validasi buku + jumlah
    if (rowsContainer) {
        let rows = rowsContainer.querySelectorAll(".buku-row");
        if (rows.length === 0) {
            if (errRows) errRows.innerHTML = "Minimal satu baris buku wajib ada!";
            valid = false;
        }

        rows.forEach(function (row) {
            let idBukuEl = row.querySelector("select[name='id_buku[]']");
            let jumlahEl = row.querySelector("input[name='jumlah[]']");
            let errRowBuku = row.querySelector(".err_id_buku_row");
            let errRowJumlah = row.querySelector(".err_jumlah_row");

            let idBuku = idBukuEl ? idBukuEl.value : "";
            let jumlah = jumlahEl ? jumlahEl.value.trim() : "";

            if (idBuku === "") {
                if (errRowBuku) errRowBuku.innerHTML = "Pilih buku!";
                valid = false;
            }

            if (jumlah === "") {
                if (errRowJumlah) errRowJumlah.innerHTML = "Wajib diisi!";
                valid = false;
            } else if (/[^0-9]/.test(jumlah)) {
                if (errRowJumlah) errRowJumlah.innerHTML = "Harus angka!";
                valid = false;
            } else if (parseInt(jumlah) <= 0) {
                if (errRowJumlah) errRowJumlah.innerHTML = "Harus lebih dari 0!";
                valid = false;
            }
        });
    } else {
        let idBukuEl = document.getElementById("id_buku");
        let jumlahEl = document.getElementById("jumlah");
        let idBuku = idBukuEl ? idBukuEl.value : "";
        let jumlah = jumlahEl ? jumlahEl.value.trim() : "";

        if (idBuku === "") {
            if (errIdBuku) errIdBuku.innerHTML = "Pilih buku!";
            valid = false;
        }

        if (jumlah === "") {
            if (errJumlah) errJumlah.innerHTML = "Wajib diisi!";
            valid = false;
        } else if (/[^0-9]/.test(jumlah)) {
            if (errJumlah) errJumlah.innerHTML = "Harus angka!";
            valid = false;
        } else if (parseInt(jumlah) <= 0) {
            if (errJumlah) errJumlah.innerHTML = "Harus lebih dari 0!";
            valid = false;
        }
    }

    return valid;
}
