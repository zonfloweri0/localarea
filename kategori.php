<?php
$p = $_GET['p'];
$cr = $_GET['cr'];
$kat = $_GET['kat'];
?>
<div class="card border-primary">
    <div class="card-header border-primary text-primary">
        <h5>Data Kategori</h5>
    </div>
    <div class="card-body">
        <div class="input-group">
            <div clas="col col-md-4"></div>
            <div class="col col-md-8">
                <form class="input-group">
                    <input type="hidden" name="p" value="kategori">
                    <select name="kat" id="kat" class="form-select">
                        <option value="">Pilih Kategori</option>
                        <?php
                        $q1 = mysqli_query($konek, "select * from kategoribuku");
                        while ($d1 = mysqli_fetch_array($q1)) {
                            if ($kat == $d1['kategoriid']) {
                                echo "<option value=\"$d1[kategoriid]\" selected>$d1[namakategori]</option>";
                            } else {
                                echo "<option value=\"$d1[kategoriid]\">$d1[namakategori]</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="text" name="cr" id="cr" class="form-control" placeholder="Pencarian">
                    <button class="btn btn-secondary" type="submit" id="button-addon2">Cari</button>
                </form>
            </div>
        </div>
        <?php
        if (isset($cr)) {
            /*$qr = mysqli_query($konek, "select * from buku left join kategoribuku_relasi on buku.bukuid=kategoribuku_relasi.bukuid where (judul like '%$cr%' 
            or penulis like '%$cr%' or penerbit like '%$cr%') and kategoriid like '%$kat%'");*/
            $qr = mysqli_query($konek, "select * from buku left join kategoribuku_relasi on buku.bukuid=kategoribuku_relasi.bukuid where judul like '%$cr%' or 
            penulis like '%$cr%' or penerbit like'%$cr%' and kategoriid like '%$kat%'");
        } else {
            $qr = mysqli_query($konek, "select * from buku  limit 0,20");
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
                                <button class="btn btn-small btn-info">Lihat</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>