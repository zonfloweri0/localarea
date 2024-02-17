<?php
error_reporting(0);
session_start();
require_once "../konek.php";
require_once "../fungsi.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
$hal = $_GET['p'];
$level = $_SESSION['level'];
?>

<head>

    <link rel='stylesheet' type='text/css' href='../plugin/bootstrap/css/bootstrap.min.css'>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand px-3" href="#">Digilib</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuku">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="#menuku">
                <ul class="navbar-nav col-md-11">
                    <li class="nav-item">
                        <a class="nav-link <?= (!isset($hal)) ? "active" : "" ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($hal == "buku") ? "active" : "" ?>" href="index.php?p=buku">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($hal == "kategori") ? "active" : "" ?>" href="index.php?p=kategori">Kategori</a>
                    </li>
                    <?php
                    if ($_SESSION['level'] == 'admin') {

                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($hal == "user") ? "active" : "" ?>" href="index.php?p=user">Registrasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($hal == "peminjaman") ? "active" : "" ?>" href="index.php?p=peminjaman">Peminjaman</a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($hal == "laporan") ? "active" : "" ?>" href="index.php?p=laporan">Laporan</a>
                    </li>
                </ul>
                <li class="navbar-nav col-md-1">
                    <a class="nav-link active" href="logout.php">Logout</a>
                </li>
            </div>
        </nav>
    </header>
    <main role="main" class="container py-4">
        <?php
        if (isset($hal)) {
            require $hal . '.php';
        } else {
        ?>
            <h3>Dashboard Digilib</h3>Gunakan pilihan menu navigasi untuk mengolah data
            <h2> Info terkini</h2>
            <div class="row">
                <div class="col-md-2 my-2">
                    <div class="card bg-primary py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(userid) as 'jml' from user"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        User
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="card bg-success py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(bukuid) as 'jml' from buku"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        Buku
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="card bg-warning py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(userid) as 'jml' from peminjaman"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        Peminjaman
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="card bg-danger py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(userid) as 'jml' from ulasanbuku"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        Ulasan
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="card bg-success py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(kategoriid) as 'jml' from kategoribuku"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        Kategori
                    </div>
                </div>
                <div class="col-md-2 my-2">
                    <div class="card bg-secondary py-4 text-white text-center">
                        <?php
                        $j1 = mysqli_fetch_array(mysqli_query($konek, "select count(userid) as 'jml' from peminjaman
                        where statuspeminjaman='belum kembali'"));
                        echo "<h1>" . $j1['jml'] . "</h1>";
                        ?>
                        Belum Kembali
                    </div>
                </div>
            <?php
        }
            ?>
    </main>
    <footer class="col-12 bg-secondary" style="bottom:0;position:fixed;">
        <div class="container py-1">
            <span class="text-white col-form-label-sm">Copyright 2024 by Arina Manasikana Alfikri</span>
        </div>
    </footer>
    <script src="../plugin/bootstrap/js/bootstrap.js"></script>
    <script src="../plugin/jquery/jquery.min.js"></script>
    <script>
        <?= $script; ?>
    </script>
</body>

</html>