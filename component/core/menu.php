<?php
include "configuration/config_connect.php";
include "configuration/config_chmod.php";
$nouser = $_SESSION['nouser'];
$user = "SELECT * FROM user WHERE no='$nouser' ";
$query = mysqli_query($conn, $user);
$row  = mysqli_fetch_assoc($query);
$nama = $row['nama'];
$jabatan = $row['jabatan'];
$avatar = $row['avatar'];
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $avatar; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $nama; ?></p>
                <a href="#"><i class="fa fa-circle text-online"></i> Online</a>

            </div>
        </div>
        <br>
        <?php
        $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        ?>
        <ul class="sidebar-menu">
            <!-- <li class="header">MENU UTAMA</li> -->
            <li class="<?php if ($uriSegments[1] == 'index' || $uriSegments[1] == '') {
                            echo 'active';
                        } ?>">
                <a href="index"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
            </li>
            <li class="<?php if ($uriSegments[1] == 'tracking') {
                            echo 'active';
                        } ?>">
                <a href="tracking"> <i class="fa fa-truck"></i> <span>Tracking Barang</span> </a>
            </li>
            <li class="<?php if ($uriSegments[1] == 'check_barcode') {
                            echo 'active';
                        } ?>">
                <a href="check_barcode"> <i class="fa fa-search" aria-hidden="true"></i> <span>Check Barcode Barang</span> </a>
            </li>
            <?php
            if ($chmenu4 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'add_barang' || $uriSegments[1] == 'barang' || $uriSegments[1] == 'cetak_barcode') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-th-list"></i> <span>Barang</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'add_barang') {
                                echo 'class="active"';
                            } ?>>
                            <a href="add_barang"><i class="fa fa-circle-o"></i>Tambah Barang</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'barang') {
                                echo 'class="active"';
                            } ?>>
                            <a href="barang"><i class="fa fa-circle-o"></i>Data Barang</a>
                        </li>

                        <li <?php if ($uriSegments[1] == 'cetak_barcode') {
                                echo 'class="active"';
                            } ?>>
                            <a href="cetak_barcode"><i class="fa fa-circle-o"></i>Cetak Barcode</a>
                        </li>
                        <!-- <li>
                        <a href="stok_menipis"><i class="fa fa-circle-o"></i>Stok Menipis</a>
                      </li> -->
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu3 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>

                <li class="<?php if ($uriSegments[1] == 'kategori' || $uriSegments[1] == 'merek' || $uriSegments[1] == 'satuan') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-tag"></i> <span>Atribut Barang</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'kategori') {
                                echo 'class="active"';
                            } ?>>
                            <a href="kategori"><i class="fa fa-circle-o"></i>Kategori</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'merek') {
                                echo 'class="active"';
                            } ?>>
                            <a href="merek"><i class="fa fa-circle-o"></i>Brand</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'satuan') {
                                echo 'class="active"';
                            } ?>>
                            <a href="satuan"><i class="fa fa-circle-o"></i>Satuan</a>
                        </li>
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu5 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'stok_masuk' || $uriSegments[1] == 'stok_keluar' || $uriSegments[1] == 'surat_kelola' || $uriSegments[1] == 'stok_sesuaikan' || $uriSegments[1] == 'stok_in' || $uriSegments[1] == 'stok_out') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-th-list"></i> <span>Aktivitas</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'stok_masuk' || $uriSegments[1] == 'stok_in') {
                                echo 'class="active"';
                            } ?>>
                            <a href="stok_masuk"><i class="fa fa-circle-o"></i>Barang Masuk</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'stok_keluar' || $uriSegments[1] == 'stok_out') {
                                echo 'class="active"';
                            } ?>>
                            <a href="stok_keluar"><i class="fa fa-circle-o"></i>Barang Keluar</a>
                        </li>
                        <!-- <li>
                       <a href="surat_masuk"><i class="fa fa-circle-o"></i>Surat Masuk</a>
                    </li> -->
                        <li <?php if ($uriSegments[1] == 'surat_kelola') {
                                echo 'class="active"';
                            } ?>>
                            <a href="surat_kelola"><i class="fa fa-circle-o"></i>Surat Keluar</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'stok_sesuaikan') {
                                echo 'class="active"';
                            } ?>>
                            <a href="stok_sesuaikan"><i class="fa fa-circle-o"></i>Penyesuaian</a>
                        </li>
                        <!-- <li>
                        <a href="stok_menipis"><i class="fa fa-circle-o"></i>Stok Menipis</a>
                      </li> -->
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu6 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
            <?php } else {
            }
            if ($chmenu7 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
            <?php } else {
            }
            if ($chmenu8 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'stok_barang' || $uriSegments[1] == 'mutasi') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-inbox"></i> <span>Stok</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'stok_barang') {
                                echo 'class="active"';
                            } ?>>
                            <a href="stok_barang"><i class="fa fa-circle-o"></i>Data Stok</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'mutasi') {
                                echo 'class="active"';
                            } ?>>
                            <a href="mutasi"><i class="fa fa-circle-o"></i>Mutasi</a>
                        </li>
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu9 >= 1 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'laporan_penyesuaian' || $uriSegments[1] == 'laporan_arus' || $uriSegments[1] == 'laporan_imei_sn' || $uriSegments[1] == 'laporan_stok_barang_ged') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Laporan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">

                        <?php
                        if ($chmenu9 == 2 || $_SESSION['jabatan'] == 'admin') {
                        ?>
                            <li <?php if ($uriSegments[1] == 'laporan_penyesuaian') {
                                    echo 'class="active"';
                                } ?>>
                                <a href="laporan_penyesuaian"><i class="fa fa-circle-o"></i>Daftar Penyesuaian</a>
                            </li>
                        <?php
                        }
                        ?>

                        <li <?php if ($uriSegments[1] == 'laporan_arus') {
                                echo 'class="active"';
                            } ?>>
                            <a href="laporan_arus"><i class="fa fa-circle-o"></i>Keluar Masuk</a>
                        </li>

                        <li <?php if ($uriSegments[1] == 'laporan_imei_sn') {
                                echo 'class="active"';
                            } ?>>
                            <a href="laporan_imei_sn"><i class="fa fa-circle-o"></i>Daftar No IMEI & SN</a>
                        </li>

                        <li <?php if ($uriSegments[1] == 'laporan_stok_barang_ged') {
                                echo 'class="active"';
                            } ?>>
                            <a href="laporan_stok_barang_ged"><i class="fa fa-circle-o"></i>Laporan Stok Barang GED</a>
                        </li>


                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu2 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'supplier' || $uriSegments[1] == 'add_supplier' || $uriSegments[1] == 'customer' || $uriSegments[1] == 'add_customer') {
                                echo 'active';
                            } ?> treeview">
                    <a href="#"> <i class="glyphicon glyphicon-folder-close"></i> <span>Supplier & Pelanggan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'supplier') {
                                echo 'class="active"';
                            } ?>>
                            <a href="supplier"><i class="fa fa-circle-o"></i>Data Supplier</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'add_supplier') {
                                echo 'class="active"';
                            } ?>>
                            <a href="add_supplier"><i class="fa fa-circle-o"></i>Tambah Supplier</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'customer') {
                                echo 'class="active"';
                            } ?>>
                            <a href="customer"><i class="fa fa-circle-o"></i>Data Pelanggan</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'add_customer') {
                                echo 'class="active"';
                            } ?>>
                            <a href="add_customer"><i class="fa fa-circle-o"></i>Tambah pelanggan</a>
                        </li>
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu1 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'admin' || $uriSegments[1] == 'add_jabatan') {
                                echo 'active';
                            } ?> treeview">
                    <a href=""> <i class="glyphicon glyphicon-cog"></i> <span>Manajemen User</span> <span class="pull-right-container"> </span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'admin') {
                                echo 'class="active"';
                            } ?>>
                            <a href="admin"><i class="fa fa-circle-o"></i>Kelola User</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'add_jabatan') {
                                echo 'class="active"';
                            } ?>>
                            <a href="add_jabatan"><i class="fa fa-circle-o"></i>Jabatan User</a>
                        </li>
                    </ul>
                </li>
            <?php } else {
            }
            if ($chmenu10 >= 5 || $_SESSION['jabatan'] == 'admin') { ?>
                <li class="<?php if ($uriSegments[1] == 'set_general' || $uriSegments[1] == 'set_themes' || $uriSegments[1] == 'backup' || $uriSegments[1] == 'license') {
                                echo 'active';
                            } ?> treeview">
                    <a href=""> <i class="glyphicon glyphicon-cog"></i> <span>Pengaturan</span> <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i> </span> </a>
                    <ul class="treeview-menu">
                        <li <?php if ($uriSegments[1] == 'set_general') {
                                echo 'class="active"';
                            } ?>>
                            <a href="set_general"><i class="fa fa-circle-o"></i>General Setting</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'set_themes') {
                                echo 'class="active"';
                            } ?>>
                            <a href="set_themes"><i class="fa fa-circle-o"></i>Theme Setting</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'backup') {
                                echo 'class="active"';
                            } ?>>
                            <a href="backup"><i class="fa fa-circle-o"></i>Backup & Restore</a>
                        </li>
                        <li <?php if ($uriSegments[1] == 'license') {
                                echo 'class="active"';
                            } ?>>
                            <a href="license"><i class="fa fa-circle-o"></i>Lisensi</a>
                        </li>
                    </ul>
                </li>
            <?php } else {
            }
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>