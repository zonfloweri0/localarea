<?php
$p = $_GET['p'];
$cr = $_GET['cr'];
?>
<div class="card border-primary">
    <div class="card-header border-primary text-primary">
        <h5>Data Buku</h5>
    </div>
    <div class="card-body">
        <div class="input-group">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <form class="input-group">
                    <input type="hidden" name="p" value="buku">
                    <input type="text" name="cr" id="cr" class="form-control" placeholder="pencarian">
                    <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($cr)) {
            $qr = mysqli_query($konek, "select * from buku where judul like '%$cr%' or 
            penulis like '%$cr%' or penerbit like'%$cr%'");
        } else {
            $qr = mysqli_query($konek, "select * from buku limit 0,20");
        }
        if (mysqli_num_rows($qr) > 0) {
        ?>
            <table class="table table-striped">
                <tr class="table-light">
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
                            <a href="index.php?p=detail-buku&id=<?= $dt['bukuid'] ?>">
                                <button class="btn btn-small btn-info">Lihat</button> </a>
                        </td>
                    </tr>
                <?php   } ?>
            </table>
        <?php   } ?>
    </div>
</div>