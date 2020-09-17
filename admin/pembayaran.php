<h2>Data Pembayaran</h2>

<?php
// Mendapatkan id_pembelian dari url
$id_pembelian = $_GET['id'];

// Mengambil data pembayaran berdasarkan id_pembelian
$ambil = $koneksi->query("SELECT * FROM pembayaran WHERE id_pembelian='$id_pembelian'");
$detail = $ambil->fetch_assoc();

?>


<div class="row">
  <div class="col-md-6">
    <table class="table">
      <tr>
        <th>Nama</th>
        <td><?= $detail['nama']; ?></td>
      </tr>
      <tr>
        <th>Bank</th>
        <td><?= $detail['bank']; ?></td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>Rp. <?= number_format($detail['jumlah']); ?>,-</td>
      </tr>
      <tr>
        <th>Tanggal</th>
        <td><?= $detail['tanggal']; ?></td>
      </tr>
    </table>
  </div>
  <div class="col-md-6">
    <img src="../bukti_pembayaran/<?= $detail['bukti']; ?>" alt="" class="img-responsive">
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <form action="" method="post">
      <div class="form-group">
        <Label>No Resi Pengiriman</Label>
        <input type="text" class="form-control" name="resi">
      </div>
      <div class="form-group">
        <label for="">Status</label>
        <select name="status" id="" class="form-control">
          <option value="">Pilih Status</option>
          <option value="lunas">Lunas</option>
          <option value="barang dikirim">Barang Dikirim</option>
          <option value="batal">Batal</option>
        </select>
      </div>
      <button class="btn btn-success" name="proses">Proses</button>
    </form>
  </div>
</div>

<?php
if(isset($_POST['proses'])){
  $resi = $_POST['resi'];
  $status = $_POST['status'];
  $koneksi->query("UPDATE pembelian SET resi_pengiriman='$resi', status_pembelian='$status' WHERE id_pembelian='$id_pembelian'");

  echo "<script>alert('Data pembelian terupdate');</script>";
  echo "<script>location='index.php?halaman=pembelian';</script>";
}

?>




 