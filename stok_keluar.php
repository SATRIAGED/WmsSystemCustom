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
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- SETTING START-->

          <?php
          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
          include "configuration/config_chmod.php";
          $halaman = "stok_keluar"; // halaman
          $dataapa = "Barang Keluar"; // data
          $tabeldatabase = "stok_keluar"; // tabel database
          $chmod = $chmenu5; // Hak akses Menu
          $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
          $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
          $search = $_POST['search'];

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

          <!-- BOX HAPUS BERHASIL -->

          <script>
            window.setTimeout(function() {
              $("#myAlert").fadeTo(500, 0).slideUp(1000, function() {
                $(this).remove();
              });
            }, 5000);
          </script>

          <?php
          $hapusberhasil = $_POST['hapusberhasil'];

          if ($hapusberhasil == 1) {
          ?>
            <div id="myAlert" class="alert alert-success alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Berhasil!</strong> <?php echo $dataapa; ?> telah berhasil dihapus dari Data <?php echo $dataapa; ?>.
            </div>

            <!-- BOX HAPUS BERHASIL -->
          <?php
          } elseif ($hapusberhasil == 2) {
          ?>
            <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Gagal!</strong> <?php echo $dataapa; ?> tidak bisa dihapus dari Data <?php echo $dataapa; ?> karena telah melakukan transaksi sebelumnya, gunakan menu update untuk merubah informasi <?php echo $dataapa; ?> .
            </div>
          <?php
          } elseif ($hapusberhasil == 3) {
          ?>
            <div id="myAlert" class="alert alert-danger alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Gagal!</strong> Hanya user tertentu yang dapat mengupdate Data <?php echo $dataapa; ?> .
            </div>
          <?php
          }

          ?>
          <!-- BOX INFORMASI -->

          <?php
          if ($chmod == 5 || $_SESSION['jabatan'] == 'admin') {
          ?>

            <?php

            $sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
            $hasila = mysqli_query($conn, $sqla);
            $rowa = mysqli_fetch_assoc($hasila);
            $totaldata = $rowa['totaldata'];

            ?>

            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Data Barang Keluar <span class="label label-default"><?php echo $totaldata; ?></span>
                </h3> &nbsp; &nbsp;
                <a href="stok_out" class="btn btn-primary">Tambah</a>
                <form method="post">
                  <br />
                  <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control pull-right" placeholder="Cari">

                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>

                </form>


              </div>

              <!-- /.box-header -->
              <!-- /.Paginasi -->
              <?php
              error_reporting(E_ALL ^ E_DEPRECATED);
              $sql    = "select *,DATE_FORMAT(tgl,'%d %M %Y') as tglconv from $forward order by no desc";
              $result = mysqli_query($conn, $sql);
              $rpp    = 5;
              $reload = "$halaman" . "?pagination=true";
              $page   = intval(isset($_GET["page"]) ? $_GET["page"] : 0);

              if ($page <= 0)
                $page = 1;
              $tcount  = mysqli_num_rows($result);
              $tpages  = ($tcount) ? ceil($tcount / $rpp) : 1;
              $count   = 0;
              $i       = ($page - 1) * $rpp;
              $no_urut = ($page - 1) * $rpp;
              ?>
              <div class="box-body table-responsive">
                <table class="table table-hover ">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No.Trx</th>
                      <th>Tanggal</th>
                      <th>Airway Bill</th>
                      <th>No. IRF</th>
                      <th>File IRF</th>
                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                        <th>Opsi</th>
                      <?php } else {
                      } ?>
                    </tr>
                  </thead>
                  <?php
                  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                  $search = $_POST['search'];

                  if ($search != null || $search != "") {

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                      if (isset($_POST['search'])) {
                        $query1 = "SELECT *,DATE_FORMAT(tgl,'%d %M %Y') as tglconv FROM  $forward where 
                                   nota like '%$search%' 
                                   or UPPER(pelanggan) like UPPER('%$search%') 
                                   or awb like '%$search%'
                                   order by no limit $rpp";
                        $hasil = mysqli_query($conn, $query1);
                        $no = 1;
                        while ($fill = mysqli_fetch_assoc($hasil)) {
                  ?>
                          <tbody>
                            <tr>
                              <td><?php echo ++$no_urut; ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['tglconv']); ?></td>
                              <td><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                              <td><?php
                                  if ($fill['no_irf']) {
                                    echo mysqli_real_escape_string($conn, $fill['no_irf']);
                                  } else {
                                    echo '-';
                                  } ?></td>
                              <td><?php
                                  if ($fill['irf']) {
                                    echo mysqli_real_escape_string($conn, $fill['irf']);
                                  } else {
                                    echo '-';
                                  } ?></td>
                              <td>
                                <?php if ($fill['pelanggan'] == 'customer') { ?>

                                  <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                    <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='surat_buat?q=<?php echo $fill['nota']; ?>'">Buat|Cetak Surat</button>
                                  <?php } else {
                                  } ?>

                                <?php } ?>


                                <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                  <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='stok_masuk_batal?nota=<?php echo $fill['nota']; ?>'">BATAL</button>
                                <?php } else {
                                } ?>

                                <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-default<?php echo $fill['nota']; ?>">VIEW</button>
                                <div class="modal fade" id="modal-default<?php echo $fill['nota']; ?>">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Detail Transaksi Barang Keluar : <?php echo $fill['nota']; ?></h4>
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
                                                $notainfo = $fill['nota'];
                                                $querinfo = "SELECT nota,DATE_FORMAT(tgl,'%d %M %Y') as tgl,keterangan,awb,no_irf FROM stok_keluar WHERE nota='$notainfo' order by no";
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
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                $notaa = $fill['nota'];
                                                $querya = "SELECT * FROM stok_keluar_daftar WHERE nota='$notaa' order by no";
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
                                                  <th style="text-align: center;">Satuan</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php
                                                $notab = $fill['nota'];
                                                $queryb = "
                                                  SELECT a.sku, b.nama, a.imei1, a.imei2, b.satuan 
                                                  FROM imei a 
                                                  LEFT JOIN barang b ON a.sku = b.sku
                                                  WHERE a.nota_keluar = '$notab' order by a.sku";
                                                $hasilb = mysqli_query($conn, $queryb);
                                                $no_urutb = 0;
                                                while ($fillb = mysqli_fetch_assoc($hasilb)) {
                                                ?>

                                                  <tr bgcolor="white">
                                                    <td align="center"><?php echo ++$no_urutb; ?></td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fillb['nama']); ?></td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fillb['imei1']); ?></td>
                                                    <td><?php echo mysqli_real_escape_string($conn, $fillb['imei2']); ?></td>
                                                    <td align="center"><?php echo mysqli_real_escape_string($conn, $fillb['satuan']); ?></td>
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
                              </td>
                            </tr><?php
                                }

                                  ?>
                          </tbody>
                </table>
                <div align="right"><?php if ($tcount >= $rpp) {
                                      echo paginate_one($reload, $page, $tpages);
                                    } else {
                                    } ?></div>
              <?php
                      }
                    }
                  } else {
                    while (($count < $rpp) && ($i < $tcount)) {
                      mysqli_data_seek($result, $i);
                      $fill = mysqli_fetch_array($result);
              ?>
              <tbody>
                <tr>
                  <td><?php echo ++$no_urut; ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['nota']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['tglconv']); ?></td>
                  <td><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                  <td><?php
                      if ($fill['no_irf']) {
                        echo mysqli_real_escape_string($conn, $fill['no_irf']);
                      } else {
                        echo '-';
                      } ?></td>
                  <td>
                    <?php
                      if ($fill['irf']) {
                    ?>
                      <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-default2<?php echo $fill['nota']; ?>"><?php echo str_replace("dist/upload/irf/", "", mysqli_real_escape_string($conn, $fill['irf'])); ?></button>
                      <div class="modal fade" id="modal-default2<?php echo $fill['nota']; ?>">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title"> Gambar IRF : <?php echo $fill['nota']; ?></h4>
                            </div>
                            <div class="modal-body">
                              <div class="container-fluid">
                                <div class="row">
                                  <div class="col-md-12 ml-auto">
                                    <img class="img-responsive" src="<?php echo mysqli_real_escape_string($conn, $fill['irf']); ?>">
                                  </div>
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
                        echo '-';
                      }
                    ?>
                  </td>
                  <td>

                    <?php if ($fill['pelanggan'] == 'customer') { ?>


                      <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                        <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='surat_buat?q=<?php echo $fill['nota']; ?>'">Buat|Cetak Surat</button>
                      <?php } else {
                        } ?>

                    <?php } ?>


                    <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                      <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='stok_keluar_batal?nota=<?php echo $fill['nota']; ?>'">BATAL</button>
                    <?php } else {
                      } ?>


                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-default<?php echo $fill['nota']; ?>">VIEW</button>
                    <div class="modal fade" id="modal-default<?php echo $fill['nota']; ?>">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> Detail Transaksi Barang Keluar : <?php echo $fill['nota']; ?></h4>
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
                                    $notainfo = $fill['nota'];
                                    $querinfo = "SELECT nota,DATE_FORMAT(tgl,'%d %M %Y') as tgl,keterangan,awb,no_irf FROM stok_keluar WHERE nota='$notainfo' order by no";
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
                                    $notaa = $fill['nota'];
                                    $querya = "
                                    SELECT a.*,b.divisi FROM stok_keluar_daftar a
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
                                    $notab = $fill['nota'];
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
          ?>
            <div class="callout callout-danger">
              <h4>Info</h4>
              <b>Hanya user tertentu yang dapat mengakses halaman <?php echo $dataapa; ?> ini .</b>
            </div>
          <?php
          } ?>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
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