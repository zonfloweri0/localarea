<?php

$jenis;

// var_dump($_POST);

if (isset($_POST['submit'])) {
    require_once "../konek.php";
    if ($_POST['jenis'] == "") {
        $jenis = "Semua Transaksi";
        $qr = mysqli_query($konek, "select * from peminjaman where (tanggalpeminjaman between '$_POST[dari]'
        and '$_POST[sampai]') or (tenggalpegembalian between '$_POST[dari]' and '$_POST[sampai]')");
    }
    if ($_POST['jenis'] == "pinjam") {
        $jenis = "Transaksi $_POST[jenis]";
        $qr = mysqli_query($konek, "select * from peminjaman where (tanggalpeminjaman between '$_POST[dari]'
            and '$_POST[sampai]') and statuspeminjaman='belum kembali'");
    }
    if ($_POST['jenis'] == "kembali") {
        $jenis = "Transaksi $_POST[jenis]";
        $qr = mysqli_query($konek, "select * from peminjaman where (tanggalpeminjaman between '$_POST[dari]'
            and '$_POST[sampai]') and statuspeminjaman='sudah kembali'");
    }
?>
    <html>

    <head>
        <title>Tahu</title>
        <link rel="stylesheet" href="../plugin/bootstrap/css/bootstrap.min.css">
        <script src="../plugin/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>

        <br><br><br>
        <hr>
        <div class="row d-flex justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header text-center">
                            <h4>Laporan Peminjaman<br><?= $jenis; ?></h4>

                        </div>


                        <table cellpadding="5" class="table">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pinjam</th>
                                <th>UserId</th>
                                <th>BukuId</th>
                                <th>Status</th>
                            </tr>
                            <?php
                            $no = 0;
                            while ($dt = mysqli_fetch_array($qr)) {
                                $no++;
                                echo "<tr class='table-primary'>
              <td>$no</td>
              <td>$dt[tanggalpeminjaman]</td>
              <td>$dt[userid]</td>
              <td>$dt[bukuid]</td>
              <td>$dt[statuspeminjaman]</td>
              </tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
    exit();
}
require_once "../konek.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
?>
<div class="card border-primary">
    <div class="card-header border-primary text-primary">
        <h5>Laporan Peminjaman</h5>
    </div>
    <div class="card-body">
        <form method="post" target="_blank" action="laporan.php">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="dari" class="form-control" required>
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" required>
            <label class="form-label">Jenis Transaksi</label>
            <select name="jenis" class="form-select">
                <option value="">semua</option>
                <option value="pinjam">peminjaman</option>
                <option value="kembali">pengembalian</option>
            </select><br>
            <input type="submit" name="submit" class="btn btn-success">
        </form>
    </div>
</div>