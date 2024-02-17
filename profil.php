<?php
if (isset($_POST['update'])) {
    session_start();
    require_once "konek.php";
    require_once "fungsi.php";
    if (strcmp($_POST['sandi'], $_POST['sandi1']) != 0) {
        echo "<script type='text/javascript'>alert('Kata sandi tidak sama!');
                history.back();</script>";
        exit();
    }
    if (isset($_POST['sandi'])) {
        mysqli_query($konek, "update user set
            password='" . md5($_POST['sandi']) . "',
            email='$_POST[email]',
            namalengkap='$_POST[nama]',
            alamat='$_POST[alamat]'
            where username='$_POST[user]'
            ");
    } else {
        mysqli_query($konek, "update user set
            email='$_POST[email]',
            namalengkap='$_POST[nama]',
            alamat='$_POST[alamat]'
            where username='$_POST[user]' 
            ");
    }
    lapor($_SESSION['id'] . "melakukan perubahan data profil");
    header("location:index.php?p=profil");
}

if (!isset($_SESSION['nama']) and !isset($_SESSION['password'])) {
    header("location:index.php");
}
$hal = $_GET['p'];
?>
<?php
$qr = mysqli_query($konek, "select * from user where userid='$_SESSION[id]'");
$dt = mysqli_fetch_array($qr);
?>
<div class="card border-primary">
    <div class="card-header border-primary text-primary">
        <div class="input-group">
            <div class="col-md-12">
                <h5>Profil</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="profil.php" method="post" class="row">
            <div class="col-md-3">
                <label class="form-label">Nama Pengguna</label>
                <input type="text" name="user" class="form-control" placeholder="Nama Pengguna" value="<?= $dt['username'] ?>" readonly><br>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" name="sandi" class="form-control" placeholder="Kosongi bila tidak diubah"><br>
            </div>

            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <input type="password" name="sandi1" class="form-control" placeholder="Ketik ulang sandi"><br>
            </div>
            <div class="col-md-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $dt['email'] ?>" required><br>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="<?= $dt['namalengkap'] ?>" required><br>
            </div>
            <div class="col-md-8">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?= $dt['alamat'] ?>" required><br>
            </div>
            <div class="form-group">
                <button type="submit" name="update" class="btn btn-primary">Perbaharui</button>
            </div>
        </form>
    </div>
</div>