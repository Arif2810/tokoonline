<?php
session_start();

// menampilkan id_produk dari url
$id_produk = $_GET['id'];

// var_dump($id_produk);
// die;

// jika sudah ada produk di keranjang, maka produk itu jumlahnya +1
if(isset($_SESSION['keranjang'][$id_produk])){
  $_SESSION['keranjang'][$id_produk] += 1;
}
// selain itu (belum ada di keranjang), maka produk itu dianggap dibeli 1
else{
  $_SESSION['keranjang'][$id_produk] = 1;
}

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// Dialihkan ke halaman keranjang
echo "<script>alert('Produk telah masuk ke keranjang belanja');</script>";
echo "<script>location='keranjang.php';</script>";