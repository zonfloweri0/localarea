<?php
session_start();
if (isset($_SESSION['nama']) and isset($_SESSION['sandi'])) {
    header("location:index.php");
}
if (isset($_POST['login'])) {
    require_once "konek.php";
    //require_once "fungsi.php";
    $nama = $_POST['nama'];
    $sandi = md5($_POST['sandi']);
    $qr = mysqli_query($konek, "select * from user where username='$nama' and
        password='$sandi' and level not in ('admin','petugas')");
    $cek = mysqli_num_rows($qr);
    if ($cek > 0) {
        $dt = mysqli_fetch_array($qr);
        $_SESSION['level'] = 'peminjam';
        $_SESSION['nama'] = $nama;
        $_SESSION['id'] = $dt['userid'];
        $_SESSION['sandi'] = $sandi;
        //tambah event log
        //lapor($nama ."berhasil login");
        header("location:index.php");
        exit();
    }
    //lapor($nama . "gagal login!");
}
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="plugin/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container py-5 my-5">
        <div class="card border-primary col-md-6 mx-auto">
            <div class="card-header text-white bg-primary">
                <h4>Login Digilib</h4>
            </div>
            <div class="card-body">
                <img src="assets/logo.jpg" width="96px" alt="logo">
                <form method="post" action="login.php">
                    <div class="form-outline mb-4">
                        <label class="form-label">Nama Pengguna</label>
                        <input type="text" name="nama" id="nama" class="form-control form-control-lg">
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label">Sandi</label>
                        <input type="password" name="sandi" id="sandi" class="form-control form-control-lg">
                    </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit" name="login">Submit</button>
                Belum Punya Akun? <a href="index.php?p=register">Daftar Sekarang</a>
                </form>
            </div>
        </div>
</body>

</html>