<!DOCTYPE html>
<html>
<?php
include "configuration/config_etc.php";
include "configuration/config_include.php";
include "configuration/config_alltotal.php";
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
        table {
            border-collapse: collapse;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        th,
        td {
            padding: 8px 16px;
            border: 1px solid #ccc;
        }

        th {
            background: #eee;
        }

        tr {
            font-size: small;
        }

        .box-header {
            padding: 0px;
        }


        .content-header>.breadcrumb {
            padding: 1px 10px;
        }


        /* Important part */
        .modal-dialog {
            overflow-y: initial !important
        }

        .modal-body {
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
    </style>
    <?php
    $decimal = "0";
    $a_decimal = ",";
    $thousand = ".";
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
                    $halaman = "tracking"; // halaman
                    $dataapa = "Tracking Barang"; // data
                    $tabeldatabase = "stok_keluar"; // tabel database
                    $chmod = $chmenu8; // Hak akses Menu
                    $forward = mysqli_real_escape_string($conn, $tabeldatabase); // tabel database
                    $forwardpage = mysqli_real_escape_string($conn, $halaman); // halaman
                    $search = $_POST['search'];

                    ?>

                    <!-- SETTING STOP -->

                    <textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
                    <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
                    <script type="text/javascript">
                        function printDiv(elementId) {
                            var a = document.getElementById('printing-css').value;
                            var b = document.getElementById(elementId).innerHTML;
                            window.frames["print_frame"].document.title = document.title;
                            window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
                            window.frames["print_frame"].window.focus();
                            window.frames["print_frame"].window.print();
                        }
                    </script>

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

                        $sqla = "SELECT no, COUNT( * ) AS totaldata FROM $forward";
                        $hasila = mysqli_query($conn, $sqla);
                        $rowa = mysqli_fetch_assoc($hasila);
                        $totaldata = $rowa['totaldata'];

                        ?>
                        <div class="box" id="tabel1">
                            <section class="content-header">
                                <h1 style="font-size: large;">
                                    Data <?php echo $dataapa ?> <span class="no-print label label-default" id="no-print"><?php echo $totaldata; ?></span>
                                </h1>
                                <ol class="breadcrumb">
                                    <form method="post">
                                        <div class="input-group input-group-sm" style="width: 250px;">
                                            <input type="text" name="search" class="form-control input-sm pull-right" placeholder="Cari">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </ol>
                            </section>
                            <hr>
                            <!-- /.box-header -->
                            <!-- /.Paginasi -->
                            <?php
                            error_reporting(E_ALL ^ E_DEPRECATED);
                            $sql    = "select tgl, awb, no_irf from stok_keluar order by no desc";
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
                                            <th style="text-align: center;">No</th>
                                            <th style="text-align: center;">Tanggal</th>
                                            <th style="text-align: center;">Awb</th>
                                            <th style="text-align: center;">IRF</th>
                                            <th style="text-align: center;">#</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                    $search = $_POST['search'];

                                    if ($search != null || $search != "") {

                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                                            if (isset($_POST['search'])) {
                                                $query1 = "SELECT tgl, awb, no_irf FROM  $forward where 
                                                UPPER(awb) like UPPER('%$search%') 
                                                or UPPER(no_irf) like UPPER('%$search%')
                                                order by no desc limit $rpp";
                                                $hasil = mysqli_query($conn, $query1);
                                                $no = 1;
                                                while ($fill = mysqli_fetch_assoc($hasil)) {
                                    ?>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo ++$no_urut; ?></td>
                                                            <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
                                                            <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                                                            <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['no_irf']); ?></td>
                                                            <td style="text-align: center;"><button type="button" class="btn btn-info btn-xs" value="<?= $fill['awb'] ?>" id="btnchecktracking" data-toggle="modal" data-target="#modal-tracking"><i class='fa fa-eye'></i></button></td>
                                                        </tr>
                                                    <?php
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
                                    <td style="text-align: center;"><?php echo ++$no_urut; ?></td>
                                    <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['tgl']); ?></td>
                                    <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['awb']); ?></td>
                                    <td style="text-align: center;"><?php echo mysqli_real_escape_string($conn, $fill['no_irf']); ?></td>
                                    <td style="text-align: center;"><button type="button" class="btn btn-info btn-xs" value="<?= $fill['awb'] ?>" id="btnchecktracking" data-toggle="modal" data-target="#modal-tracking"><i class='fa fa-eye'></i></button></td>
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
                        </div>
                    <?php } else {
                    } ?>
                </div>
            </div>
            <!-- ./col -->
    </div>
    <!-- Start Modal Tracking -->
    <div class="modal fade in" id="modal-tracking">
        <div class="modal-dialog" style="width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Detail Tracking (awb) :</h4>
                </div>
                <div class="modal-body" style="background-color: #ecf0f5;">
                    <section class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="timeline" id="settimeline">
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Tracking -->
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

<script>
    $(document).on('click', "button[id='btnchecktracking']", function(e) {
        e.preventDefault();
        var awb = $(this).val();
        $.ajax({
            url: "gettrack.php",
            type: 'post',
            dataType: "json",
            data: {
                awb: awb
            },
            beforeSend: function() {
                $('#settimeline').empty();
            },
            success: function(data) {
                $('#settimeline').empty();
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
                $('#settimeline').append(msg);
            },
            complete: function(val) {
                var statusajax = val.responseJSON['Status'];
                $('#settimeline').empty();
                if (statusajax == 'Success') {
                    var length = val.responseJSON['Data'].length;
                    var arr = [];
                    var i = 0;
                    for (var j = 0; j < length; j++) {
                        if (val.responseJSON['Data'][j].header == 'delivered') {

                            arr[i++] = '<li>';
                            arr[i++] = '<i class="fa fa-truck bg-aqua"></i>';
                            arr[i++] = '<div class="timeline-item">';
                            arr[i++] = '<span class="time"><i class="fa fa-clock-o"></i> ' + val.responseJSON['Data'][j].timeline + '</span>';
                            arr[i++] = '<h3 class="timeline-header"><a href="#">' + val.responseJSON['Data'][j].header + '</a> (' + val.responseJSON['Data'][j].status.toLowerCase() + ')</h3>';
                            arr[i++] = `<div class="timeline-body">` + val.responseJSON['Data'][j].remarks + `<br> <div id="imagesetrack"></div></div>`;
                            arr[i++] = '<div class="timeline-footer"><i>' + val.responseJSON['Data'][j].user + '</i></div>';
                            arr[i++] = '</div>';
                            arr[i++] = '</li>';

                            $.ajax({
                                url: "gettrackimage.php",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    awb: awb
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
                                    console.log(msg);
                                },
                                complete: function(val) {
                                    var statusajaximage = val.responseJSON['Status'];
                                    if (statusajaximage == 'Success') {
                                        var pod = val.responseJSON['Data'][0].pod;
                                        var map = val.responseJSON['Data'][0].map;
                                        var signature = val.responseJSON['Data'][0].signature;
                                        var location = val.responseJSON['Data'][0].location;
                                        var receiver = val.responseJSON['Data'][0].receiver;
                                        var setimagehtmlpod = (pod) ? '<img src="https://appl.ged.co.id/gedtrace/assets/uploads/sdr/' + pod + '" class="margin" width="140" height="100">' : '';
                                        var setimagehtmlmap = (map) ? '<img src="https://maps.googleapis.com/maps/api/staticmap?center=' + map.replace(/\s/g, '') + '&amp;zoom=15&amp;markers=color:green|' + map.replace(/\s/g, '') + '&amp;path=color:0x0000FF80|weight:5|' + map.replace(/\s/g, '') + '&amp;size=140x100&amp;sensor=false&amp;key=AIzaSyBpHnSwDwwLzzX8hKN2CuEpgzwceixSgzg" class="margin">' : '';
                                        var setimagehtmlsignature = (signature) ? '<img src="https://appl.ged.co.id/gedtrace/assets/uploads/signature/' + signature + '" class="margin" width="140" height="100">' : '';
                                        var setimagehtmllocation = (location) ? '<img src="https://appl.ged.co.id/gedapi/assets/uploads/location/' + location + '" class="margin" width="140" height="100">' : '';
                                        var setimagehtmlreceiver = (receiver) ? '<img src="https://appl.ged.co.id/gedapi/assets/uploads/receiver/' + receiver + '" class="margin" width="140" height="100">' : '';
                                        $('#imagesetrack').append(setimagehtmlpod + setimagehtmlmap + setimagehtmlsignature + setimagehtmllocation + setimagehtmlreceiver);
                                    } else {

                                    }
                                }
                            });
                        } else {
                            arr[i++] = '<li>';
                            arr[i++] = '<i class="fa fa-truck bg-aqua"></i>';
                            arr[i++] = '<div class="timeline-item">';
                            arr[i++] = '<span class="time"><i class="fa fa-clock-o"></i> ' + val.responseJSON['Data'][j].timeline + '</span>';
                            arr[i++] = '<h3 class="timeline-header"><a href="#">' + val.responseJSON['Data'][j].header + '</a> (' + val.responseJSON['Data'][j].status.toLowerCase() + ')</h3>';
                            arr[i++] = '<div class="timeline-body">' + val.responseJSON['Data'][j].remarks + '</div>';
                            arr[i++] = '<div class="timeline-footer"><i>' + val.responseJSON['Data'][j].user + '</i></div>';
                            arr[i++] = '</div>';
                            arr[i++] = '</li>';
                        }
                    }
                    $('#settimeline').append(arr.join(''));
                } else {
                    $('#settimeline').append('Tidak Ada Tracking Atas Nomor Ini...');
                }
            }
        });
    });
</script>

</body>

</html>