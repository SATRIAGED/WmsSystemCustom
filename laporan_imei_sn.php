<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
etc();
encryption();
session();
connect();
head();
body();
timing();
//alltotal();
pagination();
?>

<?php
if (!login_check()) {
?>
    <meta http-equiv="refresh" content="0; url=logout" />
<?php
    exit(0);
}
?>
<div class="wrapper">
    <?php
    theader();
    menu();
    ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Daftar IMEI & SN
                <small>Forms</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="laporan_imei_sn">Forms</a></li>
                <li class="active">Daftar No Imei & SN</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <!-- SETTING START-->

                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    include "configuration/config_chmod.php";
                    $halaman = "laporan_imei_sn"; // halaman
                    $dataapa = "Daftar IMEI & SN"; // data
                    $tabeldatabase = "imei"; // tabel database
                    $chmod = $chmenu9; // Hak akses Menu
                    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
                    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
                    $produk = $_POST['produk'];
                    $statusreturn = $_POST['status'];
                    $rangedate = $_POST['rangedate'];
                    $arraydate = explode("-", $rangedate);
                    $date1 = trim(date("Y-m-d", strtotime($arraydate[0])));
                    $date2 = trim(date("Y-m-d", strtotime($arraydate[1])));
                    ?>

                    <!-- SETTING STOP -->

                    <!-- BOX INFORMASI -->
                    <?php
                    if ($chmod == '1' || $chmod == '2' || $chmod == '3' || $chmod == '4' || $chmod == '5' || $_SESSION['jabatan'] == 'admin') {
                    } else {
                    ?>
                        <div class="callout callout-danger">
                            <h4>Info</h4>
                            <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    if ($chmod >= 1 || $_SESSION['jabatan'] == 'admin') {
                    ?>

                        <?php
                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            if ($produk) {
                                switch ($status) {
                                    case 'G':
                                        $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_masuk desc";
                                        break;
                                    case 'TK':
                                        $where = "a.sku = 'SK" . $produk . "' and a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_keluar desc";
                                        break;
                                    case 'K':
                                        $where = "a.sku = 'SK" . $produk . "' and a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_return desc";
                                        break;
                                    case 'R':
                                        $where = "a.sku = 'SK" . $produk . "' and a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_return_ged desc";
                                        break;
                                    default:
                                        $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
                                        $orderby = "order by a.tgl_masuk desc";
                                }
                            } else {
                                switch ($status) {
                                    case 'G':
                                        $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_masuk desc";
                                        break;
                                    case 'TK':
                                        $where = "a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_keluar desc";
                                        break;
                                    case 'K':
                                        $where = "a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_return desc";
                                        break;
                                    case 'R':
                                        $where = "a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                        $orderby = "order by a.tgl_return_ged desc";
                                        break;
                                    default:
                                        $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
                                        $orderby = "order by a.tgl_masuk desc";
                                }
                            }

                            $sqla = "SELECT count(a.sku) as totaldata
                                                FROM imei a 
                                                LEFT JOIN barang b ON a.sku = b.sku 
                                                LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
                                                WHERE 
                                                $where
                                                $orderby
                                              ";
                            $hasila = mysqli_query($conn, $sqla);
                            $rowa = mysqli_fetch_assoc($hasila);
                            $totaldata = $rowa['totaldata'];
                        } else {
                            $sqla = "SELECT  COUNT( * ) AS totaldata FROM $forward";
                            $hasila = mysqli_query($conn, $sqla);
                            $rowa = mysqli_fetch_assoc($hasila);
                            $totaldata = $rowa['totaldata'];
                        }
                        ?>

                        <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Form Filter..</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse" fdprocessedid="5ufl9"><i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove" fdprocessedid="odowcr"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                            <form method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Produk</label>
                                                <select class="form-control input-sm select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" id="produk" name="produk">
                                                    <?php
                                                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                                    if ($produk) {
                                                        echo "<option value=''>Pilih Barang</option>";
                                                        $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                                                        while ($row = mysqli_fetch_assoc($sql)) {
                                                            if ($produk == $row['kode'])
                                                                echo "<option selected='selected' value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                                                            else
                                                                echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value='' selected='selected'>Pilih Barang</option>";
                                                        $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                                                        while ($row = mysqli_fetch_assoc($sql)) {
                                                            if ($barcode == $row['barcode'])
                                                                echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                                                            else
                                                                echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control input-sm" style="width: 100%;" name="status" id="status" required="true">
                                                    <option value='ALL' <?= ($statusreturn == 'ALL') ? 'selected' : '' ?>>Semua</option>
                                                    <option value='G' <?= ($statusreturn == 'G') ? 'selected' : '' ?>>Digudang GED</option>
                                                    <option value='TK' <?= ($statusreturn == 'TK') ? 'selected' : '' ?>>Tidak Dikembalikan</option>
                                                    <option value='K' <?= ($statusreturn == 'K') ? 'selected' : '' ?>>Dikembalikan XIA</option>
                                                    <option value='R' <?= ($statusreturn == 'R') ? 'selected' : '' ?>>Diterima GED</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Date range:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control input-sm pull-right" id="rangedate" name="rangedate" value="<?= ($rangedate) ? $rangedate : '' ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="submit" name="find" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Cari Data</button>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <!-- <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='configuration/config_exportimei'"><i class="fa fa-file-excel-o"></i> Excel</button> -->
                                                <button type="button" class="btn btn-success btn-sm" id="exportexcelimei"><i class="fa fa-file-excel-o"></i> Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Data IMEI & SN <span class="label label-default"><?php echo $totaldata; ?></span>
                                </h3>
                            </div>
                            <div class="box-body table-responsive" role="grid">
                                <table class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr style="font-size: smaller;">
                                            <th>No</th>
                                            <th>SKU</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Nota</th>
                                            <th>IMEI & SN</th>
                                            <th>AWB</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                        if ($produk) {
                                            switch ($status) {
                                                case 'G':
                                                    $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_masuk desc";
                                                    break;
                                                case 'TK':
                                                    $where = "a.sku = 'SK" . $produk . "' and a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_keluar desc";
                                                    break;
                                                case 'K':
                                                    $where = "a.sku = 'SK" . $produk . "' and a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_return desc";
                                                    break;
                                                case 'R':
                                                    $where = "a.sku = 'SK" . $produk . "' and a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_return_ged desc";
                                                    break;
                                                default:
                                                    $where = "a.sku = 'SK" . $produk . "' and a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
                                                    $orderby = "order by a.tgl_masuk desc";
                                            }
                                        } else {
                                            switch ($status) {
                                                case 'G':
                                                    $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_masuk desc";
                                                    break;
                                                case 'TK':
                                                    $where = "a.tgl_keluar >= '" . $date1 . "' and a.tgl_keluar <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_keluar desc";
                                                    break;
                                                case 'K':
                                                    $where = "a.tgl_return >= '" . $date1 . "' and a.tgl_return <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_return desc";
                                                    break;
                                                case 'R':
                                                    $where = "a.tgl_return_ged >= '" . $date1 . "' and a.tgl_return_ged <= '" . $date2 . "' and a.status_return = '" . $status . "'";
                                                    $orderby = "order by a.tgl_return_ged desc";
                                                    break;
                                                default:
                                                    $where = "a.tgl_masuk >= '" . $date1 . "' and a.tgl_masuk <= '" . $date2 . "'";
                                                    $orderby = "order by a.tgl_masuk desc";
                                            }
                                        }

                                        $sql    = "SELECT a.sku, b.nama, DATE_FORMAT(a.tgl_masuk,'%d %M %Y') AS tgl_masuk,
                                                DATE_FORMAT(a.tgl_keluar,'%d %M %Y') AS tgl_keluar,
                                                DATE_FORMAT(a.tgl_return,'%d %M %Y') AS tgl_return,
                                                DATE_FORMAT(a.tgl_return_ged,'%d %M %Y') AS tgl_return_ged,
                                                a.nota_masuk,a.nota_keluar,a.imei1,a.imei2,a.sn,a.status_return,c.awb 
                                                FROM $forward a 
                                                LEFT JOIN barang b ON a.sku = b.sku 
                                                LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
                                                WHERE
                                                $where
                                                $orderby";
                                        $result = mysqli_query($conn, $sql);
                                        $rpp    = 4;
                                        $reload = "$halaman" . "?pagination=true";
                                        $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

                                        if ($page <= 0)
                                            $page = 1;
                                        $tcount  = mysqli_num_rows($result);
                                        $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
                                        $count   = 0;
                                        $i       = ($page - 1) * $rpp;
                                        $no_urut = ($page - 1) * $rpp;

                                        while (($count < $rpp) && ($i < $tcount)) {
                                            mysqli_data_seek($result, $i);
                                            $fill = mysqli_fetch_array($result);
                                    ?>
                                            <tbody>
                                                <tr style="font-size: smaller;">
                                                    <td><?php echo ++$no_urut; ?></td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                                                    <td>Masuk GED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_masuk']); ?><br>
                                                        Keluar GED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_keluar']); ?><br>
                                                        Return XIA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_return']); ?><br>
                                                        Receive GED &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_return_ged']); ?>
                                                    </td>
                                                    <td>Masuk : <?php echo mysqli_real_escape_string($conn, $fill['nota_masuk']); ?><br>
                                                        Keluar : <?php echo mysqli_real_escape_string($conn, $fill['nota_keluar']); ?>
                                                    </td>
                                                    <td>IMEI 1 : <?php echo mysqli_real_escape_string($conn, $fill['imei1']); ?><br>
                                                        IMEI 2 : <?php echo mysqli_real_escape_string($conn, $fill['imei2']); ?><br>
                                                        SN : <?php echo mysqli_real_escape_string($conn, $fill['sn']); ?>
                                                    </td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                                                    <td><?php
                                                        if ($fill['status_return'] == "TK") { ?>
                                                            <span class="label label-success">Tidak Dikembalikan</span>
                                                        <?php } else if ($fill['status_return'] == "K") { ?>
                                                            <span class="label label-warning">Dikembalikan</span>
                                                        <?php } else if ($fill['status_return'] == "R") { ?>
                                                            <span class="label label-primary">Diterima</span>
                                                        <?php } else { ?>
                                                            <span class="label label-info">Digudang</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr> <?php
                                                        $i++;
                                                        $count++;
                                                    }

                                                        ?>
                                            </tbody>
                                </table>
                                <div align="right"><?php if ($tcount >= $rpp) {
                                                        echo paginate_one($reload, $page, $tpages);
                                                    } else {
                                                    } ?></div>
                                <?php
                                    } else {
                                        error_reporting(E_ALL ^ E_DEPRECATED);
                                        $sql    = "SELECT a.sku, b.nama, DATE_FORMAT(a.tgl_masuk,'%d %M %Y') AS tgl_masuk,
                                        DATE_FORMAT(a.tgl_keluar,'%d %M %Y') AS tgl_keluar,
                                        DATE_FORMAT(a.tgl_return,'%d %M %Y') AS tgl_return,
                                        DATE_FORMAT(a.tgl_return_ged,'%d %M %Y') AS tgl_return_ged,
                                        a.nota_masuk,a.nota_keluar,a.imei1,a.imei2,a.sn,a.status_return,c.awb 
                                        FROM $forward a 
                                        LEFT JOIN barang b ON a.sku = b.sku 
                                        LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
                                        ORDER BY a.tgl_keluar DESC;";
                                        $result = mysqli_query($conn, $sql);
                                        $rpp    = 4;
                                        $reload = "$halaman" . "?pagination=true";
                                        $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

                                        if ($page <= 0)
                                            $page = 1;
                                        $tcount  = mysqli_num_rows($result);
                                        $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
                                        $count   = 0;
                                        $i       = ($page - 1) * $rpp;
                                        $no_urut = ($page - 1) * $rpp;
                                        while (($count < $rpp) && ($i < $tcount)) {
                                            mysqli_data_seek($result, $i);
                                            $fill = mysqli_fetch_array($result);
                                ?>
                                    <tbody>
                                        <tr style="font-size: smaller;">
                                            <td><?php echo ++$no_urut; ?></td>
                                            <td><?php echo mysqli_real_escape_string($conn, $fill['sku']); ?></td>
                                            <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                                            <td>Masuk GED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_masuk']); ?><br>
                                                Keluar GED&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_keluar']); ?><br>
                                                Return XIA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_return']); ?><br>
                                                Receive GED &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo mysqli_real_escape_string($conn, $fill['tgl_return_ged']); ?>
                                            </td>
                                            <td>Masuk : <?php echo mysqli_real_escape_string($conn, $fill['nota_masuk']); ?><br>
                                                Keluar : <?php echo mysqli_real_escape_string($conn, $fill['nota_keluar']); ?>
                                            </td>
                                            <td>IMEI 1 : <?php echo mysqli_real_escape_string($conn, $fill['imei1']); ?><br>
                                                IMEI 2 : <?php echo mysqli_real_escape_string($conn, $fill['imei2']); ?><br>
                                                SN : <?php echo mysqli_real_escape_string($conn, $fill['sn']); ?>
                                            </td>
                                            <td><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                                            <td><?php
                                                if ($fill['status_return'] == "TK") { ?>
                                                    <span class="label label-success">Tidak Dikembalikan</span>
                                                <?php } else if ($fill['status_return'] == "K") { ?>
                                                    <span class="label label-warning">Dikembalikan</span>
                                                <?php } else if ($fill['status_return'] == "R") { ?>
                                                    <span class="label label-primary">Diterima</span>
                                                <?php } else { ?>
                                                    <span class="label label-info">Digudang</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php
                                            $i++;
                                            $count++;
                                        }

                                    ?>
                                    </tbody>
                                    </table>
                                    <div align="right"><?php if ($tcount >= $rpp) {
                                                            echo paginate_one($reload, $page, $tpages);
                                                        } else {
                                                        } ?></div>
                                <?php } ?>

                            </div>
                            <!-- /.box-body -->
                        </div>

                    <?php } else {
                    } ?>
                </div>
                <!-- ./col -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php footer(); ?>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="libs/1.11.4-jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="dist/plugins/morris/morris.min.js"></script>
<script src="dist/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="dist/plugins/knob/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="dist/plugins/daterangepicker/daterangepicker.js"></script>
<script src="dist/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/js/app.min.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
    $(".select2").select2();

    //Date range picker
    $('#rangedate').daterangepicker();
    $("#exportexcelimei").click(function() {
        var produk = $('#produk').val();
        var status = $('#status').val();
        var rangedate = $('#rangedate').val().split("-");
        var date1 = rangedate[0].trim();
        var date2 = rangedate[1].trim();
        // console.log(date2);
        window.location.href = 'configuration/config_exportimei?produk=' + produk + '&status=' + status + '&date1=' + date1 + '&date2=' + date2;
    });
</script>
</body>

</html>