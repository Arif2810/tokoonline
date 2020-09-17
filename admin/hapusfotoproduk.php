<?php

$id_foto = $_GET['idfoto'];
$id_produk = $_GET['idproduk'];

// Mengambil data
$ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk_foto='$id_foto'");
$detailfoto = $ambilfoto->fetch_assoc();

$namafilefoto = $detailfoto['nama_produk_foto'];
// Hapus namafilefoto
unlink("../foto_produk/" . $namafilefoto);

// echo "<pre>";
// print_r($namafilefoto);
// echo "</pre>";

// Menghapus data di database
$koneksi->query("DELETE FROM produk_foto WHERE id_produk_foto='$id_foto'");

echo "<script>alert('Foto produk berhasil dihapus');</script>";
echo "<script>location='index.php?halaman=detailproduk&id=$id_produk';</script>";


?>