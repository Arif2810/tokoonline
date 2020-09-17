<?php
$id_produk = $_GET['id'];

$ambil = $koneksi->query("SELECT * FROM produk LEFT JOIN kategori ON produk.id_kategori=kategori.id_kategori WHERE id_produk='$id_produk'");
$detailproduk = $ambil->fetch_assoc();

$fotoproduk = array();
$ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk='$id_produk'");
while($tiap = $ambilfoto->fetch_assoc()){
  $fotoproduk[] = $tiap;
}

// echo "<pre>";
// print_r($detailproduk);
// print_r($fotoproduk);
// echo "</pre>";

?>


<table class="table">
  <tr>
    <th>Produk</th>
    <td><?= $detailproduk['nama_produk']; ?></td>
  </tr>
  <tr>
    <th>Kategori</th>
    <td><?= $detailproduk['nama_kategori']; ?></td>
  </tr>
  <tr>
    <th>Harga</th>
    <td>Rp. <?= number_format($detailproduk['harga_produk']) ?>,-</td>
  </tr>
  <tr>
    <th>Berat</th>
    <td><?= $detailproduk['berat_produk']; ?></td>
  </tr>
  <tr>
    <th>Deskripsi</th>
    <td><?= $detailproduk['deskripsi_produk']; ?></td>
  </tr>
  <tr>
    <th>Stok</th>
    <td><?= $detailproduk['stok_produk']; ?></td>
  </tr>
</table>

<div class="row">
  <?php foreach($fotoproduk as $key => $value): ?>
  <div class="col-md-4 text-center">
    <img src="../foto_produk/<?= $value['nama_produk_foto']; ?>" alt="" class="img-responsive"><br>
    <a href="index.php?halaman=hapusfotoproduk&idfoto=<?= $value['id_produk_foto']; ?>&idproduk=<?= $id_produk; ?>" class="btn btn-danger btn-sm">hapus</a>
  </div>
  <?php endforeach; ?>
</div><br>

<div class="row">
  <div class="col-md-4">
    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="">File Foto</label>
        <input type="file" name="produk_foto" class="form-control" required>
      </div>
      <button class="btn btn-primary" name="simpan" value="simpan">Simpan</button>
    </form>
  </div>
</div>

<?php
if(isset($_POST['simpan'])){
  $lokasifoto = $_FILES['produk_foto']['tmp_name'];
  $namafoto = $_FILES['produk_foto']['name'];
  $namafoto = date('YmdHis') . $namafoto;

  // Upload ke folder foto_produk
  move_uploaded_file($lokasifoto, '../foto_produk/' . $namafoto);

  // Memasukkan nama foto ke tabel produk_foto
  $koneksi->query("INSERT INTO produk_foto(id_produk, nama_produk_foto) VALUES('$id_produk', '$namafoto')");

  echo "<script>alert('Foto produk berhasil ditambahkan');</script>";
  echo "<script>location='index.php?halaman=detailproduk&id=$id_produk';</script>";
}

?>