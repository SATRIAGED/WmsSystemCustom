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
    #snackbar {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 999999;
      left: 50%;
      top: 30px;
      font-size: 17px;
    }

    #snackbar.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
      from {
        top: 0;
        opacity: 0;
      }

      to {
        top: 30px;
        opacity: 1;
      }
    }

    @keyframes fadein {
      from {
        top: 0;
        opacity: 0;
      }

      to {
        top: 30px;
        opacity: 1;
      }
    }

    @-webkit-keyframes fadeout {
      from {
        top: 30px;
        opacity: 1;
      }

      to {
        top: 0;
        opacity: 0;
      }
    }

    @keyframes fadeout {
      from {
        top: 30px;
        opacity: 1;
      }

      to {
        top: 0;
        opacity: 0;
      }
    }

    .haserorform {
      border-color: #dd4b39;
    }

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
  </style>
  <div class="content-wrapper">
    <section class="content-header">
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div id="snackbar">
        </div>
        <div class="col-lg-12">
          <!-- ./col -->

          <!-- SETTING START-->

          <?php
          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
          include "configuration/config_chmod.php";
          $halaman = "stok_in"; // halaman
          $dataapa = "Stok Masuk"; // data
          $tabeldatabase = "stok_masuk"; // tabel database
          $tabel = "stok_masuk_daftar";
          $chmod = $chmenu5; // Hak akses Menu
          $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
          $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
          $search = $_POST['search'];
          $insert = $_POST['insert'];




          function autoNumber()
          {
            include "configuration/config_connect.php";
            global $forward;
            $query = "SELECT MAX(no) as max_id FROM stok_masuk ORDER BY no";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_array($result);
            $id_max = $data['max_id'];
            $sort_num = (int) $id_max;
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            return $new_code;
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

          <?php
          //fungsi menangkap barcode

          // if (isset($_GET['barcode'])) {
          //   $barcode = mysqli_real_escape_string($conn, $_GET["barcode"]);
          //   $sql1 = "SELECT * FROM barang where barcode='$barcode'";
          //   $query = mysqli_query($conn, $sql1);
          //   $data = mysqli_fetch_assoc($query);
          //   $nama = $data['nama'];
          //   $kode = $data['kode'];
          //   $stok = $data['sisa'];
          //   $jumlah = '1';
          // }
          ?>
          <!-- tambah -->
          <?php

          // if (isset($_POST["masuk"])) {
          //   if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //     $totalscan = mysqli_real_escape_string($conn, $_POST["totalscan"]);
          //     $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
          //     if ($totalscan < $jumlah) {
          //       echo "<script type='text/javascript'>  alert('Data Belum Di Scan / Jumlah Barang Masuk tidak sama dengan Jumlah Yang di scan! $totalscan - $jumlah');</script>";
          //       echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //     } else {
          //       $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
          //       $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          //       $nama = mysqli_real_escape_string($conn, $_POST["nama"]);

          //       $kegiatan = "Stok Masuk";
          //       $status = "pending";
          //       $usr = $_SESSION['nama'];
          //       $today = date('Y-m-d');


          //       $brg = mysqli_query($conn, "SELECT * FROM barang WHERE kode='$kode'");
          //       $ass = mysqli_fetch_assoc($brg);
          //       $oldstok = $ass['sisa'];
          //       $oldin = $ass['terbeli'];
          //       $newstok = $oldstok + $jumlah;
          //       $newin = $oldin + $jumlah;

          //       $sqlx = "UPDATE barang SET sisa='$newstok', terbeli='$newin' WHERE kode='$kode'";
          //       $updx = mysqli_query($conn, $sqlx);
          //       if ($updx) {

          //         $sql = "select * from stok_masuk_daftar where nota='$nota' and kode_barang='$kode'";
          //         $resulte = mysqli_query($conn, $sql);

          //         if (mysqli_num_rows($resulte) > 0) {
          //           $q = mysqli_fetch_assoc($resulte);
          //           $cart = $q['jumlah'];
          //           $newcart = $cart + $jumlah;
          //           $sqlu = "UPDATE stok_masuk_daftar SET jumlah='$newcart' where nota='$nota' AND kode_barang='$kode'";
          //           $ucart = mysqli_query($conn, $sqlu);
          //           if ($ucart) {


          //             //            $sql3 = "UPDATE mutasi SET jumlah='$newcart' WHERE keterangan='$nota' AND kegiatan='$kegiatan' ";
          //             //            $upd=mysqli_query($conn,$sql3);

          //             echo "<script type='text/javascript'>  alert('Jumlah Stok masuk telah ditambah!');</script>";
          //             echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //           } else {
          //             echo "<script type='text/javascript'>  alert('GAGAL, Periksa kembali input anda!');</script>";
          //           }
          //         } else {

          //           $sql2 = "insert into stok_masuk_daftar values( '$nota','$kode','$nama','$jumlah','')";
          //           $insertan = mysqli_query($conn, $sql2);

          //           if ($insertan) {

          //             $sql9 = "INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok masuk','$nota','','pending')";
          //             $mutasi = mysqli_query($conn, $sql9);

          //             echo "<script type='text/javascript'>  alert('Produk telah dimasukan dalam daftar!');</script>";
          //             echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //           } else {
          //             echo "<script type='text/javascript'>  alert('GAGAL memasukan produk, periksa kembali!');</script>";
          //           }
          //         }
          //       } else {
          //         echo "<script type='text/javascript'>  alert('Gagal mengupdate jumlah stok!');</script>";
          //         echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //       }
          //     }
          //   }
          // }
          // 
          ?>
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
          if ($chmod == 5 || $_SESSION['jabatan'] == 'admin') {
          ?>


            <!-- KONTEN BODY AWAL -->
            <!-- Default box -->
            <div class="col-lg-5 col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Form Stok Masuk</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">

                  <div class="row">
                    <!-- <form method="get" action="">
                      <div class="col-md-4">
                        <div class="form-group" data-select2-id="13">
                          <label style="font-size: smaller;">Barcode</label>
                          <input type="text" class="form-control input-sm" id="barcode" name="barcode" placeholder="Masukan Barcode...">
                        </div>
                      </div>
                    </form> -->

                    <div class="col-md-12">
                      <div class="form-group">
                        <label style="font-size: smaller;">Pilih Barang<span style="color: red;">*</span></label>
                        <select class="form-control select2" style="width: 100%;" name="produk" id="produk">
                          <option selected="selected" value="">- Pilih Barang -</option>
                          <?php
                          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                          $sql = mysqli_query($conn, "select *,barang.nama as nama, barang.kode as kode, barang.sku as sku from barang");
                          while ($row = mysqli_fetch_assoc($sql)) {
                            // if ($barcode == $row['barcode'])
                            //   echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                            // else
                            echo "<option value='" . $row['kode'] . "' nama='" . $row['nama'] . "' kode='" . $row['kode'] . "' stok='" . $row['sisa'] . "' >" . $row['sku'] . " | " . $row['nama'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <form method="post" id="formtambahkanbarangmasuk">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label style="font-size: smaller;">Nama Produk<span style="color: red;">*</span></label>
                          <input type="text" class="form-control input-sm" readonly id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukan Nama Barang...">
                          <input type="hidden" class="form-control" readonly id="kode" name="kode" value="<?php echo $kode; ?>">
                          <input type="hidden" class="form-control" readonly id="nota" name="nota" value="<?php echo autoNumber(); ?>">
                        </div>
                      </div>

                      <?php
                      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                      ?>

                      <div class="col-md-6">
                        <div class="form-group" data-select2-id="13">
                          <label style="font-size: smaller;">Stok Tersedia<span style="color: red;">*</span></label>
                          <input type="text" class="form-control input-sm" id="stok" name="stok" value="<?php echo $stok; ?>" readonly placeholder="Stok yang tersedia...">
                        </div>
                      </div>

                      <input type="hidden" id="totalscan" name="totalscan" value="">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label style="font-size: smaller;">Jumlah Stok<span style="color: red;">*</span></label>
                          <input type="number" class="form-control input-sm" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" placeholder="Jumlah Stok...">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <button type="submit" name="masuk" id="masuk" class="btn bg-orange btn-flat btn-block">Tambahkan</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>

            <div class="col-lg-7 col-xs-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Masuk</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-success">
                        <div class="box-header with-border">
                        </div>

                        <?php
                        error_reporting(E_ALL ^ E_DEPRECATED);

                        $sql    = "select * from stok_masuk_daftar where nota =" . autoNumber() . " order by no";
                        $result = mysqli_query($conn, $sql);
                        $checkdatalist = mysqli_num_rows($result);
                        $rpp    = 30;
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
                          <table class="data table table-hover table-bordered">
                            <thead>
                              <tr>
                                <th style="width:10px">No</th>
                                <th>Nama Barang</th>
                                <th style="width:10%">Jumlah Masuk</th>

                                <?php if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') { ?>
                                  <th style="width:10px">Opsi</th>
                                <?php } else {
                                } ?>
                              </tr>
                            </thead>
                            <?php
                            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                            while (($count < $rpp) && ($i < $tcount)) {
                              mysqli_data_seek($result, $i);
                              $fill = mysqli_fetch_array($result);
                            ?>
                              <tbody>
                                <tr>
                                  <td><?php echo ++$no_urut; ?></td>


                                  <td><?php echo mysqli_real_escape_string($conn, $fill['nama']); ?></td>

                                  <td><?php echo mysqli_real_escape_string($conn, $fill['jumlah']); ?></td>

                                  <td>
                                    <?php if ($chmod >= 4 || $_SESSION['jabatan'] == 'admin') { ?>
                                      <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_stok?get=<?php echo 'in' . '&'; ?>barang=<?php echo $fill['kode_barang'] . '&'; ?>jumlah=<?php echo $fill['jumlah'] . '&'; ?>&kode=<?php echo $kode . '&'; ?>no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $tabel . '&'; ?>forwardpage=<?php echo "" . $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
                                    <?php } else {
                                    } ?>
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

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="box box-danger">
                        <div class="box-header with-border">

                          <form method="post" id="forminputmasterbarangmasuk" enctype="multipart/form-data">
                            <div class="row">

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label style="font-size: smaller;">Supplier</label>
                                  <select class="form-control select2" style="width: 100%;" name="supplier" id="supplier">
                                    <?php
                                    $sql = mysqli_query($conn, "select * from supplier");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                      if ($supplier == $row['kode'])
                                        echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nohp'] . " | " . $row['nama'] . "</option>";
                                      else
                                        echo "<option value='" . $row['nama'] . "'>" . $row['nohp'] . " | " . $row['nama'] . "</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label style="font-size: smaller;">Divisi<span style="color: red;">*</span></label>
                                  <select class="form-control select2 select2-hidden-accessible" id="divisi" name="divisi" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option selected="selected" value="">- Pilih Divisi -</option>
                                    <?php
                                    $sql = mysqli_query($conn, "select * from divisi where id != 13");
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                      echo "<option value='" . $row['id'] . "'>" . $row['divisi'] . "</option>";
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group" data-select2-id="13">
                                  <label style="font-size: smaller;">No. SO<span style="color: red;">*</span></label>
                                  <input type="text" class="form-control input-sm" placeholder="Masukan No.So..." id="noso" name="noso" value="">
                                </div>

                                <div class="form-group">
                                  <label style="font-size: smaller;">User Request<span style="color: red;">*</span></label>
                                  <input type="text" class="form-control input-sm " placeholder="Masukan Nama User..." id="user_request" name="user_request" value="">
                                </div>

                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label style="font-size: smaller;">Foto SO<span style="color: red;">*</span></label>
                                  <input type="file" class="form-control input-sm" name="foto_so" id="foto_so">
                                </div>

                                <div class="form-group">
                                  <label style="font-size: smaller;">Foto Barang<span style="color: red;">*</span></label>
                                  <input type="file" class="form-control input-sm" name="foto_barang" id="foto_barang">
                                </div>
                              </div>

                            </div>

                            <input type="hidden" class="form-control" readonly id="notae" name="notae" value="<?php echo autoNumber(); ?>">

                            <div class="row">
                              <div class="form-group col-md-12 col-xs-12">
                                <?php
                                if ($checkdatalist > 0) {
                                ?>
                                  <button type="submit" id="simpan" name="simpan" value="simpan" class="btn btn-flat bg-purple btn-block">SIMPAN</button>
                                <?php
                                }
                                ?>
                              </div>
                            </div>
                          </form>


                        </div>
                      </div>
                    </div>
                  </div>





                </div>

                <!-- /.box-body -->
              </div>
            </div>




            <?php

            // if (isset($_POST["simpan"])) {
            //   echo "<script type='text/javascript'>  alert('Stok selesai dimasukan!');</script>";
            //   if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //     $nota       = mysqli_real_escape_string($conn, $_POST["notae"]);
            //     $sup        = mysqli_real_escape_string($conn, $_POST["supplier"]);
            //     $tgl        = date('Y-m-d');
            //     $usr        = $_SESSION['nouser'];
            //     $cab        = '01';
            //     echo $nota;
            //     $kegiatan   = "Stok Masuk";

            //     $sql2       = "insert into stok_masuk values( '$nota','$cab','$tgl','$sup','$usr','')";
            //     $insertan   = mysqli_query($conn, $sql2);

            //     $sqlso      = "insert into so_num values('{$no_so}','{$nota}',{$id_divisi},'{$user_request}','{$foto_barang}')";
            //     $insertanso = mysqli_query($conn, $sqlso);

            //     $mut        = "UPDATE mutasi SET status='berhasil' WHERE keterangan='$nota' AND kegiatan='stok masuk'";
            //     $muta       = mysqli_query($conn, $mut);

            //     echo "<script type='text/javascript'>  alert('Stok selesai dimasukan!');</script>";
            //     echo "<script type='text/javascript'>window.location = 'stok_masuk';</script>";
            //   }
            // } 
            ?>

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
      <?php
      if ($chmod == 5 || $_SESSION['jabatan'] == 'admin') {
      ?>
        <!-- START FORM INPUT IMEI BARANG -->
        <div class="row">
          <div class="col-lg-5 col-xs-12">
            <!-- START SCAN FOTO BARCODE -->
            <!-- <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Scan Barcode Photo</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div id="qr-reader"></div>
            </div> -->
            <!-- END SCAN FOTO BARCODE -->
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Form Scan Nomor IMEI & SN</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">

                <div class="row">
                  <div class="form-group col-md-12 col-xs-12">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="checkboxaktifimei2"> <strong><i>Tambahkan IMEI 2</i></strong>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-xs-12">
                    <label for="barang" class="col-sm-2 control-label" style="font-size: smaller;">IMEI 1 :</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control input-sm" id="nomorimei1" name="nomorimei1" required="true" disabled placeholder="Scan Imei 1....">
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-xs-12" id="formimei2" style="display: none;">
                    <label for="barang" class="col-sm-2 control-label" style="font-size: smaller;">IMEI 2 :</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control input-sm" id="nomorimei2" name="nomorimei2" required="true" disabled placeholder="Scan Imei 2....">
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-xs-12" id="formsn">
                    <label for="barang" class="col-sm-2 control-label" style="font-size: smaller;">SN :</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control input-sm" id="nomorsn" name="nomorsn" required="true" disabled placeholder="Scan SN...." disabled>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Table Scan IMEI & SN &nbsp;--&nbsp; <span> <strong><i>Total Scan </i> : </strong></span>&nbsp;<span id="jumlahbaranginputview"> - </span></h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="box-body table-responsive" style="max-height: 240px;">
                  <table class="data table table-hover table-bordered" id="tableimei">
                    <thead style="top:0;position:sticky; background-color:#e7e9ed">
                      <tr>
                        <th style="width:10px">No</th>
                        <th style="width:60px">SKU</th>
                        <th>Nama Barang</th>
                        <th>IMEI 1</th>
                        <th>IMEI 2</th>
                        <th>SN</th>
                        <th style="text-align: center">-</th>
                      </tr>
                    </thead>
                    <tbody id="listdataimeiinput">

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END FORM INPUT IMEI BARANG -->
      <?php
      } ?>

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

<script src="dist/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="libs/1.11.4-jquery-ui.min.js"></script>
<script src="configuration/barcodecamera.js"></script>





<script>
  $("#produk").on("change", function() {

    var nama = $("#produk option:selected").attr("nama");
    var kode = $("#produk option:selected").attr("kode");
    var stok = $("#produk option:selected").attr("stok");


    $("#nama").val(nama);
    $("#stok").val(stok);
    $("#kode").val(kode);

    $("#jumlah").val(1);
  });
</script>


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



  // START Function javascript untuk IMEI

  function delay(callback, ms) {
    var timer = 0;
    return function() {
      var context = this,
        args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function() {
        callback.apply(context, args);
      }, ms || 0);
    };
  };

  var arraytampungdataimei = [];
  var nota = $('#nota').val();
  $("#checkboxaktifimei2").click(function() {
    if ($(this).is(":checked")) {
      $("#checkboxaktifimei2").prop("checked", true);
      $("#formimei2").show();
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById('nomorimei1').disabled = false;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById("nomorimei1").focus();
      // $('#listdataimeiinput').empty();
      // arraytampungdataimei = [];
    } else {
      $("#checkboxaktifimei2").prop("checked", false);
      $("#formimei2").hide();
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById('nomorimei1').disabled = false;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById("nomorimei1").focus();
      // $('#listdataimeiinput').empty();
      // arraytampungdataimei = [];
    }
  });


  $('#produk').on('change', function(e) {
    e.preventDefault();
    arraytampungdataimei = [];
    var valproduk = $('#produk').val();
    if (valproduk == '') {
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      $('#listdataimeiinput').empty();
      document.getElementById('jumlahbaranginputview').innerHTML = '-';
    } else {
      document.getElementById('nomorimei1').disabled = false;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById('jumlah').focus();
      $('#listdataimeiinput').empty();
      document.getElementById('jumlahbaranginputview').innerHTML = '-';
    }
  });

  $('#jumlah').on('keyup', delay(function(e) {
    e.preventDefault();
    var counttr = $('#tableimei tbody tr').length;
    if (this.value) {
      if (this.value == counttr) {
        document.getElementById('nomorimei1').disabled = true;
        document.getElementById('nomorimei2').disabled = true;
        document.getElementById('nomorsn').disabled = true;
        document.getElementById('nomorimei1').value = '';
        document.getElementById('nomorimei2').value = '';
        document.getElementById('nomorsn').value = '';
      } else if (this.value < counttr) {
        document.getElementById('nomorimei1').disabled = true;
        document.getElementById('nomorimei2').disabled = true;
        document.getElementById('nomorsn').disabled = true;
        document.getElementById('nomorimei1').value = '';
        document.getElementById('nomorimei2').value = '';
        document.getElementById('nomorsn').value = '';
      } else {
        document.getElementById('nomorimei1').disabled = false;
        document.getElementById('nomorimei2').disabled = true;
        document.getElementById('nomorsn').disabled = true;
        document.getElementById('nomorimei1').value = '';
        document.getElementById('nomorimei2').value = '';
        document.getElementById('nomorsn').value = '';
        document.getElementById('nomorimei1').focus();
      }

    } else {
      if (counttr == 0) {
        document.getElementById('nomorimei1').disabled = false;
      } else {
        document.getElementById('nomorimei1').disabled = true;
      }
      document.getElementById('jumlah').value = 1;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById('nomorimei1').focus();
    }
  }, 500));

  function functioncheckimei1(nomorimei, codeproduk, namaproduk, counttr, jumlahbarangmasuk) {

    if (jumlahbarangmasuk <= counttr) {
      myFunction('Warning', 'Jumlah Barang Masuk Hanya ' + jumlahbarangmasuk + ' Barang');
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById("jumlah").focus();
    } else {
      if (!$("#checkboxaktifimei2").is(":checked")) {
        if (nomorimei) {
          if (nomorimei != '-') {
            const itemPos = arraytampungdataimei.findIndex(
              item => item.no_imei1 == nomorimei
            );

            if (itemPos == -1) {
              const itemPos2 = arraytampungdataimei.findIndex(
                item => item.no_sn == nomorimei
              );

              if (itemPos2 == -1) {
                $.ajax({
                  url: "imei_row.php",
                  type: 'post',
                  dataType: "json",
                  data: {
                    modulview: 'viewrowbarangmasuk',
                    nomorsku: codeproduk,
                    nomorimei: nomorimei,
                    divisi: "-",
                    produk: "-"
                  },
                  success: function(data) {},
                  error: function(jqXHR, exception) {
                    if (jqXHR.status === 0) {
                      msg = 'Not connect.\n Verify Networks.'
                    } else if (jqXHR.status == 404) {
                      msg = 'Requested page not found. [404]'
                    } else if (jqXHR.status == 500) {
                      msg = 'Internal Server Error [500]. Please check server again'
                    } else if (exception === 'parsererror') {
                      msg = 'Requested JSON parse failed.'
                    } else if (exception === 'timeout') {
                      msg = 'Time out error.'
                    } else if (exception === 'abort') {
                      msg = 'Ajax request aborted.'
                    } else {
                      msg = 'Uncaught Error.\n' + jqXHR.responseText
                    }
                  },
                  complete: function(val) {
                    var sku = val.responseJSON[0].sku;
                    if (sku == 'Kosong') {
                      document.getElementById('nomorimei1').disabled = true;
                      document.getElementById('nomorsn').value = '';
                      document.getElementById('nomorsn').disabled = false;
                      document.getElementById("nomorsn").focus();
                    } else {
                      myFunction('Warning', 'Data IMEI & SN Sudah Tersimpan Di Database!!!');
                      document.getElementById('nomorimei1').disabled = false;
                      document.getElementById('nomorimei1').value = '';
                      document.getElementById("nomorimei1").focus();
                      document.getElementById('nomorsn').value = '';
                      document.getElementById('nomorsn').disabled = true;
                    }
                  }
                });
              } else {
                myFunction('Warning', 'Data IMEI 1 Tidak Boleh Disii oleh SN!!!!');
                document.getElementById('nomorimei1').disabled = false;
                document.getElementById('nomorimei1').value = '';
                document.getElementById("nomorimei1").focus();
                document.getElementById('nomorsn').value = '';
                document.getElementById('nomorsn').disabled = true;
              }
            } else {
              myFunction('Warning', 'Data Sudah Diinput');
              document.getElementById('nomorimei1').disabled = false;
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
              document.getElementById('nomorsn').value = '';
              document.getElementById('nomorsn').disabled = true;
            }
          } else {
            document.getElementById('nomorimei1').disabled = true;
            document.getElementById('nomorsn').value = '';
            document.getElementById('nomorsn').disabled = false;
            document.getElementById("nomorsn").focus();
          }
        } else {
          myFunction('Warning', 'Check Input Nomor IMEI...');
          document.getElementById('nomorimei1').disabled = false;
          document.getElementById('nomorimei1').value = '';
          document.getElementById("nomorimei1").focus();
          document.getElementById('nomorsn').value = '';
          document.getElementById('nomorsn').disabled = true;
        }
      } else {
        if (nomorimei) {
          if (nomorimei != '-') {
            const itemPos = arraytampungdataimei.findIndex(
              item => item.no_imei1 == nomorimei
            );

            if (itemPos == -1) {
              const itemPos2 = arraytampungdataimei.findIndex(
                item => item.no_imei2 == nomorimei
              );

              if (itemPos2 == -1) {
                const itemPos3 = arraytampungdataimei.findIndex(
                  item => item.no_sn == nomorimei
                );
                if (itemPos3 == -1) {
                  $.ajax({
                    url: "imei_row.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                      modulview: 'viewrowbarangmasuk',
                      nomorsku: codeproduk,
                      nomorimei: nomorimei,
                      divisi: "-",
                      produk: "-"
                    },
                    success: function(data) {},
                    error: function(jqXHR, exception) {
                      if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.'
                      } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]'
                      } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].'
                      } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.'
                      } else if (exception === 'timeout') {
                        msg = 'Time out error.'
                      } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.'
                      } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText
                      }
                    },
                    complete: function(val) {
                      var sku = val.responseJSON[0].sku;

                      if (sku == 'Kosong') {
                        document.getElementById('nomorimei1').disabled = true;
                        document.getElementById('nomorimei2').value = '';
                        document.getElementById('nomorimei2').disabled = false;
                        document.getElementById('nomorsn').value = '';
                        document.getElementById('nomorsn').disabled = true;
                        document.getElementById("nomorimei2").focus();
                      } else {
                        myFunction('Warning', 'Data IMEI & SN Sudah Tersimpan Di Database!!!');
                        document.getElementById('nomorimei1').disabled = false;
                        document.getElementById('nomorimei1').value = '';
                        document.getElementById("nomorimei1").focus();
                        document.getElementById('nomorsn').value = '';
                        document.getElementById('nomorsn').disabled = true;
                        document.getElementById('nomorimei2').value = '';
                        document.getElementById('nomorimei2').disabled = true;
                      }
                    }
                  });
                } else {
                  myFunction('Warning', 'Data IMEI 1 Tidak Boleh Disii oleh SN!!!!');
                  document.getElementById('nomorimei1').disabled = false;
                  document.getElementById('nomorimei1').value = '';
                  document.getElementById("nomorimei1").focus();
                  document.getElementById('nomorimei2').value = '';
                  document.getElementById('nomorimei2').disabled = true;
                  document.getElementById('nomorsn').value = '';
                  document.getElementById('nomorsn').disabled = true;
                }
              } else {
                myFunction('Warning', 'Data IMEI 1 Tidak Boleh Disii oleh IMEI 2!!!!');
                document.getElementById('nomorimei1').disabled = false;
                document.getElementById('nomorimei1').value = '';
                document.getElementById("nomorimei1").focus();
                document.getElementById('nomorimei2').value = '';
                document.getElementById('nomorimei2').disabled = true;
                document.getElementById('nomorsn').value = '';
                document.getElementById('nomorsn').disabled = true;
              }
            } else {
              myFunction('Warning', 'Data Sudah Diinput');
              document.getElementById('nomorimei1').disabled = false;
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
              document.getElementById('nomorimei2').disabled = true;
              document.getElementById('nomorimei2').value = '';
              document.getElementById('nomorsn').value = '';
              document.getElementById('nomorsn').disabled = true;
            }
          } else {
            document.getElementById('nomorimei1').disabled = true;
            document.getElementById('nomorsn').value = '';
            document.getElementById('nomorsn').disabled = true;
            document.getElementById('nomorimei2').value = '';
            document.getElementById('nomorimei2').disabled = false;
            document.getElementById("nomorimei2").focus();
          }
        } else {
          myFunction('Warning', 'Check Input Nomor IMEI...');
          document.getElementById('nomorimei1').disabled = false;
          document.getElementById('nomorimei1').value = '';
          document.getElementById("nomorimei1").focus();
          document.getElementById('nomorsn').value = '';
          document.getElementById('nomorsn').disabled = true;
          document.getElementById('nomorimei2').value = '';
          document.getElementById('nomorimei2').disabled = true;
        }
      }
    }
  }

  // START SCAN IMEI 1
  $('#nomorimei1').keyup(delay(function(e) {
    var nomorimei = this.value;
    var codeproduk = 'SK' + $('#produk').val();
    var namaproduk = $('#nama').val();
    var counttr = $('#tableimei tbody tr').length;
    var jumlahbarangmasuk = $('#jumlah').val();
    functioncheckimei1(nomorimei, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
  }, 500));
  // END SCAN IMEI 1

  function functioncheckimei2(nomorimei1, nomorimei2, nomorimei, codeproduk, namaproduk, counttr, jumlahbarangmasuk) {
    if (jumlahbarangmasuk == counttr) {
      myFunction('Warning', 'Jumlah Barang Masuk Hanya ' + jumlahbarangmasuk + ' Barang');
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
    } else {
      if ($("#checkboxaktifimei2").is(":checked")) {
        if (nomorimei2) {
          if (nomorimei2 != '-') {
            if (nomorimei2 != nomorimei1) {
              const itemPos = arraytampungdataimei.findIndex(
                item => item.no_imei2 == nomorimei2
              );
              if (itemPos == -1) {
                const itemPos2 = arraytampungdataimei.findIndex(
                  item => item.no_imei1 == nomorimei2
                );
                if (itemPos2 == -1) {
                  const itemPos3 = arraytampungdataimei.findIndex(
                    item => item.no_sn == nomorimei2
                  );
                  if (itemPos3 == -1) {
                    $.ajax({
                      url: "imei_row.php",
                      type: 'post',
                      dataType: "json",
                      data: {
                        modulview: 'viewrowbarangmasuk',
                        nomorsku: codeproduk,
                        nomorimei: nomorimei2,
                        divisi: "-",
                        produk: "-"
                      },
                      success: function(data) {},
                      error: function(jqXHR, exception) {
                        if (jqXHR.status === 0) {
                          msg = 'Not connect.\n Verify Network.'
                        } else if (jqXHR.status == 404) {
                          msg = 'Requested page not found. [404]'
                        } else if (jqXHR.status == 500) {
                          msg = 'Internal Server Error [500].'
                        } else if (exception === 'parsererror') {
                          msg = 'Requested JSON parse failed.'
                        } else if (exception === 'timeout') {
                          msg = 'Time out error.'
                        } else if (exception === 'abort') {
                          msg = 'Ajax request aborted.'
                        } else {
                          msg = 'Uncaught Error.\n' + jqXHR.responseText
                        }
                      },
                      complete: function(val) {
                        var sku = val.responseJSON[0].sku;

                        if (sku == 'Kosong') {
                          document.getElementById('nomorimei1').disabled = true;
                          document.getElementById('nomorimei2').disabled = true;
                          document.getElementById('nomorsn').value = '';
                          document.getElementById('nomorsn').disabled = false;
                          document.getElementById("nomorsn").focus();
                        } else {
                          myFunction('Warning', 'Data IMEI & SN Sudah Tersimpan Di Database!!!');
                          document.getElementById('nomorimei1').disabled = false;
                          document.getElementById('nomorimei1').value = '';
                          document.getElementById("nomorimei1").focus();
                          document.getElementById('nomorsn').value = '';
                          document.getElementById('nomorsn').disabled = true;
                          document.getElementById('nomorimei2').value = '';
                          document.getElementById('nomorimei2').disabled = true;
                        }
                      }
                    });
                  } else {
                    myFunction('Warning', 'Data SN Sudah Diinput');
                    document.getElementById("nomorimei1").disabled = true;
                    document.getElementById("nomorimei2").disabled = false;
                    document.getElementById("nomorimei2").value = '';
                    document.getElementById("nomorimei2").focus();
                    document.getElementById('nomorsn').value = '';
                    document.getElementById("nomorsn").disabled = true;
                  }
                } else {
                  myFunction('Warning', 'Data IMEI 1 Sudah Diinput');
                  document.getElementById("nomorimei1").disabled = true;
                  document.getElementById("nomorimei2").disabled = false;
                  document.getElementById("nomorimei2").value = '';
                  document.getElementById("nomorimei2").focus();
                  document.getElementById('nomorsn').value = '';
                  document.getElementById("nomorsn").disabled = true;
                }
              } else {
                myFunction('Warning', 'Data Sudah Diinput');
                document.getElementById("nomorimei1").disabled = true;
                document.getElementById("nomorimei2").disabled = false;
                document.getElementById("nomorimei2").value = '';
                document.getElementById("nomorimei2").focus();
                document.getElementById('nomorsn').value = '';
                document.getElementById("nomorsn").disabled = true;
              }
            } else {
              myFunction('Warning', 'Data IMEI 2 Tidak Boleh Sama Dengan IMEI 1 saat Scan!!!');
              document.getElementById("nomorimei1").disabled = true;
              document.getElementById("nomorimei2").value = '';
              document.getElementById("nomorimei2").focus();
              document.getElementById('nomorsn').value = '';
              document.getElementById("nomorsn").disabled = true;
            }

          } else {
            document.getElementById('nomorimei1').disabled = true;
            document.getElementById('nomorsn').value = '';
            document.getElementById('nomorsn').disabled = false;
            document.getElementById('nomorimei2').disabled = true;
            document.getElementById("nomorsn").focus();
          }
        } else {
          myFunction('Warning', 'Check Input Nomor IMEI 2...');
          document.getElementById('nomorimei2').value = '';
          document.getElementById("nomorimei2").focus();
        }
      }
    }
  }
  // START SCAN IMEI 2
  $('#nomorimei2').keyup(delay(function(e) {
    var nomorimei1 = $('#nomorimei1').val();
    var nomorimei2 = this.value;
    var nomorimei = nomorimei1 + ',' + nomorimei2;
    var codeproduk = 'SK' + $('#produk').val();
    var namaproduk = $('#nama').val();
    var counttr = $('#tableimei tbody tr').length;
    var jumlahbarangmasuk = $('#jumlah').val();
    functioncheckimei2(nomorimei1, nomorimei2, nomorimei, codeproduk, namaproduk, counttr, jumlahbarangmasuk)
  }, 500));

  // END SCAN IMEI 2

  function functionchecksn(nomorimei1, nomorimei2, nomorsn, codeproduk, namaproduk, counttr, jumlahbarangmasuk) {
    if (jumlahbarangmasuk <= counttr) {
      myFunction('Warning', 'Jumlah Barang Masuk Hanya ' + jumlahbarangmasuk + ' Barang');
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById('nomorimei2').disabled = true;
      document.getElementById('nomorsn').disabled = true;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei2').value = '';
      document.getElementById('nomorsn').value = '';
      // document.getElementById("nomorimei1").focus();
    } else {
      if (!$("#checkboxaktifimei2").is(":checked")) {
        if (nomorsn) {
          if (nomorsn != '-') {
            if (nomorimei1 != nomorsn) {
              var tottr = counttr + 1;
              const itemPos = arraytampungdataimei.findIndex(
                item => item.no_sn == nomorsn
              );

              if (itemPos == -1) {
                const itemPos2 = arraytampungdataimei.findIndex(
                  item => item.no_imei1 == nomorsn
                );
                if (itemPos2 == -1) {
                  $.ajax({
                    url: "imei_row.php",
                    type: 'post',
                    dataType: "json",
                    data: {
                      modulview: 'viewrowbarangmasuk',
                      nomorsku: codeproduk,
                      nomorimei: nomorsn,
                      divisi: "-",
                      produk: "-"
                    },
                    success: function(data) {},
                    error: function(jqXHR, exception) {
                      if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.'
                      } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]'
                      } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].'
                      } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.'
                      } else if (exception === 'timeout') {
                        msg = 'Time out error.'
                      } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.'
                      } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText
                      }
                    },
                    complete: function(val) {
                      var sku = val.responseJSON[0].sku;

                      if (sku == 'Kosong') {
                        arraytampungdataimei.push({
                          "kode_barang": codeproduk,
                          "nama_barang": namaproduk,
                          "no_imei1": nomorimei1,
                          "no_imei2": '-',
                          'nota': nota,
                          'no_sn': nomorsn
                        });

                        $('#listdataimeiinput').append(`
                        <tr>
                            <td>` + tottr + `</td>
                            <td>` + codeproduk + `</td>
                            <td>` + namaproduk + `</td>
                            <td><span id="td1imei` + tottr + `">` + nomorimei1 + `</span></td>
                            <td><span id="td2imei` + tottr + `"> - </span></td>
                            <td><span id="tdsn` + tottr + `">` + nomorsn + `</span></td>
                            <td align="center"><button id="btnhapusimeiscan" value="` + tottr + `" type="button" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button></td>
                        </tr>
                      `);
                        document.getElementById('jumlahbaranginputview').innerHTML = (tottr);
                        document.getElementById('totalscan').value = (tottr);
                        document.getElementById("nomorimei1").disabled = false;
                        document.getElementById('nomorimei1').value = '';
                        document.getElementById("nomorimei1").focus();
                        document.getElementById('nomorsn').value = '';
                        document.getElementById("nomorsn").disabled = true;
                      } else {
                        myFunction('Warning', 'Data IMEI & SN Sudah Tersimpan Di Database!!!');
                        document.getElementById("nomorimei1").disabled = false;
                        document.getElementById("nomorimei1").value = '';
                        document.getElementById("nomorimei1").focus();
                        document.getElementById('nomorsn').value = '';
                        document.getElementById("nomorsn").disabled = true;
                      }
                    }
                  });
                } else {
                  myFunction('Warning', 'Data Yang Di Scan Bukan No SN!!!');
                  document.getElementById("nomorimei1").disabled = true;
                  document.getElementById('nomorsn').value = '';
                  document.getElementById("nomorsn").focus();
                }
              } else {
                myFunction('Warning', 'Data Sudah Diinput');
                document.getElementById("nomorimei1").disabled = true;
                document.getElementById('nomorsn').value = '';
                document.getElementById("nomorsn").focus();
              }
            } else {
              myFunction('Warning', 'Data IMEI 1 Tidak Boleh Sama Dengan SN saat Scan!!!');
              document.getElementById("nomorimei1").disabled = false;
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
              document.getElementById('nomorsn').value = '';
              document.getElementById("nomorsn").disabled = true;
            }
          } else {
            var tottr = counttr + 1;
            arraytampungdataimei.push({
              "kode_barang": codeproduk,
              "nama_barang": namaproduk,
              "no_imei1": nomorimei1,
              "no_imei2": '-',
              'nota': nota,
              'no_sn': nomorsn
            });

            $('#listdataimeiinput').append(`
                        <tr>
                            <td>` + tottr + `</td>
                            <td>` + codeproduk + `</td>
                            <td>` + namaproduk + `</td>
                            <td><span id="td1imei` + tottr + `">` + nomorimei1 + `</span></td>
                            <td><span id="td2imei` + tottr + `"> - </span></td>
                            <td><span id="tdsn` + tottr + `">` + nomorsn + `</span></td>
                            <td align="center"><button id="btnhapusimeiscan" value="` + tottr + `" type="button" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button></td>
                        </tr>
                      `);
            document.getElementById('jumlahbaranginputview').innerHTML = (tottr);
            document.getElementById('totalscan').value = (tottr);
            document.getElementById("nomorimei1").disabled = false;
            document.getElementById('nomorimei1').value = '';
            document.getElementById("nomorimei1").focus();
            document.getElementById('nomorsn').value = '';
            document.getElementById("nomorsn").disabled = true;
          }
        } else {
          myFunction('Warning', 'Check Input Nomor SN...');
          document.getElementById('nomorsn').value = '';
          document.getElementById("nomorsn").focus();
        }
      } else {
        if (nomorsn) {
          if (nomorsn != '-') {
            if (nomorsn == nomorimei1) {
              myFunction('Warning', 'Data IMEI 1 Tidak Boleh Sama Dengan SN saat Scan!!!');
              document.getElementById("nomorimei1").disabled = false;
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
              document.getElementById('nomorsn').value = '';
              document.getElementById("nomorsn").disabled = true;
              document.getElementById('nomorimei2').value = '';
              document.getElementById("nomorimei2").disabled = true;
            } else if (nomorsn == nomorimei2) {
              myFunction('Warning', 'Data IMEI 2 Tidak Boleh Sama Dengan SN saat Scan!!!');
              document.getElementById("nomorimei1").disabled = false;
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
              document.getElementById('nomorsn').value = '';
              document.getElementById("nomorsn").disabled = true;
              document.getElementById('nomorimei2').value = '';
              document.getElementById("nomorimei2").disabled = true;
            } else {
              var tottr = counttr + 1;
              const itemPos = arraytampungdataimei.findIndex(
                item => item.no_sn == nomorsn
              );

              if (itemPos == -1) {
                const itemPos2 = arraytampungdataimei.findIndex(
                  item => item.no_imei1 == nomorsn
                );
                if (itemPos2 == -1) {
                  const itemPos3 = arraytampungdataimei.findIndex(
                    item => item.no_imei2 == nomorsn
                  );
                  if (itemPos3 == -1) {
                    $.ajax({
                      url: "imei_row.php",
                      type: 'post',
                      dataType: "json",
                      data: {
                        modulview: 'viewrowbarangmasuk',
                        nomorsku: codeproduk,
                        nomorimei: nomorsn,
                        divisi: "-",
                        produk: "-"
                      },
                      success: function(data) {},
                      error: function(jqXHR, exception) {
                        if (jqXHR.status === 0) {
                          msg = 'Not connect.\n Verify Network.'
                        } else if (jqXHR.status == 404) {
                          msg = 'Requested page not found. [404]'
                        } else if (jqXHR.status == 500) {
                          msg = 'Internal Server Error [500].'
                        } else if (exception === 'parsererror') {
                          msg = 'Requested JSON parse failed.'
                        } else if (exception === 'timeout') {
                          msg = 'Time out error.'
                        } else if (exception === 'abort') {
                          msg = 'Ajax request aborted.'
                        } else {
                          msg = 'Uncaught Error.\n' + jqXHR.responseText
                        }
                      },
                      complete: function(val) {
                        var sku = val.responseJSON[0].sku;

                        if (sku == 'Kosong') {
                          arraytampungdataimei.push({
                            "kode_barang": codeproduk,
                            "nama_barang": namaproduk,
                            "no_imei1": nomorimei1,
                            "no_imei2": nomorimei2,
                            'nota': nota,
                            'no_sn': nomorsn
                          });

                          $('#listdataimeiinput').append(`
                          <tr>
                              <td>` + tottr + `</td>
                              <td>` + codeproduk + `</td>
                              <td>` + namaproduk + `</td>
                              <td><span id="td1imei` + tottr + `">` + nomorimei1 + `</span></td>
                              <td><span id="td2imei` + tottr + `">` + nomorimei2 + `</span></td>
                              <td><span id="tdsn` + tottr + `">` + nomorsn + `</span></td>
                              <td align="center"><button id="btnhapusimeiscan" value="` + tottr + `" type="button" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button></td>
                          </tr>
                        `);
                          document.getElementById('jumlahbaranginputview').innerHTML = (tottr);
                          document.getElementById('totalscan').value = (tottr);
                          document.getElementById("nomorimei1").disabled = false;
                          document.getElementById('nomorimei1').value = '';
                          document.getElementById("nomorimei1").focus();
                          document.getElementById('nomorsn').value = '';
                          document.getElementById("nomorsn").disabled = true;
                          document.getElementById('nomorimei2').value = '';
                          document.getElementById("nomorimei2").disabled = true;
                        } else {
                          myFunction('Warning', 'Data IMEI & SN Sudah Tersimpan Di Database!!!');
                          document.getElementById("nomorimei1").disabled = false;
                          document.getElementById("nomorimei1").value = '';
                          document.getElementById("nomorimei1").focus();
                          document.getElementById('nomorsn').value = '';
                          document.getElementById("nomorsn").disabled = true;
                          document.getElementById('nomorimei2').value = '';
                          document.getElementById("nomorimei2").disabled = true;
                        }
                      }
                    });
                  } else {
                    myFunction('Warning', 'Data Yang Di Scan Bukan No SN!!!');
                    document.getElementById("nomorimei1").disabled = true;
                    document.getElementById("nomorimei2").disabled = true;
                    document.getElementById('nomorsn').value = '';
                    document.getElementById("nomorsn").focus();
                  }
                } else {
                  myFunction('Warning', 'Data Yang Di Scan Bukan No SN!!!');
                  document.getElementById("nomorimei1").disabled = true;
                  document.getElementById("nomorimei2").disabled = true;
                  document.getElementById('nomorsn').value = '';
                  document.getElementById("nomorsn").focus();
                }
              } else {
                myFunction('Warning', 'Data Sudah Diinput');
                document.getElementById("nomorimei1").disabled = true;
                document.getElementById("nomorimei2").disabled = true;
                document.getElementById('nomorsn').value = '';
                document.getElementById("nomorsn").focus();
              }
            }
          } else {
            var tottr = counttr + 1;
            arraytampungdataimei.push({
              "kode_barang": codeproduk,
              "nama_barang": namaproduk,
              "no_imei1": nomorimei1,
              "no_imei2": nomorimei2,
              'nota': nota,
              'no_sn': nomorsn
            });

            $('#listdataimeiinput').append(`
                        <tr>
                            <td>` + tottr + `</td>
                            <td>` + codeproduk + `</td>
                            <td>` + namaproduk + `</td>
                            <td><span id="td1imei` + tottr + `">` + nomorimei1 + `</span></td>
                            <td><span id="td2imei` + tottr + `">` + nomorimei2 + `</span></td>
                            <td><span id="tdsn` + tottr + `">` + nomorsn + `</span></td>
                            <td align="center"><button id="btnhapusimeiscan" value="` + tottr + `" type="button" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button></td>
                        </tr>
                      `);
            document.getElementById('jumlahbaranginputview').innerHTML = (tottr);
            document.getElementById('totalscan').value = (tottr);
            document.getElementById("nomorimei1").disabled = false;
            document.getElementById('nomorimei1').value = '';
            document.getElementById("nomorimei1").focus();
            document.getElementById('nomorsn').value = '';
            document.getElementById("nomorsn").disabled = true;
            document.getElementById('nomorimei2').value = '';
            document.getElementById("nomorimei2").disabled = true;
          }
        } else {
          myFunction('Warning', 'Check Input Nomor SN...');
          document.getElementById('nomorsn').value = '';
          document.getElementById("nomorsn").focus();
          document.getElementById("nomorimei1").disabled = true;
          document.getElementById("nomorimei2").disabled = true;
        }
      }
    }
  }

  // START SCAN SN
  $('#nomorsn').keyup(delay(function(e) {
    var nomorimei1 = $('#nomorimei1').val();
    var nomorimei2 = $('#nomorimei2').val();
    var nomorsn = this.value;
    var codeproduk = 'SK' + $('#produk').val();
    var namaproduk = $('#nama').val();
    var counttr = $('#tableimei tbody tr').length;
    var jumlahbarangmasuk = $('#jumlah').val();
    functionchecksn(nomorimei1, nomorimei2, nomorsn, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
  }, 500));
  // END SCAN SN

  function myFunction(type, message) {
    var x = document.getElementById("snackbar");
    switch (type) {
      case 'Success':
        x.innerHTML = `<div class="alert alert-success alert-dismissible">
            <h5><i class="icon fa fa-check"></i> ` + message + `</h5>
          </div>`;
        break;
      case 'Warning':
        x.innerHTML = `<div class="alert alert-warning alert-dismissible">
            <h5><i class="icon fa fa-warning"></i> ` + message + `</h5>
          </div>`;
        break;
      default:
        x.innerHTML = `<div class="alert alert-error alert-dismissible">
            <h5><i class="icon fa fa-ban"></i> ` + message + `</h5>
          </div>`;
        break;
    }
    x.className = "show";
    setTimeout(function() {
      x.className = x.className.replace("show", "");
    }, 3000);
  }

  $("#formtambahkanbarangmasuk").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var formProduk = document.getElementById('produk').value;
    var formNama = document.getElementById('nama').value;
    var formKode = document.getElementById('kode').value;
    var formNota = document.getElementById('nota').value;
    var formStok = document.getElementById('stok').value;
    var formJumlah = document.getElementById('jumlah').value;
    var totalscan = document.getElementById('totalscan').value;

    var formProdukcheck = (formProduk) ? 'True' : 'False';
    var formNamacheck = (formNama) ? 'True' : 'False';
    var formKodecheck = (formKode) ? 'True' : 'False';
    var formNotacheck = (formNota) ? 'True' : 'False';
    var formStokcheck = (formStok) ? 'True' : 'False';
    var formJumlahcheck = (formJumlah) ? 'True' : 'False';

    var arrdata = [formProdukcheck, formNamacheck, formKodecheck, formNotacheck, formStokcheck, formJumlahcheck];
    let checkFormTrue = arrdata.filter(x => x == 'True').length


    if (checkFormTrue == 6) {
      if (totalscan < formJumlah) {
        myFunction('Warning', 'Data Imei/SN Belum Di Scan!!!');
      } else {
        $.ajax({
          url: "form_stok_masuk_detail.php",
          type: 'post',
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          data: formData,
          beforeSend: function() {
            $('#masuk').empty();
            $('#masuk').append(`<i class="fa fa-spinner fa-spin"></i>Loading...`);
            document.getElementById('masuk').disabled = true;
          },
          error: function(jqXHR, exception) {
            if (jqXHR.status === 0) {
              msg = 'Not connect.\n Verify Networks.'
            } else if (jqXHR.status == 404) {
              msg = 'Requested page not found. [404]'
            } else if (jqXHR.status == 500) {
              msg = 'Internal Server Error [500]. Please check server again'
            } else if (exception === 'parsererror') {
              msg = 'Requested JSON parse failed.'
            } else if (exception === 'timeout') {
              msg = 'Time out error.'
            } else if (exception === 'abort') {
              msg = 'Ajax request aborted.'
            } else {
              msg = 'Uncaught Error.\n' + jqXHR.responseText
            }
            myFunction('Error', msg);
          },
          complete: function(val) {
            if (val.status == 200) {
              myFunction('Success', val.responseJSON['status']);
              $.ajax({
                url: "imei.php",
                type: 'post',
                dataType: 'json',
                data: {
                  dataimei: arraytampungdataimei
                },
                error: function(jqXHR, exception) {
                  if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Networks.'
                  } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]'
                  } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500]. Please check server again'
                  } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.'
                  } else if (exception === 'timeout') {
                    msg = 'Time out error.'
                  } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.'
                  } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText
                  }
                  myFunction('Error', msg);
                },
                complete: function(val) {
                  if (val.status == 200) {
                    myFunction('Success', val.responseJSON['status']);
                    window.location = 'stok_in';
                  } else {
                    myFunction('Error', val.status);
                  }
                }
              });
            } else {
              myFunction('Error', val.status);
            }
          }
        });
      }
    } else {
      myFunction('Warning', 'Masih terdapat form yang kosong!!!');
    }
  });


  $("#forminputmasterbarangmasuk").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var formSupplier = document.getElementById('supplier').value;
    var formNoso = document.getElementById('noso').value;
    var formDivisi = document.getElementById('divisi').value;
    var formUser = document.getElementById('user_request').value;
    var formFoto = document.getElementById('foto_barang').value;
    var formFotoSo = document.getElementById('foto_so').value;
    var formNota = document.getElementById('notae').value;

    var formSuppliercheck = (formSupplier) ? 'True' : 'False';
    var formNosocheck = (formNoso) ? 'True' : 'False';
    var formDivisicheck = (formDivisi) ? 'True' : 'False';
    var formUsercheck = (formUser) ? 'True' : 'False';
    var formFotocheck = (formFoto) ? 'True' : 'False';
    var formFotoSocheck = (formFotoSo) ? 'True' : 'False';
    var formNotacheck = (formNota) ? 'True' : 'False';

    var arrdata = [formSuppliercheck, formNosocheck, formDivisicheck, formUsercheck, formFotocheck, formFotoSocheck, formNotacheck];
    let checkFormTrue = arrdata.filter(x => x == 'True').length

    if (checkFormTrue == 7) {
      $.ajax({
        url: "form_stok_masuk_master.php",
        type: 'post',
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function() {
          $('#simpan').empty();
          $('#simpan').append(`<i class="fa fa-spinner fa-spin"></i>Loading...`);
          document.getElementById('simpan').disabled = true;
        },
        error: function(jqXHR, exception) {
          if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Networks.'
          } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]'
          } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500]. Please check server again'
          } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.'
          } else if (exception === 'timeout') {
            msg = 'Time out error.'
          } else if (exception === 'abort') {
            msg = 'Ajax request aborted.'
          } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText
          }
          myFunction('Error', msg);
        },
        complete: function(val) {
          if (val.status == 200) {
            myFunction('Success', val.responseJSON['status']);
            window.location = 'stok_masuk';
          } else {
            myFunction('Error', val.status);
          }
        }
      });
    } else {
      myFunction('Warning', 'Masih terdapat form yang kosong!!!');
    }
  });



  $(document).on('click', "[id='btnhapusimeiscan']", function(e) {
    e.preventDefault();
    var index = $(this).val();
    var imei1 = document.getElementById('td1imei' + index).innerText;
    var imei2 = document.getElementById('td2imei' + index).innerText;
    var sn = document.getElementById('tdsn' + index).innerText;

    const itemCheck = arraytampungdataimei.findIndex(
      item => item.no_imei1 == imei1,
      item => item.no_imei2 == imei2,
      item => item.no_sn == sn
    );
    arraytampungdataimei.splice(itemCheck, 1);
    $('#listdataimeiinput').empty();
    var length = arraytampungdataimei.length;
    var arr = [];
    var i = 0;
    for (var j = 0; j < length; j++) {
      var nomor = j + 1;
      arr[i++] = '<tr>'
      arr[i++] = '<td>' + nomor + '</td>'
      arr[i++] = '<td>' + arraytampungdataimei[j].kode_barang + '</td>'
      arr[i++] = '<td>' + arraytampungdataimei[j].nama_barang + '</td>'
      arr[i++] = '<td><span id="td1imei' + nomor + '">' + arraytampungdataimei[j].no_imei1 + '</span></td>'
      arr[i++] = '<td><span id="td2imei' + nomor + '">' + arraytampungdataimei[j].no_imei2 + '</span></td>'
      arr[i++] = '<td><span id="tdsn' + nomor + '">' + arraytampungdataimei[j].no_sn + '</span></td>'
      arr[i++] = `<td align="center"><button id="btnhapusimeiscan" value="` + nomor + `" type="button" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i></button></td>`
      arr[i++] = '</tr>'
    }
    $('#listdataimeiinput').append(arr.join(''));
    var counttr = $('#tableimei tbody tr').length;
    document.getElementById('jumlahbaranginputview').innerHTML = (counttr);
    document.getElementById('totalscan').value = (counttr);
    var jumlahbarangmasuk = $('#jumlah').val();
    if (jumlahbarangmasuk <= counttr) {
      document.getElementById("nomorimei1").disabled = false;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorsn').value = '';
      document.getElementById("nomorsn").disabled = true;
      document.getElementById('nomorimei2').value = '';
      document.getElementById("nomorimei2").disabled = true;
      document.getElementById("jumlah").focus();
    } else {
      document.getElementById("nomorimei1").disabled = false;
      document.getElementById('nomorimei1').value = '';
      document.getElementById("nomorimei1").focus();
      document.getElementById('nomorsn').value = '';
      document.getElementById("nomorsn").disabled = true;
      document.getElementById('nomorimei2').value = '';
      document.getElementById("nomorimei2").disabled = true;
    }
  });

  function onScanSuccess(decodedText, decodedResult) {
    var checkformnomorimei1 = $('#nomorimei1').val();
    var checkformnomorimei2 = $('#nomorimei2').val();
    var checkformnomorsn = $('#nomorsn').val();
    var nomorimeiscan = decodedText;
    var codeproduk = 'SK' + $('#produk').val();
    var namaproduk = $('#nama').val();
    var counttr = $('#tableimei tbody tr').length;
    var jumlahbarangmasuk = $('#jumlah').val();
    if (!$("#checkboxaktifimei2").is(":checked")) {
      if (!checkformnomorimei1) {
        document.getElementById('nomorimei1').value = nomorimeiscan;
        functioncheckimei1(nomorimeiscan, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
      } else {
        if (nomorimeiscan != checkformnomorimei1) {
          if (!checkformnomorsn) {
            document.getElementById('nomorsn').value = nomorimeiscan;
            functionchecksn(checkformnomorimei1, checkformnomorimei2, nomorimeiscan, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
          }
        }
      }
    } else {
      if (!checkformnomorimei1) {
        document.getElementById('nomorimei1').value = nomorimeiscan;
        functioncheckimei1(nomorimeiscan, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
      } else if (!checkformnomorimei2) {
        if (nomorimeiscan != checkformnomorimei1 && nomorimeiscan != checkformnomorsn) {
          if (!checkformnomorimei2) {
            document.getElementById('nomorimei2').value = nomorimeiscan;
            var nomorimeigab = checkformnomorimei1 + ',' + nomorimeiscan;
            functioncheckimei2(checkformnomorimei1, nomorimeiscan, nomorimeigab, codeproduk, namaproduk, counttr, jumlahbarangmasuk)
          }
        }
      } else {
        if (nomorimeiscan != checkformnomorimei1 && nomorimeiscan != checkformnomorimei2) {
          if (!checkformnomorsn) {
            document.getElementById('nomorsn').value = nomorimeiscan;
            functionchecksn(checkformnomorimei1, checkformnomorimei2, nomorimeiscan, codeproduk, namaproduk, counttr, jumlahbarangmasuk);
          }
        }
      }
    }

  }
  var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", {
      fps: 10,
      qrbox: 250
    });
  html5QrcodeScanner.render(onScanSuccess);


  // END Function javascript untuk IMEI
</script>


</body>

</html>