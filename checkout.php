<?php
session_start();
//koneksi ke database
include 'koneksi.php';

// Jika tidak ada session pelanggan (belum login)
if(!isset($_SESSION["pelanggan"])){
  // Diarahkan ke ke login.php
  echo "<script>alert('Silahkan login!')</script>";
  echo "<script>location='login.php';</script>";
}

if(!isset($_SESSION["keranjang"])){
  // Diarahkan ke ke index.php
  echo "<script>alert('Keranjang kosong!')</script>";
  echo "<script>location='index.php';</script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
  <script src="admin/assets/js/jquery.min.js"></script>
</head>
<body style="min-height: 1000px;">

<?php include 'templates/navbar.php'; ?>

<!-- <pre> -->
  <?php // print_r($_SESSION['pelanggan']); ?>
<!-- </pre> -->
<!-- <pre> -->
  <?php // print_r($_SESSION['keranjang']); ?>
<!-- </pre> -->

<section class="content">
  <div class="container">
    <h1>Halaman Checkout</h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subharga</th>
        </tr>
      </thead>
      <tbody>
				<?php $no=1; ?>
				<?php $totalberat = 0; ?>
				<?php $totalbelanja = 0; ?>
        <?php foreach($_SESSION['keranjang'] as $id_produk => $jumlah): ?>
        <!-- Menampilkan produk yang sedang duperulangkan berdasarkan id_produk -->
        <?php
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
        $pecah = $ambil->fetch_assoc();
        $subharga = $pecah['harga_produk'] * $jumlah;
        // Subberat diperoleh dari berat produk x jumlah
        $subberat = $pecah['berat_produk'] * $jumlah;
        $totalberat+=$subberat;

        // echo "<pre>";
        // print_r($pecah);
        // echo "</pre>";
        ?>
        <tr>
					<td><?= $no++; ?></td>
          <td><?= $pecah['nama_produk']; ?></td>
          <td>Rp. <?= number_format($pecah['harga_produk']); ?>,-</td>
          <td><?= $jumlah; ?></td>
          <td>Rp. <?= number_format($subharga); ?>,-</td>
				</tr>
				<?php $totalbelanja += $subharga; ?>
        <?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4">Total Belanja</th>
					<th>Rp. <?= number_format($totalbelanja); ?>,-</th>
				</tr>
			</tfoot>
    </table>
    
    <form action="" method="post">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly value="<?= $_SESSION['pelanggan']['nama_pelanggan']; ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly value="<?= $_SESSION['pelanggan']['telepon_pelanggan']; ?>" class="form-control">
					</div>
				</div>
      </div>
      <div class="form-group">
        <label for="">Alamat Lengkap Pengiriman</label>
        <textarea name="alamat_pengiriman" cols="30" rows="3" class="form-control" placeholder="Masukkan alamat lengkap pengiriman (termasuk kode pos)"></textarea>
      </div>

      <!-- source code dari rajaongkir -->
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Provinsi</label>
            <select name="nama_provinsi" id="" class="form-control">
              <!-- Menggunakan javascript -->
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Distrik</label>
            <select name="nama_distrik" id="" class="form-control">

            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Ekspedisi</label>
            <select name="nama_ekspedisi" id="" class="form-control">
              
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Paket</label>
            <select name="nama_paket" id="" class="form-control">
              
            </select>
          </div>
        </div>
      </div>

      <input type="text" name="total_berat" value="<?= $totalberat; ?>">
      <input type="text" name="provinsi">
      <input type="text" name="distrik">
      <input type="text" name="tipe">
      <input type="text" name="kodepos">
      <input type="text" name="ekspedisi">
      <input type="text" name="paket">
      <input type="text" name="ongkir">
      <input type="text" name="estimasi">
  
      <div class="form-group" style="margin-top: 10px;">
        <button class="btn btn-primary" name="checkout">Checkout</button>
      </div>
    </form>

    <?php
    if(isset($_POST["checkout"])){
      $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
      $tanggal_pembelian = date('Y-m-d');
      $alamat_pengiriman = $_POST['alamat_pengiriman'];
    
      $totalberat = $_POST['total_berat'];
      $provinsi = $_POST['provinsi'];
      $distrik = $_POST['distrik'];
      $tipe = $_POST['tipe'];
      $kodepos = $_POST['kodepos'];
      $ekspedisi = $_POST['ekspedisi'];
      $paket = $_POST['paket'];
      $ongkir = $_POST['ongkir'];
      $estimasi = $_POST['estimasi'];
    
      $total_pembelian = $totalbelanja + $ongkir;
    
      // Menyimpan data ke tabel pembelian
      $koneksi->query("INSERT INTO pembelian(id_pelanggan, tanggal_pembelian, total_pembelian, alamat_pengiriman, totalberat, provinsi, distrik, tipe, kodepos, ekspedisi, paket, ongkir, estimasi) VALUES('$id_pelanggan', '$tanggal_pembelian', '$total_pembelian', '$alamat_pengiriman', '$totalberat', '$provinsi', '$distrik', '$tipe', '$kodepos', '$ekspedisi', '$paket', '$ongkir', '$estimasi')");

      // Mendapatkan id_pembelian yang baru terjadi
      $id_pemebelian_barusan = $koneksi->insert_id;

      foreach($_SESSION["keranjang"] as $id_produk => $jumlah){

        // Mendapatkan data produk berdasarkan id_produk
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
        $perproduk = $ambil->fetch_assoc();
        
        $nama = $perproduk['nama_produk'];
        $harga = $perproduk['harga_produk'];
        $berat = $perproduk['berat_produk'];
        $subberat = $perproduk['berat_produk']*$jumlah;
        $subharga = $perproduk['harga_produk']*$jumlah;

        $koneksi->query("INSERT INTO pembelian_produk(id_pembelian, id_produk, nama, harga, berat, subberat, subharga, jumlah) VALUES('$id_pemebelian_barusan', '$id_produk', '$nama', '$harga', '$berat', '$subberat', '$subharga', '$jumlah')");

        // Update stok
        $koneksi->query("UPDATE produk SET stok_produk=stok_produk - $jumlah WHERE id_produk='$id_produk'");
      }

      // Mengosongkan keranjang belanja
      unset($_SESSION["keranjang"]);

      // Tampilan dialihkan ke halaman nota dari pembelian barusan
      echo "<script>alert('Pembelian sukses');</script>";
      echo "<script>location='nota.php?id=$id_pemebelian_barusan';</script>";
    }
    
    ?>

  </div>
</section>

<script>
    $(document).ready(function(){
      $.ajax({
        type: 'post',
        url: 'dataprovinsi.php',
        success: function(hasil_provinsi){
          $("select[name=nama_provinsi]").html(hasil_provinsi);
        }
      });

      $("select[name=nama_provinsi]").on("change", function(){
        // Ambil id_provinsi ynag dipilih (dari atribut pribadi)
        var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
        $.ajax({
          type: 'post',
          url: 'datadistrik.php',
          data: 'id_provinsi='+id_provinsi_terpilih,
          success:function(hasil_distrik){
            $("select[name=nama_distrik]").html(hasil_distrik);
          }
        })
      });

      $.ajax({
        type: 'post',
        url: 'jasaekspedisi.php',
        success: function(hasil_ekspedisi){
          $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
        }
      });

      $("select[name=nama_ekspedisi]").on("change", function(){
        // Mendapatkan data ongkos kirim

        // Mendapatkan ekspedisi yang dipilih
        var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();
        // Mendapatkan id_distrik yang dipilih
        var distrik_terpilih = $("option:selected", "select[name=nama_distrik]").attr("id_distrik");
        // Mendapatkan toatal berat dari inputan
        $total_berat = $("input[name=total_berat]").val();
        $.ajax({
          type: 'post',
          url: 'datapaket.php',
          data: 'ekspedisi='+ekspedisi_terpilih+'&distrik='+distrik_terpilih+'&berat='+$total_berat,
          success: function(hasil_paket){
            // console.log(hasil_paket);
            $("select[name=nama_paket]").html(hasil_paket);

            // Meletakkan nama ekspedisi terpilih di input ekspedisi
            $("input[name=ekspedisi]").val(ekspedisi_terpilih);
          }
        })
      });

      $("select[name=nama_distrik]").on("change", function(){
        var prov = $("option:selected", this).attr('nama_provinsi');
        var dist = $("option:selected", this).attr('nama_distrik');
        var tipe = $("option:selected", this).attr('tipe_distrik');
        var kodepos = $("option:selected", this).attr('kodepos');
        
        $("input[name=provinsi]").val(prov);
        $("input[name=distrik]").val(dist);
        $("input[name=tipe]").val(tipe);
        $("input[name=kodepos]").val(kodepos);
      });

      $("select[name=nama_paket]").on("change", function(){
        var paket = $("option:selected", this).attr("paket");
        var ongkir = $("option:selected", this).attr("ongkir");
        var etd = $("option:selected", this).attr("etd");

        $("input[name=paket]").val(paket);
        $("input[name=ongkir]").val(ongkir);
        $("input[name=estimasi]").val(etd);
      })
    });
  </script>
  
</body>
</html>