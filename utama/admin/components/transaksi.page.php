
	<input type="hidden" id="defaultForm-ordertype" name="ip-ordertype" value="<?php echo $_SESSION['order_type']; ?>">
    <input type="hidden" id="defaultForm-role" name="ip-role" value="<?php echo $_SESSION['role']; ?>">
	<main class="transaksi p-0 mr-0">
		<div class="main-wrapper">
		    <div class="container-fluid">
				<div class="row">
					<div class="col-md-1 pl-0 pr-0 position-relative">
						<div class="pt-3 pl-1 pr-1 row-nonota justify-content-md-center">
							<h5><b>Transaksi Booth</b></h5>
							<div class="pt-3 container__load__left"></div>
						</div>
					</div>
					<div class="col-md-7 pl-0 pr-0 container__load position-relative">

					</div>

					<div class="col-md-4 position-relative box-right">
						<div class="row">
							<div class="col-md-12 position-fixed info-color text-white col-right"></div>
							<div class="col-md-12">
								<h3 class="text-white pt-3 float-left">Order List</h3>
								<span class="text-white pt-4 float-right" id="datetime"></span>
								<div class="clear"></div>
								<!-- Search form -->
								<div class="form-inline md-form form-sm mt-2 mb-3 form-search info-color-dark">
									<input class="form-control form-control-sm text-white " type="text" placeholder="Cari Menu"
									    aria-label="Search" id="carimenu">
									<i class="fas fa-search text-white" aria-hidden="true"></i>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="button" class="btn btn-white waves-effect mr-2 text-info ordertype" data-id="dinein" id="dinein"><i class="fas fa-utensils"></i>Dine In</button>
								<button type="button" class="btn btn-white waves-effect mr-2 text-info ordertype" data-id="takeaway" id="takeaway"><i class="fab fa-gulp"></i>Take Away</button>
								<button type="button" class="btn btn-white waves-effect text-info ordertype" data-id="online" id="online"><i class="fas fa-motorcycle"></i>Online</button>
							</div>
							<div class="col-md-12 text-white mt-3 info-color-dark fadeIn animated" id="listitem">
								<table class="pt-2 pb-2"></table>
							</div>
							<?php
							if ($pajakresto==1) {
								
							}

							?>
							<div class="col-md-12 box-bottom">
								<div class="row text-white">
									<div class="col-md-4"><p class="h6">Subtotal</p></div>
									<div class="col-md-8 text-right"><p class="h5" id="subtotal"></p></div>
								</div>
								<div class="row text-white">
									<div class="col-md-4"><p class="h6 text-jenisdiskon"></p></div>
									<div class="col-md-8 text-right"><p class="h5 text-jumlahdiskon" id="dicount"></p></div>
								</div>
								<div class="row text-white">
									<div class="col-md-4"><p class="h6">Tax</p></div>
									<div class="col-md-8 text-right"><p class="h5" id="pajak"></p></div>
								</div>
								<?php 
								if ($pajakservice!=0) {
								?>
									<div class="row text-white">
										<div class="col-md-4"><p class="h6">Tax Service</p></div>
										<div class="col-md-8 text-right"><p class="h5" id="pajakservice"></p></div>
									</div>
								<?php
								}
								?>
								<div class="row text-white border-top pt-1">
									<div class="col-md-4"><p class="h1 mb-0">Total</p></div>
									<div class="col-md-8 text-right"><p class="h1 mb-0" id="total"></p></div>
								</div>

							    <input type="hidden" id="defaultForm-tax" name="ip-tax" value="">
							    <input type="hidden" id="defaultForm-servicetax" name="ip-servicetax" value="">
							    <input type="hidden" id="defaultForm-subtotal" name="ip-subtotal" value="">
							    <input type="hidden" id="defaultForm-total" name="ip-total" value="">
							    <input type="hidden" id="defaultForm-jenisdiskon" name="ip-jenisdiskon" value="">
							    <input type="hidden" id="defaultForm-jumlahdiskon" name="ip-jumlahdiskon" value="0">
								<div class="row pt-0 pb-2">
									<div class="col-md-6 btn-bottom">
										<div class="row">
											<div class="col-md-6 p-0">
												<button type="button" class="btn btn-white waves-effect text-danger" id="batal"><i class="fas fa-trash mr-2"></i>Batal</button>
											</div>
											<!--
											<div class="col-md-4 p-0">
												<a href="print/nota-temp.print.php?ordertype=<?php echo $_SESSION['order_type']; ?>" class="btn btn-white waves-effect text-warning" id="print" target="_blank"><i class="fas fa-print d-block mr-2"></i>Print</a>
											</div>
											-->
											<div class="col-md-6 p-0">
												<button type="button" class="btn btn-white waves-effect text-info" id="discount" data-toggle="modal" data-target="#modaldiscount"><i class="fas fa-tag mr-2"></i>Discount</button>
											</div>
										</div>

									</div>
									<div class="col-md-6 btn-bottom pr-1">
										<button type="button" class="btn btn-white waves-effect text-info" id="bayar" data-toggle="modal" data-target="#modaltransaksi" disabled><i class="fas fa-money-bill mr-2"></i>Bayar</button>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
		    </div>
		</div>
	</main>

	<?php include 'partials/footer.php'; ?>

	<?php include 'modals/transaksi.modal.php'; ?>
	<?php include 'modals/discount.modal.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){
		/*
		$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=list-transaksi-print',
		        dataType: "json",
		        success:function(data){
		        	console.log(data);
					
					for (var i in data) {
						if (i%2==0) {
							var n = parseInt(i) + 1;
							console.log("cek "+data[i].transaksi_nota+" - "+data[n].snack+" "+n);
						    //content += '<div class="btn box-item btn-print-nota danger-color text-white" data-id="'+data[i].transaksi_id+'" data-nota="'+data[i].transaksi_nota+'">'+data[i].transaksi_nota+'</div>';
					    }
					}
					
					
					

		        }
		    }); 

		/*/
		setInterval(function(){
			var content = "";
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=list-transaksi-print',
		        dataType: "json",
		        success:function(data){
		        	//console.log(data);

					for (var i in data) {
					    if (i%2==0) {
					    	var n = parseInt(i) + 1;
						    content += '<div class="btn box-item btn-print-nota danger-color text-white" data-id="'+data[i].transaksi_id+'" data-nota="'+data[i].transaksi_nota+'" data-snack="'+data[n].snack+'" data-makanan="'+data[n].makanan+'" data-minuman="'+data[n].minuman+'">'+data[i].transaksi_nota+'</div>';
					    }
					    
					}

					$('.container__load__left').empty(); 
					$('.container__load__left').append(content);

					$('.btn-print-nota').unbind('click').click(function() {
						var id = $(this).data('id');
						var nota = $(this).data('nota');
						var snack = $(this).data('snack');
						var minuman = $(this).data('minuman');
						var makanan = $(this).data('makanan');

						$.ajax({
							type:'POST',
					        url: "controllers/transaksi.ctrl.php?ket=updateket",
			                dataType: "json",
			                data:{id:id},
			                success:function(data){
			                	

			                }
			            });

						if (($("#print-kitchen").val()==1 && $("#makanan").val()!=0) && ($("#print-snack").val()==1 && snack==0) && ($("#print-bar").val()==1 && minuman==0)) {

			                windowList = new Array('print/checklist.print.php?set=makanan&id='+nota);
			        
				        } else if (($("#print-kitchen").val()==1 && makanan==0) && ($("#print-snack").val()==1 && snack!=0) && ($("#print-bar").val()==1 && minuman==0)) {
				           
				                windowList = new Array('print/checklist.print.php?set=snack&id='+nota);
				        
				        } else if (($("#print-kitchen").val()==1 && makanan==0) && ($("#print-snack").val()==1 && snack==0) && ($("#print-bar").val()==1 && minuman!=0)) {

				                windowList = new Array('print/checklist.print.php?set=minuman&id='+nota);
				        
				        } else if (($("#print-kitchen").val()==1 && makanan!=0) && ($("#print-snack").val()==1 && snack!=0) && ($("#print-bar").val()==1 && minuman==0)) {

				                windowList = new Array('print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=snack&id='+nota);
				        
				        } else if (($("#print-kitchen").val()==1 && makanan!=0) && ($("#print-snack").val()==1 && snack==0) && ($("#print-bar").val()==1 && minuman!=0)) {

				                windowList = new Array('print/checklist.print.php?set=makanan&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
				        
				        } else if (($("#print-kitchen").val()==1 && makanan==0) && ($("#print-snack").val()==1 && snack!=0) && ($("#print-bar").val()==1 && minuman!=0)) {

				                windowList = new Array('print/checklist.print.php?set=snack&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
				        
				        } else if (($("#print-kitchen").val()==1 && makanan!=0) && ($("#print-snack").val()==1 && snack!=0) && ($("#print-bar").val()==1 && minuman!=0)) {

				                windowList = new Array('print/checklist.print.php?set=makanan&id='+nota , 'print/checklist.print.php?set=snack&id='+nota, 'print/checklist.print.php?set=minuman&id='+nota);
				        
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

					});

		        }
		    }); 
		
		}, 4000);
		

		var order_type = $('#defaultForm-ordertype').val();
		if (order_type!='') {
			$('#'+order_type).attr("disabled","true");
			$('#bayar').removeAttr("disabled");
		} else {
			$('#bayar').attr("disabled","true");
		}

	    $('.ordertype').on('click',function(){
			var id = $(this).data('id');

            $.ajax({
				type:'POST',
		        url: "controllers/transaksi.ctrl.php?ket=ordertype",
                dataType: "json",
                data:{id:id},
                success:function(data){
                	$('#defaultForm-ordertype').val(data[0]);

					$('#bayar').removeAttr("disabled");
					$('.ordertype').removeAttr("disabled");
					$('#'+data[0]).attr("disabled","true");
					$('.container__load').load('components/content/transaksi.content.php?kond=home');
                	/*
                	if (data[0]=="dinein") {}
                		ordertype
                	*/

                }
            });
	    });

		if (order_type=='dinein') {

		}
		setInterval(function(){ 
			$('#datetime').empty(); 
			$('#datetime').append(moment(new Date()).format('ddd MMM DD YYYY | HH:mm:ss '));
		
		}, 1000);

		$('.container__load').load('components/content/transaksi.content.php?kond=home');

		$('#carimenu').bind("enterKey",function(e){
			var search = $(this).val();
			$('.container__load').load('components/content/transaksi.content.php?kond=search&q='+search);
			//alert(search);
			/*
			$.ajax({
                type: 'POST',
                url: "components/content/transaksi.content.php?kond=search",
                dataType: "json",
                data:{search:search},
                success: function(data) {
                	console.log(data)
                  //$('.container__load').load(data);
                }
            });
            */
		});
		

		$('#carimenu').keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});


		$('#batal').on('click',function(){
			$.ajax({
                type: 'POST',
		        url: "controllers/transaksi.ctrl.php?ket=batal",
                dataType: "json",
                success: function() {
                  	console.log("delete sukses")
					$('.container__load').load('components/content/transaksi.content.php?kond=home');
		        	$('#listitem table').empty();
		        	$('#subtotal').empty();
		        	$('#subtotal').append('Rp. 0');
					$('.ordertype').removeAttr("disabled");
                	$('#defaultForm-ordertype').val('');
					$('#bayar').attr("disabled","true");
                }
            });
		});


		$('#bayar').on('click',function(){
		    $("#totaltransaksi").empty();
		    $("#totaltransaksi").append($("#total").text());
        	$('#defaultForm-totalmodal').val($("#defaultForm-total").val());


		    $('.btn.paytype').on('click',function(){
				var id = $(this).data('id');
            	$('#defaultForm-paytype').val(id);

				$('.paytype').removeAttr("disabled");
				$('#'+id).attr("disabled","true");

				$('.btn.paytype').removeClass("select");
				$(this).addClass("select");

				if (id=='cash') {
					$('#price').removeAttr("disabled");
					$('#price').val('');
                  	$("#modaltransaksi label").removeClass("active");
					$('#defaultForm-meja').val('');
					$('#defaultForm-lantai').val('');
				} else {
                  	$("#modaltransaksi label").addClass("active");
					$('#price').val(formatCurrency($('#defaultForm-totalmodal').val().toString(), ''));
					$('#price').attr("disabled","true");

					if (id=='goresto') {
						$('#defaultForm-meja').val('1');
						$('#defaultForm-lantai').val('1');
					} else {
						$('#defaultForm-meja').val('');
						$('#defaultForm-lantai').val('');

					}
				}

		    });
			
		});

	});
</script>