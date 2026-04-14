//validasi form tambah buku
function validasiForm(){
    let valid = true;
    
    let id = document.getElementById("id_buku").value;
    let kategori = document.getElementById("kategori").value;
    let nama = document.getElementById("nama_buku").value;
    let harga = document.getElementById("harga").value;
    let stok = document.getElementById("stok").value;
    let penerbit = document.getElementById("id_penerbit").value;
    
    // reset error
    document.getElementById("err_id").innerHTML = "";
    document.getElementById("err_kategori").innerHTML = "";
    document.getElementById("err_nama").innerHTML = "";
    document.getElementById("err_harga").innerHTML = "";
    document.getElementById("err_stok").innerHTML = "";
    document.getElementById("err_penerbit").innerHTML = "";
    
    // validasi id
    if(id === ""){
        document.getElementById("err_id").innerHTML = "Wajib diisi!";
        valid = false;
    }
    
    // validasi kategori
    if(kategori === ""){
        document.getElementById("err_kategori").innerHTML = "Wajib diisi!";
        valid = false;
    }
    
    // validasi nama
    if(nama === ""){
        document.getElementById("err_nama").innerHTML = "Wajib diisi!";
        valid = false;
    }
    
    // validasi harga
    if(harga === ""){
        document.getElementById("err_harga").innerHTML = "Wajib diisi!";
        valid = false;
    }else if(/[^0-9]/.test(harga)){
        document.getElementById("err_harga").innerHTML = "Harus angka!";
        valid = false;
    }
    
    // validasi stok
    if(stok === ""){
        document.getElementById("err_stok").innerHTML = "Wajib diisi!";
        valid = false;
    }else if(/[^0-9]/.test(stok)){
        document.getElementById("err_stok").innerHTML = "Harus angka!";
        valid = false;
    }
    
    // validasi penerbit
    if(penerbit === ""){
        document.getElementById("err_penerbit").innerHTML = "Pilih penerbit!";
        valid = false;
    }
    
    return valid;
}