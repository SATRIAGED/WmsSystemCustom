<!DOCTYPE html>
<html>
<?php
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
include "configuration/config_connect.php";
encryption();
session();
connect();
head();
body();
timing();
//pagination();
?>
<?php
$decimal = "0";
$a_decimal = ",";
$thousand = ".";
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
    <!-- Content Header (Page header) -->
    <style>
      table {
        width: 100%;
      }

      .first {
        width: 50%;
      }

      .ellipsis {
        position: relative;
      }

      .ellipsis:before {
        content: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        visibility: hidden;
      }

      .ellipsis span {
        position: absolute;
        left: 0;
        right: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
    </style>
    <section class="content-header">
      <h1>
        Dashboard
        <small>V.01</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- SETTING START-->
      <div class="row">

        <?php
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING) );
        $halaman = "index"; // halaman
        $dataapa = "Dashboard"; // data
        $tabeldatabase = "index"; // tabel database
        $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
        $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
        //$search = $_POST['search'];
        ?>
      </div>
      <!-- SETTING STOP -->

      <!-- SETTING START HEADER CARD FIRST -->
      <div class="row">
        <?php
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $alert = $_GET['alert'];
        $sql1 = "SELECT url FROM backset";
        $hasil1 = mysqli_query($conn, $sql1);
        $row = mysqli_fetch_assoc($hasil1);
        $url = $row['url'];
        if ($alert == 1 && $url == '') {
        ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Peringatan!</h4>
            Url Aplikasi belum disesuaikan dengan url anda sekarang. Klik Tombol pengaturan dibawah untuk menyesuaikan dengan url dimana anda menggunakan aplikasi. <br>
            <button type="button" class="btn btn-success btn btn-xs" data-toggle="modal" data-target="#modal-default">
              Pengaturan
            </button>
          </div>
        <?php
        } else {
        ?>
          <!-- Start Card Barang All -->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-cubes"></i></span>
              <div class="info-box-content">
                <span style="font-size: small;">Jumlah Produk</span>
                <span class="info-box-number"><?php echo $datax3; ?></span>
                <a href="barang" class="small-box-footer link-info" style="font-size: small;">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- End Card Barang All -->

          <!-- Start Card Barang Stok Menipis all -->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-minus-square-o"></i></span>
              <div class="info-box-content">
                <span style="font-size: small;">Stok Barang Menipis <?php echo $alert; ?></span>
                <span class="info-box-number"><?php echo $datax4; ?></span>
                <a href="stok_menipis" class="small-box-footer link-info" style="font-size: small;">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- End Card Barang Stok Menipis All -->

          <!-- Start Card Barang Retur All -->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fa fa-eject"></i></span>
              <div class="info-box-content">
                <span style="font-size: small;">Barang Retur </span>
                <span class="info-box-number"><?php echo $datax5; ?></span>
                <a href="#" class="small-box-footer link-info" style="font-size: small;" data-toggle="modal" data-target="#modal-default">Info lengkap <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- End Card Barang Retur All -->

          <!-- Start Modal Barang Retur -->
          <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg" style="width:90%">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"> <strong><i>Detail Barang Yang Akan Di Return : </i></strong></h4>
                </div>
                <div class="modal-body">
                  <div class="box-body">
                    <div class="box-body table-responsive" style="max-height: 450px;">
                      <table class="data table table-hover table-bordered" id="tableimei">
                        <thead style="top:0;position:sticky; background-color:#e7e9ed">
                          <tr>
                            <th style="width:10px">No</th>
                            <th>SKU</th>
                            <th>Barang</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>SN</th>
                            <th>Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Return</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $queryb = "
                            SELECT 
                            a.sku,
                            b.nama, 
                            a.imei1, 
                            a.imei2, 
                            a.sn,
                            a.nota_masuk,
                            a.nota_keluar,
                            DATE_FORMAT(a.tgl_masuk,'%d %M %Y') AS tgl_masuk,
                            DATE_FORMAT(a.tgl_keluar,'%d %M %Y') AS tgl_keluar,
                            case when a.status_return = 'K' then 'Dikembalikan' ELSE 'Tidak Dikembalikan' END AS status_return,
                            DATE_FORMAT(a.tgl_return, '%d %M %Y') AS tgl_return  
                            FROM imei a 
                            LEFT JOIN barang b ON a.sku = b.sku
                            WHERE 
                            a.status_return IS NOT NULL AND
                            a.status_return = 'K' AND
                            ((DATEDIFF(a.tgl_return,date(NOW())) > 0) AND (DATEDIFF(a.tgl_return,DATE(NOW())) <= 3));";
                          $hasilb = mysqli_query($conn, $queryb);
                          $no_urutb = 0;
                          while ($fillb = mysqli_fetch_assoc($hasilb)) {
                          ?>

                            <tr bgcolor="white">
                              <td align="center"><?php echo ++$no_urutb; ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fillb['sku']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fillb['nama']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fillb['imei1']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fillb['imei2']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fillb['sn']); ?></td>
                              <td>Masuk : <?php echo mysqli_real_escape_string($conn, $fillb['nota_masuk']); ?><br>Keluar : <?php echo mysqli_real_escape_string($conn, $fillb['nota_masuk']); ?></td>
                              <td>Masuk : <?php echo mysqli_real_escape_string($conn, $fillb['tgl_masuk']); ?><br>Keluar : <?php echo mysqli_real_escape_string($conn, $fillb['tgl_keluar']); ?></td>
                              <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fillb['tgl_return']); ?></td>
                            </tr>

                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal Barang Retur -->
        <?php
        }
        ?>
      </div>
      <!-- SETTING STOP HEADER CARD FIRST -->

      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang Stok Terbanyak</h3>&nbsp;<span class="badge bg-aqua">dari #<?php echo $stok1; ?> di gudang...</span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" fdprocessedid="k2ppy"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" fdprocessedid="4s1ijo"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <?php
                    $mySql  = "SELECT no,sku,nama,sisa FROM barang ORDER BY sisa DESC LIMIT 5";
                    $myQry  = mysqli_query($conn, $mySql)  or die("Query  salah : " . mysqli_error());
                    $nomor  = 0;
                    ?>
                    <tr>
                      <th>SKU</th>
                      <th>Barang</th>
                      <th>Stok</th>
                      <th>Persentase</th>
                    </tr>
                  </thead>
                  <?php while ($kolomData = mysqli_fetch_array($myQry)) { ?>
                    <tbody>
                      <tr>
                        <td><a href="barang_detail?no=<?= $kolomData['no']; ?>"><?php echo $kolomData['sku']; ?></a></td>
                        <td class="ellipsis"><span><?php echo $kolomData['nama']; ?></span></td>
                        <td><?php echo $kolomData['sisa']; ?></td>
                        <td><span class="label label-info"><?php echo round((($kolomData['sisa'] / $stok1) * 100), 2); ?></span></td>
                      </tr>
                    </tbody>
                  <?php } ?>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">5 Barang Keluar Terbanyak</h3>&nbsp;<span class="badge bg-red">dari #<?php echo $stok2; ?> keluar...</span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" fdprocessedid="k2ppy"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" fdprocessedid="4s1ijo"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <?php
                    $mySql  = "SELECT no,sku,nama,terjual FROM barang ORDER BY terjual DESC LIMIT 5";
                    $myQry  = mysqli_query($conn, $mySql)  or die("Query  salah : " . mysqli_error());
                    $nomor  = 0;
                    ?>
                    <tr>
                      <th>SKU</th>
                      <th>Barang</th>
                      <th>Keluar</th>
                      <th>Persentase</th>
                    </tr>
                  </thead>
                  <?php while ($kolomData = mysqli_fetch_array($myQry)) { ?>
                    <tbody>
                      <tr>
                        <td><a href="barang_detail?no=<?= $kolomData['no']; ?>"><?php echo $kolomData['sku']; ?></a></td>
                        <td class="ellipsis"><span><?php echo $kolomData['nama']; ?></span></td>
                        <td><?php echo $kolomData['terjual']; ?></td>
                        <td><span class="label label-danger"><?php if (empty($kolomData['terjual'])) {
                                                                echo '0';
                                                              } else {
                                                                echo round((($kolomData['terjual'] / $stok2) * 100), 2);
                                                              } ?></span></td>
                      </tr>
                    </tbody>
                  <?php } ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Barang yang harus dikembalikan</h3>&nbsp;<span class="badge bg-yellow">3 hari sebelum tanggal kembali barang...</span>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" fdprocessedid="k2ppy"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" fdprocessedid="4s1ijo"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <?php
                    $mySql  = "SELECT 
                    a.sku,
                    b.nama, 
                    a.imei1, 
                    a.imei2,
                    a.sn,
                    DATE_FORMAT(a.tgl_keluar,'%d %M %Y') AS tgl_keluar,
                    DATE_FORMAT(a.tgl_return, '%d %M %Y') AS tgl_return,
                    case when a.status_return = 'K' then 'Dikembalikan' ELSE 'Tidak Dikembalikan' END AS status_return
                    FROM imei a 
                    LEFT JOIN barang b ON a.sku = b.sku
                    WHERE 
                    a.status_return IS NOT NULL AND
                    a.status_return = 'K' AND
                    ((DATEDIFF(a.tgl_return,date(NOW())) > 0) AND (DATEDIFF(a.tgl_return,DATE(NOW())) <= 3))
                    ORDER BY a.tgl_return ASC LIMIT 5;";
                    $myQry  = mysqli_query($conn, $mySql)  or die("Query  salah : " . mysqli_error());
                    $nomor  = 0;
                    ?>
                    <tr>
                      <th>SKU</th>
                      <th>Barang</th>
                      <th>IMEI 1</th>
                      <th>IMEI 2</th>
                      <th>SN</th>
                      <th>Keluar</th>
                      <th>Return</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <?php
                  $rowcount = mysqli_num_rows($myQry);
                  if ($rowcount > 0) {
                    while ($kolomData = mysqli_fetch_array($myQry)) { ?>
                      <tbody>
                        <tr>
                          <td><?php echo $kolomData['sku']; ?></td>
                          <td><?php echo $kolomData['nama']; ?></td>
                          <td><?php echo $kolomData['imei1']; ?></td>
                          <td><?php echo $kolomData['imei2']; ?></td>
                          <td><?php echo $kolomData['sn']; ?></td>
                          <td><?php echo $kolomData['tgl_keluar']; ?></td>
                          <td><?php echo $kolomData['tgl_return']; ?></td>
                          <td><span class="label label-warning"><?php echo $kolomData['status_return']; ?></span></td>
                        </tr>
                      </tbody>
                    <?php }
                  } else { ?>
                    <tbody>
                      <tr>
                        <td colspan="8" style="text-align: center;"><span class="label label-warning">-- No Data Available --</span></td>
                      </tr>
                    </tbody>
                  <?php
                  }
                  ?>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>








<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Url Aplikasi</h4>
      </div>

      <form method="post">
        <div class="modal-body">
          <p> Url Aplikasi adalah alamat domain website/subdomain atau bisa berupa folder di localhost yang anda ketika pada address bar browser anda untuk mengakses aplikasi. Saat ini Url aplikasi seperti digambar, anda perlu menggantinya dengan milik anda sendiri. <img src="dist/img/url.png"></p>
          <p>Anda wajib ganti URL Aplikasi agar bisa berjalan dengan baik</p>



          <div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Url Aplikasi Baru</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" name="url" placeholder="idwares.esy.es">
            </div>
          </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" name="save" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php


if (isset($_POST['save'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = mysqli_real_escape_string($conn, $_POST['url']);

    $sqlu = "UPDATE backset SET url='$url' ";
    $query = mysqli_query($conn, $sqlu);


    if ($query) {
      echo "<script type='text/javascript'>  alert('Berhasil, Url Aplikasi telah diubah!'); </script>";
      echo "<script type='text/javascript'>window.location = 'index';</script>";
    }
  }
}

?>


<!-- /.content-wrapper -->
<?php footer(); ?>
<div class="control-sidebar-bg"></div>
</div>
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
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>

</body>

</html>