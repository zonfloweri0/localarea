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
    if (strcmp($_POST['sandi'], $_POST['sandi']) != 0) {
        echo "<script type='text/javascript'>alert('kata sandi tidak sama!');history.back();</script>";
        exit();
    }
    $jml = mysqli_num_rows(mysqli_query($konek, "select * from user where username='$_POST[user]'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('Nama pengguna sudah ada!');history.back();</script>";
        exit();
    } else {
        mysqli_query($konek, "insert into user set
        username='$_POST[user]',
        password='" . md5($_POST['sandi']) . "',
        email='$_POST[email]',
        namalengkap='$_POST[nama]',
        alamat='$_POST[alamat]'               
        ");
        lapor($_SESSION['nama'] . "menambahkan pengguna : " . $_POST['user'], "../log/");
    }
}
if (isset($_POST['update'])) {
    if (strcmp($_POST['sandi'], $_POST['sandi']) != 0) {
        echo "<script type='text/javascript'>alert('kata sandi tidak sama!');history.back();</script>";
        exit();
    }
    if (isset($_POST['sandi'])) {
        mysqli_query($konek, "update user set
        password='" . md5($_POST['sandi']) . "',
        email='$_POST[email]',
        namalengkap='$_POST[nama]',
        alamat='$_POST[alamat]' 
        where  username='$_POST[user]',              
        ");
    } else {
        mysqli_query($konek, "update user set
        email='$_POST[email]',
        namalengkap='$_POST[nama]',
        alamat='$_POST[alamat]' 
        where username='$_POST[user]',              
        ");
    }
    lapor($_SESSION['nama'] . "menambahkan pengguna : " . $_POST['user'], "../log/");
}
if ($aksi == 'hapus') {
    mysqli_query($konek, "delete from user where userid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from koleksipribadi where userid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from peminjaman where userid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from ulasanbuku where userid='" . $_GET['cr'] . "'");
    lapor($_SESSION['nama'] . "menghapus data pengguna: " . $_GET['CR'], "../log/");
}
header("location: index.php?p=$hal");
