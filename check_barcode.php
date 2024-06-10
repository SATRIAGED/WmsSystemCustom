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
</style>
<div class="wrapper">
    <?php
    theader();
    menu();
    ?>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Check Barcode Barang</h1>
            <ol class="breadcrumb">
                <li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Check Barcode Barang</li>
            </ol>
        </section>
        <section class="content">
            <div id="snackbar">
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-default">
                        <div class="box-body">
                            <div class="table-responsive">
                                <div id="main">
                                    <div class="container-fluid">
                                        <div class="box-body col-md-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Scan Barcode Barang<span style="color:red;">*</span></label>
                                                                        <input type="text" class="form-control input-sm" placeholder="Scan Barcode..." id="barcode" name="barcode" value="" required="true">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Scan Barcode Foto</label>
                                                                        <div id="reader"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="box-body col-md-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="box box-danger">
                                                        <div class="box-header with-border">
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <center><img class="img-responsive" id="image-product" src="" onerror="this.src='dist/img/noimage.jpg'" width="150" alt="User profile picture"></center>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="form-group">
                                                                            <center>
                                                                                <table class="table">
                                                                                    <tbody style="font-size: smaller;">
                                                                                        <tr>
                                                                                            <th style="width: 50%;">Masuk:</th>
                                                                                            <td id="tabmasuk">0</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Keluar:</th>
                                                                                            <td id="tabkeluar">0</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Tersedia:</th>
                                                                                            <td id="tabsisa">0</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>Lokasi:</th>
                                                                                            <td id="tablokasi">-</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </center>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">SKU</label>
                                                                        <input type="text" class="form-control input-sm" id="sku" placeholder="SKU..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Barcode</label>
                                                                        <input type="text" class="form-control input-sm" id="dbarcode" autocomplete="off" placeholder="Barcode..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Nama Barang</label>
                                                                        <input type="text" class="form-control input-sm" id="namabarang" autocomplete="off" placeholder="Nama Barang..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Lokasi</label>
                                                                        <input type="text" class="form-control input-sm" id="lokasi" placeholder="Lokasi.." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Merek</label>
                                                                        <input type="text" class="form-control input-sm" id="merek" autocomplete="off" placeholder="Merek..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Kategori</label>
                                                                        <input type="text" class="form-control input-sm" id="kategori" autocomplete="off" placeholder="Kategori..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Satuan</label>
                                                                        <input type="text" class="form-control input-sm" id="satuan" autocomplete="off" placeholder="Satuan..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">P<span style="font-size:8px;">(Panjang)Cm</span></label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control input-sm" id="p" placeholder="Panjang..." value="" readonly="readonly">
                                                                            <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">L<span style="font-size:8px;">(Lebar)Cm</span></label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control input-sm" id="l" placeholder="Lebar..." value="" readonly="readonly">
                                                                            <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">T<span style="font-size:8px;">(Tinggi)Cm</span></label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control input-sm" id="t" placeholder="Tinggi..." value="" readonly="readonly">
                                                                            <span class="input-group-addon" style="font-size: small; font-weight: bold;">Cm</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">CBM<span style="font-size:8px;">(Cubic Meter)</span></label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control input-sm" id="cbm" placeholder="Tinggi..." value="" readonly="readonly">
                                                                            <span class="input-group-addon" style="font-size: small; font-weight: bold;">m<sup>3</sup></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Stok Masuk</label>
                                                                        <input type="text" class="form-control input-sm" id="masuk" placeholder="Stok Masuk..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Stok Keluar</label>
                                                                        <input type="text" class="form-control input-sm" id="keluar" autocomplete="off" placeholder="Stok Keluar..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label style="font-size: smaller;">Stok Tersedia</label>
                                                                        <input type="text" class="form-control input-sm" id="sisa" autocomplete="off" placeholder="Stok Tersedia..." value="" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="box-footer">
                                                    <button class="btn btn-sm btn-primary" type="submit" name="savebarang"><i class="fa fa-check-square-o" aria-hidden="true"></i> Simpan</button>
                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
<script src="html5-qrcode.min.js"></script>


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
    function myFunctionSnack(type, message) {
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

    function loadDataBarcode(no_barcode) {
        return $.ajax({
            url: "getLoadDataBarcode.php",
            type: 'post',
            dataType: "json",
            data: {
                barcode: no_barcode
            },
            beforeSend: function() {
                $('#tabmasuk,#tabkeluar,#tabsisa').html("0");
                $('#tablokasi').html("-");
                $('#sku,#dbarcode,#namabarang,#lokasi,#merek,#kategori,#satuan,#p,#l,#t,#cbm,#masuk,#keluar,#sisa').val("");
                $("#image-product").attr("src", "dist/img/noimage.jpg");
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
                myFunctionSnack('Error', msg);
            },
            complete: function(val) {
                if (val.status == 200) {
                    if (val.responseJSON == null) {
                        myFunctionSnack('Warning', 'Data Barcode ' + no_barcode + ' Tidak Ditemukan...');
                        document.getElementById("barcode").focus();
                    } else {
                        myFunctionSnack('Success', 'Data Barcode ' + val.responseJSON['barcode'] + ' Ditemukan...');
                        document.getElementById('tabmasuk').innerHTML = val.responseJSON['masuk'];
                        document.getElementById('tabkeluar').innerHTML = val.responseJSON['keluar'];
                        document.getElementById('tabsisa').innerHTML = val.responseJSON['sisa'];
                        document.getElementById('tablokasi').innerHTML = val.responseJSON['lokasi'];
                        document.getElementById('sku').value = val.responseJSON['sku'];
                        document.getElementById('dbarcode').value = val.responseJSON['barcode'];
                        document.getElementById('namabarang').value = val.responseJSON['nama'];
                        document.getElementById('lokasi').value = val.responseJSON['lokasi'];
                        document.getElementById('merek').value = val.responseJSON['merek'];
                        document.getElementById('kategori').value = val.responseJSON['kategori'];
                        document.getElementById('satuan').value = val.responseJSON['satuan'];
                        document.getElementById('p').value = val.responseJSON['p'];
                        document.getElementById('l').value = val.responseJSON['l'];
                        document.getElementById('t').value = val.responseJSON['t'];
                        document.getElementById('cbm').value = val.responseJSON['cbm'];
                        document.getElementById('masuk').value = val.responseJSON['masuk'];
                        document.getElementById('keluar').value = val.responseJSON['keluar'];
                        document.getElementById('sisa').value = val.responseJSON['sisa'];
                        document.getElementById('image-product').src = val.responseJSON['avatar'];
                        document.getElementById('barcode').value = "";
                        document.getElementById("barcode").focus();
                    }

                } else {
                    myFunctionSnack('Error', 'Something Went Wrongg!!!');
                }
            }
        });
    }

    var setscancondition = false;
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 100
            },
            rememberLastUsedCamera: false,
            // aspectRatio: 1.7777778
        }
    );

    function onScanSuccess(decodedText, decodedResult) {
        if (html5QrcodeScanner.getState() !==
            Html5QrcodeScannerState.NOT_STARTED) {
            setscancondition = true;
            loadDataBarcode(decodedText);
            document.getElementById('barcode').value = decodedText;
            document.getElementById("html5-qrcode-button-camera-stop").click();
        }
    }
    html5QrcodeScanner.render(onScanSuccess);

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

    // START SCAN BARCODE
    $('#barcode').keyup(delay(function(e) {
        var barcode = this.value;
        loadDataBarcode(barcode);
    }, 500));
    // END SCAN BARCODE

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