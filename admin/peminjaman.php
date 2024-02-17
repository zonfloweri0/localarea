<?php
require_once "../konek.php";
if (!isset($_SESSION['nama']) and !isset($_SESSION['sandi'])) {
    header("location:login.php");
}
$hal = $_GET['p'];
$aksi = $_GET['a'];
?>
<?php if ($aksi == "input") { ?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <div class="input-group">
                <div class="col-md-11">
                    <h5> Data peminjaman tambah</h5>
                </div>
                <div class="col-md-1">
                    <a href="index.php?p=peminjaman" class="btn btn-sm btn-secondary">Kembali</a><br>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="peminjaman_aksi.php?p=peminjaman" method="post" enctype="multipart/form-data" class="row">
                <div class="col-md-3">
                    <label class="form-label">UserId</label>
                    <input list="user1" id="user" name="user" class="form-control" placeholder="UserId" required><br>
                    <div id="userList"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kode Buku</label>
                    <input list="kode1" id="kode" name="kode" class="form-control" placeholder="Kode Buku" required><br>
                    <div id="userList"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tgl" class="form-control" required><br>
                </div>
                <div class="form-group">
                    <button type="submit" name="insert" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
<?php
    $script = "
    $(document).ready(function(){
        $(#'user').keyup(function(){
            var user= $(this).val();
            if(user !='')[
                $.ajax({
                    url:\"peminjaman_aksi.php\",
                    method:\"GET\",
                    data:{user1:user},
                    succes:function(data){
                        $(#'userList').fadeIn();
                        $(#'userList').html(data);
                    }
                });
            }
        });
        $(#'kode').keyup(function(){
            var kode = $(this).val();
            if(kode !=''){
                $.ajax({
                    url:\"peminjaman_aksi.php\",
                    method:\"GET\",
                    data:{kode1:kode},
                    succes:function(data){
                        $(#'bukuList').fadeIn();
                        $(#'bukuList').html(data);
                    }
                });
            }
        });";
} else { ?>
    <div class="card border-primary">
        <div class="card-header border-primary text-primary">
            <h5>Data Peminjaman</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="input-group">
            <div class="col-md-8">
                <a href="index.php?p=peminjaman&a=input" class="btn btn-sm btn-succes">Tambah Data</a><br>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <form class="input-group">
            <input type="hidden" name="p" value="peminjaman">
            <input type="text" name="cr" id="cr" class="form-control" placeholder="Pencarian">
            <button class="btn btn- secondary" type="submit" id="button-addon2">Cari</button>
        </form>
    </div>
    </div>
    <?php
    if (isset($cr)) {
        $qr = mysqli_query($konek, "select * from peminjaman where userid like '%$Scr%' or bukuid like '%$cr%' or tanggalpeminjaman like '%$$cr%' or tenggalpengembalian like '%$cr%'
            or statuspeminjaman like '%$cr%' order by peminjamanid desc");
    } else {
        $qr = mysqli_query($konek, "select * from peminjaman order by peminjamanid desc ");
    }
    if (mysqli_num_rows($qr) > 0) {
    ?>
        <table class="table table-striped">
            <tr class="table-light">
                <th>No</th>
                <th>Kode Pengguna</th>
                <th>Kode Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php
            while ($dt = mysqli_fetch_array($qr)) {
            ?>
                <tr>
                    <td><?= ++$no; ?></td>
                    <td><?= $dt['userid']; ?></td>
                    <td><?= $dt['bukuid']; ?></td>
                    <td><?= $dt['tanggalpeminjaman']; ?></td>
                    <td><?= $dt(['statuspeminjaman'] == 'belum kembali' and
                            $dt['tanggalpengembalian'] == $dt['tanggalpeminjaman']) ? "" : $dt['tanggalpengembalian']; ?></td>
                    <td><?= $dt['statuspeminjaman']; ?></td>
                    <td>
                        <a href="peminjaman_aksi?p=peminjaman&a=kembali&cr=<?= $Dt['peminjamanid'] ?>" onclick="return confirm('Yakin dikembalikan?')">
                            <button class="btn btn-small btn-secondary">Kembalikan</button>
                        </a>
                        <a href="peminjaman_aksi?p=peminjaman&a=hapus&cr=<?= $Dt['peminjamanid'] ?>" onclick="return confirm('Yakin akan dihapus?')">
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