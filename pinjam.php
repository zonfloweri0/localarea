<?php
session_start();
require_once "konek.php";
require_once "fungsi.php";
if (!isset($_SESSION['nama']) and ($_GET['a'] == "pinjam" or $_GET['a'] == "koleksi")) {
    echo "<script type='text/javascript'>alert('Silakan login untuk melakukan peminjaman!');
            history.back();</script>";
    exit();
}
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
//untuk ajax user
$hal = $_GET['p'];
$aksi = $_GET['a'];
//untuk simpan data ya rin diingat
if ($aksi == 'pinjam') {
    lapor($_SESSION['id'] . "melakukan peminjaman buku : " . $_GET['id']);
    header("location:index.php?p=$hal&id=$_GET[id]");

    # cek pinjam buku yang sama
    $jml = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman where userid='$_SESSION[id]'
            and bukuid='$_GET[id]' and statuspeminjaman='belum kembali'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('Tidak bisa meminjam buku yang sama!');
                history.back();</script>";
        exit();
    }
    $jmlbuku = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman where userid='$_SESSION[id]'
         and statuspeminjaman='belum kembali'"));
    if ($jmlbuku > 2) {
        echo "<script type='text/javascript'>alert('Peminjaman melebihi batas maksimum!');
                history.back();</script>";
        exit();
    } else {
        $tgl = date('Y-m-d');
        mysqli_query($konek, "insert into peminjaman set
            userid='$_SESSION[id]',
            bukuid='$_GET[id]',
            tanggalpeminjaman='$tgl',
            tenggalpegembalian='$tgl',
            statuspeminjaman='belum kembali'
            ");
        exit();
    }
}
if ($aksi == 'kembali') {
    $tgl = date('Y-m-d');
    mysqli_query($konek, "update peminjaman set tenggalpegembalian='$tgl', statuspeminjaman='sudah kembali'
         where userid='$_SESSION[id]' and bukuid='$_GET[id]' and statuspeminjaman='belum kembali'");
    lapor($_SESSION['id'] . "mengembalikan buku : " . $_GET['id']);
}
//tambah koleksi
if ($aksi == 'koleksi') {
    // header("location:index.php?p=$hal&id=$_GET[id]");
    $jml = mysqli_num_rows(mysqli_query($konek, "select * from koleksipribadi where userid='$_SESSION[id]'
        and bukuid='$_GET[id]'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('Sudah masuk koleksi pribadi!');
            history.back();</script>";
        exit();
    }
    // pakein , bukan query and
    mysqli_query($konek, "insert into koleksipribadi set userid='$_SESSION[id]' , bukuid='$_GET[id]'");
    lapor($_SESSION['id'] . "menambahkan koleksi buku" . $_GET['id']);
}
header("location:index.php?p=$hal&id=$_GET[id]");
