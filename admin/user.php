<?php
require_once "../konek.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
$cr = $_GET['cr'];
$aksi = $_GET['a'];
?>
<?php if ($aksi == "input") { ?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <div class="input-group">
                <div class="col-md-11">
                    <h5>Data Pengguna-Tambah</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=user" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="user_aksi.php>p=user" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="user" class="form-control" placeholder="Nama Pengguna" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="sandi" class="form-control" placeholder="Sandi" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <input type="password" name="sandi1" class="form-control" placeholder="Ketik Ulang Sandi" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required><br>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required><br>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat" required><br>
                </div>
                <div class="form-group">
                    <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
<?php } elseif ($aksi == "edit") {
    $qr = mysqli_query($konek, "select * from user where userid='$cr'");
    $dt = mysqli_fetch_array($qr);
?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <div class="input-group">
                <div class="col-md-11">
                    <h5>Data Pengguna-Edit</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=user" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="user_aksi.php>p=user" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-3">
                    <label class="form-label">Nama Pengguna</label>
                    <input type="text" name="user" class="form-control" placeholder="Nama Pengguna" value="<?= $dt['username'] ?>" readonly><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="sandi" class="form-control" placeholder="Kosongi bila tidak diubah!" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <input type="password" name="sandi1" class="form-control" placeholder="Ketik Ulang Sandi" required><br>
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
<?php } else { ?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <h5>Data Pengguna-Tambah</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="input-group">
            <div class="col-md-8">
                <a href="index.php?p=user&a=input" class="btn btn-succes">Tambah Data</a><br><br>
            </div>
            <div class="col-md-4">
                <form class="input-group">
                    <input type="hidden" name="p" value="user">
                    <input type="text" name="cr" id="cr" class="form-control" placeholder="Pencarian">
                    <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($cr)) {
            $qr = mysqli_query($konek, "select * from user where (username like '%$cr%' or email like '%$cr%'
        or namalengkap like '%$cr%' or alamat like '%$cr%') and username not in('admin','petugas')");
        } else {
            $qr = mysqli_query($konek, "select * from user where username not in('admin','petugas')");
        }
        if (mysqli_num_rows($qr) > 0) {
        ?>
            <table class="table table-striped">
                <tr class="table-light">
                    <th>No</th>
                    <th>UserId</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                <?php
                while ($dt = mysqli_fetch_array($qr)) {
                ?>
                    <tr>
                        <td><?= ++$no; ?></td>
                        <td><?= ['userid']; ?></td>
                        <td><?= ['username']; ?></td>
                        <td><?= ['email']; ?></td>
                        <td><?= ['namalengkap']; ?></td>
                        <td><?= ['alamat']; ?></td>
                        <td>
                            <a href="index.php?p=user&a=edit&cr=<?= $dt['userid'] ?>">
                                <button class="btn btn-small btn-info">edit</button>
                            </a>
                            <a href="user_aksi.php?p=user&a=hapus&cr=<?= $dt['userid'] ?>" onclick="return confirm('Yakin aka dihapus?')">
                                <button class="btn btn-small btn-warning">Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
    </div>
    </div>
<?php  }
    } ?>