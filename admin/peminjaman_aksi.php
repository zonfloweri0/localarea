<?php
session_start();
require_once "../konek.php";
require_once "../fungsi.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
if (isset($_GET['user1'])) {
    $output = '';
    $key = "%" . $_GET['user1'] . "%";
    $query = "SELECT * FROM user WHERE userid LIKE ? or username LIKE ? or namalengkap LIKE ? LIMIT 5";
    $cek = $konek->prepare($query);
    $cek->bind_param('sss', $key, $key, $key);
    $cek->execute();
    $res = $cek->get_result();

    $output = '<datalist id="user1">';
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $output .= '<option value="' . $row["userid"] . '">' . $row["username"] . '-' . $row["namalengkap"] . '</option>';
        }
    } else {
        $output .= '<option value="">Tidak ada yang cocok.</option>';
    }
    $output .= '</datalist>';
    echo $output;
    exit();
}
if (isset($_GET['kode1'])) {
    $output = '';
    $key = "%" . $_GET['kode1'] . "%";
    $query = "SELECT * FROM buku WHERE bukuid LIKE ? or judul LIKE ? LIMIT 5";
    $cek = $konek->prepare($query);
    $cek->bind_param('ss', $key, $key,);
    $cek->execute();
    $res = $cek->get_result();

    $output = '<datalist id="kode1">';
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $output .= '<option value="' . $row["bukuid"] . '">' . $row["judul"] . '-' . '</option>';
        }
    } else {
        $output .= '<option value="">Tidak ada yang cocok.</option>';
    }
    $output .= '</ul>';
    echo $output;
    exit();
}
$hal = $_GET['p'];
$aksi = $_GET['a'];
if (isset($_POST['insert'])) {
    # cek pinjam buku yang sama
    $jml = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman where userid='$_POST[user]'
        and bukuid='$_POST[kode]' and statuspeminjaman='belum kembali'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('Tidak bisa meminjam buku yang sama!');
                history.back();</script>";
        exit();
    }
    $jmlbuku = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman where userid='$_POST[user]'
        and statuspeminjaman='belum kembali'"));
    if ($jmlbuku > 2) {
        echo "<script type='text/javascript'>alert('Peminjaman melebihi batas maksimum!');
        history.back();</script>";
        exit();
    } else {
        mysqli_query($konek, "insert into peminjaman set
        userid='$_POST[user]',
        bukuid='$_POST[kode]',
        tanggalpeminjaman='$_POST[tgl]',
        tenggalpengembalian='$_POST[tgl]',
        statuspeminjaman ='belum kembali'               
        ");
        lapor($_SESSION['nama'] . "menambahkan peminjaman buku :user- " .
            $_POST['user'] . "buku-" . $_POST['kode'], "../log/");
    }
}
if ($aksi == 'kembali') {
    $tgl = date('Y-m-d');
    mysqli_query($konek, "update peminjaman set tenggalpengembalian='$tgl', 
    statuspeminjaman='sudah kembali' where peminjamanid='" . $_GET['cr'] . "' ");
    lapor($_SESSION['nama'] . "mengembalikan buku dengan kode pinjaman" . $_GET['cr'], "../log/");
}
if ($aksi == 'hapus') {
    mysqli_query($konek, "delete from peminjaman where peminjamanid='" . $_GET['cr'] . "' ");
    lapor($_SESSION['nama'] . "menghapus peminjaman buku dengan kode pinjaman" . $_GET['cr'], "../log/");
}
header("location:index.php?p=$hal");
