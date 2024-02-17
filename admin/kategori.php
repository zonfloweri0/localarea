<?php
session_start();
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
                    <h5>Data Kategori-Tambah</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=kategori" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="kategori_aksi.php?p=kategori" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-2">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="kode" class="form-control" placeholder="kode kategori" required><br>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control" placeholder="nama kategori" required><br>
                </div>
                <div class="input-group">
                    <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
<?php } elseif ($aksi == "edit") {
    $qr = mysqli_query($konek, "select * from kategoribuku where kategoriid='$cr'");
    $dt = mysqli_fetch_array($qr);
?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <div class="input-group">
                <div class="col-md-11">
                    <h5>Data Kategori-Edit</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=kategori" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="kategori_aksi.php?p=kategori" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-2">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="kode" class="form-control col-md-2" value="<?= $dt['kategoriid'] ?>" placeholder="kode kategori" required><br>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama" class="form-control col-md-10" value="<?= $dt['namakategori'] ?>" placeholder="nama kategori" required><br>
                </div>
                <div class="form-group">
                    <button type="submit" name="update" class="btn btn-primary">Perbaharui</button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="card-body">
        <div class="card-header border-primary text-primary">
            <h5>Data Kategori</h5>
        </div>
        <div class="col-md-8">
            <a href="index.php?p=kategori&a=input" class="btn btn-success">Tambah Data</a><br>
        </div>
        <div class="col-md-4">
            <form class="input-group">
                <input type="hidden" name="p" value="kategori">
                <input type="text" name="cr" id="cr" class="form-control" placeholder="Pencarian">
                <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($cr)) {
        $qr = mysqli_query($konek, "select * from kategoribuku where namakategori like'%$cr%'");
    } else {
        $qr = mysqli_query($konek, "select * from kategoribuku");
    }
    if (mysqli_num_rows($qr) > 0) {
    ?>
        <table class="table table-striped">
            <tr class="table-light">
                <th>No</th>
                <th>Kode</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php
            while ($dt = mysqli_fetch_array($qr)) {
            ?>
                <tr>
                    <td><?= ++$no; ?></td>
                    <td><?= $dt['kategoriid']; ?></td>
                    <td><?= $dt['namakategori']; ?></td>
                    <td>
                        <a href="index.php?p=kategori&a=edit&cr=<?= $dt['kategoriid'] ?>">
                            <button class="btn btn-small btn-info">Edit</button> </a>
                        <a href="kategori_aksi.php?p=kategori&a=hapus&cr=<?= $dt['kategoriid'] ?>" onclick="return confirm('Yakin akan dihapus?')">
                            <button class="btn btn-small btn-warning">Hapus</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        </div>
        </div>
<?php }
} ?>