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
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- ./col -->

          <!-- SETTING START-->
          <?php
          error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
          include "configuration/config_chmod.php";
          $halaman = "barang"; // halaman
          $dataapa = "Barang"; // data
          $tabeldatabase = "barang"; // tabel database
          $chmod = $chmenu4; // Hak akses Menu
          $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
          $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
          $id = $_GET['q'];
          ?>
          <!-- SETTING STOP -->

          <?php

          function autoNumber()
          {
            include "configuration/config_connect.php";
            global $forward;
            $query = "SELECT MAX(no) as max_id FROM $forward ORDER BY no";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_array($result);
            $id_max = $data['max_id'];
            $sort_num = $id_max;
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            return $new_code;
          }


          function autoKate()
          {
            include "configuration/config_connect.php";
            $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM kategori ORDER BY kode";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_array($result);
            $id_max = $data['max_id'];
            $sort_num = (int) substr($id_max, 1, 4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            return $new_code;
          }


          function autoSatu()
          {
            include "configuration/config_connect.php";
            $query = "SELECT MAX(RIGHT(kode, 4)) as max_id FROM satuan ORDER BY kode";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_array($result);
            $id_max = $data['max_id'];
            $sort_num = (int) substr($id_max, 1, 4);
            $sort_num++;
            $new_code = sprintf("%04s", $sort_num);
            return $new_code;
          }

          $m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT mode FROM backset"));
          $mode = $m['mode'];
          ?>

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




          <!-- BOX INFORMASI -->
          <?php
          if ($chmod == 5 || $_SESSION['jabatan'] == 'admin') {
          ?>

            <?php
            if (isset($id) && $id != '') {
              $w = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE no='$id'"));
              $formkodebarang = $w['kode'];
              $formskubarang = $w['sku'];
              $formnamabarang = $w['nama'];
              $formkategoribarang = $w['kategori'];
              $formsatuanbarang = $w['satuan'];
              $formmerekbarang = $w['brand'];
              $formstokminimalbarang = $w['stokmin'];
              $formbarcodebarang = $w['barcode'];
              $formpanjangbarang = $w['p'];
              $formlebarbarang = $w['l'];
              $formtinggibarang = $w['t'];
              $formlokasirakbarang = $w['lokasi'];
              $formtanggalmasukbarang = $w['expired'];
              $formketeranganspesifikasibarang = $w['keterangan'];
            } else {
              $formkodebarang = autoNumber();
              $formskubarang = 'SK' . autoNumber();
              $formnamabarang = "";
              $formkategoribarang = "";
              $formsatuanbarang = "";
              $formmerekbarang = "";
              $formstokminimalbarang = 1;
              $formbarcodebarang = 'BR' . autoNumber();
              $formpanjangbarang = "";
              $formlebarbarang = "";
              $formtinggibarang = "";
              $formlokasirakbarang = "";
              $formtanggalmasukbarang = "";
              $formketeranganspesifikasibarang = "-";
            }
            ?>

            <!-- KONTEN BODY AWAL -->
            <!-- START TESTING BODY FORM  -->
            <div class="box box-default">
              <div class="box-header with-border">
                <h4 class="box-title">Tambah Barang:</h4>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <div id="main">
                    <div class="container-fluid">
                      <form method="post" enctype="multipart/form-data">
                        <div class="box-body col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">SKU Barang<span style="color:red;">*</span></label>
                                        <input class="form-control" type="hidden" id="kode" name="kode" value="<?php echo $formkodebarang; ?>">
                                        <input type="text" class="form-control input-sm" placeholder="Masukan No. SKU Barang..." readonly="readonly" id="sku" name="sku" value="<?php echo $formskubarang; ?>" required="true">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Nama Barang<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control input-sm" name="nama" maxlength="200" autocomplete="off" placeholder="Masukan Nama Barang..." value="<?php echo $formnamabarang; ?>" required="true">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Barcode<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control input-sm " name="barcode" placeholder="Masukan Barcode Barang..." readonly="readonly" value="<?php echo $formbarcodebarang; ?>" required="true">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Merek Barang<span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <select class="form-control input-sm" style="width: 100%;" name="merek" required="true">
                                            <?php
                                            $sql = mysqli_query($conn, "select * from brand");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                              if ($formmerekbarang == $row['nama'])
                                                echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                              else
                                                echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                            }
                                            ?>
                                          </select><span class="input-group-btn">
                                            <a class="btn btn-sm btn-info" href="add_merek"><i class="fa fa-edit" aria-hidden="true"></i> </a></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Kategori Barang<span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <select class="form-control input-sm" style="width: 100%;" name="kategori" required="true">
                                            <?php
                                            $sql = mysqli_query($conn, "select * from kategori");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                              if ($formkategoribarang == $row['nama'])
                                                echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                              else
                                                echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                            }
                                            ?>
                                          </select><span class="input-group-btn">
                                            <a class="btn btn-sm btn-info" href="add_kategori"><i class="fa fa-edit" aria-hidden="true"></i> </a></span>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Stok Sekarang<span style="color:red;">*</span></label>
                                        <input type="number" class="form-control input-sm" placeholder="Masukan Stok Sekarang..." readonly="readonly" value="0">
                                      </div>

                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Satuan<span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <select class="form-control input-sm" style="width: 100%;" name="satuan" required="true">
                                            <?php
                                            $sql = mysqli_query($conn, "select * from satuan");
                                            while ($row = mysqli_fetch_assoc($sql)) {
                                              if ($formsatuanbarang == $row['nama'])
                                                echo "<option value='" . $row['nama'] . "' selected='selected'>" . $row['nama'] . "</option>";
                                              else
                                                echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                            }
                                            ?>
                                          </select><span class="input-group-btn">
                                            <a class="btn btn-sm btn-info" href="add_satuan"><i class="fa fa-edit" aria-hidden="true"></i> </a></span>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Stok Minimal<span style="color:red;">*</span></label>
                                        <input type="number" min="1" name="stok_minimal" class="form-control input-sm " placeholder="Masukan Stok Minimal..." readonly="readonly" required="true" value="<?php echo $formstokminimalbarang; ?>">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="box-body col-md-6">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="box box-danger">
                                <div class="box-header with-border">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Lokasi Rak<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control input-sm" name="lokasi" placeholder="Masukan Lokasi Rak..." value="<?php echo $formlokasirakbarang; ?>" required="true">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Tanggal Masuk Barang<span style="color:red;">*</span></label>
                                        <input id="datepicker" type="text" class="form-control input-sm datepicker-here" data-language="en" name="expired" autocomplete="off" placeholder="Masukan Tanggal Masuk Barang..." value="<?php echo $formtanggalmasukbarang; ?>" required="true">
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Keterangan - Spesifikasi Barang Detail<span style="color:red;">*</span></label>
                                        <input type="text" class="form-control input-sm" name="keterangan" autocomplete="off" placeholder="Masukan Keterangan / Spesifikasi..." value="<?php echo $formketeranganspesifikasibarang; ?>" required="true">
                                      </div>
                                      <div class="form-group">
                                        <label style="font-size: smaller;">Gambar Barang<span style="color:red;">*</span></label>
                                        <input type="file" class="form-control input-sm " required="true" name="avatar" placeholder="Masukan Gambar Barang...">
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">P<span style="font-size:8px;">(Panjang)Cm</span><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <input type="number" class="form-control input-sm" name="p" placeholder="Panjang..." value="<?php echo $formpanjangbarang; ?>" required="true">
                                          <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                        </div>
                                      </div>
                                      <p style="font-size: 7px;">**Diisi dengan mengikuti Contoh = 10, 9.7 dan dihitung dalam CM -> <b>P(Panjang)</b><span style="color:red;">*</span></p>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">L<span style="font-size:8px;">(Lebar)Cm</span><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <input type="number" class="form-control input-sm" name="l" placeholder="Lebar..." value="<?php echo $formlebarbarang; ?>" required="true">
                                          <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                        </div>
                                      </div>
                                      <p style="font-size: 7px;">**Diisi dengan mengikuti Contoh = 10, 9.7 dan dihitung dalam CM -> <b>L(Lebar)</b><span style="color:red;">*</span></p>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label style="font-size: smaller;">T<span style="font-size:8px;">(Tinggi)Cm</span><span style="color:red;">*</span></label>
                                        <div class="input-group">
                                          <input type="number" class="form-control input-sm" name="t" placeholder="Tinggi..." value="<?php echo $formtinggibarang; ?>" required="true">
                                          <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                        </div>
                                      </div>
                                      <p style="font-size: 7px;">**Diisi dengan mengikuti Contoh = 10, 9.7 dan dihitung dalam CM -> <b>T(Tinggi)</b><span style="color:red;">*</span></p>
                                    </div>

                                    <?php
                                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                    if ($mode >= 1) {
                                    ?>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label style="font-size: smaller;">Harga Beli</label>
                                          <input class="form-control" name="harga_beli" required autocomplete="off" value="<?php echo $w['hargabeli']; ?>">
                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label style="font-size: smaller;">Harga Jual</label>
                                          <input class="form-control" name="harga_jual" required autocomplete="off" value="<?php echo $w['hargajual']; ?>">
                                        </div>
                                      </div>
                                    <?php } ?>

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="box-footer">
                            <button class="btn btn-sm btn-primary" type="submit" name="savebarang"><i class="fa fa-check-square-o" aria-hidden="true"></i> Simpan</button>
                            <a class="btn btn-sm btn-warning" href="add_barang"><i class="fa fa-retweet" aria-hidden="true"></i>
                              Reset</a>
                            <a class="btn btn-sm btn-danger" href="barang"><i class="fa fa-window-close" aria-hidden="true"></i> Batal</a>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- KONTEN BODY AKHIR -->
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            </div>
            <!-- END TESTING BODY FORM -->
            <!-- Default box -->
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

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['savebarang'])) {

          $kode = mysqli_real_escape_string($conn, $_POST["kode"]);
          $sku = mysqli_real_escape_string($conn, $_POST["sku"]);
          $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
          $satuan = mysqli_real_escape_string($conn, $_POST["satuan"]);
          $kategori = mysqli_real_escape_string($conn, $_POST["kategori"]);
          $hargabeli = mysqli_real_escape_string($conn, $_POST["harga_beli"]);
          $hargajual = mysqli_real_escape_string($conn, $_POST["harga_jual"]);
          $stok = mysqli_real_escape_string($conn, $_POST["stok"]);
          $stokmin = mysqli_real_escape_string($conn, $_POST["stok_minimal"]);

          $ukuran = mysqli_real_escape_string($conn, $_POST["ukuran"]);
          $p = mysqli_real_escape_string($conn, $_POST["p"]);
          $l = mysqli_real_escape_string($conn, $_POST["l"]);
          $t = mysqli_real_escape_string($conn, $_POST["t"]);

          $warna = mysqli_real_escape_string($conn, $_POST["warna"]);
          $brand = mysqli_real_escape_string($conn, $_POST["merek"]);
          $rak = mysqli_real_escape_string($conn, $_POST["lokasi"]);
          $exp = mysqli_real_escape_string($conn, $_POST["expired"]);
          $ket = mysqli_real_escape_string($conn, $_POST["keterangan"]);

          $barcode = mysqli_real_escape_string($conn, $_POST["barcode"]);
          $namaavatar = $_FILES['avatar']['name'];
          $ukuranavatar = $_FILES['avatar']['size'];
          $tipeavatar = $_FILES['avatar']['type'];
          $tmp = $_FILES['avatar']['tmp_name'];
          $avatar = "dist/upload/" . $namaavatar;
          $insert = ($_POST["insert"]);


          $sql = "select * from $tabeldatabase where kode='$kode'";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            if ($namaavatar != '') {
              move_uploaded_file($tmp, $avatar);

              $sql1 = "UPDATE barang SET sku='$sku', nama='$nama',kategori='$kategori',hargabeli='$hargabeli',hargajual='$hargajual',keterangan='$ket',satuan='$satuan',stokmin='$stokmin',barcode='$barcode',brand='$brand',lokasi='$rak',expired='$exp',warna='$warna',ukuran='$ukuran', p='$p', l='$l', t='$t', avatar='$avatar' WHERE kode='$kode'";

              if (mysqli_query($conn, $sql1)) {
                echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
              } else {
                echo "<script type='text/javascript'>  alert('GAGAL, terjadi kesalahan!'); </script>";
                echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
              }
            } else if ($chmod >= 3 || $_SESSION['jabatan'] == 'admin') {

              $sql1 = "UPDATE barang SET sku='$sku', nama='$nama',kategori='$kategori',hargabeli='$hargabeli',hargajual='$hargajual',keterangan='$ket',satuan='$satuan',stokmin='$stokmin',barcode='$barcode',brand='$brand',lokasi='$rak',expired='$exp',warna='$warna',ukuran='$ukuran', p='$p', l='$l', t='$t' WHERE kode='$kode'";

              if (mysqli_query($conn, $sql1)) {
                echo "<script type='text/javascript'>  alert('Berhasil, Data barang telah diupdate!'); </script>";
                echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
              } else {
                echo "<script type='text/javascript'>  alert('GAGAL, terjadi kesalahan!'); </script>";
                echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
              }
            } else {

              echo "<script type='text/javascript'>  alert('Gagal, Data gagal diupdate!'); </script>";
              echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
            }
          } else if (($chmod >= 2 || $_SESSION['jabatan'] == 'admin')) {
            move_uploaded_file($tmp, $avatar);
            $sql2 = "insert into $tabeldatabase values('$kode','$sku','$nama','$hargabeli','$hargajual','$ket','$kategori','$satuan','','','$stok','$stokmin','$barcode','$brand','$rak','$exp','$warna','$ukuran','$p','$l','$t','$avatar','')";
            if (mysqli_query($conn, $sql2)) {
              echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
              echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
            } else {
              $avatar = "dist/upload/index.jpg";
              $sql2 = "insert into $tabeldatabase values('$kode','$sku','$nama','$hargabeli','$hargajual','$ket','$kategori','$satuan','','','$stok','$stokmin','$barcode','$brand','$rak','$exp','$warna','$ukuran','$p','$l','$t','$avatar','')";
              if (mysqli_query($conn, $sql2)) {
                echo "<script type='text/javascript'>  alert('Berhasil, Data telah disimpan!'); </script>";
                echo "<script type='text/javascript'>window.location = '$forwardpage';</script>";
              } else {

                echo "<script type='text/javascript'>  alert('Gagal, Data gagal disimpan!'); </script>";
              }
            }
          }
        }
      }

      ?>



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
<script src="dist/plugins/jQuery/jquery-ui.min.js"></script>

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
</script>
</body>

</html>