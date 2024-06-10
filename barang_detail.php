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
  <style>
    .select2-container--default .select2-selection--single {
      background-color: #fff;
      box-shadow: none;
      border-color: #d2d6de;
      border-radius: 0;
    }

    .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 30px;
      user-select: none;
      -webkit-user-select: none
    }

    .select2-container--default .select2-selection--single,
    .select2-selection .select2-selection--single {
      border: 1px solid #d2d6de;
      border-radius: 0;
      padding: 6px 6px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #444;
      line-height: 25px;
      font-size: 12px;
    }

    .select2-dropdown {
      background-color: white;
      /* border:1px solid #aaa; */
      border-radius: 0;
      box-sizing: border-box;
      display: block;
      position: absolute;
      left: -100000px;
      width: 100%;
      z-index: 1051;
      font-size: 12px;
    }


    .content-imei {
      overflow-y: auto;
      /* make the table scrollable if height is more than 200 px  */
      height: 200px;
      /* gives an initial height of 200px to the table */
    }

    .content-imei thead th {
      position: sticky;
      /* make the table heads sticky */
      top: 0px;
      /* table head will be placed from the top of the table and sticks to it */
    }

    .content-imei-sn {
      overflow-y: auto;
      /* make the table scrollable if height is more than 200 px  */
      height: 350px;
      /* gives an initial height of 200px to the table */
    }

    .content-imei-sn thead th {
      position: sticky;
      /* make the table heads sticky */
      top: 0px;
      /* table head will be placed from the top of the table and sticks to it */
    }

    table {
      border-collapse: collapse;
      /* make the table borders collapse to each other */
      width: 100%;
    }

    th,
    td {
      padding: 8px 16px;
      border: 1px solid #ccc;
    }

    th {
      background: #eee;
    }

    .modal-dialog {
      overflow-y: initial !important
    }

    .modal-body {
      max-height: calc(100vh - 200px);
      overflow-y: auto;
    }
  </style>
  <div class="content-wrapper">
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- ./col -->

          <!-- SETTING START-->

          <?php
          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
          include "configuration/config_chmod.php";
          $halaman = "barang_detail"; // halaman
          $dataapa = "Barang"; // data
          $tabeldatabase = "barang"; // tabel database
          $chmod = $chmenu4; // Hak akses Menu
          $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
          $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
          $search = $_POST['search'];
          $insert = $_POST['insert'];


          $no = $_GET['no'];
          $divisi = $_GET['divisi'];
          if ($divisi) {
            $divisiselectedperid = 'selected="selected"';
            $divisiselectedall = '';
            if ($divisi == 13) {
              $wdivisi = "AND b.id_divisi IS NULL";
            } else {
              $wdivisi = "AND b.id_divisi = {$divisi}";
            }
          } else {
            $divisiselectedperid = '';
            $divisiselectedall = 'selected="selected"';
            $wdivisi = "";
          }

          $sql = "SELECT * from $tabeldatabase where no = '$no' ";
          $query = mysqli_query($conn, $sql);
          $data = mysqli_fetch_assoc($query);
          $avatar = $data['avatar'];
          if ($avatar == "dist/upload/") {
            $avatar = "dist/upload/index.jpg";
          } else {
            $avatar = $data['avatar'];
          }

          $nama = $data['nama'];
          $hargabeli = $data['hargabeli'];
          $hargajual = $data['hargajual'];
          $keterangan = $data['keterangan'];
          $kategori = $data['kategori'];
          $brand = $data['brand'];
          $barcode = $data['barcode'];
          $terjual = $data['terjual'];
          $terbeli = $data['terbeli'];
          $sisa = $data['sisa'];
          $kode = $data['kode'];
          $sku = $data['sku'];
          $p = $data['p'];
          $l = $data['l'];
          $t = $data['t'];
          $cbm = (($p * $l * $t) / 1000000) * $sisa;

          function custom_echo($x, $length)
          {
            if (strlen($x) <= $length) {
              echo $x;
            } else {
              $y = substr($x, 0, $length) . '...';
              echo $y;
            }
          }
          ?>
          <!-- SETTING STOP -->


          <!-- BREADCRUMB -->
          <ol class="breadcrumb ">
            <li><a href="<?php echo $_SESSION['baseurl']; ?>">Dashboard </a></li>
            <li><a href="<?php echo $halaman; ?>"><?php echo $dataapa ?></a></li>
            <?php

            if ($search != null || $search != "") {
            ?>
              <li> <a href="<?php echo $halaman; ?>">Data <?php echo $dataapa ?></a></li>
              <li class="active"><?php
                                  echo $search;
                                  ?></li>
            <?php
            } else {
            ?>
              <li class="active">Data <?php echo $dataapa ?></li>
            <?php
            }
            ?>
          </ol>

          <!-- BREADCRUMB -->

          <!-- BOX INSERT BERHASIL -->

          <script>
            window.setTimeout(function() {
              $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
                $(this).remove();
              });
            }, 5000);
          </script>


          <!-- BOX INFORMASI -->
          <?php
          if ($chmod >= 2 || $_SESSION['jabatan'] == 'admin' || $_SESSION['jabatan'] == 'xiaomi') {
          ?>

            <!-- KONTEN BODY AWAL -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h4 class="box-title" style="float: left;">Detail | Kode Barang:#<?php echo $kode; ?></h4>
                <div class="col-sm-3">
                  <select class="form-control select2 select2-hidden-accessible" onchange="window.location.href = this.value;" id="divisi" name="divisi" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option <?= $divisiselectedall ?> value="barang_detail?no=<?php echo $no; ?>">- Semua Divisi -</option>
                    <?php
                    $sql = mysqli_query($conn, "
                    SELECT IFNULL(b.id_divisi,13) AS id, IFNULL(c.divisi,'General') AS divisi
                    FROM stok_masuk_daftar a 
                    LEFT JOIN so_num b ON a.nota = b.nota
                    LEFT JOIN divisi c ON b.id_divisi = c.id
                    WHERE a.kode_barang = '{$kode}' GROUP BY b.id_divisi");
                    while ($row = mysqli_fetch_assoc($sql)) {
                      if ($divisi == $row['id']) {
                        echo "<option " . $divisiselectedperid . " value='barang_detail?no=" . $no . "&divisi=" . $row['id'] . "'>" . $row['divisi'] . "</option>";
                      } else {
                        echo "<option value='barang_detail?no=" . $no . "&divisi=" . $row['id'] . "'>" . $row['divisi'] . "</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- /.box-header -->

              <div class="box-body">
                <div class="table-responsive">
                  <!----------------KONTEN------------------->
                  <?php

                  ?>
                  <div id="main">
                    <div class="container-fluid">

                      <div class="box-body col-md-3">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                          <div class="box-body box-profile">
                            <img class="img-responsive" src="<?php echo $avatar; ?>" width="250" alt="User profile picture">

                            <h3 class="profile-username text-center" style="font-size: large;"><?php custom_echo($nama, 15); ?></h3>

                            <p class="text-muted text-center" style="font-size: smaller;"><?php custom_echo($brand, 15); ?></p>

                            <ul class="list-group list-group-unbordered">
                              <li class="list-group-item">
                                <b style="font-size: smaller;">Stok keluar</b> <a class="pull-right" style="font-size: smaller;"><?php echo $terjual; ?></a>
                              </li>
                              <li class="list-group-item">
                                <b style="font-size: smaller;">Stok Masuk</b> <a class="pull-right" style="font-size: smaller;"><?php echo $terbeli; ?></a>
                              </li>
                              <li class="list-group-item">
                                <b style="font-size: smaller;">Stok Available</b> <a class="pull-right" style="font-size: smaller;"><?php echo $sisa; ?></a>
                              </li>
                            </ul>
                            <?php
                            if ($_SESSION['jabatan'] == 'xiaomi') {
                            } else {
                            ?>
                              <!-- <a href="stok_sesuaikan" class="btn btn-sm btn-primary btn-block" disabled readonly><b>Penyesuaian Stok</b></a> -->
                            <?php
                            }
                            ?>

                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>

                      <div class="box-body col-md-1">
                      </div>

                      <div class="box-body col-md-8">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="box box-danger">
                              <div class="box-header with-border">

                                <form>
                                  <div class="row">

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">SKU</label>
                                        <div class="input-group">
                                          <input type="text" class="form-control input-sm" placeholder="No SKU..." readonly="readonly" value="<?php echo $sku; ?>">
                                          <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default-check-imei"><strong>Check IMEI/SN</strong></button>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Nama Produk</label>
                                        <input type="text" class="form-control input-sm" placeholder="Nama Produk..." readonly="readonly" value="<?php echo $nama; ?>">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Barcode</label>
                                        <?php
                                        if ($_SESSION['jabatan'] == 'xiaomi') {
                                        ?>
                                          <input type="text" class="form-control input-sm " placeholder="Barcode Barang..." readonly="readonly" value="<?php echo $barcode; ?>">
                                        <?php
                                        } else {
                                        ?>
                                          <div class="input-group">
                                            <input type="text" class="form-control input-sm " placeholder="Barcode Barang..." readonly="readonly" value="<?php echo $barcode; ?>">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-sm btn-danger" onclick="window.open('cetak_barcode?kode=<?php echo $kode; ?>')"><strong>Cetak Barcode</strong></button>
                                            </div>
                                          </div>
                                        <?php
                                        }
                                        ?>
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Merek</label>
                                        <input type="text" class="form-control input-sm " placeholder="Merek..." readonly="readonly" value="<?php echo $data['brand']; ?>">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Kategori</label>
                                        <input type="text" class="form-control input-sm " placeholder="Kategori..." readonly="readonly" value="<?php echo $kategori; ?>">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Lokasi</label>
                                        <input type="text" class="form-control input-sm" placeholder="Lokasi Barang..." readonly="readonly" value="<?php echo $data['lokasi']; ?>">
                                      </div>

                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Satuan</label>
                                        <input type="text" class="form-control input-sm" placeholder="Satuan..." readonly="readonly" value="<?php echo $data['satuan']; ?>">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Tanggal Barang Masuk</label>
                                        <input type="text" class="form-control input-sm " placeholder="Tanggal Barang Masuk..." readonly="readonly" value="<?php echo $data['expired']; ?>">
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">P<span style="font-size:8px;">(Panjang)</span></label>
                                        <input type="text" class="form-control input-sm" placeholder="Panjang..." readonly="readonly" value="<?php echo $p; ?> cm">
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">L<span style="font-size:8px;">(Lebar)</span></label>
                                        <input type="text" class="form-control input-sm" placeholder="Lebar..." readonly="readonly" value="<?php echo $l; ?> cm">
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">T<span style="font-size:8px;">(Tinggi)</span></label>
                                        <input type="text" class="form-control input-sm" placeholder="Tinggi..." readonly="readonly" value="<?php echo $t; ?> cm">
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">CBM<span style="font-size:8px;">(Cubic Meter)</span></label>
                                        <input type="text" class="form-control input-sm" placeholder="Cubic Meter..." readonly="readonly" value="<?php echo round($cbm, 3); ?>">
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Keterangan</label>
                                        <textarea class="form-control input-sm" id="inputExperience" placeholder="Keterangan..." readonly="readonly"><?php echo $keterangan; ?></textarea>
                                      </div>
                                    </div>

                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- KONTEN BODY AKHIR -->
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>



            <div class="box-body col-md-12">
              <!-- Start Tabel Aktivitas  -->
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="box box-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Detail Aktivitas Barang | <?php echo $sku; ?></h3>
                      <!-- <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='configuration/config_exporttransbarangdetail?no=<?= $no; ?>'"><i class="fa fa-file-excel-o"></i> Export Excel Aktivitas</button> -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-success" fdprocessedid="jj4b5u"><i class="fa fa-file-excel-o"></i> Export Excel</button>
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" fdprocessedid="oqky4p" aria-expanded="false">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="configuration/config_exporttransbarangdetail?no=<?= $no; ?>&divisi=<?= $divisi; ?>" target="_blank"><i class="fa fa-file-excel-o"></i> Export All Aktivitas</a></li>
                          <li><a href="configuration/config_exportaktivitasstokmasuk?sk=<?= $sku; ?>&divisi=<?= $divisi; ?>" target="_blank"><i class="fa fa-file-excel-o"></i> Export Aktivitas Stok Masuk</a></li>
                          <li><a href="configuration/config_exportaktivitasstokkeluar?sk=<?= $sku; ?>&divisi=<?= $divisi; ?>" target="_blank"><i class="fa fa-file-excel-o"></i> Export Aktivitas Stok Keluar</a></li>
                          <li class="divider"></li>
                        </ul>
                      </div>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" fdprocessedid="k2ppy"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" fdprocessedid="4s1ijo"><i class="fa fa-times"></i></button>
                      </div>
                    </div>

                    <div class="box-body">
                      <?php
                      error_reporting(E_ALL ^ E_DEPRECATED);
                      $sql    = "
                      SELECT a.*,c.nama 
                      FROM mutasi a 
                      LEFT JOIN so_num b ON a.keterangan = b.nota
                      inner join barang c on a.kodebarang=c.kode 
                      WHERE a.kodebarang = '{$kode}' {$wdivisi} AND a.kegiatan = 'stok masuk'
                      union
                      SELECT a.*,c.nama  
                      FROM mutasi a 
                      LEFT JOIN stok_keluar_daftar b ON a.keterangan = b.nota
                      inner join barang c on a.kodebarang=c.kode
                      WHERE a.kodebarang = '{$kode}' {$wdivisi} AND a.kegiatan = 'stok keluar'
                      ORDER BY NO desc";
                      $result = mysqli_query($conn, $sql);
                      $rpp    = 5;
                      if ($divisi) {
                        $divisipage = "&divisi={$divisi}";
                      } else {
                        $divisipage = "";
                      }
                      $reload = "$halaman" . "?no=" . $no . "" . $divisipage . "&pagination=true";
                      $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

                      if ($page <= 0)
                        $page = 1;
                      $tcount  = mysqli_num_rows($result);
                      $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
                      $count   = 0;
                      $i       = ($page - 1) * $rpp;
                      $no_urut = ($page - 1) * $rpp;
                      ?>
                      <div class="table-responsive">
                        <table class="table no-margin">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Tanggal</th>
                              <th>User</th>
                              <th>Aktivitas</th>
                              <th>Barang</th>
                              <th>Jumlah</th>
                              <th>Stok</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <?php
                          while (($count < $rpp) && ($i < $tcount)) {
                            mysqli_data_seek($result, $i);
                            $fill = mysqli_fetch_array($result);
                          ?>
                            <tbody>
                              <tr>
                                <td><?php echo ++$no_urut; ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['namauser']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['kegiatan']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fill['sisa']); ?></td>
                                <td>
                                  <?php
                                  if ($fill['kegiatan'] == 'stok masuk') {
                                  ?>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-default<?php echo $fill['keterangan']; ?>">Detail Masuk</button>
                                    <div class="modal fade" id="modal-default<?php echo $fill['keterangan']; ?>">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"> Detail Transaksi Barang Masuk : <?php echo $fill['keterangan']; ?></h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="box-body">
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Detail Barang Masuk :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th>No. SO</th>
                                                      <th>Divisi</th>
                                                      <th>User Request</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $quersoget = "
                                                    SELECT a.no_so, b.divisi, a.user_request 
                                                    FROM so_num a
                                                    LEFT JOIN divisi b on a.id_divisi = b.id  
                                                    WHERE a.nota='{$fill['keterangan']}' limit 1";
                                                    $datasoget = mysqli_query($conn, $quersoget);
                                                    $countdatasoget  = mysqli_num_rows($datasoget);
                                                    if ($countdatasoget > 0) {
                                                      while ($fillso = mysqli_fetch_assoc($datasoget)) {
                                                    ?>
                                                        <tr bgcolor="white">
                                                          <td><?php echo mysqli_real_escape_string($conn, $fillso['no_so']); ?></td>
                                                          <td><?php echo mysqli_real_escape_string($conn, $fillso['divisi']); ?></td>
                                                          <td><?php echo mysqli_real_escape_string($conn, $fillso['user_request']); ?></td>
                                                        </tr>
                                                      <?php }
                                                    } else {
                                                      ?>
                                                      <tr bgcolor="white">
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                      </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Total Barang :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th style="width:10px">No</th>
                                                      <th style="width:100px">Code Barang</th>
                                                      <th>Nama Barang</th>
                                                      <th style="text-align: center;">Jumlah</th>
                                                      <th style="text-align: center;">Satuan</th>
                                                      <th style="text-align: center;">Divisi</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $notaa = $fill['keterangan'];
                                                    $querya = "
                                                    SELECT a.*,IFNULL(c.divisi,'General') as divisi FROM stok_masuk_daftar a
                                                    LEFT JOIN so_num b on a.nota = b.nota
                                                    LEFT JOIN divisi c on c.id = b.id_divisi
                                                    WHERE a.nota='$notaa' order by a.no";
                                                    $hasila = mysqli_query($conn, $querya);
                                                    $no_uruta = 0;
                                                    while ($filla = mysqli_fetch_assoc($hasila)) {
                                                    ?>
                                                      <tr bgcolor="white">
                                                        <td style="text-align: center;"><?php echo ++$no_uruta; ?></td>
                                                        <td>SK<?php echo mysqli_real_escape_string($conn, $filla['kode_barang']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $filla['nama']); ?></td>
                                                        <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $filla['jumlah']); ?></td>
                                                        <td style="text-align: center;"><?php $cba = $filla['kode_barang'];
                                                                                        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT satuan FROM barang WHERE kode='$cba'"));
                                                                                        echo mysqli_real_escape_string($conn, $r['satuan']); ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $filla['divisi']); ?></td>
                                                      </tr>
                                                    <?php } ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                            <div class="box-body">
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Detail Barang :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th style="width:10px">No</th>
                                                      <th>Nama Barang</th>
                                                      <th>IMEI 1</th>
                                                      <th>IMEI 2</th>
                                                      <th>SN</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $notab = $fill['keterangan'];
                                                    $queryb = "
                                                    SELECT a.sku, b.nama, a.imei1, a.imei2, a.sn, b.satuan 
                                                    FROM imei a 
                                                    LEFT JOIN barang b ON a.sku = b.sku
                                                    WHERE a.nota_masuk = '$notab' order by a.sku";
                                                    $hasilb = mysqli_query($conn, $queryb);
                                                    $no_urutb = 0;
                                                    while ($fillb = mysqli_fetch_assoc($hasilb)) {
                                                    ?>
                                                      <tr bgcolor="white">
                                                        <td align="center"><?php echo ++$no_urutb; ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['nama']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['imei1']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['imei2']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['sn']); ?></td>
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
                                  <?php
                                  } else if ($fill['kegiatan'] == 'stok keluar') {
                                  ?>
                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-default<?php echo $fill['keterangan']; ?>">Detail Keluar</button>
                                    <div class="modal fade" id="modal-default<?php echo $fill['keterangan']; ?>">
                                      <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"> Detail Transaksi Barang Keluar : <?php echo $fill['keterangan']; ?></h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="box-body">
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Informasi Barang Keluar :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th style="text-align: center; width:150px;">No. Transaksi</th>
                                                      <th style="text-align: center; width:150px;">No. Airway Bill</th>
                                                      <th style="text-align: center; width:100px;">No. IRF</th>
                                                      <th style="text-align: center; width:150px;">Tanggal Input</th>
                                                      <th>Keterangan</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $notainfo = $fill['keterangan'];
                                                    $querinfo = "SELECT nota,DATE_FORMAT(tgl,'%d %M %Y') as tgl,keterangan,awb,IFNULL(no_irf,'-') as no_irf 
                                                    FROM stok_keluar WHERE nota='$notainfo' order by no";
                                                    $hasilinfo = mysqli_query($conn, $querinfo);
                                                    $rowinfo = mysqli_fetch_assoc($hasilinfo);
                                                    ?>
                                                    <tr bgcolor="white">
                                                      <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $rowinfo['nota']); ?></td>
                                                      <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $rowinfo['awb']); ?></td>
                                                      <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $rowinfo['no_irf']); ?></td>
                                                      <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $rowinfo['tgl']); ?></td>
                                                      <td><?php echo mysqli_real_escape_string($conn, $rowinfo['keterangan']); ?></td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                            <div class="box-body">
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Total Barang :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th style="width:10px">No</th>
                                                      <th style="width:100px">Code Barang</th>
                                                      <th>Nama Barang</th>
                                                      <th style="text-align: center;">Jumlah</th>
                                                      <th style="text-align: center;">Satuan</th>
                                                      <th style="text-align: center;">Divisi</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $notaa = $fill['keterangan'];
                                                    $querya = "
                                                    SELECT a.*,IFNULL(b.divisi,'General') as divisi FROM stok_keluar_daftar a
                                                    left join divisi b on b.id = id_divisi
                                                    WHERE a.nota='$notaa' order by a.no";
                                                    $hasila = mysqli_query($conn, $querya);
                                                    $no_uruta = 0;
                                                    while ($filla = mysqli_fetch_assoc($hasila)) {
                                                    ?>
                                                      <tr bgcolor="white">
                                                        <td style="text-align: center;"><?php echo ++$no_uruta; ?></td>
                                                        <td>SK<?php echo mysqli_real_escape_string($conn, $filla['kode_barang']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $filla['nama']); ?></td>
                                                        <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $filla['jumlah']); ?></td>
                                                        <td style="text-align: center;"><?php $cba = $filla['kode_barang'];
                                                                                        $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT satuan FROM barang WHERE kode='$cba'"));
                                                                                        echo mysqli_real_escape_string($conn, $r['satuan']); ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $filla['divisi']); ?></td>
                                                      </tr>
                                                    <?php } ?>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                            <div class="box-body">
                                              <div class="box-body table-responsive" style="max-height: 240px;">
                                                <p>Detail Barang :</p>
                                                <table class="data table table-hover table-bordered" id="tableimei">
                                                  <thead style="top:0;position:sticky; background-color:#e7e9ed">
                                                    <tr>
                                                      <th style="width:10px">No</th>
                                                      <th>Nama Barang</th>
                                                      <th>IMEI 1</th>
                                                      <th>IMEI 2</th>
                                                      <th>SN</th>
                                                      <th style="text-align: center;">Status</th>
                                                      <th style="text-align: center;">Tanggal</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    <?php
                                                    $notab = $fill['keterangan'];
                                                    $queryb = "
                                                    SELECT a.sku, b.nama, a.imei1, a.imei2, a.sn, b.satuan,
                                                    case when a.status_return = 'TK' then 'Tidak Dikembalikan' else 'Dikembalikan' end as status_return,
                                                    case when a.tgl_return = '0000-00-00' then '-' else DATE_FORMAT(a.tgl_return,'%d %M %Y') end as tgl_return
                                                    FROM imei a 
                                                    LEFT JOIN barang b ON a.sku = b.sku
                                                    WHERE a.nota_keluar = '$notab' order by a.sku,a.tgl_return desc";
                                                    $hasilb = mysqli_query($conn, $queryb);
                                                    $no_urutb = 0;
                                                    while ($fillb = mysqli_fetch_assoc($hasilb)) {
                                                    ?>
                                                      <tr bgcolor="white">
                                                        <td align="center"><?php echo ++$no_urutb; ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['nama']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['imei1']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['imei2']); ?></td>
                                                        <td><?php echo mysqli_real_escape_string($conn, $fillb['sn']); ?></td>
                                                        <td align="center"><?php echo mysqli_real_escape_string($conn, $fillb['status_return']); ?></td>
                                                        <td align="center"><?php echo mysqli_real_escape_string($conn, $fillb['tgl_return']); ?></td>
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
                                  <?php
                                  } else {
                                  ?>
                                    -
                                  <?php
                                  }
                                  ?>
                                </td>
                              </tr>
                            </tbody>
                          <?php
                            $i++;
                            $count++;
                          }
                          ?>


                        </table>
                        <div align="right"><?php if ($tcount >= $rpp) {
                                              echo paginate_one($reload, $page, $tpages);
                                            } else {
                                            } ?></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Table Aktivitas -->

              <!-- Start Modal Barang Retur -->
              <div class="modal fade" id="modal-default-check-imei">
                <div class="modal-dialog modal-lg" style="width:90%">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"> <strong><i>Detail IMEI & SN (<?php echo $sku; ?>) : </i></strong></h4>
                    </div>
                    <div class="modal-body">
                      <button type="button" class="btn btn-success btn-sm" onclick="window.location.href='configuration/config_exportlistimeisnsk?sk=<?= $sku; ?>&divisi=<?= $divisi; ?>'"><i class="fa fa-file-excel-o"></i> Export Excel IMEI & SN</button>
                      <div class="box-body table-responsive content-imei-sn">
                        <table class="table no-margin" id="tableimei">
                          <thead>
                            <tr>
                              <th style="width:10px">No</th>
                              <th>SKU</th>
                              <th>No-SO</th>
                              <th>No-IRF</th>
                              <th>IMEI-1</th>
                              <th>IMEI-2</th>
                              <th>SN</th>
                              <th>Masuk</th>
                              <th>Keluar</th>
                              <th>Status</th>
                              <th>Divisi</th>
                            </tr>
                          </thead>
                          <?php

                          $sqlmasuk = "
                          SELECT COUNT(a.tgl_masuk) AS totalmasuk
                          FROM dbwr_xiaomi_ga.imei a 
                          LEFT JOIN so_num  b on a.nota_masuk = b.nota
                          WHERE a.sku = '{$sku}' AND a.nota_masuk IS NOT NULL {$wdivisi}";
                          $sqlkeluar = "
                          SELECT COUNT(a.tgl_keluar) AS totalkeluar
                          FROM dbwr_xiaomi_ga.imei a 
                          LEFT JOIN so_num  b on a.nota_masuk = b.nota
                          WHERE a.sku = '{$sku}' AND a.nota_masuk IS NOT NULL {$wdivisi}";
                          $resultmasuk = mysqli_query($conn, $sqlmasuk);
                          $resultkeluar = mysqli_query($conn, $sqlkeluar);
                          $valuemasuk = $resultmasuk->fetch_row()[0] ?? 0;
                          $valuekeluar = $resultkeluar->fetch_row()[0] ?? 0;
                          $valuetersedia = ($valuemasuk - $valuekeluar);
                          ?>
                          <tfoot style="bottom:0;position:sticky; ">
                            <tr style="background:#e7e9ed;">
                              <td colspan="10" style="text-align: right; vertical-align:middle; background:#e7e9ed; "><strong>Stok Masuk : </strong></td>
                              <td style="text-align: left; vertical-align:middle; background:#e7e9ed; "><strong><?= $valuemasuk ?></strong></td>
                            </tr>
                            <tr style="background:#e7e9ed;">
                              <td colspan="10" style="text-align: right; vertical-align:middle; background:#e7e9ed; "><strong>Stok Keluar : </strong></td>
                              <td style="text-align: left; vertical-align:middle; background:#e7e9ed; "><strong><?= $valuekeluar ?></strong></td>
                            </tr>
                            <tr style="background:#e7e9ed;">
                              <td colspan="10" style="text-align: right; vertical-align:middle; background:#e7e9ed; "><strong>Stok Tersedia : </strong></td>
                              <td style="text-align: left; vertical-align:middle; background:#e7e9ed; "><strong><?= $valuetersedia ?></strong></td>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php
                            $queryb = "
                            SELECT 
                            a.sku,
                            IFNULL(b.no_so,'-') AS no_so,
                            IFNULL(c.no_irf,'-') AS no_irf,
                            a.imei1,
                            a.imei2,
                            a.sn,
                            IFNULL(a.tgl_masuk,'-') AS masuk,
                            IFNULL(a.tgl_keluar,'-') AS keluar,
                            case when a.tgl_keluar IS NULL then 'Masuk'
                            ELSE 'Keluar' END AS status,
                            IFNULL(d.divisi,'General') AS divisi
                            FROM dbwr_xiaomi_ga.imei a 
                            LEFT JOIN so_num  b on a.nota_masuk = b.nota
                            LEFT JOIN stok_keluar c ON a.nota_keluar = c.nota
                            LEFT JOIN divisi d ON b.id_divisi = d.id
                            WHERE a.sku = '{$sku}' {$wdivisi} ORDER BY a.tgl_masuk ASC,b.no_so;";
                            $hasilb = mysqli_query($conn, $queryb);
                            $no_urutb = 0;
                            while ($fillb = mysqli_fetch_assoc($hasilb)) {
                            ?>

                              <tr bgcolor="white">
                                <td align="center"><?php echo ++$no_urutb; ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['sku']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['no_so']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['no_irf']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['imei1']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['imei2']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['sn']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['masuk']); ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['keluar']); ?></td>
                                <td><?php
                                    if ($fillb['status'] == 'Masuk') {
                                      echo '<span class="label label-success">' . mysqli_real_escape_string($conn, $fillb['status']) . '</span>';
                                    } else {
                                      echo '<span class="label label-danger">' . mysqli_real_escape_string($conn, $fillb['status']) . '</span>';
                                    }
                                    ?></td>
                                <td><?php echo mysqli_real_escape_string($conn, $fillb['divisi']); ?></td>
                              </tr>

                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Modal Barang Retur -->
            </div>
        </div>
        <!-- KONTEN BODY AKHIR -->
      </div>
  </div>

  <!-- /.box-body -->
