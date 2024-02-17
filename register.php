<?php
if (isset($_POST['insert'])) {
    require_once "konek.php";
    require_once "fungsi.php";
    if (strcmp($_POST['sandi'], $_POST['sandi1']) != 0) {
        echo "<script type='text/javascript'>alert('kata sandi tidak sama!');history.back();</script>";
        exit();
    }
    $jml = mysqli_num_rows(mysqli_query($konek, "select * from user where username='$_POST[user]'"));
    if ($jml > 0) {
        echo "<script type='text/javascript'>alert('nama pengguna sudah ada!');history.back();</script>";
        exit();
    } else {
        mysqli_query($konek, "insert into user set
                username='$_POST[user]',
                password='" . md5($_POST['sandi']) . "',
                email='$_POST[email]',
                namalengkap='$_POST[nama]',
                alamat='$_POST[alamat]'               
                ");
        lapor($_POST['user'] . "melakukan pendaftaran akun baru");
    }
    header("location:index.php?p=login");

    $hal = $_GET['p'];
    $qr = mysqli_query($konek, "select from user where userid='$_SESSION[id]'");
    $dt = mysqli_fetch_array($qr);
}
?>
<div class="card border-primary">
    <div class="card-header broder-primary text-primary">
        <div class="input-group">
            <div class="col-md-12">
                <h5> Registrasi Akun</h5>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form action="register.php" method="post" class="row">
            <div class="col-md-3">
                <label class="form-label">nama pengguna</label>
                <input type="text" name="user" class="form-control" placeholder="nama anda" required><br>
            </div>
            <div class="col-md-3">
                <label class="form-label">kata sandi</label>
                <input type="password" name="sandi" class="form-control" placeholder="sandi" required><br>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <input type="password" name="sandi1" class="form-control" placeholder="ketik ulang sandi" required><br>
            </div>
            <div class="col-md-3">
                <label class="form-label">email</label>
                <input type="email" name="email" class="form-control" required><br>
            </div>
            <div class="col-md-4">
                <label class="form-label">nama lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="nama lengkap" required><br>
            </div>
            <div class="col-md-8">
                <label class="form-label">alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="alamat" required><br>
            </div>
            <div class="form-group">
                <button type="submit" name="insert" class="btn btn-primary">kirim</button>
            </div>
        </form>
    </div>
</div>