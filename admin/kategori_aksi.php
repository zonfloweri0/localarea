<?php
session_start();
require_once "../konek.php";
require_once "../fungsi.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
$hal = $_GET['p'];
$aksi = $_GET['a'];

if (isset($_POST['insert'])) {
    $jmk = mysqli_num_rows(mysqli_query($konek, "SELECT * from kategoribuku where kategoriid='$_POST[kode]'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('kode kategori sudah ada!');history.back();</script>";
        exit();
    } else {
        mysqli_query($konek, "insert into kategoribuku set
            kategoriid='$_POST[kode]',
            namakategori='$_POST[nama]'
            ");
        lapor($_SESSION['nama'] . "menambahkan kategori buku" . $_POST['kode'], "../log/");
    }
}
if (isset($_POST['update'])) {
    mysqli_query($konek, "update kategoribuku set
        namakategori='$_POST[nama]'
        where kategoriid='$_POST[kode]'
        ");
    lapor($_SESSION['nama'] . "mengubah data kategori buku" . $_POST['kode'], "../log/");
}
if ($aksi == 'hapus') {
    mysqli_query($konek, "delete from kategoribuku where kategoriid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from kategoribuku_relasi where kategoriid='" . $_GET['cr'] . "'");
    lapor($_SESSION['nama'] . "menghapus kategori buku dengan kode" . $_GET['cr'], "../log/");
}
header("location: index.php?p=$hal");
