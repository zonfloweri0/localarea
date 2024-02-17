<div class="card border-primary">
    <div class="card-header fw-bold">Peminjaman</div>
    <div class="card-body">
        <ul class="list-unstyled">
            <?php
            $q = mysqli_query($konek, "select * from peminjaman
                where userid='$_SESSION[id]' and statuspeminjaman='belum kembali'");
            while ($dt = mysqli_fetch_array($q)) {
                echo "<li style=\"display:inline-block;\">
                <a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">
                <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px;
                margin-bottom:10px;margin-right:10px;\"></a></li>";
            }
            ?>
        </ul>
    </div>
</div>
<br>