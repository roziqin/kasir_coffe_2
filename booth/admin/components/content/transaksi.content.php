<?php 
session_start();
$con = mysqli_connect("localhost","root","","kasir_new");
include '../../../include/format_rupiah.php';

$kond = $_GET['kond'];

if ($kond=='home' || $kond=='') { ?>
    <?php if ($_SESSION['order_type']=='') { ?>
        <div class="box-hidden">
            <div class="row row-jumlah justify-content-md-center">
                <div class="col-md-12 text-center" style="margin-top: 45vh;">
                    <button type="button" class="btn btn-default waves-effect mr-2" id="ceknota"><i class="fas fa-clipboard-check mr-2"></i>Cek Nota</button>
                    <button type="button" class="btn btn-default waves-effect mr-2" id="tutupkasir"><i class="fas fa-cash-register mr-2"></i>Tutup Kasir</button>
                </div>
            </div>
        </div>
    <?php } ?>
	<div class="classic-tabs">
		<ul class="nav tabs-white border-bottom" id="myClassicTab" role="tablist">
			<?php
                $n=0;
                $sql="SELECT * from kategori ORDER BY kategori_id";
                $query=mysqli_query($con, $sql);
                while ($data1=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    if ($n==0) {
                        $ket = 'active show';
                        $ket1 = 'true';
                        $ket2 = 'ml-0';
                    } else {
                        $ket = '';
                        $ket1 = 'false';
                        $ket2 = '';

                    }
                ?>
					<li class="nav-item <?php echo $ket2; ?>">
						<a class="nav-link  waves-light <?php echo $ket; ?>" id="profile-tab-classic" data-toggle="tab" href="#<?php echo $data1['kategori_slug']; ?>"
						role="tab" aria-controls="<?php echo $data1['kategori_slug']; ?>" aria-selected="<?php echo $ket1; ?>"><?php echo $data1['kategori_nama']; ?></a>
					</li>
                <?php
                $n++;

                }

            ?>
		</ul>
		<div class="tab-content" id="myClassicTabContent">
			<?php
                $n=0;
                $sql="SELECT * from kategori ORDER BY kategori_id";
                $query=mysqli_query($con, $sql);
                while ($data1=mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    if ($n==0) {
                        $ket='show active';
                    } else {
                        $ket='';

                    }
                ?>
                	<div class="tab-pane fade <?php echo $ket; ?>" id="<?php echo $data1['kategori_slug']; ?>" role="tabpanel" aria-labelledby="<?php echo $data1['kategori_slug']; ?>-tab">
                        <div class="row">
                            <?php
                                $sqlbarang="SELECT * from barang where barang_kategori='$data1[kategori_id]'";
                                $querybarang=mysqli_query($con, $sqlbarang);
                                while ($databarang=mysqli_fetch_array($querybarang, MYSQLI_ASSOC)) {
                                	if ($databarang['barang_image']=='') {
                                		$image = 'default.jpg';
                                	} else {
                                		$image = $databarang['barang_image'];
                                	}

                                	if ($databarang['barang_disable']==1) {
                                		$disable = 'disable';
                                	} else {
                                		$disable = '';
                                	}


							    	if ($_SESSION['order_type']=='online') {
							        	$harga = $databarang['barang_harga_jual_online'];
							    	} else {
							        	$harga = $databarang['barang_harga_jual'];
							        }

                                    if ($databarang['barang_set_stok']==0 && $harga!=0) {
                                        ?>
                                            <div class="col-3 mb-3">
                                                    <div class="card custom <?php echo $disable; ?>">
		                                            	<div class="box-button fadeIn faster animated">
		                                            		<button class="btn btn-primary tambahmenu" data-id="<?php echo $databarang['barang_id']; ?>"><i class="fas fa-magic mr-1"></i> Tambah</button>
															<button class="btn btn-default pilihmenu" data-id="<?php echo $databarang['barang_id']; ?>">Pilih <i class="fas fa-magic ml-1"></i></button>
		                                            	</div>
                                                        <div class="card-body">
                                                        	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
                                                            Rp. <?php echo format_rupiah($harga); ?>
                                                        </div>
                                                    </div>
                                            </div>


                                        <?php
                                        
                                    } elseif ($databarang['barang_set_stok']!=0 && $harga!=0) {
                                        if ($databarang['barang_stok']!=0) {
                                            if ($databarang['barang_stok']<$databarang['barang_batas_stok']) {
                                                $stok_status="warning";
                                            } else {
                                                $stok_status="";
                                            }
                                            
                                            ?>
                                                <div class="col-3 mb-3">
                                                    <div class="card custom <?php echo $stok_status.' '.$disable; ?>">
		                                            	<div class="box-button fadeIn faster animated">
		                                            		<button class="btn btn-primary tambahmenu" data-id="<?php echo $databarang['barang_id']; ?>"><i class="fas fa-magic mr-1"></i> Tambah</button>
															<button class="btn btn-default pilihmenu" data-id="<?php echo $databarang['barang_id']; ?>">Pilih <i class="fas fa-magic ml-1"></i></button>
		                                            	</div>
                                                        <div class="card-body">
                                                        	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
                                                            <span class="stok <?php echo $stok_status; ?>">Stok: <?php echo $databarang['barang_stok']; ?></span>
                                                        </div>
                                                        <div class="card-footer">
                                                            <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
                                                        	Rp. <?php echo format_rupiah($harga); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                        } else {
                                            ?>
                                                <div class="col-3">
                                                    <div class="card custom grey-text <?php echo $disable; ?>">
                                                        <div class="card-body">
                                                        	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
                                                        	<span class="stok empty">Stok: Habis</span>
                                                        </div>
                                                        <div class="card-footer">
                                                            <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
                                                            Rp. <?php echo format_rupiah($harga); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                        
                                    }    
                                }
                            ?>
                        </div>
                    </div>
                    
                <?php
                $n++;
                }

            ?>
		</div>

	</div>

<?php } elseif ($kond=='search') { ?>
	
    <div class="row p-3">
    	<div class="col-md-12 mb-2"><h1 class="secondary-heading mb-3 float-left">Hasil pencarian "<?php echo $_GET['q']; ?>"</h1> <button class="btn btn-danger btn-clear-search float-right" >Reset Pencarian <i class="fas fa-times ml-1"></i></button></div>
    	<div class="search-result">
        <?php
            $sqlbarang="SELECT * from barang where barang_nama LIKE '%$_GET[q]%'";
            $querybarang=mysqli_query($con, $sqlbarang);
            while ($databarang=mysqli_fetch_array($querybarang, MYSQLI_ASSOC)) {
            	if ($databarang['barang_image']=='') {
            		$image = 'default.jpg';
            	} else {
            		$image = $databarang['barang_image'];
            	}


		    	if ($_SESSION['order_type']=='online') {
		        	$harga = $databarang['barang_harga_jual_online'];
		    	} else {
		        	$harga = $databarang['barang_harga_jual'];
		        }

                if ($databarang['barang_set_stok']==0 && $harga!=0) {
                    ?>
                        <div class="col-3 mb-3">
                            <div class="card custom">
                            	<div class="box-button fadeIn faster animated">
                            		<button class="btn btn-primary tambahmenu" data-id="<?php echo $databarang['barang_id']; ?>"><i class="fas fa-magic mr-1"></i> Tambah</button>
									<button class="btn btn-default pilihmenu" data-id="<?php echo $databarang['barang_id']; ?>">Pilih <i class="fas fa-magic ml-1"></i></button>
                            	</div>
                                <div class="card-body">
                                	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
                                </div>
                                <div class="card-footer">
                                    <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
                                    Rp. <?php echo format_rupiah($harga); ?>
                                </div>
                            </div>
                        </div>


                    <?php
                    
                } elseif ($databarang['barang_set_stok']==0 && $harga!=0) {
                    if ($databarang['barang_stok']!=0) {
                        if ($databarang['barang_stok']<$databarang['barang_batas_stok']) {
                            $stok_status="warning";
                        } else {
                            $stok_status="";
                        }
                        
                        ?>
                            <div class="col-3 mb-3">
                                <div class="card custom <?php echo $stok_status; ?>">
                                	<div class="box-button fadeIn faster animated">
                                		<button class="btn btn-primary tambahmenu" data-id="<?php echo $databarang['barang_id']; ?>"><i class="fas fa-magic mr-1"></i> Tambah</button>
										<button class="btn btn-default pilihmenu" data-id="<?php echo $databarang['barang_id']; ?>">Pilih <i class="fas fa-magic ml-1"></i></button>
                                	</div>
                                    <div class="card-body">
                                    	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
                                        <span class="stok <?php echo $stok_status; ?>">Stok: <?php echo $databarang['barang_stok']; ?></span>
                                    </div>
                                    <div class="card-footer">
                                        <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
                                    	Rp. <?php echo format_rupiah($harga); ?><br>
                                    </div>
                                </div>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="col-3 mb-3">
	                            <div class="card custom grey-text">
	                                <div class="card-body">
	                                	<div class="image-menu" style="background-image: url(../assets/img/produk/<?php echo $image; ?>)"></div>
	                                    <span class="stok empty">Stok: Habis</span>
	                                </div>
	                                <div class="card-footer">
	                                    <strong class="card-title"><?php echo $databarang['barang_nama']; ?></strong>
	                                    Rp. <?php echo format_rupiah($harga); ?>
	                                </div>
	                            </div>
	                        </div>
                        <?php
                    }
                    
                }    
            }
        ?>
	    </div>
    </div>

<?php }  elseif ($kond=='jumlah') { ?>

    <div class="row p-3 row-jumlah justify-content-md-center">
    	<div class="col-md-6 mt-5">
    		<h3 class="text-center mb-5">Input Jumlah</h3>
	    	<form method="post" class="form-jumlah">
	    		<input type="hidden" id="barang_id" class="form-control" value="<?php echo $_GET['id']; ?>" name="barang_id">  	
	    		<div class="md-form mb-3">
				  	<input type="text" id="jumlah" class="form-control" name="jumlah" >
				  	<label for="jumlah">Jumlah dipesan</label>
				</div>
	    		<div class="md-form">
					<textarea id="keterangan" class="md-textarea form-control" rows="3" name="keterangan"></textarea>
					<label for="keterangan">Request</label>
				</div>
				<button class="btn btn-primary prosesmenu float-right">Proses</button>
	    	</form>
	    </div>
    </div>

<?php } elseif ($kond=='kembalian') { ?>

    <input type="hidden" id="cekordertype" value="<?php echo $_SESSION['order_type']; ?>" name="cekordertype">
    <input type="hidden" id="ketnota" value="<?php echo $_SESSION['no-nota']; ?>" name="ketnota">
    <input type="hidden" id="cekprintmakanan" value="<?php echo $_SESSION['printmakanan']; ?>" name="printmakanan">
    <input type="hidden" id="cekprintminuman" value="<?php echo $_SESSION['printminuman']; ?>" name="printminuman">
    <input type="hidden" id="cekprintsnack" value="<?php echo $_SESSION['printsnack']; ?>" name="printsnack">   
    <div class="row p-3 row-jumlah justify-content-md-center">
        <div class="col-md-6 mt-5">
            <h3 class="text-center mb-5">Jumlah Kembalian</h3>
            <h1 class="text-center mt-5 mb-3" id="jumlahkembalian">Rp. <?php echo format_rupiah($_SESSION['kembalian']); ?></h1>
            <button class="btn btn-primary transaksibaru float-right">Transaksi Baru</button>
        </div>
    </div>
    
    <script type="text/javascript">
        var nota = $("#ketnota").val();
        var printnota = 'print/nota.print.php?id='+nota;
        
        /*
        if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()!=0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()==0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()==0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()==0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()!=0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()==0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=snack&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=snack&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()==0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()==0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()!=0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=minuman&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=minuman&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()!=0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()!=0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()==0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=snack&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=snack&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()!=0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()==0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()!=0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()==0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()!=0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()!=0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=snack&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=snack&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
            }
        
        } else if (($("#print-kitchen").val()==1 && $("#cekprintmakanan").val()!=0) && ($("#print-snack").val()==1 && $("#cekprintsnack").val()!=0) && ($("#print-bar").val()==1 && $("#cekprintminuman").val()!=0)) {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota , 'print/checklist.print.php?set=snack&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota , 'print/checklist.print.php?set=makanan&id='+nota , 'print/checklist.print.php?set=snack&id='+nota , 'print/checklist.print.php?set=minuman&id='+nota);
            }
        
        } else {

            if ($("#cekordertype").val()!='online') {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota );
            } else {
                windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota);
            }

        }
        */

        if ($("#cekordertype").val()!='online') {
            windowList = new Array('print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota );
        } else {
            windowList = new Array('print/nota.print.php?id='+nota , 'print/nota.print.php?id='+nota , 'print/checklist.print.php?set=check&id='+nota);
        }
        
        i = 0;
        windowName = "window";
        windowInterval = window.setInterval(function(){
            window.open(windowList[i],windowName+i,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,titlebar=no');
            i++;
            if(i==windowList.length){
                window.clearInterval(windowInterval);
            }
        },1000);
    </script>

   
<?php } elseif ($kond=='ceknota') { ?>

    <div class="row p-3 row-jumlah justify-content-md-center">
        <div class="col-md-6 mt-5">
            <h3 class="text-center mb-5">Cek Nota</h3>
            <form method="post" class="form-jumlah"> 
                <div class="md-form mb-3">
                    <input type="text" id="idnonota" class="form-control" name="idnonota" >
                    <label for="idnonota">No Nota</label>
                </div>
                <button class="btn btn-primary prosesceknota float-right">Proses</button>
                <button class="btn btn-danger kembali float-right">Kembali</button>
            </form>
        </div>
        <div class="clear"></div>
        <?php if ($_GET['nonota']!='') { 
            $nota = $_GET['nonota'];
            $sqlnot="SELECT * FROM transaksi where transaksi_nota='$nota' ";
            $querynot=mysqli_query($con,$sqlnot);
            $datanot=mysqli_fetch_assoc($querynot);
            $total = $datanot['transaksi_total'];
        ?>
        <div class="col-md-12 p-5">

            <input type="hidden" id="ip-nota" class="form-control" name="ip-nota" value="<?php echo $nota; ?>" >
            <h3>Cek Nota Transaksi : <?php echo $nota; ?></h3>
            <div class="row">
                <div class="col-md-6 col-md-offset-0">
                    <h4>Nama : <?php echo $datanot['transaksi_pelanggan'];?></h4>
                </div>
                <table id="listbarang" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Nama Menu</th>
                      <th class="text-right">Harga</th>
                      <th width="50px" style="padding-right: 8px; ">Jumlah</th>
                      <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sqlte1="SELECT * from transaksi_detail, barang where transaksi_detail_barang_id=barang_id and transaksi_detail_nota='$nota' ORDER BY transaksi_detail_id ASC";
                        $queryte1 = mysqli_query($con,$sqlte1);
                        while($datatea = mysqli_fetch_assoc($queryte1)) {
                            $jumlah = $datatea["transaksi_detail_jumlah"];
                            $harga = $datatea["barang_harga_jual"];
                        ?>
                            <tr>
                                <td><?php echo $datatea["barang_nama"]; ?></td>
                                <td class="text-right">Rp. <?php echo format_rupiah($harga); ?></td>
                                <td><?php echo $jumlah; ?></td>
                                <td class="text-right">Rp. <?php echo format_rupiah($jumlah*$harga); ?></td>
                                
                            </tr>
                        <?php
                        }
                    ?>
                    </tbody>
                </table>
                <div class="col-6 col-md-offset-0">
                    <h4>Total : </h4>
                </div>
                <div class="col-md-6 col-md-offset-0 text-right">
                    <h4>Rp. <?php echo format_rupiah($total); ?></h4>
                </div>              
            </div>
            <button class="btn btn-warning printulang float-right mr-0" id="btn-printulang"><i class="fas fa-print mr-2"></i>Print Ulang</button>
        </div>
        <?php } ?>
    </div>

<?php }  elseif ($kond=='tutupkasir') { ?>

    <div class="row-jumlah">
        <div class="row p-3 justify-content-md-center">
            <div class="col-md-6 mt-5">
                <h3 class="text-center mb-5">Tutup Kasir</h3>
                <form method="post" class="form-omset"> 
                    <div class="md-form mb-3">
                        <input type="text" id="uangfisik" class="form-control" name="uangfisik" >
                        <label for="uangfisik">Masukkan Jumlah Uang Fisik</label>
                    </div>
                    <button class="btn btn-primary prosestutupkasir float-right">Proses</button>
                    <button class="btn btn-danger kembali float-right">Kembali</button>
                </form>
            </div>
        </div>
        <div class="row p-3 justify-content-md-center">
            <div class="col-md-6 p-5">

                <h3 id="spuangfisik"></h3>
                <h3 id="spcash"></h3>
                <h3 id="spdebet"></h3>
                <h3 id="spgoresto"></h3>
                <h3 id="spomset"></h3>
                <h3 id="spselisih"></h3>
                
                    
            </div>
        </div>
    </div>
<?php } ?>


<?php if ($kond=='home' || $kond=='search' || $kond=='' ) { ?>

<script type="text/javascript">
	

	$('.pilihmenu').on('click',function(){
		var barang_id = $(this).data('id');
		$('.container__load').load('components/content/transaksi.content.php?kond=jumlah&id='+barang_id);
	});

    $('#ceknota').on('click',function(){
        $('.container__load').load('components/content/transaksi.content.php?kond=ceknota&nonota=');
    });

    $('#tutupkasir').on('click',function(){
        $('.container__load').load('components/content/transaksi.content.php?kond=tutupkasir&omset=');
    });

	$('.btn-clear-search').on('click',function(){
		$('#carimenu').val('');
		$('.container__load').load('components/content/transaksi.content.php?kond=home');

	});

	$('.tambahmenu').on('click',function(){
    	var barang_id = $(this).data('id');
    	var jumlah = 1;
    	var keterangan = '';
    	if ($('#defaultForm-ordertype').val()=='online') {
        	var pajakjml = $('#ip-pajakonline').val();	
    	} else {
        	var pajakjml = $('#ip-pajakresto').val();
        }
        console.log(barang_id);
        
        $.ajax({
            type:'POST',
	        url: "controllers/transaksi.ctrl.php?ket=tambahmenu",
            dataType: "json",
            data:{
            	barang_id:barang_id,
            	jumlah:jumlah,
            	keterangan:keterangan
            },
            success:function(data){
				$('#carimenu').val('');

            	console.log(data);
            	if (data.totalordertemp.toString()=="Stok Kurang") {
            		$.confirm({
	                      title: 'Stok Kurang',
	                      content: 'Jumlah stok tidak mencukupi',
	                      buttons: {
	                          confirm: {
	                              text: 'Close',
	                              btnClass: 'col-md-12 btn btn-primary',
	                              action: function(){
	                                  
	                                  
	                              }
	                          }
	                      }
	                });
            	} else {
		            var content = '<tr class="fadeInLeft animated"><td><button type="button" class="btn btn-dark-info waves-effect btn orange-text m-0 p-0 btn-remove" data-id="'+data.item.transaksi_detail_temp_id+'"><i class="fas fa-times"></i></button></td><td>'+data.item.barang_nama+'<br><span>'+data.item.transaksi_detail_temp_keterangan+'</span></td><td><button type="button" class="btn btn-dark-info waves-effect btn btn-outline-white mr-2 mt-0 ml-0 mb-0 p-1 btn-plusminus" data-ket="minus" data-id="'+data.item.transaksi_detail_temp_id+'" data-idbarang="'+data.item.transaksi_detail_temp_barang_id+'" data-jumlah="'+data.item.transaksi_detail_temp_jumlah+'"><i class="fas fa-minus"></i></button><span class="text_jumlah">'+data.item.transaksi_detail_temp_jumlah+'</span><button type="button" class="btn btn-dark-info waves-effect btn-outline-white mr-0 mt-0 ml-2 mb-0 p-1 btn-plusminus" data-ket="plus" data-id="'+data.item.transaksi_detail_temp_id+'" data-idbarang="'+data.item.transaksi_detail_temp_barang_id+'" data-jumlah="'+data.item.transaksi_detail_temp_jumlah+'"><i class="fas fa-plus"></i></button></td><td><span class="text_total">'+formatRupiah(data.item.transaksi_detail_temp_total, 'Rp. ')+'</span></td></tr>';
		        	$('#subtotal').empty();
		            $('#subtotal').append(formatRupiah(data.totalordertemp.toString(), 'Rp. '));

					var tax = parseInt(pajakjml)*data.totalordertemp*0.1;
					if ($('#ip-pajakpembulatan').val()==1) {
						tax = pembulatan(tax);
			        }

		        	$('#pajak').empty();
					$('#pajak').append(formatRupiah(tax.toString(), 'Rp. '))
					
					var taxservice = 0;
			        if ($('#ip-pajakservice').val()!='') {
			        	taxservice = parseInt($('#ip-pajakservice').val())*data.totalordertemp/100;
						if ($('#ip-pajakpembulatan').val()==1) {
							taxservice = pembulatan(taxservice);
				        }
				        
			        	$('#pajakservice').empty();
						$('#pajakservice').append(formatRupiah(taxservice.toString(), 'Rp. '))
			        }
			        
			        var jmldiskon = $("#defaultForm-jumlahdiskon").val();

					var total = tax+data.totalordertemp+taxservice-jmldiskon;
					$('#total').empty();
					$('#total').append(formatRupiah(total.toString(), 'Rp. '));

					$('#defaultForm-tax').val(tax);
					$('#defaultForm-subtotal').val(data.totalordertemp);
                    $('#defaultForm-total').val(total);

					$('#listitem table').append(content);
					$('.container__load').load('components/content/transaksi.content.php?kond=');

					$('.btn-remove').unbind('click').click(function() {
                        var indexitem = $(this).parent().parent().index();
                        var id = $(this).data('id');
                        console.log("tambah "+indexitem+" "+id)
                        
                        removeItemTemp(id, indexitem);
                        
					});


					$('.btn-plusminus').on('click',function(){
						var indexitem = $(this).parent().parent().index();
						var id = $(this).data('id');
						var idbarang = $(this).data('idbarang');
						var ket = $(this).data('ket');
						var jumlah = $(this).data('jumlah');

						plusminusItem(id, idbarang, indexitem, ket, jumlah);
					});
            	}
            	/*
				*/


            }
        });          
	});


</script>

<?php } elseif ($kond=='kembalian') { ?>
    <script type="text/javascript">
        $('.transaksibaru').on('click',function(){
            window.location.reload();
            $('.container__load').load('components/content/transaksi.content.php?kond=home');
        });
    </script>

<?php } elseif ($kond=='ceknota' || $kond=='tutupkasir') { ?>

    <script type="text/javascript">

        $('.kembali').on('click',function(e){
            e.preventDefault();
            var idnonota = $('#idnonota').val();
            $('.container__load').load('components/content/transaksi.content.php?kond=home');
        });

        $('.prosesceknota').on('click',function(e){
            e.preventDefault();
            var idnonota = $('#idnonota').val();
            $('.container__load').load('components/content/transaksi.content.php?kond=ceknota&nonota='+idnonota);
        });

        $('.prosestutupkasir').on('click',function(e){
            e.preventDefault();
            var data = $('.form-omset').serialize();
            console.log("data "+data)
            $.ajax({
                type:'POST',
                url: "controllers/transaksi.ctrl.php?ket=tutupkasir",
                dataType: "json",
                data:data,
                success:function(data){
                    console.log("data "+data.ket);
                    if (data.ket == "gagal") {
                        $.confirm({
                              title: 'Validasi Gagal',
                              content: 'Validasi max 1x',
                              buttons: {
                                  confirm: {
                                      text: 'Close',
                                      btnClass: 'col-md-12 btn btn-primary',
                                      action: function(){
                                          
                                          
                                      }
                                  }
                              }
                        });
                    } else {


                        $('#spuangfisik').empty();
                        $('#spuangfisik').append("Uang Fisik : <span class='float-right'>"+formatRupiah(data.uangfisik.toString(), 'Rp. ')+"</span>");
                        $('#spcash').empty();
                        $('#spcash').append("Omset Cash : <span class='float-right'>"+formatRupiah(data.cash.toString(), 'Rp. ')+"</span>");
                        $('#spdebet').empty();
                        $('#spdebet').append("Omset Debet : <span class='float-right'>"+formatRupiah(data.debet.toString(), 'Rp. ')+"</span>");
                        $('#spgoresto').empty();
                        $('#spgoresto').append("Omset GoResto : <span class='float-right'>"+formatRupiah(data.goresto.toString(), 'Rp. ')+"</span>");
                        $('#spomset').empty();
                        $('#spomset').append("Total Omset : <span class='float-right'>"+formatRupiah(data.omset.toString(), 'Rp. ')+"</span>");
                        $('#spselisih').empty();
                        var selisih = data.uangfisik - data.cash;
                        if (selisih < 0) {
                            $('#spselisih').append("Selisih : <span class='float-right text-danger'>"+formatRupiah(selisih.toString(), 'Rp. ')+"</span>");
                        } else {
                            $('#spselisih').append("Selisih : <span class='float-right'>"+formatRupiah(selisih.toString(), 'Rp. ')+"</span>");
                        }

                            windowList = new Array('print/omset.print.php');
                            i = 0;
                            windowName = "window";
                            windowInterval = window.setInterval(function(){
                                window.open(windowList[i],windowName+i,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,titlebar=no');
                                i++;
                                if(i==windowList.length){
                                    window.clearInterval(windowInterval);
                                }
                            },1000);

                    }

                }
            });

        });

        $('#btn-printulang').on('click',function(e){
            var idnonota = $('#ip-nota').val();
            e.preventDefault();
            
            windowList = new Array('print/nota.print.php?id='+idnonota);
            i = 0;
            windowName = "window";
            windowInterval = window.setInterval(function(){
              window.open(windowList[i],windowName+i,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,titlebar=no');
              i++;
              if(i==windowList.length){
                window.clearInterval(windowInterval);
              }
            },1000);
        });

                                    
    </script>

<?php } elseif ($kond=='jumlah' ) { ?>

	<script type="text/javascript">
		
		$('.prosesmenu').on('click',function(e){
			e.preventDefault();
	        var data = $('.form-jumlah').serialize();
        	if ($('#defaultForm-ordertype').val()=='online') {
	        	var pajakjml = $('#ip-pajakonline').val();	
        	} else {
	        	var pajakjml = $('#ip-pajakresto').val();
	        }
	        console.log("prosesmenu");
	        console.log(data)
	       
	        $.ajax({
	            type:'POST',
		        url: "controllers/transaksi.ctrl.php?ket=tambahmenu",
	            dataType: "json",
	            data:data,
	            success:function(data){
					$('#carimenu').val('');
	            	if (data.totalordertemp.toString()=="Stok Kurang") {
	            		$.confirm({
		                      title: 'Stok Kurang',
		                      content: 'Jumlah stok tidak mencukupi',
		                      buttons: {
		                          confirm: {
		                              text: 'Close',
		                              btnClass: 'col-md-12 btn btn-primary',
		                              action: function(){
		                                  
		                                  
		                              }
		                          }
		                      }
		                });
	            	} else {
			            var content = '<tr class="fadeInLeft animated"><td><button type="button" class="btn btn-dark-info waves-effect btn orange-text m-0 p-0 btn-remove" data-id="'+data.item.transaksi_detail_temp_id+'"><i class="fas fa-times"></i></button></td><td>'+data.item.barang_nama+'<br><span>'+data.item.transaksi_detail_temp_keterangan+'</span></td><td><button type="button" class="btn btn-dark-info waves-effect btn btn-outline-white mr-2 mt-0 ml-0 mb-0 p-1 btn-plusminus" data-ket="minus" data-id="'+data.item.transaksi_detail_temp_id+'" data-idbarang="'+data.item.transaksi_detail_temp_barang_id+'" data-jumlah="'+data.item.transaksi_detail_temp_jumlah+'"><i class="fas fa-minus"></i></button><span class="text_jumlah">'+data.item.transaksi_detail_temp_jumlah+'</span><button type="button" class="btn btn-dark-info waves-effect btn-outline-white mr-0 mt-0 ml-2 mb-0 p-1 btn-plusminus" data-ket="plus" data-id="'+data.item.transaksi_detail_temp_id+'" data-idbarang="'+data.item.transaksi_detail_temp_barang_id+'" data-jumlah="'+data.item.transaksi_detail_temp_jumlah+'"><i class="fas fa-plus"></i></button></td><td><span class="text_total">'+formatRupiah(data.item.transaksi_detail_temp_total, 'Rp. ')+'</span></td></tr>';

			        	$('#subtotal').empty();
			            $('#subtotal').append(formatRupiah(data.totalordertemp.toString(), 'Rp. '));


						var tax = parseInt(pajakjml)*data.totalordertemp*0.1;
						if ($('#ip-pajakpembulatan').val()==1) {
							tax = pembulatan(tax);
				        }

			        	$('#pajak').empty();
						$('#pajak').append(formatRupiah(tax.toString(), 'Rp. '))
						
						var taxservice = 0;
				        if ($('#ip-pajakservice').val()!='') {
				        	taxservice = parseInt($('#ip-pajakservice').val())*data.totalordertemp/100;
							if ($('#ip-pajakpembulatan').val()==1) {
								taxservice = pembulatan(taxservice);
					        }
					        
				        	$('#pajakservice').empty();
							$('#pajakservice').append(formatRupiah(taxservice.toString(), 'Rp. '))
				        }

				        var jmldiskon = $("#defaultForm-jumlahdiskon").val();

						var total = tax+data.totalordertemp+taxservice-jmldiskon;
						$('#total').empty();
						$('#total').append(formatRupiah(total.toString(), 'Rp. '));

						$('#defaultForm-tax').val(tax);
                        $('#defaultForm-subtotal').val(data.totalordertemp);
						$('#defaultForm-total').val(total);

						$('#listitem table').append(content);
						$('.container__load').load('components/content/transaksi.content.php?kond=');

						$('.btn-remove').unbind('click').click(function() {
                            var indexitem = $(this).parent().parent().index();
                            var id = $(this).data('id');
                        console.log("plusminus "+indexitem+" "+id)

                            removeItemTemp(id, indexitem);
						});

						$('.btn-plusminus').on('click',function(){
							var indexitem = $(this).parent().parent().index();
							var id = $(this).data('id');
							var idbarang = $(this).data('idbarang');
							var ket = $(this).data('ket');
							var jumlah = $(this).data('jumlah');

							plusminusItem(id, idbarang, indexitem, ket, jumlah);
						});
					}

	            }
	        });
	                  
		});		

	</script>

<?php
}

if ($kond=='home') { ?>
    <script type="text/javascript">
		$.ajax({
	        type:'POST',
	        url:'api/view.api.php?func=list-transaksi-temp',
	        dataType: "json",
	        success:function(data){
	        	$('#listitem table').empty();
	        	$('#subtotal').empty();
	        	$('#pajak').empty();
	        	$('#total').empty();
	        	if ($('#defaultForm-ordertype').val()=='online') {
		        	var pajakjml = $('#ip-pajakonline').val();	
	        	} else {
		        	var pajakjml = $('#ip-pajakresto').val();
		        }
	            var content = "";
	            var subtotal = 0;

				for (var i in data) {
				    content += '<tr><td><button type="button" class="btn btn-dark-info waves-effect btn orange-text m-0 p-0 btn-remove" data-id="'+data[i].transaksi_detail_temp_id+'"><i class="fas fa-times"></i></button></td><td>'+data[i].barang_nama+'<br><span>'+data[i].transaksi_detail_temp_keterangan+'</span></td><td><button type="button" class="btn btn-dark-info waves-effect btn btn-outline-white mr-2 mt-0 ml-0 mb-0 p-1 btn-plusminus"  data-ket="minus" data-id="'+data[i].transaksi_detail_temp_id+'" data-idbarang="'+data[i].transaksi_detail_temp_barang_id+'" data-jumlah="'+data[i].transaksi_detail_temp_jumlah+'"><i class="fas fa-minus"></i></button><span class="text_jumlah">'+data[i].transaksi_detail_temp_jumlah+'</span><button type="button" class="btn btn-dark-info waves-effect btn-outline-white mr-0 mt-0 ml-2 mb-0 p-1 btn-plusminus" data-ket="plus" data-id="'+data[i].transaksi_detail_temp_id+'" data-idbarang="'+data[i].transaksi_detail_temp_barang_id+'" data-jumlah="'+data[i].transaksi_detail_temp_jumlah+'"><i class="fas fa-plus"></i></button></td><td><span class="text_total">'+formatRupiah(data[i].transaksi_detail_temp_total, 'Rp. ')+'</span></td></tr>';
				    subtotal += parseInt(data[i].transaksi_detail_temp_total);
				}
				var tax = parseInt(pajakjml)*subtotal*0.1;
				if ($('#ip-pajakpembulatan').val()==1) {
					tax = pembulatan(tax);
		        }
				$('#pajak').append(formatRupiah(tax.toString(), 'Rp. '))

				var taxservice = 0;
		        if ($('#ip-pajakservice').val()!='') {
		        	taxservice = parseInt($('#ip-pajakservice').val())*subtotal/100;
					
					if ($('#ip-pajakpembulatan').val()==1) {
						taxservice = pembulatan(taxservice);
			        }
			        
		        	$('#pajakservice').empty();
					$('#pajakservice').append(formatRupiah(taxservice.toString(), 'Rp. '))
		        }

				$('#subtotal').append(formatRupiah(subtotal.toString(), 'Rp. '));

				var jmldiskon = $("#defaultForm-jumlahdiskon").val();

				var total = tax+subtotal+taxservice-jmldiskon;
				$('#total').append(formatRupiah(total.toString(), 'Rp. '));
				$('#listitem table').append(content);

				$('#defaultForm-tax').val(tax);
                $('#defaultForm-subtotal').val(subtotal);
				$('#defaultForm-total').val(total);

				$('.btn-remove').on('click',function(){
					var indexitem = $(this).parent().parent().index();
					var id = $(this).data('id');
                        console.log("home "+indexitem+" "+id)

					removeItemTemp(id, indexitem);
				});

				$('.btn-plusminus').on('click',function(){
					var indexitem = $(this).parent().parent().index();
					var id = $(this).data('id');
					var idbarang = $(this).data('idbarang');
					var ket = $(this).data('ket');
					var jumlah = $(this).data('jumlah');

					plusminusItem(id, idbarang, indexitem, ket, jumlah);
				});
	        }
	    });

	</script>

<?php } ?>

<script type="text/javascript">
	function removeItemTemp(id, index) {
		$.ajax({
			type:'POST',
	        url: "controllers/transaksi.ctrl.php?ket=removeitem",
            dataType: "json",
            data:{
            	id:id,
            	index:index
            },
            success:function(data){
            	
            	if ($('#defaultForm-ordertype').val()=='online') {
		        	var pajakjml = $('#ip-pajakonline').val();	
	        	} else {
		        	var pajakjml = $('#ip-pajakresto').val();
		        }

            	console.log("remove sukses "+data.totalordertemp);
				$("#listitem tr").eq(index).remove();
				$('#subtotal').empty();
	            $('#subtotal').append(formatRupiah(data.totalordertemp.toString(), 'Rp. '));

				var tax = parseInt(pajakjml)*data.totalordertemp*0.1;
				if ($('#ip-pajakpembulatan').val()==1) {
					tax = pembulatan(tax);
		        }

		        if ($('#ip-pajakservice').val()!='') {
		        	var taxservice = parseInt($('#ip-pajakservice').val())*data.totalordertemp/100;
					if ($('#ip-pajakpembulatan').val()==1) {
						taxservice = pembulatan(taxservice);
			        }

		        	$('#pajakservice').empty();
					$('#pajakservice').append(formatRupiah(taxservice.toString(), 'Rp. '))
		        }

	        	$('#pajak').empty();
				$('#pajak').append(formatRupiah(tax.toString(), 'Rp. '))
				
				var total = tax+data.totalordertemp;
				$('#total').empty();
				$('#total').append(formatRupiah(total.toString(), 'Rp. '));
				//$('.container__load').load('components/content/transaksi.content.php?kond=home');
            }
        });
	}

	function plusminusItem(id, idbarang, index, keterangan, jumlah) {
		$.ajax({
			type:'POST',
	        url: "controllers/transaksi.ctrl.php?ket=plusminus",
            dataType: "json",
            data:{
            	id:id,
            	idbarang:idbarang,
            	index:index,
            	keterangan:keterangan,
            	jumlah:jumlah
            },
            success:function(data){
            	
            	if ($('#defaultForm-ordertype').val()=='online') {
		        	var pajakjml = $('#ip-pajakonline').val();	
	        	} else {
		        	var pajakjml = $('#ip-pajakresto').val();
		        }

            	console.log("plusminus sukses "+data.totalordertemp);
            	/*
            	if (data.jumlahordertemp==0) {
            		$("#listitem tr").eq(index).remove();
            	} else {
            		$("#listitem tr:eq("+index+") td span.text_total").empty();
	            	$("#listitem tr:eq("+index+") td span.text_total").text(formatRupiah(data.item.transaksi_detail_temp_total, 'Rp. '));
	            	
	            	$("#listitem tr:eq("+index+") td span.text_jumlah").empty();
	            	$("#listitem tr:eq("+index+") td span.text_jumlah").text(data.item.transaksi_detail_temp_jumlah);

	            	$("#listitem tr:eq("+index+") td button.btn-plusminus").attr("data-jumlah", data.item.transaksi_detail_temp_jumlah)
            	}
				
				$('#subtotal').empty();
	            $('#subtotal').append(formatRupiah(data.totalordertemp.toString(), 'Rp. '));

				var tax = parseInt(pajakjml)*data.totalordertemp*0.1;
				if ($('#ip-pajakpembulatan').val()==1) {
					tax = pembulatan(tax);
		        }

	        	$('#pajak').empty();
				$('#pajak').append(formatRupiah(tax.toString(), 'Rp. '))
				
				var total = tax+data.totalordertemp;
				$('#total').empty();
				$('#total').append(formatRupiah(total.toString(), 'Rp. '));
				*/

                $('.container__load').load('components/content/transaksi.content.php?kond=home');
                $('.btn-remove').unbind('click').click(function() {
                    var indexitem = $(this).parent().parent().index();
                    var id = $(this).data('id');
                    console.log("tambah "+indexitem+" "+id)
                    
                    removeItemTemp(id, indexitem);
                    
                });
				
            }
        });
	}

	function pembulatan(tax) {
		if (tax.toString().length == 3) {
            if (tax.toString().slice(0) == 0 ) {
                tax = 0;
            } else if (tax.toString().slice(0) <= 500 ) {
                tax = 500;
            } else {
                tax = 1000;
            }
            return tax;

        } else if (tax.toString().length == 4) {
            if (tax.toString().slice(1) == 0 ) {
                tax = tax.toString().slice(0,1)+"000";
            } else if (tax.toString().slice(1) <= 500 ) {
                tax = tax.toString().slice(0,1)+"500";
            } else {
                tax = parseInt(tax.toString().slice(0,1))+1+"000";
            }
            tax = parseInt(tax);
            return tax;
        } else if (tax.toString().length == 5) {
            if (tax.toString().slice(2) == 0 ) {
                tax = tax.toString().slice(0,2)+"000";
            } else if (tax.toString().slice(2) <= 500 ) {
                tax = tax.toString().slice(0,2)+"500";
            } else {
                tax = parseInt(tax.toString().slice(0,2))+1+"000";
            }
            tax = parseInt(tax);
            return tax;
        } else {
            if (tax.toString().slice(3) == 0 ) {
                tax = tax.toString().slice(0, 3)+"000";
            } else if (tax.toString().slice(3) <= 500 ) {
                tax = tax.toString().slice(0, 3)+"500";
            } else {
                tax = parseInt(tax.toString().slice(0, 3))+1+"000";
            }
            tax = parseInt(tax);
            return tax;
        }
	}
</script>