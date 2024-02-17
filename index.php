<?php
error_reporting(0);
session_start();
require_once "konek.php";
require_once "fungsi.php";
$hal = $_GET['p'];
$level = $_SESSION['level'];
?>

<head>
    <link rel='stylesheet' type='text/css' href='plugin/bootstrap/css/bootstrap.min.css'>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <a class="navbar-brand px-3" href="#">Digilib</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuku">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="#menuku">
                <ul class="navbar-nav col-md-10">
                    <li class="nav-item">
                        <a class="nav-link <?= (!isset($hal)) ? "active" : "" ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($hal == "buku")) ? "active" : "" ?>" href="index.php?p=buku">Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($hal == "kategori")) ? "active" : "" ?>" href="index.php?p=kategori">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($hal == "peminjaman")) ? "active" : "" ?>" href="index.php?p=peminjaman">Peminjaman</a>
                    </li>
                </ul>
                <ul class="navbar-nav col-md-2">
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['nama'])) {
                            echo '<a class="nav-link active" href="logout.php"><b>Logout</b></a>';
                        } else {
                            echo '<a class="nav-link active" href="index.php?p=login"><b>Login/Daftar</b></a>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main role="main" class="container py-4">
        <div class="row"></div>
        <div class="col col-md-9">
            <?php
            if (isset($hal)) {
                require $hal . '.php';
            } else {
            ?>
                <div class="card border-primary">
                    <div class="card-header fw-bold">Sering Dibaca</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $q = mysqli_query($konek, "select bukuid,count(bukuid) as 'jml' from peminjaman
                            group by bukuid order by count(bukuid) desc limit 0,6");
                            while ($dt = mysqli_fetch_array($q)) {
                                echo "<li style=\"display:inline-block;\"><a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                                <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px;margin-bottom,:10px;margin-right:10px;\">
                                </a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="card border-primary">
                    <div class="card-header fw-bold">Rating tertinggi</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $q = mysqli_query($konek, "select bukuid,avg(rating) as 'rata' from ulasanbuku
                            group by bukuid order by avg(rating) desc limit 0,6");
                            while ($dt = mysqli_fetch_array($q)) {
                                echo "<li style=\"display:inline-block;\"><a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                                <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px;margin-bottom,:10px;margin-right:10px;\">
                                </a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="card border-primary">
                    <div class="card-header fw-bold">Ulasan Terbanyak</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $q = mysqli_query($konek, "select bukuid,count(bukuid) as 'jml' from ulasanbuku
                            group by bukuid order by count(bukuid) desc limit 0,6");
                            while ($dt = mysqli_fetch_array($q)) {
                                echo "<li style=\"display:inline-block;\"><a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                                <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px;margin-bottom,:10px;margin-right:10px;\">
                                </a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="card border-primary">
                    <div class="card-header fw-bold">Koleksi Favorit</div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $q = mysqli_query($konek, "select bukuid,count(bukuid) as 'jml' from koleksipribadi
                            group by bukuid order by count(bukuid) desc limit 0,6");
                            while ($dt = mysqli_fetch_array($q)) {
                                echo "<li style=\"display:inline-block;\"><a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                                <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px;margin-bottom,:10px;margin-right:10px;\">
                                </a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <br>
            <?php
            }
            ?>
        </div>
        <div class="col col-md-3">
            <?php
            if (isset($_SESSION['nama'])) {
            ?>
                <div class="card border-primary">
                    <div class="card-header">Hai,
                        <?= $_SESSION['nama'] ?></div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $jm1 = mysqli_num_rows(mysqli_query($konek, "select bukuid from peminjaman
                    where userid='$_SESSION[id]' and statuspeminjaman='belum kembali'"));
                            $jm11 = mysqli_num_rows(mysqli_query($konek, "select bukuid from koleksipribadi
                    where userid='$_SESSION[id]'"));
                            ?>
                            <li><a href="index.php?p=profil">profil</a></li>
                            <li><a href="index.php?p=peminjaman">peminjaman (<?= $jm1; ?>)</a></li>
                            <li><a href="index.php?p=koleksi">koleksiku (<?= $jm11; ?>)</a></li>
                        </ul>
                    </div>
                </div><br>
            <?php
            }
            ?>
            <div class="card border-primary">
                <div class="card-header fw-bold">Buku Terbaru</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php
                        $q = mysqli_query($konek, "select * from buku order by bukuid desc limit 5");
                        while ($dt = mysqli_fetch_array($q)) {
                            echo "<li><a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                                 <img src=\"cover/$dt[bukuid].jpg\" style=\"width:75%;height:200px;margin-bottom,:10px;\">
                                 </a></li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        </div>
    </main>
    <footer class="col-12 bg-secondary" style="bottom:0;position:fixed;">
        <div class="container py-1"><span class="text-white col-form-label-sm">Copyright 2024 by Arina Manasikana Alfikri</span>
        </div>
    </footer>
    <script src="plugin/bootstrap/js/bootstrap.js"></script>
    <script src="plugin/jquery/jquery.min.js"></script>
    <?= $script; ?>
</body>

</html>