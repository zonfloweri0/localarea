<?php
$hal = $_GET['p'];
$aksi = $_GET['a'];

if ($aksi == 'hapus') {
    session_start();
    require_once "konek.php";
    mysqli_query($konek, "delete from koleksipribadi where
            userid='$_SESSION[id]' and bukuid='$_GET[id]'");
    header("location:index.php?p=$hal");
}
?>
<div class="card border-primary">
    <div class="card-header fw-bold">Koleksi</div>
    <div class="card-body">
        <ul class="list-unstyled">
            <?php

            $q = mysqli_query($konek, "select * from koleksipribadi where userid='$_SESSION[id]'");
            while ($dt = mysqli_fetch_array($q)) {
                echo "<li style=\"display:inline-block;\">
                <a href=\"index.php?p=detail-buku&id=$dt[bukuid]\">

                            <img src=\"cover/$dt[bukuid].jpg\" style=\"width:185px;height:250px; margin-bottom:10px;margin-right:10px;\">
                            </a>
                            <br>
                            <a href=\"koleksi.php?p=koleksi&a=hapus&id=$dt[bukuid]\" >
                            <button class=\"btn btn-danger\" onclick=\"return confirm('Yakin di hapus dari daftar koleksi?')\">Hapus dari koleksiku</button>
                            </a><br><br>
                            </li>";
            }
            ?>
    </div>
</div>
<br>