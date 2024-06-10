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
  <style>
    .my-icon-inputform {
      padding-right: calc(1.5em + .75rem);
      background-image: url('https://use.fontawesome.com/releases/v5.8.2/svgs/regular/calendar-alt.svg');
      background-repeat: no-repeat;
      background-position: center right calc(.375em + .1875rem);
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
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
  </style>
  <?php
  theader();
  menu();
  ?>
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
          $halaman = "stok_out"; // halaman
          $dataapa = "Stok Keluar"; // data
          $tabeldatabase = "stok_keluar"; // tabel database
          $tabel = "stok_keluar_daftar";
          $chmod = $chmenu5; // Hak akses Menu
          $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
          $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
          $search = $_POST['search'];
          $insert = $_POST['insert'];



          function autoNumber()
          {
            include "configuration/config_connect.php";
            global $forward;
            $query = "SELECT MAX(no) as max_id FROM stok_keluar ORDER BY no";
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

          <!-- tambah -->
          <?php

          // if (isset($_POST["keluar"])) {
          //   if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //     $totalscan = mysqli_real_escape_string($conn, $_POST["totalscan"]);
          //     $jumlah = mysqli_real_escape_string($conn, $_POST["jumlah"]);
          //     if ($totalscan < $jumlah) {
          //       echo "<script type='text/javascript'>  alert('Data Belum Di Scan / Jumlah Barang Keluar tidak sama dengan Jumlah Yang di scan! $totalscan - $jumlah');</script>";
          //       echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //     } else if ($jumlah > $totalscan) {
          //       echo "<script type='text/javascript'>  alert('Data Belum Di Scan / Jumlah Barang Keluar tidak sama dengan Jumlah Yang di scan! $totalscan - $jumlah');</script>";
          //       echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //     } else {
          //       $nota = mysqli_real_escape_string($conn, $_POST["nota"]);
          //       $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          //       $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
          //       $hbeli = mysqli_real_escape_string($conn, $_POST["hargabeli"]);
          //       $hjual = mysqli_real_escape_string($conn, $_POST["hargajual"]);
          //       $stok = mysqli_real_escape_string($conn, $_POST["stok"]);

          //       $kegiatan = "Stok Keluar";
          //       $status = "pending";
          //       $usr = $_SESSION['nama'];
          //       $today = date('Y-m-d');
          //       if ($jumlah <= $stok) {

          //         $brg = mysqli_query($conn, "SELECT * FROM barang WHERE kode='$kode'");
          //         $ass = mysqli_fetch_assoc($brg);
          //         $oldstok = $ass['sisa'];
          //         $oldout = $ass['terjual'];
          //         $newstok = $oldstok - $jumlah;
          //         $newout = $oldout + $jumlah;

          //         $sqlx = "UPDATE barang SET sisa='$newstok', terjual='$newout' WHERE kode='$kode'";
          //         $updx = mysqli_query($conn, $sqlx);
          //         if ($updx) {

          //           $sql = "select * from stok_keluar_daftar where nota='$nota' and kode_barang='$kode'";
          //           $resulte = mysqli_query($conn, $sql);

          //           if (mysqli_num_rows($resulte) > 0) {
          //             $q = mysqli_fetch_assoc($resulte);
          //             $cart = $q['jumlah'];
          //             $newcart = $cart + $jumlah;
          //             $total = $newcart * $hjual;
          //             $modal = $newcart * $hbeli;


          //             $sqlu = "UPDATE stok_keluar_daftar SET jumlah='$newcart', subbeli='$modal', subtotal='$total' where nota='$nota' AND kode_barang='$kode'";
          //             $ucart = mysqli_query($conn, $sqlu);
          //             if ($ucart) {


          //               //            $sql3 = "UPDATE mutasi SET jumlah='$newcart' WHERE keterangan='$nota' AND kegiatan='$kegiatan' ";
          //               //            $upd=mysqli_query($conn,$sql3);

          //               echo "<script type='text/javascript'>  alert('Jumlah Stok keluar telah ditambah!');</script>";
          //               echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //             } else {
          //               echo "<script type='text/javascript'>  alert('GAGAL, Periksa kembali input anda!');</script>";
          //             }
          //           } else {

          //             $total = $jumlah * $hjual;
          //             $modal = $jumlah * $hbeli;

          //             $sql2 = "insert into stok_keluar_daftar values( '$nota','$kode','$nama','$jumlah','$modal','$total','')";
          //             $insertan = mysqli_query($conn, $sql2);

          //             if ($insertan) {

          //               $sql9 = "INSERT INTO mutasi VALUES('$usr','$today','$kode','$newstok','$jumlah','stok keluar','$nota','','pending')";
          //               $mutasi = mysqli_query($conn, $sql9);


          //               echo "<script type='text/javascript'>  alert('Produk telah dimasukan dalam daftar!');</script>";
          //               echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //             } else {
          //               echo "<script type='text/javascript'>  alert('GAGAL memasukan produk, periksa kembali!');</script>";
          //             }
          //           }
          //         } else {
          //           echo "<script type='text/javascript'>  alert('Gagal mengupdate jumlah stok!');</script>";
          //           echo "<script type='text/javascript'>window.location = '$halaman';</script>";
          //         }
          //       } else {
          //         echo "<script type='text/javascript'>  alert('Jumlah keluar tidak boleh lebih besar dari stok tersedia!');</script>";
          //         echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
          //       }
          //     }
          //   }
          // }

          $query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(subbeli) as beli, SUM(subtotal) as total FROM stok_keluar_daftar WHERE nota=" . autoNumber() . ""));
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
                  <h3 class="box-title">Form Stok Keluar</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">

                  <body>
                    <div class="row">
                      <form method="post" id="formtambahkanbarangkeluar">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label style="font-size: smaller;">Pilih Divisi<span style="color: red;">*</span></label>
                            <select class="form-control select2 select2-hidden-accessible" id="divisi" name="divisi" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                              <option selected="selected" value="">- Pilih Divisi -</option>
                              <?php
                              $sql = mysqli_query($conn, "select * from divisi");
                              while ($row = mysqli_fetch_assoc($sql)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['divisi'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label style="font-size: smaller;">Pilih Barang<span style="color: red;">*</span></label>
                            <select class="form-control select2" style="width: 100%;" name="produk" id="produk" readonly disabled>
                              <option selected="selected">- Pilih Barang -</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label style="font-size: smaller;">Nama Produk<span style="color: red;">*</span></label>
                            <input type="text" class="form-control input-sm" readonly id="nama" name="nama" value="" placeholder="Masukan Nama Barang...">
                            <input type="hidden" class="form-control" readonly id="kode" name="kode" value="">
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
                            <input type="hidden" class="form-control" id="hbeli" name="hargabeli" value="<?php echo $hbeli; ?>" readonly>
                            <input type="hidden" class="form-control" id="hjual" name="hargajual" value="<?php echo $hjual; ?>" readonly>
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
                            <button type="submit" id="keluar" name="keluar" class="btn bg-maroon btn-flat btn-block">Tambahkan</button>
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
                  <h3 class="box-title">Daftar Keluar</h3>

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

                        $sql    = "select * from stok_keluar_daftar where nota =" . autoNumber() . " order by no";
                        $result = mysqli_query($conn, $sql);
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
                                <th style="width:10%">Jumlah Keluar</th>

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
                                      <button type="button" class="btn btn-danger btn-xs" onclick="window.location.href='component/delete/delete_stok?get=<?php echo 'out' . '&'; ?>barang=<?php echo $fill['kode_barang'] . '&'; ?>jumlah=<?php echo $fill['jumlah'] . '&'; ?>&kode=<?php echo $kode . '&'; ?>no=<?php echo $fill['no'] . '&'; ?>forward=<?php echo $tabel . '&'; ?>forwardpage=<?php echo "" . $forwardpage . '&'; ?>chmod=<?php echo $chmod; ?>'">Hapus</button>
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

                          <form method="post" enctype="multipart/form-data" id="forminputmasterbarangkeluar">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label style="font-size: smaller;">No. AWB<span style="color: red;">*</span></label>
                                  <input type="text" class="form-control input-sm" id="awb" name="awb" placeholder="Masukan No. Airway Bill Sebelum Disimpan...">
                                </div>

                                <div class="form-group">
                                  <label style="font-size: smaller;">No. IRF<span style="color: red;">*</span></label>
                                  <input type="text" class="form-control input-sm" id="noirf" name="noirf" placeholder="Masukan No IRF...">
                                </div>

                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                  <label style="font-size: smaller;">User Request<span style="color: red;">*</span></label>
                                  <input type="text" class="form-control input-sm" id="user_request" name="user_request" placeholder="Masukan Nama User Sebelum Disimpan...">
                                </div>

                                <div class="form-group">
                                  <label style="font-size: smaller;">Foto IRF<span style="color: red;">*</span></label>
                                  <input type="file" class="form-control input-sm" id="fotoirf" name="fotoirf">
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label style="font-size: smaller;">Keterangan</label>
                                  <input type="text" class="form-control input-sm" id="keterangan" name="keterangan" placeholder="Masukan Keterangan Sebelum Disimpan...">
                                </div>
                              </div>
                            </div>
                            <input type="hidden" class="form-control" readonly id="notae" name="notae" value="<?php echo autoNumber(); ?>">
                            <input type="hidden" class="form-control" readonly name="modal" value="<?php echo $query['beli']; ?>">
                            <input type="hidden" class="form-control" readonly name="total" value="<?php echo $query['total']; ?>">

                            <div class="row">
                              <div class="form-group col-md-12 col-xs-12">
                                <div class="col-lg-12">
                                  <button type="submit" id="simpan" name="simpan" class="btn btn-flat bg-teal btn-block">SIMPAN</button>
                                </div>

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
            //   if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //     $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
            //     $ket = mysqli_real_escape_string($conn, $_POST["ket"]);
            //     $awb = mysqli_real_escape_string($conn, $_POST["awb"]);
            //     $modal = mysqli_real_escape_string($conn, $_POST["modal"]);
            //     $total = mysqli_real_escape_string($conn, $_POST["total"]);

            //     $tgl = date('Y-m-d');
            //     $usr = $_SESSION['nouser'];
            //     $cab = '01';
            //     $kegiatan = "Stok Keluar";

            //     $namaavatar = $_FILES['avatar']['name'];
            //     $ukuranavatar = $_FILES['avatar']['size'];
            //     $tipeavatar = $_FILES['avatar']['type'];
            //     $tmp = $_FILES['avatar']['tmp_name'];
            //     $avatar = "dist/upload/irf/" . $namaavatar;

            //     if ($namaavatar != '') {

            //       move_uploaded_file($tmp, $avatar);
            //       $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','customer','$usr','$ket','$modal','$total','','$awb','$avatar')";
            //       $insertan = mysqli_query($conn, $sql2);

            //       $mut = "UPDATE mutasi SET status='berhasil' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
            //       $muta = mysqli_query($conn, $mut);

            //       echo "<script type='text/javascript'>  alert('Stok selesai dikeluarkan!');</script>";
            //       echo "<script type='text/javascript'>window.location = 'stok_keluar';</script>";
            //     } else {
            //       echo "<script type='text/javascript'>  alert('GAGAL, terjadi kesalahan!');</script>";
            //       echo "<script type='text/javascript'>window.location = 'stok_out';</script>";
            //     }
            //   }
            // }

            ?>

            <?php

            if (isset($_POST["surat"])) {
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nota = mysqli_real_escape_string($conn, $_POST["notae"]);
                $ket = mysqli_real_escape_string($conn, $_POST["ket"]);
                $tgl = date('Y-m-d');
                $usr = $_SESSION['nouser'];
                $cab = '01';

                $kegiatan = "Stok Keluar";

                $sql2 = "insert into stok_keluar values( '$nota','$cab','$tgl','customer','$usr','$ket','')";
                $insertan = mysqli_query($conn, $sql2);

                $mut = "UPDATE mutasi SET status='berhasil' WHERE keterangan='$nota' AND kegiatan='$kegiatan'";
                $muta = mysqli_query($conn, $mut);


                echo "<script type='text/javascript'>window.location = 'surat_buat?q=$nota';</script>";
              }
            } ?>

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

      <?php
      if ($chmod == 5 || $_SESSION['jabatan'] == 'admin') {
      ?>
        <div class="row">
          <div class="col-lg-12 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Form Input IMEI</h3>

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
                    <label for="barang" class="col-sm-2 control-label">SCAN IMEI :</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nomorimei1" name="nomorimei1" required="true" disabled placeholder="Scan Imei Disini.....">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-xs-12">
            <div class="box">
              <div class="box-header with-border">
                <input id="myInput" type="text" placeholder="Search Imei..">
                <h3 class="box-title">&nbsp;<span> <strong><i>Total data yang masuk </i> : </strong></span>&nbsp;<span id="jumlahbaranginputview"> - </span></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="box-body table-responsive" style="max-height: 220px;">
                  <table class="data table table-hover table-bordered" id="tableimei">
                    <thead style="top:0;position:sticky; background-color:#e7e9ed">
                      <tr>
                        <th style="width:10px">No</th>
                        <th style="width:100px">Code Barang</th>
                        <th>Nama Barang</th>
                        <th>IMEI 1</th>
                        <th>IMEI 2</th>
                        <th>SN</th>
                        <th style="width:350px">Notes</th>
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
      <?php } ?>
      <!-- /.row -->

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
<script src="libs/1.11.4-jquery-ui.min.js"></script>





<script>
  $("#produk").on("change", function() {

    var nama = $("#produk option:selected").attr("nama");
    var kode = $("#produk option:selected").attr("kode");
    var stok = $("#produk option:selected").attr("stok");
    var hbeli = $("#produk option:selected").attr("hargabeli");
    var hjual = $("#produk option:selected").attr("hargajual");


    $("#nama").val(nama);
    $("#kode").val(kode);
    $("#stok").val(stok);
    $("#hbeli").val(hbeli);
    $("#hjual").val(hjual);
    $("#jumlah").val(1);
  });

  $("#divisi").on("change", function() {
    document.getElementById('produk').disabled = true;
    document.getElementById('produk').readonly = true;
    $("#nama").val('');
    $("#kode").val('');
    $("#stok").val('');
    $("#jumlah").val('');
    $('#produk').empty();
    $('#produk').append(`<option selected="selected">- Pilih Barang -</option>`);
    var divisi = $('#divisi').val();
    if (divisi) {
      $.ajax({
        url: "get_divisi_produk.php",
        type: 'post',
        dataType: "json",
        data: {
          divisi: divisi
        },
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
          if (val.status == 200) {
            $('#produk').empty();
            $('#produk').append(`<option selected="selected">- Pilih Barang -</option>`);
            var length = val.responseJSON.length;
            if (length) {
              var arr = [];
              var i = 0;
              for (var j = 0; j < length; j++) {
                arr[i++] = `
                <option value='` + val.responseJSON[j].kode + `' nama='` + val.responseJSON[j].nama + `' kode='` + val.responseJSON[j].kode + `' stok='` + val.responseJSON[j].sisa + `' >
                ` + val.responseJSON[j].sku + ` | ` + val.responseJSON[j].nama + `
                </option>`
              }
              $('#produk').append(arr.join(''));
              document.getElementById('produk').disabled = false;
              document.getElementById('produk').readonly = false;
            } else {
              $('#produk').empty();
              $('#produk').append(`<option selected="selected">- Pilih Barang -</option>`);
              document.getElementById('produk').disabled = false;
              document.getElementById('produk').readonly = false;
            }
          } else {
            $('#produk').empty();
            $('#produk').append(`<option selected="selected">- Pilih Barang -</option>`);
          }
        }
      });
    } else {
      document.getElementById('produk').disabled = true;
      document.getElementById('produk').readonly = true;
      $('#produk').empty();
      $('#produk').append(`<option selected="selected">- Pilih Barang -</option>`);
    }
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

  $('#produk').on('change', function(e) {
    e.preventDefault();
    arraytampungdataimei = [];
    var valproduk = $('#produk').val();
    if (valproduk == '') {
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById('nomorimei1').value = '';
      $('#listdataimeiinput').empty();
      document.getElementById('jumlahbaranginputview').innerHTML = '-';
    } else {
      document.getElementById('nomorimei1').disabled = false;
      document.getElementById('nomorimei1').value = '';
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
        document.getElementById('nomorimei1').value = '';
        document.getElementById('jumlah').focus();
      } else if (this.value < counttr) {
        document.getElementById('nomorimei1').disabled = true;
        document.getElementById('nomorimei1').value = '';
        document.getElementById('jumlah').focus();
      } else {
        document.getElementById('nomorimei1').disabled = false;
        document.getElementById('nomorimei1').value = '';
        document.getElementById('nomorimei1').focus();
      }
    } else {
      if (counttr == 0) {
        document.getElementById('nomorimei1').disabled = false;
      } else {
        document.getElementById('nomorimei1').disabled = true;
      }
      document.getElementById('jumlah').value = 1;
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei1').focus();
    }
  }, 500));


  $('#nomorimei1').keyup(delay(function(e) {
    var nomorimei = this.value;
    var codeproduk = 'SK' + $('#produk').val();
    var namaproduk = $('#nama').val();
    var counttr = $('#tableimei tbody tr').length;
    var jumlahbarangmasuk = $('#jumlah').val();
    var divisi = $('#divisi').val();
    var produk = $('#produk').val();

    if (jumlahbarangmasuk <= counttr) {
      myFunction('Warning', 'Jumlah Barang Masuk Hanya ' + jumlahbarangmasuk + ' Barang');
      document.getElementById('nomorimei1').value = '';
      document.getElementById('nomorimei1').disabled = true;
      document.getElementById("jumlah").focus();
    } else {

      if (this.value) {
        var tottr = counttr + 1;
        // START CHECK IMEI 1
        const itemPos = arraytampungdataimei.findIndex(
          item => item.no_imei1 == this.value
        );
        if (itemPos == -1) {
          // START CHECK IMEI 2
          const itemPos2 = arraytampungdataimei.findIndex(
            item => item.no_imei2 == this.value
          );
          if (itemPos2 == -1) {
            // START CHECK SN
            const itemPos3 = arraytampungdataimei.findIndex(
              item => item.sn == this.value
            );
            if (itemPos3 == -1) {
              $.ajax({
                url: "imei_row.php",
                type: 'post',
                dataType: "json",
                data: {
                  modulview: 'viewrowbarangkeluar',
                  nomorsku: codeproduk,
                  nomorimei: nomorimei,
                  divisi: divisi,
                  produk: produk
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
                  var imei1 = val.responseJSON[0].imei1;
                  var imei2 = val.responseJSON[0].imei2;
                  var sn = val.responseJSON[0].sn;

                  if (sku != 'Kosong') {

                    $('#listdataimeiinput').append(`
                      <tr index="` + tottr + `">
                          <td>` + tottr + `</td>
                          <td><span id="nosku` + tottr + `">` + sku + `</span></td>
                          <td>` + namaproduk + `</td>
                          <td><span id="noimei1` + tottr + `">` + imei1 + `</span></td>
                          <td><span id="noimei2` + tottr + `">` + imei2 + `</span></td>
                          <td><span id="nosn` + tottr + `">` + sn + `</span></td>
                          <td>
                            <select class="form-control" id="notesreturn` + tottr + `" name="notesreturn` + tottr + `">
                              <option selected value="TK">Tidak Dikembalikan</option>
                              <option value="K">Dikembalikan</option>
                            </select>
                            <input type="date" class="form-control" id="datepicker` + tottr + `" name="tanggalreturn` + tottr + `" placeholder="Tanggal Return.." disabled>
                          </td>
                      </tr>
                    `);

                    var status_return = document.getElementById('notesreturn' + tottr).value;
                    var tgl_return = document.getElementById('datepicker' + tottr).value;

                    arraytampungdataimei.push({
                      "kode_barang": sku,
                      "no_imei1": imei1,
                      "no_imei2": imei2,
                      "nota": nota,
                      "status_return": status_return,
                      "tgl_return": tgl_return,
                      "sn": sn
                    });

                    $('#notesreturn' + tottr).on('change', function(e) {
                      e.preventDefault();
                      var valuereturn = this.value;
                      var indextr = $(this).closest('tr').attr('index');
                      var nosku = document.getElementById('nosku' + indextr).innerHTML;
                      var noimei1 = document.getElementById('noimei1' + indextr).innerHTML;
                      var noimei2 = document.getElementById('noimei2' + indextr).innerHTML;
                      var nosn = document.getElementById('nosn' + indextr).innerHTML;

                      if (valuereturn == 'TK') {
                        document.getElementById('datepicker' + tottr).disabled = true;
                        document.getElementById('datepicker' + tottr).value = '';
                        var tglreturnindextk = document.getElementById('datepicker' + indextr).value;
                        const itemFind = arraytampungdataimei.findIndex(
                          item => item.no_imei1 == noimei1,
                          item => item.no_imei2 == noimei2,
                          item => item.nosn
                        );
                        arraytampungdataimei.splice(itemFind, 1);
                        arraytampungdataimei.push({
                          "kode_barang": nosku,
                          "no_imei1": noimei1,
                          "no_imei2": noimei2,
                          "nota": nota,
                          "status_return": valuereturn,
                          "tgl_return": tglreturnindextk,
                          "sn": nosn
                        });
                      } else {
                        document.getElementById('datepicker' + tottr).disabled = false;
                      }
                    });

                    $('#datepicker' + tottr).on('change', function(e) {
                      e.preventDefault();
                      var indextr = $(this).closest('tr').attr('index');
                      var nosku = document.getElementById('nosku' + indextr).innerHTML;
                      var noimei1 = document.getElementById('noimei1' + indextr).innerHTML;
                      var noimei2 = document.getElementById('noimei2' + indextr).innerHTML;
                      var valuereturn = document.getElementById('notesreturn' + indextr).value;
                      var nosn = document.getElementById('nosn' + indextr).innerHTML;

                      const itemFind = arraytampungdataimei.findIndex(
                        item => item.no_imei1 == noimei1,
                        item => item.no_imei2 == noimei2,
                        item => item.nosn
                      );
                      arraytampungdataimei.splice(itemFind, 1);

                      arraytampungdataimei.push({
                        "kode_barang": nosku,
                        "no_imei1": noimei1,
                        "no_imei2": noimei2,
                        "nota": nota,
                        "status_return": valuereturn,
                        "tgl_return": this.value,
                        "sn": nosn
                      });
                    });
                    document.getElementById('jumlahbaranginputview').innerHTML = (tottr);
                    document.getElementById('totalscan').value = (tottr);
                    document.getElementById('nomorimei1').value = '';
                    document.getElementById("nomorimei1").focus();
                  } else {
                    myFunction('Warning', 'Data Imei Tidak Terdapat Didalam Database!!!');
                    document.getElementById('nomorimei1').value = '';
                    document.getElementById("nomorimei1").focus();
                  }
                }
              });
            } else {
              myFunction('Warning', 'Data SN Sudah DIinput');
              document.getElementById('nomorimei1').value = '';
              document.getElementById("nomorimei1").focus();
            }
            // END CHECK SN
          } else {
            myFunction('Warning', 'Data IMEI 2 Sudah Diinput');
            document.getElementById('nomorimei1').value = '';
            document.getElementById("nomorimei1").focus();
          }
          // END CHECK IMEI 2
        } else {
          myFunction('Warning', 'Data IMEI 1 Sudah Diinput');
          document.getElementById('nomorimei1').value = '';
          document.getElementById("nomorimei1").focus();
        }
        // END CHECK IMEI 1
      } else {
        myFunction('Warning', 'Check Input Nomor IMEI...');
        document.getElementById('nomorimei1').value = '';
        document.getElementById("nomorimei1").focus();
      }
    }
  }, 500));

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

  $("#formtambahkanbarangkeluar").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var formDivisi = document.getElementById('divisi').value;
    var formProduk = document.getElementById('produk').value;
    var formNama = document.getElementById('nama').value;
    var formKode = document.getElementById('kode').value;
    var formNota = document.getElementById('nota').value;
    var formStok = document.getElementById('stok').value;
    var formJumlah = document.getElementById('jumlah').value;
    var totalscan = document.getElementById('totalscan').value;

    var formDivisicheck = (formDivisi) ? 'True' : 'False';
    var formProdukcheck = (formProduk) ? 'True' : 'False';
    var formNamacheck = (formNama) ? 'True' : 'False';
    var formKodecheck = (formKode) ? 'True' : 'False';
    var formNotacheck = (formNota) ? 'True' : 'False';
    var formStokcheck = (formStok) ? 'True' : 'False';
    var formJumlahcheck = (formJumlah) ? 'True' : 'False';

    var arrdata = [formDivisicheck, formProdukcheck, formNamacheck, formKodecheck, formNotacheck, formStokcheck, formJumlahcheck];
    let checkFormTrue = arrdata.filter(x => x == 'True').length;


    if (checkFormTrue == 7) {
      if (totalscan < formJumlah) {
        myFunction('Warning', 'Data Imei/SN Belum Di Scan!!!');
      } else {
        $.ajax({
          url: "form_stok_keluar_detail.php",
          type: 'post',
          cache: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          data: formData,
          beforeSend: function() {
            $('#keluar').empty();
            $('#keluar').append(`<i class="fa fa-spinner fa-spin"></i>Loading...`);
            document.getElementById('keluar').disabled = true;
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
                url: "imei_keluar.php",
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
                    window.location = 'stok_out';
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


  $("#forminputmasterbarangkeluar").on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var formAwb = document.getElementById('awb').value;
    var formNoIrf = document.getElementById('noirf').value;
    var formUser = document.getElementById('user_request').value;
    var formFotoIrf = document.getElementById('fotoirf').value;
    // var formKeterangan = document.getElementById('keterangan').value;
    var formNota = document.getElementById('notae').value;

    var formAwbcheck = (formAwb) ? 'True' : 'False';
    var formNoIrfcheck = (formNoIrf) ? 'True' : 'False';
    var formUsercheck = (formUser) ? 'True' : 'False';
    var formFotoIrfcheck = (formFotoIrf) ? 'True' : 'False';
    // var formKeterangancheck = (formKeterangan) ? 'True' : 'False';
    var formNotacheck = (formNota) ? 'True' : 'False';

    var arrdata = [formAwbcheck, formNoIrfcheck, formUsercheck, formFotoIrfcheck, formNotacheck];
    let checkFormTrue = arrdata.filter(x => x == 'True').length

    if (checkFormTrue == 5) {
      $.ajax({
        url: "form_stok_keluar_master.php",
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
            window.location = 'stok_keluar';
          } else {
            myFunction('Error', val.status);
          }
        }
      });
    } else {
      myFunction('Warning', 'Masih terdapat form yang kosong!!!');
    }
  });

  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#listdataimeiinput tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
  // END Function javascript untuk IMEI
</script>
</body>

</html>