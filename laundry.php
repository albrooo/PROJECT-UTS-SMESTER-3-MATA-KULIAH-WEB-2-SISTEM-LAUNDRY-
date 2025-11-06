<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Laundry</title>
</head>
<body>
<h2>Program Perhitungan Jasa Laundry</h2>

<form method="post">
    Nama Pelanggan: <br>
    <input type="text" name="nama" required><br><br>

    Pilihan Paket Laundry: <br>
    <select name="paket" required>
        <option value="Cuci">Cuci (Rp. 5000/kg)</option>
        <option value="Cuci Setrika">Cuci Setrika (Rp. 8000/kg)</option>
        <option value="Cuci Selimut/Seprai">Cuci Selimut/Seprai (Rp. 4000/pcs)</option>
        <option value="Cuci Setrika Selimut/Seprai">Cuci Setrika Selimut/Seprai (Rp. 6500/pcs)</option>
    </select><br><br>

    Jumlah (kg/pcs): <br>
    <input type="number" name="jumlah" required><br><br>

    Tanggal Masuk: <br>
    <input type="date" name="tgl_masuk" required><br><br>

    Durasi: <br>
    <select name="durasi">
        <option value="2">Reguler (2 hari, +0%)</option>
        <option value="1">Kilat (1 hari, +25%)</option>
        <option value="0.33">Express (8 jam, +50%)</option>
    </select><br><br>

    <button type="submit" name="proses">Hitung</button>
</form>

<hr>

<?php
if(isset($_POST['proses'])){
    date_default_timezone_set("Asia/Jakarta");

    $nama       = $_POST['nama'];
    $paket      = $_POST['paket'];
    $jumlah     = $_POST['jumlah'];
    $tglMasuk   = $_POST['tgl_masuk'];
    $durasi     = $_POST['durasi'];

    // Harga dan satuan disimpan otomatis berdasarkan pilihan paket
    switch($paket){
        case "Cuci":
            $harga = 5000;
            $satuan = "kg";
            break;
        case "Cuci Setrika":
            $harga = 8000;
            $satuan = "kg";
            break;
        case "Cuci Selimut/Seprai":
            $harga = 4000;
            $satuan = "pcs";
            break;
        case "Cuci Setrika Selimut/Seprai":
            $harga = 6500;
            $satuan = "pcs";
            break;
        default:
            $harga = 0;
            $satuan = "";
    }

    // Hitung biaya tambahan dari durasi
    if($durasi == 2) $biaya_tambah = 0;
    elseif($durasi == 1) $biaya_tambah = 0.25;
    else $biaya_tambah = 0.50;

    // Hitung total
    $subtotal = $harga * $jumlah;
    $total = $subtotal + ($subtotal * $biaya_tambah);

    // Hitung tanggal keluar
    if($durasi >= 1){
        $tglKeluar = date('Y-m-d', strtotime($tglMasuk . " +$durasi day"));
    } else {
        $tglKeluar = date('Y-m-d H:i', strtotime($tglMasuk . " +8 hour"));
    }

    // Tampilkan hasil
    echo "<h3>Hasil Transaksi Laundry</h3>";
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><td>Nama Pelanggan</td><td>$nama</td></tr>";
    echo "<tr><td>Paket</td><td>$paket</td></tr>";
    echo "<tr><td>Harga per $satuan</td><td>Rp " . number_format($harga, 0, ',', '.') . "</td></tr>";
    echo "<tr><td>Jumlah</td><td>$jumlah $satuan</td></tr>";
    echo "<tr><td>Subtotal</td><td>Rp " . number_format($subtotal, 0, ',', '.') . "</td></tr>";
    echo "<tr><td>Durasi</td><td>" . ($durasi == 2 ? "Reguler (2 hari)" : ($durasi == 1 ? "Kilat (1 hari)" : "Express (8 jam)")) . "</td></tr>";
    echo "<tr><td>Tanggal Masuk</td><td>$tglMasuk</td></tr>";
    echo "<tr><td>Tanggal Keluar</td><td>$tglKeluar</td></tr>";
    echo "<tr><td><b>Total Bayar</b></td><td><b>Rp " . number_format($total, 0, ',', '.') . "</b></td></tr>";
    echo "</table>";
}
?>
</body>
</html>