</div>
</div>

<?php
          } else {
?>
  <div class="callout callout-danger">
    <h4>Info</h4>
    <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
  </div>
<?php
          }
?>
<!-- ./col -->
</div>

<!-- /.row -->
<!-- Main row -->
<div class="row">
  <!-- Left col -->
  <!-- /.Left col -->
</div>
<!-- /.row (main row) -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php footer(); ?>
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Script -->
<script src='jquery-3.1.1.min.js' type='text/javascript'></script>

<!-- jQuery UI -->
<link href='jquery-ui.min.css' rel='stylesheet' type='text/css'>
<script src='jquery-ui.min.js' type='text/javascript'></script>

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

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
<script src="dist/js/demo.js"></script>
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="dist/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="dist/plugins/fastclick/fastclick.js"></script>
<script src="dist/plugins/select2/select2.full.min.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="dist/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="dist/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/plugins/iCheck/icheck.min.js"></script>

<!--fungsi AUTO Complete-->
<!-- Script -->
<script type='text/javascript'>
  $(function() {

    $("#barcode").autocomplete({
      source: function(request, response) {

        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        $('#nama').val(ui.item.label);
        $('#barcode').val(ui.item.value); // display the selected text
        $('#hargajual').val(ui.item.hjual);
        $('#stok').val(ui.item.sisa); // display the selected text
        $('#hargabeli').val(ui.item.hbeli);
        $('#jumlah').val(ui.item.jumlah);
        $('#kode').val(ui.item.kode); // save selected id to input
        return false;

      }
    });

    // Multiple select
    $("#multi_autocomplete").autocomplete({
      source: function(request, response) {

        var searchText = extractLast(request.term);
        $.ajax({
          url: "server.php",
          type: 'post',
          dataType: "json",
          data: {
            search: searchText
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        var terms = split($('#multi_autocomplete').val());

        terms.pop();

        terms.push(ui.item.label);

        terms.push("");
        $('#multi_autocomplete').val(terms.join(", "));

        // Id
        var terms = split($('#selectuser_ids').val());

        terms.pop();

        terms.push(ui.item.value);

        terms.push("");
        $('#selectuser_ids').val(terms.join(", "));

        return false;
      }

    });
  });

  function split(val) {
    return val.split(/,\s*/);
  }

  function extractLast(term) {
    return split(term).pop();
  }
</script>

<!--AUTO Complete-->

<script>
  $(function() {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("yyyy-mm-dd", {
      "placeholder": "yyyy/mm/dd"
    });
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      format: 'YYYY/MM/DD h:mm A'
    });
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Hari Ini': [moment(), moment()],
          'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Akhir 7 Hari': [moment().subtract(6, 'days'), moment()],
          'Akhir 30 Hari': [moment().subtract(29, 'days'), moment()],
          'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
          'Akhir Bulan': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    $('.datepicker').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });

    //Date picker 2
    $('#datepicker2').datepicker('update', new Date());

    $('#datepicker2').datepicker({
      autoclose: true
    });

    $('.datepicker2').datepicker({
      dateFormat: 'yyyy-mm-dd'
    });


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
</body>

</html>