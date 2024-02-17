<?php
require_once "../konek.php";
require_once "../fungsi.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
$cr = $_GET['cr'];
$aksi = $_GET['a'];

if (isset($_POST['insert'])) {
    $jmk = mysqli_num_rows(mysqli_query($konek, "SELECT * from buku where bukuid='$_POST[kode]'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('kode buku sudah ada!');history.back();</script>";
        exit();
    } else {
        if (file_exists("../cover/$_POST[kode].jpg")) {
            unlink("../cover/$_POST[kode].jpg");
        }
        if (file_exists("../pdf/$_POST[kode].pdf")) {
            unlink("../cover/$_POST[kode].pdf");
        }
        move_uploaded_file($_FILES['fberkas']['tmp_name'], "../pdf/$_POST[kode].pdf");
        move_uploaded_file($_FILES['fcover']['tmp_name'], "../pdf/$_POST[kode].pdf");
        mysqli_query($konek, "insert into buku set
            bukuid='$_POST[kode]',
            judul='$_POST[judul]',
            penulis='$_POST[pengarang]',
            penerbit='$_POST[penerbit]',
            tahunterbit='$_POST[tahun]'
            ");
        foreach ($_POST['kategori'] as $opsi) {
            mysqli_query($konek, "insert into kategoribuku_relasi set
              bukuid='$_POST[kode]',
              kategoriid='$opsi'
              ");
        }
        lapor($_SESSION['nama'] . "menambahkan buku" . $_POST['kode'], "../log/");
    }
}
if (isset($_POST['update'])) {
    if (!empty($_FILES['fberkas']['tmp_name'])) {
        if (file_exists("../pdf/$_POST[kode].pdf")) {
            unlink("../pdf/$_POST[kode].pdf");
        }
        move_uploaded_file($_FILES['fberkas']['tmp_name'], "../pdf/$_POST[kode].pdf");
    }
    if (!empty($_FILES['fcover']['tmp_name'])) {
        if (file_exists("../cover/$_POST[kode].jpg")) {
            unlink("../cover/$_POST[kode].jpg");
        }
        move_uploaded_file($_FILES['fcover']['tmp_name'], "../cover/$_POST[kode].jpg");
    }
    mysqli_query($konek, "update buku set
       judul='$_POST[judul]',
       penulis='$_POST[pengarang]',
       penerbit='$_POST[penerbit]',
       tahunterbit='$_POST[tahun]'
       where bukuid='$_POST[kode]'
       ");
    mysqli_query($konek, "delete from kategoribuku_relasi where bukuid='$_POST[kode]'");
    foreach ($_POST['kategori'] as $opsi) {
        mysqli_query($konek, "insert into kategoribuku_relasi set
              bukuid='$_POST[kode]',
              kategoriid='$opsi'
              ");
    }
    lapor($_SESSION['nama'] . "mengubah data buku" . $_POST['kode'], "../log/");
}
if ($aksi == "hapus") {
    mysqli_query($konek, "delete from buku where bukuid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from koleksipribadi where bukuid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from peminjaman where bukuid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from ulasanbuku where bukuid='" . $_GET['cr'] . "'");
    mysqli_query($konek, "delete from kategoribuku_relasi where bukuid='" . $_GET['cr'] . "'");
    if (file_exists("../cover/$_POST[kode].jpg")) {
        unlink("../cover/$_POST[kode].jpg");
    }
    if (file_exists("../pdf/$_POST[kode].pdf")) {
        unlink("../cover/$_POST[kode].pdf");
    }
    lapor($_SESSION['nama'] . "menghapus buku" . $_GET['cr'], "../log/");
}
header("location: index.php?p=buku");
