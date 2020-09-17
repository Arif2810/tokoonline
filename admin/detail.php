<h2>Detail Pembelian</h2>

<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan WHERE pembelian.id_pembelian = '$_GET[id]'");
$detail = $ambil->fetch_assoc();

?>

<!-- <pre><?php // print_r($detail); ?></pre> -->

<div class="row" style="margin-bottom:10px;">
	<div class="col-md-4">
		<h3>Pembelian</h3>
		tanggal : <?= $detail["tanggal_pembelian"]; ?><br>
		total : Rp.<?= number_format($detail["total_pembelian"]); ?>,- <br>
		Status : <?= $detail['status_pembelian']; ?>
	</div>
	<div class="col-md-4">
		<h3>Pelanggan</h3>
		<strong><?= $detail["nama_pelanggan"]; ?></strong><br>
		<?= $detail["telepon_pelanggan"]; ?><br>
		<?= $detail["email_pelanggan"]; ?>
	</div>
	<div class="col-md-4">
		<h3>Pengiriman</h3>
		<strong><?= $detail['tipe']; ?> <?= $detail['distrik']; ?> <?= $detail['provinsi']; ?></strong><br>
		Ongkos kirim: Rp. <?= number_format($detail['ongkir']); ?>,-<br>
		Ekspedisi: <?= $detail['ekspedisi']; ?> <?= $detail['paket']; ?> <?= $detail['estimasi']; ?><br>
		Alamat: <?= $detail['alamat_pengiriman']; ?>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Jumlah</th>
			<th>Subtotal</th>
		</tr> 
	</thead>
	<tbody>

		<?php $no=1; ?>
		<!-- menggabungkan (join) tabel produk dengan tabel pembelian_produk -->
		<?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON pembelian_produk.id_produk = produk.id_produk WHERE pembelian_produk.id_pembelian = '$_GET[id]'"); ?>
		<?php while($pecah = $ambil->fetch_assoc()): ?>
		<tr>
			<td><?= $no; ?>.</td>
			<td><?= $pecah["nama_produk"]; ?></td>
			<td>Rp. <?= number_format($pecah["harga_produk"]); ?>,-</td>
			<td><?= $pecah["jumlah"]; ?></td>
			<td>Rp. <?= number_format($pecah["jumlah"]*$pecah["harga_produk"]); ?>,-</td>
		</tr>
		<?php $no++; ?>
		<?php endwhile; ?>

	</tbody>
</table>