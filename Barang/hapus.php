<?php
if (isset($_GET['id'])) {
    include('koneksi.php');
    $kode_barang = $_GET['id'];
    $del = mysqli_query($koneksi, "DELETE FROM tb_barang WHERE kode_barang='$kode_barang'");
    if ($del) {
        echo 'Data barang berhasil dihapus! ';
        echo '<a href="index.php">Kembali</a>';
    } else {
        echo 'Gagal menghapus data! ';
        echo '<a href="index.php">Kembali</a>';
    }
}
