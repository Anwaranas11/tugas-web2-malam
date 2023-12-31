<?php
// koneksi database
include 'koneksi.php';

//Memproses data saat form di submit
// kalau mau cek request nya, bisa pake 
// 1. $_SERVER['REQUEST_METHOD'] === 'POST'
// 2. isset($_POST['save']) tapi pastiin name dari button nya itu save juga
// namanya ga perlu save, bisa di sesuaikan aja misal edit, update, dll
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // menangkap data yang di kirim dari form
    $kode_barang = $_POST['kdbarang'];
    $nama_barang = $_POST['nmbarang'];
    $satuan = $_POST['satuan'];
    $kategori = $_POST['kategori'];
    $harga_modal = $_POST['hmodal'];
    $harga_jual = $_POST['hjual'];
    $namaFileBaru = ""; // nilai default nya string kosong

    // Kalua ada gambar baru yang di masukin, baru process gamabr nya
    if ($_FILES['gambar']['name']) {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $photo = $_FILES['gambar']['name'];
        $x = explode('.', $photo); // gambar.jpg => ["gambar", "jpg"];
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $namaFileBaru = 'img_' . $kode_barang . '.'  . $ekstensi; // kalau ternyata user nya masukin gambar baru, pake yang baru

        if (!in_array($ekstensi, $ekstensi_diperbolehkan)) {
            echo "<script>alert('EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN');window location='edit_barang.php?id=$kode_barang';</script>";
            return;
        }

        if ($ukuran > 1044070) {
            echo "<script>alert('UKURAN FILE TERLALU BESAR');window.location='tambahdata.php';</script>";
            return;
        }

        if (!move_uploaded_file($file_tmp, 'file/' . $namaFileBaru)) {
            echo "<script>alert('GAGAL MENGUPLOAD GAMBAR');window.location='index.php';</script>";
            return;
            // pake return, biar fungsi ekskusi  nya cumans sampe return ini aja 
        }
    }

    // tadi kurang koma di sebelum harga_modal=
    $query = "UPDATE tb_barang SET nama_barang='$nama_barang', satuan='$satuan', kategori='$kategori', harga_modal='$harga_modal',harga_jual='$harga_jual'";
    // makanya dsini di cek, kalau bukan string kosong ( berarti ada ) lakuin update buat gambar nya juga
    if ($namaFileBaru != "") $query .= ",gambar='$namaFileBaru'";
    $query .= "WHERE kode_barang='$kode_barang'";
    // print_r($query);
    // die;
    $update = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    if ($update) {
        echo "<script>alert('DATA BERHASIL DI UPDATE');window.location='index.php';</script>";
    } else {
        echo "<script>alert('DATA GAGAL DI UPDATE');window.location='index.php';</script>";
    }
}
