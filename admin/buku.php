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
                    <h5>Data Buku - Tambah</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=buku" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="buku_aksi.php?p=buku" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-2">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode" class="form-control" placeholder="kode buku" required><br>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul" class="form-control" placeholder="judul buku" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" placeholder="pengarang" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>

                    <select name="kategori[]" class="form-control" multiple required>
                        <option value="">Silakan Pilih</option>
                        <?php
                        $q = mysqli_query($konek, "select * from kategoribuku");
                        while ($d = mysqli_fetch_array($q)) {
                            echo "<option value='$d[kategoriid]'>$d[namakategori]</option>";
                        }
                        ?>
                    </select><br>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" placeholder="penerbit" required><br>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="text" name="tahun" class="form-control" placeholder="tahun terbit" required><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Berkas</label>
                    <input type="text" name="fberkas" class="form-control" accept="application/pdf" required><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Cover Buku</label>
                    <input type="text" name="fcover" class="form-control" accept=".jpg" required><br>
                </div>
                <div class="form-group">
                    <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
<?php } elseif ($aksi == "edit") {
    $qr = mysqli_query($konek, "select * from buku where buku.bukuid='$cr'");
    $dt = mysqli_fetch_array($qr);
?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <div class="input-group">
                <div class="col-md-11">
                    <h5>Data Buku - Edit</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=buku" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="buku_aksi.php?p=buku" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-2">
                    <label class="form-label">Kode Buku</label>
                    <input type="text" name="kode" class="form-control col-md-2" value="<?= $dt['bukuid'] ?>" placeholder="kode buku" required><br>
                </div>
                <div class="col-md-10">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul" class="form-control col-md-10" value="<?= $dt['judul'] ?>" placeholder="judul buku" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" value="<?= $dt['penulis'] ?>" placeholder="pengarang" required><br>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="kategori[]" class="form-control" multiple required>
                        <option value="">Silakan Pilih</option>
                        <?php
                        $q = mysqli_query($konek, "select * from kategoribuku");
                        while ($d = mysqli_fetch_array($q)) {
                            echo "<option value='$d[kategoriid]'>$d[namakategori]</option>";
                        }
                        ?>
                        <?php
                        $q = mysqli_query($konek, "select * from kategoribuku");
                        while ($d = mysqli_fetch_array($q)) {
                            if ($d1['kategoriid'] == $d['kategoriid']) {
                                $sama++;
                            }
                        }
                        if ($sama > 0) {
                            echo "<option value='$d[kategoriid]' selected>$d[namakategori]</option>";
                        } else {
                            echo "<option value='$d[kategoriid]'>$d[namakategori]</option>";
                        }
                        ?>
                    </select><br>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="<?= $dt['penerbit'] ?>" placeholder="penerbit" required><br>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="text" name="tahun" class="form-control" value="<?= $dt['tahunterbit'] ?>" placeholder="tahun terbit" required><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Berkas</label>
                    <?php
                    if (file_exists("../pdf/" . $dt['bukuid'] . ".pdf")) {
                        echo "<br>Nama Berkas : $dt[bukuid].pdf<br>";
                    } else {
                        echo "<br><b>Berkas Tidak Ditemukan!</b><br>";
                    }
                    ?>
                    <input type="text" name="fberkas" class="form-control" accept="application/pdf"><br>
                </div>
                <div class="col-md-6">
                    <label class="form-label">File Cover Buku</label>
                    <?php
                    if (file_exists("../cover/" . $dt['bukuid'] . ".jpg")) {
                        echo "<br><img src='../cover/$dt[bukuid].jpg' style='width:150px;'><br>";
                    } else {
                        echo "<br><b>Berkas Tidak Ditemukan!</b><br>";
                    }

                    ?>
                    <input type="text" name="fcover" class="form-control" accept=".jpg" required><br>
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
            <h5>Data Buku</h5>
        </div>

        <div class="card-body">
            <div class="col-md-8">
                <a href="index.php?p=buku&a=input" class="btn btn-success">Tambah Data</a>
            </div>
            <div class="input-group">
                <form class="input-group">
                    <input type="hidden" name="p" value="buku">
                    <input type="text" name="cr" id="cr" class="form-control" placeholder="Pencarian">
                    <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($cr)) {
            $qr = mysqli_query($konek, "select * from buku where judul like '%$cr%'");
        } else {
            $qr = mysqli_query($konek, "select * from buku");
        }

        if (mysqli_num_rows($qr) > 0) {
        ?>
            <table class="table-striped">
                <tr cclass="table-light">
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Aksi</th>
                </tr>
                <?php
                while ($dt = mysqli_fetch_array($qr)) {
                ?>
                    <tr>
                        <td><?= ++$no; ?></td>
                        <td><?= $dt['bukuid']; ?></td>
                        <td><?= $dt['judul']; ?></td>
                        <td><?= $dt['penulis']; ?></td>
                        <td><?= $dt['penerbit']; ?></td>
                        <td><?= $dt['tahunterbit']; ?></td>
                        <td>
                            <a href="index.php?p=buku&a=edit&cr=<?= $dt['bukuid'] ?>">
                                <button class="btn btn-small btn-info">Edit</button> </a>
                            <a href="buku_aksi.php?p=buku&a=hapus&cr=<?= $dt['bukuid'] ?>" onclick="return confirm('yakin akan dihapus?')">
                                <button class="btn btn-small btn-info">Hapus</button> </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
    </div>
    </div>
<?php }
    } ?>