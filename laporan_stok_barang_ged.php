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
    </style>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Laporan Stok Barang GED
                <small>Forms</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="laporan_imei_sn">Forms</a></li>
                <li class="active">Laporan Stok Barang GED</li>
            </ol>
        </section>
        <section class="content">

            <!-- START TESTING BODY FORM  -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">Form Laporan Stok:</h4>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <div class="table-responsive">
                        <div id="main">
                            <div class="container-fluid">
                                <div class="box-body col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-danger">
                                                <div class="box-header with-border">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label style="font-size: smaller;">Divisi<span style="color: red;">*</span></label>
                                                                    <select class="form-control select2 select2-hidden-accessible" id="divisi" name="divisi" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                                        <?php
                                                                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                                                                        echo "<option value='' selected>- Semua Divisi -</option>";
                                                                        $sql = mysqli_query($conn, "select id,divisi from divisi");
                                                                        while ($row = mysqli_fetch_assoc($sql)) {
                                                                            echo "<option value='" . $row['id'] . "'>" . $row['divisi'] . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label style="font-size: smaller;">Produk</label>
                                                                    <select class="form-control select2" style="width: 100%;" name="produk" id="produk" readonly disabled>
                                                                        <option selected="selected" value="">- Semua Produk Barang -</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
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
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label style="font-size: smaller;">Date range:</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control input-sm pull-right" id="rangedate" name="rangedate" value="<?= ($rangedate) ? $rangedate : '' ?>">
                                                                    </div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-file-excel-o"></i> Export&nbsp;
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export All Product</a></li>
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export All Product Divisi</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export All Aktivitas</a></li>
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export Aktivitas Stok Masuk</a></li>
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export Aktivitas Stok Keluar</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="export-data"><i class="fa fa-file-excel-o"></i> Export IMEI-SN</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END TESTING BODY FORM -->
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
    $("#divisi").on("change", function() {
        document.getElementById('produk').disabled = true;
        document.getElementById('produk').readonly = true;
        $('#produk').empty();
        $('#produk').append(`<option selected="selected" value="">- Semua Produk Barang -</option>`);
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
                        $('#produk').append(`<option selected="selected" value="">- Semua Produk Barang -</option>`);
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
                            $('#produk').append(`<option selected="selected" value="">- Semua Produk Barang -</option>`);
                            document.getElementById('produk').disabled = false;
                            document.getElementById('produk').readonly = false;
                        }
                    } else {
                        $('#produk').empty();
                        $('#produk').append(`<option selected="selected" value="">- Semua Produk Barang -</option>`);
                    }
                }
            });
        } else {
            document.getElementById('produk').disabled = true;
            document.getElementById('produk').readonly = true;
            $('#produk').empty();
            $('#produk').append(`<option selected="selected" value="">- Semua Produk Barang -</option>`);
        }
    });

    //Date range picker
    $('#rangedate').daterangepicker();
    $("#exportexcelimei").click(function() {
        var produk = $('#produk').val();
        var rangedate = $('#rangedate').val().split("-");
        var date1 = rangedate[0].trim();
        var date2 = rangedate[1].trim();
        window.location.href = 'configuration/config_exportimei?produk=' + produk + '&status=' + status + '&date1=' + date1 + '&date2=' + date2;
    });

    $(document).on('click', "a[id='export-data']", function(e) {
        e.preventDefault();
        var divisi = $('#divisi').val();
        var produk = $('#produk').val();
        var rangedate = $('#rangedate').val().split("-");
        var date1 = rangedate[0].trim();
        var date2 = rangedate[1].trim();
        var typeexport = $(this).text();
        window.location.href = 'configuration/config_export_ged_data?typeexport=' + typeexport + '&divisi=' + divisi + '&produk=' + produk + '&date1=' + date1 + '&date2=' + date2;
    });
</script>
</body>

</html>