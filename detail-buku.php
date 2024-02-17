<?php
if (isset($_POST['submit'])) {
    session_start();
    require_once "konek.php";
    mysqli_query($konek, "insert into ulasanbuku set 
            userid='$_SESSION[id]',
            bukuid='$_GET[id]',
            ulasan='$_POST[ulas]',
            rating='$_POST[rating]'
    ");
    header("location:index.php?p=detail-buku&bukuid=$_GET[id]");
}
$hal = $_GET['p'];
$dt = mysqli_fetch_array(mysqli_query($konek, "select * from buku where bukuid='$_GET[id]'"));
$jml = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman where userid='$_SESSION[id]'
        and bukuid='$_GET[id]' and statuspeminjaman='belum kembali'"));
$dtulasan = mysqli_fetch_array(mysqli_query($konek, "select count(ulasan) as 'ulas'
        from ulasanbuku where bukuid='$_GET[id]' group by bukuid"));
$dtrating = mysqli_fetch_array(mysqli_query($konek, "select avg(rating) as 'rata'
        from ulasanbuku where bukuid='$_GET[id]' group by bukuid"));
$kategori = mysqli_fetch_array(mysqli_query($konek, "select namakategori 
        from kategoribuku_relasi left join kategoribuku on
        kategoribuku_relasi.kategoriid=kategoribuku.kategoriid where bukuid='$_GET[id]'"));
?>
<div class="card border-primary">
    <div class="card-header fw-bold">Detail Buku</div>
    <div class="card-body">
        <div class="row">
            <div class="col col-md-4">
                <img src="cover/<?= $dt['bukuid'] ?>.jpg" style="width:100%"><br><br>
                <?php
                if ($jml > 0) {
                ?>
                    <style type="text/css">
                        #pdf_container {
                            background: #ccc;
                            text-align: center;
                            display: none;
                            padding: 5px;
                            width: auto;
                            height: auto;
                            overflow: auto;
                        }
                    </style>
                    <script type="text/javascript" src="plugin/PDFs/pdf.min.js"></script>
                    <link href="plugin/PDFs/pdf_viewer.min.css" rel="stylesheet" type="text/css" />
                    <script type="text/javascript">
                        var pdfjsLib = window['pdfjs-dist/build/pdf'];
                        pdfjsLib.GlobalWorkerOptions.workerSrc = 'plugin/PDFs/pdf.worker.min.js';
                        var pdfDoc = null;
                        var scale = 1; //set scale for zooming pdf
                        var resolution = 1;

                        function LoadPdfFromUrl(url) {
                            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                                pdfDoc = null;
                                pdfDoc = pdfDoc_;
                                var pdf_container = document.getElementById("pdf_container");
                                pdf_container.style.display = "block";
                                for (var i = 1; i <= pdfDoc.numPages; i++) {
                                    RenderPage(pdf_container, i);
                                }
                            });
                        };

                        function RenderPage(pdf_container, num) {
                            pdfDoc.getPage(num).then(function(page) {
                                var canvas = document.createElement('canvas');
                                canvas.id = 'pdf-' + num;
                                ctx = canvas.getContext('2d');
                                pdf_container.appendChild(canvas);
                                var spacer = document.createElement("div");
                                spacer.style.height = "20px";
                                pdf_container.appendChild(spacer);
                                var viewport = page.getViewport({
                                    scale: scale
                                });
                                canvas.height = resolution * viewport.height;
                                canvas.width = resolution * viewport.width;
                                var renderContext = {
                                    canvasContext: ctx,
                                    viewport: viewport,
                                    transform: [resolution, 0, 0, resolution, 0, 0]
                                };
                                page.render(renderContext);
                            });
                        };
                    </script>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-prev" onclick="">Baca</button>
                    <div class="modal fade" id="bd-prev" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div id="pdf_container"></div>
                            </div>
                        </div>
                    </div>
            </div>
            <?php
                    $script = "<script>
                $(document).ready(function(){
                        LoadPdfFromUrl('pdf/$_GET[id].pdf');
                });
                </script>";
            ?>
            <a href="pinjam.php?p=detail-buku&a=kembali&id=<?= $_GET['id'] ?>" onclick="return confirm('Yakin ingin dikembalikan?')">
                <button class="btn btn-primary">Kembalikan</button>
            </a>
        <?php
                } else {
        ?>
            <style type="text/css">
                #pdf_container {
                    background: #ccc;
                    text-align: center;
                    display: none;
                    padding: 5px;
                    width: auto;
                    height: auto;
                    overflow: auto;
                }
            </style>
            <script type="text/javascript" src="plugin/PDFs/pdf.min.js"></script>
            <link href="plugin/PDFs/pdf_viewer.min.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript">
                var pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'plugin/PDFs/pdf.worker.min.js';
                var pdfDoc = null;
                var scale = 1;
                var resolution = 1;

                function LoadPdfFromUrl(url) {
                    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                        pdfDoc = null;
                        pdfDoc = pdfDoc_;
                        var pdf_container = document.getElementById("pdf_container");
                        pdf_container.style.display = "block";
                        for (var i = 1; i <= 15; i++) {
                            RenderPage(pdf_container, i);
                        }
                    });
                };

                function RenderPage(pdf_container, num) {
                    pdfDoc.getPage(num).then(function(page) {
                        var canvas = document.createElement('canvas');
                        canvas.id = 'pdf-' + num;
                        ctx = canvas.getContext('2d');
                        pdf_container.appendChild(canvas);
                        var spacer = document.createElement("div");
                        spacer.style.height = "20px";
                        pdf_container.appendChild(spacer);
                        var viewport = page.getViewport({
                            scale: scale
                        });
                        canvas.height = resolution * viewport.height;
                        canvas.width = resolution * viewport.width;
                        var renderContext = {
                            canvasContext: ctx,
                            viewport: viewport,
                            transform: [resolution, 0, 0, resolution, 0, 0]
                        };
                        page.render(renderContext);
                    });
                };
            </script>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#bd-prev" onclick="">Preview</button>
            <div class="modal fade" id="bd-prev" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div id="pdf_container"></div>
                    </div>
                </div>
            </div>
            <?php
                    $script = "<script>
                $(document).ready(function(){
                    LoadPdfFromUrl('pdf/$_GET[id].pdf');
                });
                </script>";
            ?>
            <a href="pinjam.php?p=detail-buku&a=pinjam&id=<?= $_GET['id'] ?>">
                <button class="btn btn-primary">Pinjam</button>
            </a>
        <?php
                }
        ?>
        <a href="pinjam.php?p=detail-buku&a=koleksi&id=<?= $_GET['id'] ?>">
            <button class="btn btn-danger">+</button>
        </a>
        </div>
        <div class="col col-md-8">
            <table>
                <tr>
                    <td style="vertical-align:top;">Kode Buku</td>
                    <td style="vertical-align:top;">:
                        <?= $dt['bukuid'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Judul</td>
                    <td style="vertical-align:top;">:
                        <?= $dt['judul'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Penulis Buku</td>
                    <td style="vertical-align:top;">:
                        <?= $dt['penulis'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Penerbit Buku</td>
                    <td style="vertical-align:top;">:
                        <?= $dt['penerbit'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Tahun Terbit</td>
                    <td style="vertical-align:top;">:
                        <?= $dt['tahunterbit'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Kategori</td>
                    <td style="vertical-align:top;">:
                        <?= $kategori['namakategori'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;"></td>Jumlah Ulasan<td style="vertical-align:top;">:
                        <?= $dtulasan['ulas'] ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Rating</td>
                    <td style="vertical-align:top;">:
                        <?= round($dtrating['rata'], 1) ?></td>
                </tr>
            </table>
        </div>
        <div class="col col-md-12">
            <br>
            <h6>Ulasan</h6>
            <ul class="list-unstyled">
                <?php
                $q1 = mysqli_query($konek, "select * from ulasanbuku left join user on 
                    ulasanbuku.userid=user.userid where bukuid='$_GET[id]'");
                while ($d1 = mysqli_fetch_array($q1)) {
                ?>
                    <li class="border border-secondary px-1 my-2">
                        <h6><?= $d1['namalengkap'] ?></h6>
                        <div style="text-align:right;margin-top:-30px;font-style:italic;" class="text-secondary">
                            Rating : <?= $d1['rating'] ?></div>
                        <p><?= $d1['ulasan'] ?></p>
                    </li>
                <?php
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['nama'])) {
                $jml = mysqli_num_rows(mysqli_query($konek, "select * from peminjaman
                    where bukuid='$_GET[id]' and userid='$_SESSION[id]'"));
                if ($jml > 0) {
            ?>
                    <div class="card border-primary">
                        <form action="detail-buku.php?id=<?= $_GET['id'] ?>" method="post">
                            <div class="card-header">Buat Ulasan</div>
                            <div class="card-body">
                                <label class="form-label">Komentar</label>
                                <textarea class="form-control" name="ulas" required></textarea>
                                <label class="form-label">Rating</label>
                                <select class="form-select" name="rating" required>
                                    <option value="">Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" width="auto" name="submit">Kirim</button>
                            </div>
                        </form>
                    </div><br>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>