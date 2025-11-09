<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Laundry</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 450px;
            background-color: #fff;
            margin: 60px auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #00796b;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: 500;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            margin-top: 5px;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        input:focus, select:focus {
            border-color: #00796b;
            box-shadow: 0 0 5px rgba(0, 121, 107, 0.3);
        }

        button {
            margin-top: 20px;
            padding: 10px;
            font-size: 15px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #004d40;
        }

        hr {
            margin: 30px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        h3 {
            color: #004d40;
            text-align: center;
            margin-bottom: 10px;
        }

        .result-box {
            margin-top: 20px;
            background-color: #f1f8e9;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 77, 64, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Program Perhitungan Jasa Laundry</h2>

        <form method="post">
            <label>Nama Pelanggan:</label>
            <input type="text" name="nama" required>

            <label>Pilihan Paket Laundry:</label>
            <select name="paket" required>
                <option value="Cuci">Cuci (Rp. 5000/kg)</option>
                <option value="Cuci Setrika">Cuci Setrika (Rp. 8000/kg)</option>
                <option value="Cuci Selimut/Seprai">Cuci Selimut/Seprai (Rp. 4000/pcs)</option>
                <option value="Cuci Setrika Selimut/Seprai">Cuci Setrika Selimut/Seprai (Rp. 6500/pcs)</option>
            </select>

            <label>Jumlah (kg/pcs):</label>
            <input type="number" name="jumlah" min="1" required>

            <label>Tanggal Masuk:</label>
            <input type="date" name="tgl_masuk" required>

            <label>Durasi:</label>
            <select name="durasi">
                <option value="2">Reguler (2 hari, +0%)</option>
                <option value="1">Kilat (1 hari, +25%)</option>
                <option value="0.33">Express (8 jam, +50%)</option>
            </select>

            <button type="submit" name="proses">Hitung Total</button>
        </form>

        <hr>

        <?php
        if(isset($_POST['proses'])){
            // date_default_timezone_set("Asia/Jakarta");

            $nama       = $_POST['nama'];
            $paket      = $_POST['paket'];
            $jumlah     = $_POST['jumlah'];
            $tglMasuk   = $_POST['tgl_masuk'];
            $durasi     = $_POST['durasi'];

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

            if($durasi == 2) $biaya_tambah = 0;
            elseif($durasi == 1) $biaya_tambah = 0.25;
            else $biaya_tambah = 0.50;

            $subtotal = $harga * $jumlah;
            $total = $subtotal + ($subtotal * $biaya_tambah);

            if($durasi >= 1){
                $tglKeluar = date('Y-m-d', strtotime($tglMasuk . " +$durasi day"));
            } else {
                $tglKeluar = date('Y-m-d H:i', strtotime($tglMasuk . " +8 hour"));
            }

            echo "<div class='result-box'>";
            echo "<h3>Hasil Transaksi Laundry</h3>";
            echo "<table>";
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
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
