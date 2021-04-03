<!-- begin:: Footer -->
					<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
						<div class="kt-container  kt-container--fluid ">
							<div class="kt-footer__copyright">
								<?php echo date('Y'); ?>
							</div>
							<!--<div class="kt-footer__menu">
								<a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">About</a>
								<a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Team</a>
								<a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>
							</div>-->
						</div>
					</div>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="assets/plugins/global/plugins.bundle.js?v1.2" type="text/javascript"></script>
		<script src="assets/js/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors(used by this page) -->
		<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
		<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
		<script src="assets/plugins/custom/gmaps/gmaps.js" type="text/javascript"></script>

		<!--end::Page Vendors -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/dashboard.js" type="text/javascript"></script>

		<!--begin::Page Vendors(used by this page) -->
		<script src="assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="assets/js/pages/components/extended/toastr.js" type="text/javascript"></script>
		<script type="text/javascript">
			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toast-top-full-width",
				"preventDuplicates": true,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
		</script>

		<!-- Validation Engine-->
		<link rel="stylesheet" href="assets/css/validationEngine/validationEngine.jquery.min.css">
		<script src="assets/js/validationEngine/jquery.validationEngine.min.js" type="text/javascript"></script>
		<script src="assets/js/validationEngine/jquery.validationEngine-en.js" type="text/javascript"></script>
		<script src="assets/js/gauge.min.js" type="text/javascript"></script>
		<script src="assets/js/highcharts/highcharts.js" type="text/javascript"></script>
		<script src="assets/js/highcharts/exporting.js" type="text/javascript"></script>
		<script src="assets/js/highcharts/export-data.js" type="text/javascript"></script>
		<script src="assets/js/highcharts/accessibility.js" type="text/javascript"></script>
		<script src="assets/js/pages/components/charts/morris-charts.js" type="text/javascript"></script>
		<script src="assets/js/highcharts/highslide-full.min.js"></script>
		<script src="assets/js/highcharts/highslide.config.js" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/highcharts/highslide.css?v1.1" />
		<script>
			$(document).ready(function(){
				// success alert fadeout

				$("#success-alert").hide();
				
				$("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
			      	$("#success-alert").slideUp(500);
			    });
				
				// success alert fadeout

				<?php 
					if($this->router->fetch_class() == 'quotations' || $this->router->fetch_class() == 'invoices'){
				?>

				$('#company, #attention, #fc_country, #fc_country_air').select2();

				$("#add_company #country").change(function(){
					$("#add_company #region").val($("#add_company #country option:selected").attr('region'));
				});

				$("#add_company #addCompany").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('client/addClientAjax'); ?>",
								data: $("#add_company #addCompany").serialize(),
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var client_id = resp.client_id;
									var clients = resp.clients;
									var html = '<option value="" disabled>Select</option>';
									Object.keys(clients).forEach(function(key) {
										var selected = '';
										if(client_id == clients[key].client_id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+clients[key].client_id+'" '+selected+'>'+clients[key].client_name+'</option>';
									});
									$("#company").html(html);
								}
							});
							$('#add_company').modal('hide');
						}
						return false;
					}, promptPosition: "inline"
				});

				$("#company").change(function(){
					if($(this).val() == ''){
						$("#attention, #addNewMember").attr("disabled", "disabled");
					}else{
						$("#attention, #addNewMember").removeAttr("disabled");
						$.ajax({
							type: 'POST',
							data: {'client_id': $(this).val()},
							url: '<?php echo site_url('client/getClientMembers'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var members = resp.members;
								var html = '<option value="" disabled>Select</option>';
								var member_id = '<?php if(isset($quote_details)){echo $quote_details[0]['member_id'];}else if(isset($rfq_details)){echo $rfq_details[0]['rfq_buyer'];} ?>';
								var selected = '';
								Object.keys(members).forEach(function(key) {
									selected = '';
									if(member_id == members[key].member_id){
										selected = 'selected="selected"';
									}
									html += '<option value="'+members[key].member_id+'" '+selected+'>'+members[key].name+'</option>';
								});
								$("#attention").html(html);
							}
						});
						$('#add_company').modal('hide');
					}
				});

				$("#company").trigger('change');

				$("#add_member #addMember").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							var inputData = $("#add_member #addMember").serializeArray();
							inputData.push({name: 'client_id', value: $("#company").val()});
							$.ajax({
								url: "<?php echo site_url('client/addClientMemberAjax'); ?>",
								data: inputData,
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var member_id = resp.member_id;
									var members = resp.members;
									var html = '<option value="" disabled>Select</option>';
									Object.keys(members).forEach(function(key) {
										var selected = '';
										if(member_id == members[key].member_id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+members[key].member_id+'" '+selected+'>'+members[key].name+'</option>';
									});
									$("#attention").html(html);
								}
							});
							$('#add_member').modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#delivery_time_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_delivery_time").val(), "type": "delivery_time"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#delivery_time").html(html);
								}
							});
							$("#new_delivery_time").val();
							$("#add_delivery_time").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#validity_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_validity").val(), "type": "validity"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#validity").html(html);
								}
							});
							$("#new_validity").val();
							$("#add_validity").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#origin_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_origin").val(), "type": "origin"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#origin_country").html(html);
								}
							});
							$("#new_origin").val('');
							$("#add_origin").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#payment_term_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_payment_term").val(), "type": "payment_terms"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#new_payment_term").val('');
									$("#payment_term").html(html);
								}
							});
							$("#add_payment_terms").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#unit_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_unit").val(), "type": "unit"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#new_unit").val('');
									$("#parent_unit").html(html);
									unit_str = html;
									$(".units").each(function(){
										$(this).html(html);
									});
								}
							});
							$("#add_unit").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#product_frm").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							$.ajax({
								url: "<?php echo site_url('quotations/addDetails'); ?>",
								data: {"data": $("#new_product").val(), "type": "product"},
								type: "POST",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '';
									Object.keys(resp.records).forEach(function(key) {
										var selected = '';
										if(resp.new_record_id == resp.records[key].id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp.records[key].id+'" '+selected+'>'+resp.records[key].value+'</option>';
									});
									$("#new_product").val('');
									$("#parent_product").html(html);
									product_str = html;
									$(".products").each(function(){
										$(this).html(html);
									});
								}
							});
							$("#add_product").modal('hide');
						}
						return false;
					},
					promptPosition: "inline"
				});

				var product_str = '<?php if(isset($prd_str)) echo $prd_str; ?>';
				var material_str = '<?php if(isset($mat_str)) echo $mat_str; ?>';
				var unit_str = '<?php if(isset($unit_str)) echo $unit_str; ?>';


				$("#fc_terms").change(function(){
					if($(this).val() == 'FOB'){
						$("#fc_country_air").parent('.form-group').hide();
						$("#fc_country").parent('.form-group').hide();
						$("#fc_port").parent('.form-group').hide();
						$("#fc_overlength").parent('.form-group').hide();
					} else if($(this).val() == 'DDU'){
						$("#fc_country_air").parent('.form-group').show();
						$("#fc_country").parent('.form-group').hide();
						$("#fc_port").parent('.form-group').hide();
						$("#fc_overlength").parent('.form-group').hide();
					} else if($(this).val() == 'CIF'){
						$("#fc_country_air").parent('.form-group').hide();
						$("#fc_country").parent('.form-group').show();
						$("#fc_port").parent('.form-group').show();
						$("#fc_overlength").parent('.form-group').show();
					}
				});

				$("#fc_trans_mode").change(function(){
					$("#fc_terms option").each(function(){
						if($(this).attr('type') == $("#fc_trans_mode").val()){
							$(this).show();
						}else{
							$(this).hide();
						}
					});
					if($("#fc_trans_mode").val() == 'sea'){
						$("#sea_country").show();
						$("#air_country").hide();
					}else if($("#fc_trans_mode").val() == 'air'){
						$("#sea_country").hide();
						$("#air_country").show();
					}
				});

				$("#fc_country").change(function(){
					$("#fc_port").val($("#fc_country option:selected").attr('port'));
				})

				$("#freight_calc").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							var weight = parseFloat($("#fc_weight").val());
							if($("#fc_trans_mode").val() == 'sea'){
								if($('#fc_terms').val() == 'FOB'){
									if(weight <= 1000){
										freight_charge = 150;
									}else if(weight <= 5000){
										freight_charge = 200;
									}else if(weight <= 7000){
										freight_charge = 250;
									}else if(weight <= 10000){
										freight_charge = 300;
									}else if(weight <= 13000){
										freight_charge = 350;
									}else if(weight <= 16000){
										freight_charge = 400;
									}else if(weight <= 18000){
										freight_charge = 450;
									}else if(weight <= 20000){
										freight_charge = 500;
									}
									$("#fc_value").val(freight_charge);
								}else if($('#fc_terms').val() == 'CIF'){
									var extra_ton_charge = 50;
									var overlength_pipe_charge = 150;
									var no_of_tons = Math.ceil(weight / 1000);
									var freight_charge = $("#fc_country option:selected").attr('per_ton');
									if(no_of_tons > 1){
										freight_charge = parseFloat(freight_charge) + parseFloat((no_of_tons - 1) * 50);
									}

									if($("#fc_overlength").val() == 'yes'){
										freight_charge = parseFloat(freight_charge) + 150;
									}
									$("#fc_value").val(freight_charge);
								}
							}else if($("#fc_trans_mode").val() == 'air'){
								if($("#fc_terms").val() == 'FOB'){
									if(weight <= 1000){
										freight_charge = 100;
									}else if(weight <= 5000){
										freight_charge = 150;
									}else if(weight <= 7000){
										freight_charge = 200;
									}else if(weight <= 10000){
										freight_charge = 250;
									}else if(weight <= 13000){
										freight_charge = 300;
									}else if(weight <= 16000){
										freight_charge = 350;
									}else if(weight <= 18000){
										freight_charge = 400;
									}else if(weight <= 20000){
										freight_charge = 450;
									}
									$("#fc_value").val(freight_charge);
								}else if($("#fc_terms").val() == 'DDU'){
									var zone_id = $("#fc_country_air option:selected").attr('zone');
									$.ajax({
										type: 'POST',
										data: {'weight': weight, 'zone_id': zone_id},
										url: '<?php echo site_url('quotations/calculateCharge'); ?>',
										success: function(res){
											$("#fc_value").val(res);
										}
									});
								}
							}
						}
						return false;
					},
					promptPosition: "inline"
				});

				$("#quotation_form #add_row").click(function(){
					var sr = parseInt($("#tbody tr").length)+1;
					$("#tbody").append('<tr><td>'+sr+'</td><td><select class="form-control products" name="product_id[]"><option value="">Select Product</option>'+product_str+'</select><select class="form-control materials" name="material_id[]"><option value="">Select Material</option>'+material_str+'</select></td><td><textarea class="form-control validate[required]" name="description[]"></textarea></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] quantity" name="quantity[]"></td><td><select class="form-control units" name="unit[]">'+unit_str+'</select></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] rate" name="unit_rate[]"></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] margin" name="margin[]"></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] packingCharge" name="packing_charge[]"></td><td><label class="unit_price"></label><input type="text" name="unit_price[]" class="form-control unit_price_txt" validate[custom[onlyNumberSp]]></td><td><label class="total_price"></label></td><td><button type="button" class="btn btn-sm btn-danger delRow">Delete</button></td></tr>');
				});


				$('#quotation_form').on('change', '.products', function(){
					if($(this).val() == 265 || $(this).val() == 266){
						$(this).closest('tr').find('.units').val(2);
					}else{
						$(this).closest('tr').find('.units').val(1);
					}

					$(".products").each(function(){
						if($(this).val() == 265){
							$("#transport_mode").val(1);
						}
					});
				});

				$("#quotation_form").on("keyup", ".unit_price_txt", function(){
					if($(this).val() != ''){
						$(this).closest('tr').find('.rate').val('').attr('readonly', 'readonly').removeClass('validate[required,custom[onlyNumberSp]]');
						$(this).closest('tr').find('.margin').val('').attr('readonly', 'readonly').removeClass('validate[required,custom[onlyNumberSp]]');
						$(this).closest('tr').find('.packingCharge').val('').attr('readonly', 'readonly').removeClass('validate[required,custom[onlyNumberSp]]');
					}else if($(this).val() == ''){
						$(this).closest('tr').find('.rate').val('').removeAttr('readonly').addClass('validate[required,custom[onlyNumberSp]]');
						$(this).closest('tr').find('.margin').val('').removeAttr('readonly').addClass('validate[required,custom[onlyNumberSp]]');
						$(this).closest('tr').find('.packingCharge').val('').removeAttr('readonly').addClass('validate[required,custom[onlyNumberSp]]');
					}
					updateRow($(this).closest('tr'));
				});

				$('#quotation_form').on('keyup', '.quantity', function(){
					updateRow($(this).closest('tr'));
				});

				$('#quotation_form').on('keyup', '.rate', function(){
					updateRow($(this).closest('tr'));
				});

				$('#quotation_form').on('keyup', '.packingCharge', function(){
					updateRow($(this).closest('tr'));
					$(".packingCharge").each(function(){
						if($(this).val() > 1){
							$("#transport_mode").val(1);
						}
					});
				});

				$('#quotation_form').on('keyup', '.margin', function(){
					updateRow($(this).closest('tr'));
				});

				$("#transport_mode").change(function(){
					var mode = $(this).val();
					$("#delivered_through option").each(function(){
						if($(this).attr('trans_id') == mode){
							$(this).show();
						}else{
							$(this).hide();
						}
					})
				});

				function updateRow(tr){
					var qty = $(tr).find('.quantity').val();
					var rate = $(tr).find('.rate').val();
					var pc = $(tr).find('.packingCharge').val();
					var margin = $(tr).find('.margin').val();
					var unit_price_txt = $(tr).find('.unit_price_txt').val();
					if(qty != '' && rate != '' && pc != ''){
						var currency_rate = $("#currency option:selected").attr('rate');
						$("#currency_rate").val(currency_rate);
						var unit_price = (parseFloat(rate) + parseFloat(rate * pc / 100) + parseFloat(rate * margin / 100) ) / currency_rate;
						var total_price = unit_price * qty;
						if(!isNaN(total_price)){
							$(tr).find('.unit_price').html(convertRound(unit_price, 2));
							$(tr).find('.total_price').html(convertRound(total_price, 2));
						}
					}else if(qty != '' && unit_price_txt != ''){
						var total_price = unit_price_txt * qty;
						if(!isNaN(total_price)){
							//$(tr).find('.unit_price').html(convertRound(unit_price, 2));
							$(tr).find('.total_price').html(convertRound(total_price, 2));
						}
					}

					var net_total = 0;
					$("#quotation_form #tbody .total_price").each(function(){
						net_total += parseFloat($(this).html());
					});


					$("#quotation_form #net_total").html(convertRound(net_total, 2));

					var freight_charges = 0; var bank_charges = 0; var grand_total = 0; var advance = 3; var discount = 0; var other_charges = 0; var gst = 0;

					if(net_total < 3000){
						bank_charges = 30;
						advance = 3;
					}else if(net_total >= 3000 && net_total < 6000){
						bank_charges = 30;
						advance = 4;
					}else if(net_total >= 6000 && net_total < 15000){
						bank_charges = 30;
						advance = 5;
					}else if(net_total >= 15000 && net_total < 25000){
						bank_charges = 30;
						advance = 5;
					}else if(net_total >= 25000 && net_total < 100000){
						bank_charges = 30;
						advance = 5;
					}else if(net_total >= 100000){
						bank_charges = 50;
						advance = 5;
					}

					$("#bank_charges").val(bank_charges);
					$("#payment_term").val(advance);

					if($("#quotation_form #freight").val() != '' && $("#quotation_form #freight").val() != undefined){
						freight_charges = $("#quotation_form #freight").val();
					}

					if($("#quotation_form #bank_charges").val() != '' && $("#quotation_form #bank_charges").val() != undefined){
						bank_charges = $("#quotation_form #bank_charges").val();
					}

					if($("#quotation_form #discount").val() != '' && $("#quotation_form #discount").val() != undefined){
						if($("#discount_type").val() == 'percent'){
							discount = convertRound((net_total * $("#discount").val()) / 100, 2);
						}else if($("#discount_type").val() == 'value'){
							discount = $("#discount").val();
						}
					}

					if($("#quotation_form #other_charges").val() != '' && $("#quotation_form #other_charges").val() != undefined){
						other_charges = $("#quotation_form #other_charges").val();
					}

					if($("#currency").val() == 3){
						gst = convertRound((18 * net_total) / 100, 2);
					}
					$("#gst_span").html(gst);
					$("#gst").val(gst);

					grand_total = parseFloat(net_total) + parseFloat(freight_charges) + parseFloat(bank_charges) + parseFloat(gst) + parseFloat(other_charges) - parseFloat(discount);
					$("#quotation_form #grand_total").html(convertRound(grand_total, 2));
				}

				$("#parent_unit").change(function(){
					$("#quotation_form #tbody tr").each(function(){
						$(this).find('.units').val($("#parent_unit").val());
					});
				});

				$("#parent_margin").keyup(function(){
					$("#quotation_form #tbody tr").each(function(){
						$(this).find('.margin').val($("#parent_margin").val());
						updateRow($(this));
					});
				});

				$("#parent_packaging").keyup(function(){
					$("#quotation_form #tbody tr").each(function(){
						$(this).find('.packingCharge').val($("#parent_packaging").val());
						updateRow($(this));
					});
				});

				$("#parent_product").change(function(){
					var prd = $(this).val();
					$(".products").each(function(){
						$(this).val(prd);
						if(prd == 265){
							$("#transport_mode").val(1);
						}
					});
				});

				$("#parent_material").change(function(){
					var mat = $(this).val();
					$(".materials").each(function(){
						$(this).val(mat);
					});
				});

				$("#currency").change(function(){
					if($(this).val() == 3){
						$("#gst_tr").show();
					}else{
						$("#gst_tr").hide();
					}
					$("#quotation_form #tbody tr").each(function(){
						updateRow($(this));
					});
				});

				$("#stage").change(function(){
					if($(this).val() == 'proforma'){
						$("#ref_div").hide();
						$("#order_div").show();
						$("#proforma_div").show();
					}else{
						$("#ref_div").show();
						$("#order_div").hide();
						$("#proforma_div").hide();
					}
				});

				$("#quotation_form #freight, #quotation_form #bank_charges, #quotation_form #discount, #quotation_form #other_charges").keyup(function(){
					var net_total = 0; var freight_charges = 0; var bank_charges = 0; var grand_total = 0; var discount = 0; var other_charges = 0; var gst = 0;

					if($("#quotation_form #net_total").html() != '' && $("#quotation_form #net_total").html() != undefined){
						var net_total = $("#quotation_form #net_total").html();
					}
					
					if($("#quotation_form #freight").val() != '' && $("#quotation_form #freight").val() != undefined){
						freight_charges = $("#quotation_form #freight").val();
					}

					if($("#quotation_form #bank_charges").val() != '' && $("#quotation_form #bank_charges").val() != undefined){
						bank_charges = $("#quotation_form #bank_charges").val();
					}

					if($("#quotation_form #discount").val() != '' && $("#quotation_form #discount").val() != undefined){
						if($("#discount_type").val() == 'percent'){
							discount = convertRound((net_total * $("#discount").val()) / 100, 2);
						}else if($("#discount_type").val() == 'value'){
							discount = $("#discount").val();
						}
					}

					if($("#quotation_form #other_charges").val() != '' && $("#quotation_form #other_charges").val() != undefined){
						other_charges = $("#quotation_form #other_charges").val();
					}

					if($("#currency").val() == 3){
						gst = convertRound((18 * net_total) / 100, 2);
					}
					$("#gst_span").html(gst);
					$("#gst").val(gst);

					grand_total = parseFloat(net_total) + parseFloat(freight_charges) + parseFloat(bank_charges) + parseFloat(gst) + parseFloat(other_charges) - parseFloat(discount);
					$("#quotation_form #grand_total").html(convertRound(grand_total, 2));
				});

				$("#quotation_form #discount_type").change(function(){
					var net_total = 0; var freight_charges = 0; var bank_charges = 0; var grand_total = 0; var discount = 0; var other_charges = 0; var gst = 0;

					if($("#quotation_form #net_total").html() != '' && $("#quotation_form #net_total").html() != undefined){
						var net_total = $("#quotation_form #net_total").html();
					}
					
					if($("#quotation_form #freight").val() != '' && $("#quotation_form #freight").val() != undefined){
						freight_charges = $("#quotation_form #freight").val();
					}

					if($("#quotation_form #bank_charges").val() != '' && $("#quotation_form #bank_charges").val() != undefined){
						bank_charges = $("#quotation_form #bank_charges").val();
					}

					if($("#quotation_form #discount").val() != '' && $("#quotation_form #discount").val() != undefined){
						if($("#discount_type").val() == 'percent'){
							discount = convertRound((net_total * $("#discount").val()) / 100, 2);
						}else if($("#discount_type").val() == 'value'){
							discount = $("#discount").val();
						}
					}

					if($("#quotation_form #other_charges").val() != '' && $("#quotation_form #other_charges").val() != undefined){
						other_charges = $("#quotation_form #other_charges").val();
					}

					if($("#currency").val() == 3){
						gst = convertRound((18 * net_total) / 100, 2);
					}
					$("#gst_span").html(gst);
					$("#gst").val(gst);

					grand_total = parseFloat(net_total) + parseFloat(freight_charges) + parseFloat(bank_charges) + parseFloat(gst) + parseFloat(other_charges) - parseFloat(discount);
					$("#quotation_form #grand_total").html(convertRound(grand_total, 2));
				});

				<?php if($this->router->fetch_class() == 'quotations' && $this->router->fetch_method() == 'list') { ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#invoice_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('quotations/list_data'); ?><?php if(isset($type)) echo '/'.$type; ?>',
									data: function(data){
										var fin_year = $("#fin_year").val();
										data.searchByFinYear = fin_year;
									} 
								},
								columns: [
									{data: 'record_id'},
									{data: 'quote_no', responsivePriority: -1},
									<?php if($this->session->userdata('role') == 1) { ?>
									{data: 'username', responsivePriority: -1},
									<?php } ?>
									{data: 'date', responsivePriority: -1},
									{data: 'month'},
									{data: 'week'},
									{data: 'client_name', responsivePriority: -1},
									{data: 'grand_total', responsivePriority: -1, render: $.fn.dataTable.render.number( ',', '.', 2 )},
									{data: 'country', responsivePriority: -1},
									{data: 'region', responsivePriority: -1},
									{data: 'fdate', responsivePriority: -1},
									{data: 'importance', responsivePriority: -1},
									{data: 'status', responsivePriority: -1},
									{data: 'WApp', responsivePriority: -1},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var fup_btn = '';
											var title = '';
											if(full.stage == 'publish'){
												fup_btn = `<button class="btn btn-sm btn-clean btn-icon btn-icon-md followup" title="Follow Up" quote_id="`+full.quotation_mst_id+`">
					                        		<i class="la la-calendar-plus-o"></i>
					                        	</button>`;
											}

											return `
					                        <a href="<?php echo site_url('quotations/viewQuotation/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation Details" target="_blank" >
					                            <i class="fa fa-file-invoice"></i>
					                        </a>
					                        <a href="<?php echo site_url('quotations/pdf/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <a href="<?php echo site_url('quotations/add/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"  target="_blank">
					                            <i class="la la-edit"></i>
					                        </a>`+fup_btn+`
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md mtcTask" title="MTC Task" quote_id="`+full.quotation_mst_id+`" quote_no="`+full.quote_no+`" company_id="`+full.client_id+`" company="`+full.client_name+`"><i class="la la-tasks"></i></button>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md deleteQuote" title="Delete" quote_id="`+full.quotation_mst_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>
					                        `;
										},
									},
									{
										targets: <?php if($this->session->userdata('role') == 1) echo '13'; else echo '12';?>,
										title: 'WApp',
										orderable: false,
										render: function(data, type, full, meta) {
											if(full.is_whatsapp == 'Y')
											{
												return `<a href="https://web.whatsapp.com/send?phone=`+full.mobile+`&text=" class="btn btn-xs btn-clean btn-icon btn-icon-sm" title="View Quotation Details" target="_blank" >
						                            <i class="la la-whatsapp"></i>
						                        </a>`;
											}else{
												return ``;
											}
										},
									},
									{
										targets: <?php if($this->session->userdata('role') == 1) echo '12'; else echo '11';?>,
										title: 'Status',
										orderable: false,
										render: function(data, type, full, meta) {
											if(full.status == 'Open'){
												return `<span class="badge badge-primary" style="color: #fff;">`+full.status+`</span>`;
											}else if(full.status == 'Closed'){
												return `<span class="badge badge-danger" style="color: #fff;">`+full.status+`</span>`;
											}else if(full.status == 'Won'){
												return `<span class="badge badge-success" style="color: #fff;">`+full.status+`</span>`;
											}else{
												return ``;
											}
										},
									},
									{
										targets: 1,
										title: 'Quote #',
										orderable: false,
										render: function(data, type, full, meta) {
											if(full.quote_no != ''){
												if(full.is_new == 'Y'){
													return full.quote_no+' <sup><span class="badge badge-sm badge-danger">New</span></sup>';
												}else{
													return full.quote_no;
												}
											}else{
												return ``;
											}
										},
									},
									{
										targets: 4,
										className: "text-center",
									},
									{
										targets: 5,
										className: "text-center",
									},
									{
										targets: 7,
										className: "text-right",
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$("#invoice_table").on('click', '.deleteQuote', function(){
						if(confirm('Are you sure?') == true){
							var quote_id = $(this).attr('quote_id');
							$.ajax({
								type: "POST",
								data: {"quote_id": quote_id},
								url: "<?php echo site_url('quotations/deleteQuote');?>",
								success: function(){
									$("#invoice_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});

					$("#fin_year").change(function(){
						var val = $(this).val();
						var dataTable = $('#invoice_table').DataTable();
						dataTable.draw();
					});

					$("#invoice_table").on('click', '.mtcTask', function(){
						var quote_id = $(this).attr('quote_id');
						var quote_no = $(this).attr('quote_no');
						var company = $(this).attr('company');
						var company_id = $(this).attr('company_id');
						$.ajax({
							type: 'POST',
							data: {quote_id: quote_id},
							url: '<?php echo site_url('quality/getSampleMTCStatus'); ?>',
							success: function(res){
								if(res == '[]'){
									var html = `
										<div class="row">
											<div class="col-md-12">
												<button class="btn btn-warning mtc_request" quote_id="`+quote_id+`" quote_no="`+quote_no+`" company="`+company+`" company_id="`+company_id+`">Request for Sample MTC</button>
											</div>
										</div>
									`;
									$("#mtc-popup .modal-body").html(html);
									$("#mtc-popup").modal('show');
								}else{
									response = $.parseJSON(res);
									resp = response.mtc;
									var mtc_made = 'No';
									if(resp.made_flag == 'Y'){
										mtc_made = 'Yes <div>';
										Object.keys(response.files).forEach(function(key) {
											mtc_made += `<a href="<?php echo site_url('assets/mtc-document/'); ?>`+response.files[key].file_name+`">View Document</a><br/>`;
										});
										mtc_made += '</div>';
									}

									var checked_qa = 'Pending';
									if(resp.checked_by_quality_admin == 'Y'){
										checked_qa = 'Approved';
									}else if(resp.checked_by_quality_admin == 'N'){
										checked_qa = 'Disapproved';
									}

									var checked_sa = 'Pending';
									if(resp.checked_by_super_admin == 'Y'){
										checked_sa = 'Approved';
									}else if(resp.checked_by_super_admin == 'N'){
										checked_sa = 'Disapproved';
									}
									var html = `
										<div class="row">
											<div class="col-md-12">Made Status: <b>`+mtc_made+`</b></div>
											<div class="col-md-12">Quality Admin Status: <b>`+checked_qa+`</b></div>
											<div class="col-md-12">Super Admin Status: <b>`+checked_sa+`</b></div>
										</div>
									`;
									$("#mtc-popup .modal-body").html(html);
									$("#mtc-popup").modal('show');
								}
							}
						});
					});

					$("#mtc-popup").on('click', '.mtc_request', function(){
						var quote_id = $(this).attr('quote_id');
						var quote_no = $(this).attr('quote_no');
						var company = $(this).attr('company');
						var company_id = $(this).attr('company_id');
						$.ajax({
							url: '<?php echo site_url('quality/add_mtc'); ?>',
							data: {mtc_type: 'sample', mtc_for: quote_no, mtc_for_hidden: quote_id, mtc_company: company, mtc_company_id: company_id, assigned_to: '', 'is_ajax': 1},
							type: 'post',
							success: function(res){
								alert(res);
							}
						});
					});
				<?php } ?>

				<?php if($this->router->fetch_class() == 'quotations' && $this->router->fetch_method() == 'followup') { ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#followup_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: '<?php echo site_url('quotations/followup_data'); ?>',
								columns: [
									{data: 'record_id'},
									{data: 'quote_no'},
									{data: 'date'},
									{data: 'client_name'},
									{data: 'grand_total'},
									{data: 'country'},
									{data: 'region'},
									{data: 'followup_date'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											/*return `
					                        <a href="<?php echo site_url('quotations/pdf/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Invoice" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md followup" title="Follow Up" quote_id="`+full.quotation_mst_id+`">
					                        	<i class="la la-calendar-plus-o"></i>
					                        </button>
					                        `;*/
					                        return `
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md followup" title="Follow Up" quote_id="`+full.quotation_mst_id+`">
					                        	<i class="la la-calendar-plus-o"></i>
					                        </button>
					                        <a href="<?php echo site_url('quotations/viewQuotation/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation Details" target="_blank" >
					                            <i class="fa fa-file-invoice"></i>
					                        </a>
					                        <a href="<?php echo site_url('quotations/pdf/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <a href="<?php echo site_url('quotations/add/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"  target="_blank">
					                            <i class="la la-edit"></i>
					                        </a>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md deleteQuote" title="Delete" quote_id="`+full.quotation_mst_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>
					                        `;
					                        /*<button class="btn btn-sm btn-clean btn-icon btn-icon-md deleteInvoice" title="Delete" invoice_id="`+full.invoice_mst_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>*/
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$("#followup_table").on('click', '.deleteQuote', function(){
						if(confirm('Are you sure?') == true){
							var quote_id = $(this).attr('quote_id');
							$.ajax({
								type: "POST",
								data: {"quote_id": quote_id},
								url: "<?php echo site_url('quotations/deleteQuote');?>",
								success: function(){
									$("#followup_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});
				<?php } ?>

				<?php if($this->router->fetch_class() == 'quotations' && ($this->router->fetch_method() == 'followup' || $this->router->fetch_method() == 'list' || $this->router->fetch_method() == 'viewQuotation')) { ?>
					$("#followup_table, #invoice_table, #siblingInvoice").on('click', '.followup', function(){
						var quote_id = $(this).attr('quote_id');
						$.ajax({
							type: "POST",
							data: {"quote_id": quote_id},
							url: "<?php echo site_url('quotations/getFollowUpHistory');?>",
							success: function(res){
								$("#followup-popup #tab_history").html('');
								if(res != '[]'){
									resp = $.parseJSON(res);
									var table = '<table class="table table-bordered table-stripped"><tr><th>Sr #</th><th>Follow Up Date</th><th>Follow Up Details</th></tr>';
									var quote_no = '';
									var client_name = '';
									for(key in resp){
										table += '<tr><td>'+parseInt(key+1)+'</td><td>'+resp[key].followedup_on+'</td><td>'+resp[key].follow_up_text+'</td>';
										quote_no = resp[key].quote_no;
										client_name = resp[key].client_name;
									}
									table += '</table>';
									$("#followup-popup #tab_history").html(table);
								}
								$("#followup-popup #quote_id").val(quote_id);
								$("#followup-popup").modal('show');
							}
						});
					});
				<?php } ?>

				<?php if($this->router->fetch_class() == 'quotations' && $this->router->fetch_method() == 'viewQuotation') { ?>
					$("#status").change(function(){
						if($(this).val() == 'Closed'){
							$("#reason").removeAttr('disabled');
						}else{
							$("#reason").attr('disabled', 'disabled');
						}
					});
				<?php } ?>


				/*-------------------------------------------------------------------------------------------------------*/

				$("#invoice_form #add_row").click(function(){
					var sr = parseInt($("#tbody tr").length)+1;
					$("#tbody").append('<tr><td>'+sr+'</td><td><textarea class="form-control validate[required]" name="description[]" ></textarea></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] qty" name="quantity[]"></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] rate" name="rate[]"></td><td><label class="price"></label></td><td><select class="form-control" id="product_select" name="product[]"><option value="">Select Product</option>'+product_str+'</select></td><td><select class="form-control id="material_select" name="material[]"><option value="">Select Material</option>'+material_str+'</select></td><td><button type="button" class="btn btn-danger btn-sm delRow">Delete</button></td></tr>');
				});

				$("#invoice_form").on('keyup', '.qty', function(){
					var rate = $(this).closest('tr').find('.rate').val();
					var qty = $(this).val();
					if(rate != ''){
						$(this).closest('tr').find('.price').text(convertRound(rate*qty, 2));
					}
					calculateTotal();
				});

				$("#invoice_form").on('keyup', '.rate', function(){
					var qty = $(this).closest('tr').find('.qty').val();
					var rate = $(this).val();
					if(rate != ''){
						$(this).closest('tr').find('.price').text(convertRound(rate*qty, 2));
					}
					calculateTotal();
				});

				$("#invoice_form #freight_charges, #invoice_form #other_charges, #invoice_form #discount").keyup(function(){
					/*var net_total = 0; var freight_charges = 0; var other_charges = 0;
					if($("#net_total").html() != ''){
						net_total = $("#net_total").html();
					}

					if($("#freight_charges").val() != ''){
						freight_charges = $("#freight_charges").val();
					}

					if($("#other_charges").val() != ''){
						other_charges = $("#other_charges").val();
					}

					$("#grand_total").html(parseInt(net_total)+parseInt(freight_charges)+parseInt(other_charges));*/
					calculateTotal();
				});

				function calculateTotal(){
					var net_total = 0; var freight_charges = 0; var other_charges = 0; var discount = 0;
					$("#invoice_form .price").each(function(){
						net_total = net_total + parseFloat($(this).html());
					});

					$("#net_total").html(convertRound(net_total, 2));

					if($("#freight_charges").val() != ''){
						freight_charges = $("#freight_charges").val();
					}

					if($("#other_charges").val() != ''){
						other_charges = $("#other_charges").val();
					}

					if($("#discount").val() != ''){
						discount = $("#discount").val();
					}

					$("#grand_total").html(convertRound(parseFloat(net_total)+parseFloat(freight_charges)+parseFloat(other_charges)-parseFloat(discount), 2));
				}

				function convertRound(num, places) {
				    return +(Math.round(num + "e+"+places)  + "e-"+places);
				}

				$("#invoice_form").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true && $("#net_total").html() != ''){
							$("#invoice_form").submit();
						}else{
							return false;
						}
					},
					promptPosition: "inline"
				});

				$("#quotation_form").validationEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							return true;
						}else{
							return false;
						}
					},
					promptPosition: "inline"
				});

				$("#quotation_form").on('click', '.delRow', function(){
					$(this).closest('tr').remove();
				});

				$("#invoice_form").on('click', '.delRow', function(){
					$(this).closest('tr').remove();
					calculateTotal();
				});

				$("#invoice_form").on('click', '.removeBtn', function(){
					if(confirm('Are you sure?') == true){
						$(this).closest('tr').remove();
						calculateTotal();
					}
				});

				<?php if($this->router->fetch_class() == 'invoices' && $this->router->fetch_method() == 'list') { ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#invoice_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('invoices/list_data'); ?>',
									data: function(data){
										var fin_year = $("#fin_year").val();
										data.searchByFinYear = fin_year;
									} 
								},
								columns: [
									{data: 'record_id'},
									{data: 'invoice_no'},
									{data: 'invoice_date'},
									{data: 'client_name'},
									{data: 'name'},
									{data: 'country'},
									{data: 'grand_total'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `
					                        <a href="<?php echo site_url('invoices/invoice_pdf/'); ?>`+full.invoice_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Invoice" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <a href="<?php echo site_url('invoices/new/'); ?>`+full.invoice_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"  target="_blank">
					                            <i class="la la-edit"></i>
					                        </a>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md deleteInvoice" title="Delete" invoice_id="`+full.invoice_mst_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>`;
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$("#invoice_table").on('click', '.deleteInvoice', function(){
						if(confirm('Are you sure?') == true){
							var invoice_id = $(this).attr('invoice_id');
							$.ajax({
								type: "POST",
								data: {"invoice_id": invoice_id},
								url: "<?php echo site_url('invoices/deleteInvoice');?>",
								success: function(){
									$("#invoice_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});

					$("#fin_year").change(function(){
						var val = $(this).val();
						var dataTable = $('#invoice_table').DataTable();
						dataTable.draw();
					});
				<?php } ?>

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'list'){ ?>

					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									complete: function (data) {
				                        $("#lead_exporter_name").html(data['responseJSON'].exporter_name);
				                        $("#lead_importer_name").html(data['responseJSON'].importer_name);
				                        $("#lead_nimporter_name").html(data['responseJSON'].new_importer_name);
				                        $("#lead_country").html(data['responseJSON'].country_str);
				                    },
									url: '<?php echo site_url('leads/list_data'); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										columnsDef: [
											'record_id', 'EXPORTER_NAME', 'IMPORTER_NAME', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR',
											'COUNTRY_OF_DESTINATION', 'no_of_employees', 'Actions',],
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'EXPORTER_NAME'},
									{data: 'IMPORTER_NAME'},
									{data: 'NEW_IMPORTER_NAME'},
									{data: 'FOB_VALUE_INR'},
									{data: 'COUNTRY_OF_DESTINATION'},
									{data: 'no_of_employees'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
										//console.log(column.title());
										switch (column.title()) {
											case 'Exporter Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_exporter_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $exporter_name; ?>');
												break;

											case 'Importer Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_importer_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $importer_name; ?>');
												break;

											case 'New Importer Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_nimporter_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $new_importer_name; ?>');
												break;

											case 'Destination Country':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_country" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $country_str; ?>');
												/*column.data().unique().sort().each(function(d, j) {
													$(input).append('<option value="' + d + '">' + d + '</option>');
												});*/
												break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									// hide search column for responsive table
									var hideSearchColumnResponsive = function () {
							           	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									           	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									           	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					         		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<input type="checkbox" class="record" value="`+full.LEAD_ID+`" title="Select to Merge">
											<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md addDetails" title="Add Details" nimp_name = "`+full.NEW_IMPORTER_NAME+`">
					                        	<i class="la la-plus-square"></i>
					                        </button>`;
										},
									},
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#merge_records").click(function(){
						var ids = '';
						$("#leads_table .record").each(function(){
							if($(this).is(':checked')){
								ids = ids + $(this).val() + ',';
							}
						});
						if(ids != ''){
							$.ajax({
								type: 'POST',
								data: {"record_ids": ids},
								url: "<?php echo site_url('leads/getImporterNames/1'); ?>",
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '<div class="kt-portlet "><div class="row">';
									Object.keys(resp).forEach(function(key) {
										html += '<div class="col-md-6"><label class="imp_name" lead_id="'+resp[key].LEAD_ID+'" style="cursor:pointer;">'+resp[key].IMPORTER_NAME+'</label></div>';
									});
									html += '</div><div class="row"><div class="col-md-6"><label>New Importer Name: <input class="form-control" id="new_imp_name"></div></div></div>';
									$("#popup .modal-body").html(html);
									$("#popup").modal('show');
								}
							});
						}
					});

					$("#popup").on("click", ".imp_name", function(){
						$("#new_imp_name").val($(this).html());
					});

					$("#update_imp_name").click(function(){
						if(confirm("Are you sure you want to update new Importer Name as `"+$("#new_imp_name").val()+"` ?")){
							var ids = "";
							$(".imp_name").each(function(){
								ids += $(this).attr('lead_id')+',';
							});
							$.ajax({
								type: 'POST',
								data: {"new_imp_name": $("#new_imp_name").val(), ids: ids},
								url: "<?php echo site_url('leads/updateImporterName/1'); ?>",
								success: function(res){
									alert('Importer Name updated successfully.');
									$("#popup").modal('hide');
									$("#leads_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});

					$("#leads_table").on('click', '.addDetails', function(){
						var nimp_name = $(this).attr('nimp_name');
						$("#details-popup #nimp_name").val(nimp_name);
						$.ajax({
							type: 'POST',
							data: {"nimp_name": nimp_name},
							url: '<?php echo site_url('leads/getDetails'); ?>',
							success: function(res){
								if(res != 'null'){
									resp = $.parseJSON(res);
									$("#details-popup #no_of_employees").val(resp['no_of_employees']);
									$("#details-popup #buyer_name").val(resp['buyer_name']);
									$("#details-popup #designation").val(resp['designation']);
									$("#details-popup #telephone").val(resp['email']);
									$("#details-popup #mobile").val(resp['mobile']);
									$("#details-popup #is_whatsapp").val(resp['is_whatsapp']);
									$("#details-popup #skype").val(resp['telephone']);
									$("#details-popup #skype").val(resp['skype']);
								}
							}
						});
						$("#details-popup").modal('show');
					})

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'fuzzy_exp_imp_list'){ ?>

					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									complete: function (data) {
				                        $("#lead_exporter_name").html(data['responseJSON'].exporter_name);
				                        $("#lead_nimporter_name").html(data['responseJSON'].new_importer_name);
				                    },
									url: '<?php echo site_url('leads/fuzzy_exp_imp_list_data'); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										columnsDef: [
											'record_id', 'EXPORTER_NAME', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'],
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'EXPORTER_NAME'},
									{data: 'NEW_IMPORTER_NAME'},
									{data: 'FOB_VALUE_INR'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
										//console.log(column.title());
										switch (column.title()) {
											case 'Exporter Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_exporter_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $exporter_name; ?>');
												break;

											case 'New Importer Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_nimporter_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $new_importer_name; ?>');
												break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									 var hideSearchColumnResponsive = function () {
					           thisTable.api().columns().every(function () {
						           var column = this
						           if(column.responsiveHidden()) {
							           $(rowFilter).find('th').eq(column.index()).show();
						           } else {
							           $(rowFilter).find('th').eq(column.index()).hide();
						           }
					           })
					         };

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<input type="checkbox" class="record" value="`+full.EXPORTER_NAME+`/`+full.NEW_IMPORTER_NAME+`" title="Select to Merge">`;
										},
									},
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#merge_records").click(function(){
						var ids = '';
						$("#leads_table .record").each(function(){
							if($(this).is(':checked')){
								ids = ids + $(this).val() + ',';
							}
						});
						if(ids != ''){
							$.ajax({
								type: 'POST',
								data: {"record_ids": ids},
								url: "<?php echo site_url('leads/getImporterNames/2'); ?>",
								success: function(res){
									var resp = $.parseJSON(res);
									//console.log(resp);
									var html = '<div class="kt-portlet "><div class="row">';
									Object.keys(resp).forEach(function(key) {
										html += '<div class="col-md-6"><label class="imp_name" lead_id="'+resp[key][0].NEW_IMPORTER_NAME+'" style="cursor:pointer;">'+resp[key][0].NEW_IMPORTER_NAME+'</label></div>';
									});
									html += '</div><div class="row"><div class="col-md-6"><label>New Importer Name: <input class="form-control" id="new_imp_name"></div></div></div>';
									$("#popup .modal-body").html(html);
									$("#popup").modal('show');
								}
							});
						}
					});

					$("#popup").on("click", ".imp_name", function(){
						$("#new_imp_name").val($(this).html());
					});

					$("#update_imp_name").click(function(){
						if(confirm("Are you sure you want to update new Importer Name as `"+$("#new_imp_name").val()+"` ?")){
							var ids = "";
							$("#leads_table .record").each(function(){
								if($(this).is(':checked')){
									ids = ids + $(this).val() + ',';
								}
							});
							$.ajax({
								type: 'POST',
								data: {"new_imp_name": $("#new_imp_name").val(), ids: ids},
								url: "<?php echo site_url('leads/updateImporterName/2'); ?>",
								success: function(res){
									alert('Importer Name updated successfully.');
									$("#popup").modal('hide');
									$("#leads_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});
				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'hetregenous_leads_old'){ ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('leads/hetro_lead_data/'.$type); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'company_name'},
									{data: 'country'},
									{data: 'region'},
									{data: 'member_name'},
									{data: 'email'},
									{data: 'brand'},
									{data: 'type_name'},
									{data: 'stage_name'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
										//console.log(column.title());
										switch (column.title()) {
											case 'Company Name':
												input = $(`<input type="text" id="company_name" title="Search Company" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Company Name">`);
												break;

											/*case 'Country':
												input = $(`<input type="text" id="country" title="Search Country" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Country">`);
												break;
 
											case 'Region':
												input = $(`<input type="text" id="region" title="Search Region" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Region">`);
												break;*/

											case 'Country':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="country" title="Select" data-col-index="` + column.index() + `">
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $lead_country_str; ?>');
												break;

											case 'Region':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="region" title="Select" data-col-index="` + column.index() + `">
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $lead_region_str; ?>');
												break;


											case 'Person':
												input = $(`<input type="text" id="person_name" title="Search Person" data-col-index="` + column.index() + `" class="form-control" placeholder="Person Name">`);
												break;

											case 'Email':
												input = $(`<input type="text" id="email" title="Search Email" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Email">`);
												break;

											case 'Type':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_type" title="Select" data-col-index="` + column.index() + `">
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $lead_type_str; ?>');
												break;

											case 'Stage':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="` + column.index() + `">
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $lead_stage_str; ?>');
												break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<a href="<?php echo site_url('leads/addLeadDetails/'); ?>`+full.lead_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" ><i class="la la-info-circle"></i></a>`;
										},
									},
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'hetregenous_leads'){ ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var imp_id_loop = 0;
							var table = $('#leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('leads/hetro_lead_data/'.$type); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								columns: [
									{data: 'record_id'},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: 'email'},
									<?php if($type == '' || $type == 'distributors'){?>
									{data: 'brand'},
									<?php } if($this->session->userdata('role') == 1){ ?>
									{data: 'name'},
									<?php } ?>
									{data: 'comments'},
									{data: 'connect_mode'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
										//console.log(column.title());
										switch (column.title()) {
											case 'Lead Details':
												input = $(`<input type="text" id="company_name" title="Search Company" data-col-index="1" class="form-control kt-input" placeholder="Company Name"><br/>
													<select class="form-control form-control-sm form-filter kt-input" id="country" title="Select" data-col-index="2">
													<option value="">Select Country</option><?php echo $lead_country_str; ?></select>`);
												break;

											/*case 'Country':
												input = $(`<input type="text" id="country" title="Search Country" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Country">`);
												break;
 
											case 'Region':
												input = $(`<input type="text" id="region" title="Search Region" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Region">`);
												break;*/

											case 'Lead Stage':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_type" title="Lead Type" data-col-index="6">
															<option value="">Select Lead Type</option><?php echo $lead_type_str; ?></select><br/>
															<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Lead Stage" data-col-index="7">
															<option value="">Select Lead Stage</option><?php echo $lead_stage_str; ?></select>`);
												break;

											case 'Name':
												input = $(`<input type="text" id="person_name" title="Search Person" data-col-index="3" class="form-control" placeholder="Person Name">`);
												break;

											case 'Contact':
												input = $(`<input type="text" id="email" title="Search Email" data-col-index="4" class="form-control kt-input" placeholder="Email">`);
												break;

											case 'Assigned To':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="country" title="Assigned To" data-col-index="8">
													<option value="">Select</option><?php echo $user_str; ?></select>`);
												break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								createdRow: function(row, data, dataIndex){
									$('.stage_dropdown', row).select2({
										templateResult: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
										  	return $state;
										},
										templateSelection: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
											return $state;
										}
									});
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" lead_id="`+full.lead_id+`">
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('leads/addLeadDetails/'); ?>`+full.lead_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>`+connect_btn+`<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md createTask" title="Create Task" lead_id="`+full.lead_id+`">
						                        	<i class="la la-tasks"></i>
						                        </button>`;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.company_name+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.type_name+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var disabled = '';
											if(full.lead_id == null){
												disabled = 'disabled="disabled"';
											}
											var stage = '<select class="stage_dropdown" id="dropdown'+full.lead_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.lead_id+'" '+disabled+'><option value=""></option>';
											if(full.lead_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.lead_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.lead_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.lead_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.lead_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.lead_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.lead_stage == 7){
												stage += '<option value="7" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="7" id="red" disabled="disabled">Stage 0</option>';
											}
											stage += '</select>';

											return stage+` <br/><span style="font-weight: lighter;" class="last_contacted">`+full.last_contacted+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Name',
										render: function(data, type, full, meta){
											var member_name = ''; var designation = '';
											if(full.member_name != null){
												member_name = full.member_name;
											}

											if(full.designation != null){
												designation = full.designation;
											}
											return `<p> <span class="member_name">`+member_name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
										}

									},
									{
										targets: 4,
										title: 'Contact',
										render: function(data, type, full, meta){
											var email = ''; var mobile = '';
											if(full.email != null){
												email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
														</span>`;
											}

											if(full.mobile != null){
												mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
														</span>`;
											}

											return `<p>`+email+`<br/>`+mobile+`</p>`;
										}
									},
									{
										targets: 5,
										title: '',
										render: function(data, type, full, meta){
											var counts = '';
											if(full.member_count > 0 || full.non_member_count > 0){
												counts = `<span style="cursor: pointer; color: #9583ce; font-weight: bold;" lead_id="`+full.lead_id+`" member_type="mem" class="mem_count">`+full.member_count+`</span> / <span style="cursor: pointer; color: #ce8383; font-weight: bold;" lead_id="`+full.lead_id+`" member_type="nonmem" class="mem_count">`+full.non_member_count+`</span>`;
											}

											return counts;
										}
									},
									{
										targets: 7,
										orderable: false
									},
									{
										targets: 8,
										orderable: false
									},
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#leads_table").on('click', '.mem_count', function(){
						$.ajax({
							type: 'POST',
							data: {'lead_id': $(this).attr('lead_id'), 'member_type': $(this).attr('member_type')},
							url: '<?php echo site_url('leads/getHetroMembers'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var member_tbody = ''; var buyer_tbody = '';
								Object.keys(resp).forEach(function(key) {
									if(resp[key]['other_member'] == 'Y'){
										member_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}else{
										buyer_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}
								});
								$("#member-modal #buyer_table tbody").html(buyer_tbody);
								$("#member-modal #member_table tbody").html(member_tbody);
								$("#member-modal").modal('show');
							}
						});
					});

					$("#leads_table").on('click', '.lead_connect', function(){
						var member_id = $(this).attr('member_id');
						var lead_id = $(this).attr('lead_id');
						$.ajax({
							type: 'POST',
							data: {'member_id': member_id},
							url: '<?php echo site_url('leads/getConnectDetails'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var tbody = '';
								Object.keys(resp).forEach(function(key) {
									tbody += '<tr><td>'+resp[key]['connected_on']+'</td><td>'+resp[key]['connect_mode']+'</td><td>'+resp[key]['email_sent']+'</td><td>'+resp[key]['comments']+'</td></tr>';
								});
								$("#connect_table tbody").html(tbody);
								$("#member-contact-popup #member_id").val(member_id);
								$("#member-contact-popup #lead_id").val(lead_id);
								$('#member-contact-popup').modal('show');
							}	
						});
					});

					$("#primary_leads_table").on('change', '.stage_dropdown', function(){
						var stage = $(this).val();
						var lead_mst_id = $(this).attr('lead_mst_id');
						$.ajax({
							type: 'POST',
							data: {'stage': stage, 'lead_mst_id':lead_mst_id},
							url: '<?php echo site_url('leads/updatePrimaryLeadStage'); ?>',
							success: function(res){
								//$("#primary_leads_table").DataTable().ajax.reload(null, false);
							}
						});
					});

					$("#addTask").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addTask").serialize();
					        	$.ajax({
					        		type: 'POST',
					        		data: frm_data,
					        		url: '<?php echo site_url('tasks/add_task_ajax'); ?>',
					        		success: function(res){
					        			toastr.success('Task created successfully!');
					        		}
					        	});
					        	addTask.reset();
					        	$("#taskModal").modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
			        });

			        $("#deadline").datetimepicker({
			            format: "dd-mm-yyyy HH:ii P",
			            showMeridian: true,
			            todayHighlight: true,
			            autoclose: true,
			            pickerPosition: 'bottom-left'
			        });

			        $("#leads_table").on('click', '.createTask', function(){
						$("#taskModal #task_lead_id").val($(this).attr('lead_id'));
						$("#taskModal").modal('show');
					});

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'primary_leads'){ ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var imp_id_loop = 0;
							var table = $('#primary_leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('leads/primary_leads_data/'.$lead_category); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								columns: [
									{data: 'RANK'},
									{data: ''},
									{data: ''},
									{data: ''},
									<?php if($this->session->userdata('role') == 1){?>
									{data: 'IMPORTER_TOTAL', render: $.fn.dataTable.render.number( ',', '.', 2 )},
									{data: 'EXPORTER_NAME'},
									{data: 'EXPORTER_CONTRIBUTION', render: $.fn.dataTable.render.number( ',', '.', 2 )},
									{data: ''},
									<?php } ?>
									{data: 'connect_mode'},
									{data: 'comments'},
									/*{data: 'type_name'},
									{data: 'stage_name'},*/
									//{data: 'Actions', responsivePriority: -1},
								],
								rowGroup: {
						            dataSrc: 'lead_name'
						        },
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								createdRow: function(row, data, dataIndex){
									$('.stage_dropdown', row).select2({
										templateResult: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
										  	return $state;
										},
										templateSelection: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
											return $state;
										}
									});
								},
								columnDefs: [
									/*{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<a href="<?php echo site_url('leads/addPrimaryLeadDetails/'); ?>`+full.IMP_ID+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" ><i class="la la-info-circle"></i></a>`;
										},
									},*/
									{
										targets: 0,
										title: 'Rank',
										render: function(data, type, full, meta){
											return full.RANK;
										}

									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											if(full.IMP_ID == imp_id_loop){
												return '';
											}else{
												imp_id_loop = full.IMP_ID;
												var disabled = '';
												if(full.lead_mst_id == null){
													disabled = 'disabled="disabled"';
												}
												var stage = '<select class="stage_dropdown" lead_mst_id="'+full.lead_mst_id+'" '+disabled+'><option value=""></option>';
												if(full.lead_stage == 1){
													stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
												}else{
													stage += '<option value="1" id="grey">Stage 1</option>';
												}

												if(full.lead_stage == 2){
													stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
												}else{
													stage += '<option value="2" id="yellow">Stage 2</option>';
												}

												if(full.lead_stage == 3){
													stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
												}else{
													stage += '<option value="3" id="orange">Stage 3</option>';
												}

												if(full.lead_stage == 4){
													stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
												}else{
													stage += '<option value="4" id="blue">Stage 4</option>';
												}

												if(full.lead_stage == 5){
													stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
												}else{
													stage += '<option value="5" id="green">Stage 5</option>';
												}

												if(full.lead_stage == 6){
													stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
												}else{
													stage += '<option value="6" id="multi">Stage 6</option>';
												}

												if(full.lead_stage == 7){
													stage += '<option value="7" selected="selected" id="red" disabled="disabled">Stage 0</option>';
												}else{
													stage += '<option value="7" id="red" disabled="disabled">Stage 0</option>';
												}
												stage += '</select>';

												return stage+` <br/><span style="font-weight: lighter;" class="last_contacted">`+full.last_contacted+`</span>`;
											}
										}
									},
									{
										targets: 2,
										title: 'Name',
										render: function(data, type, full, meta){
											var member_name = ''; var designation = '';
											if(full.member_name != null){
												member_name = full.member_name;
											}

											if(full.designation != null){
												designation = full.designation;
											}
											return `<p> <span class="member_name">`+member_name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
										}

									},
									{
										targets: 3,
										title: 'Contact',
										render: function(data, type, full, meta){
											var email = ''; var mobile = '';
											if(full.email != null){
												email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
														<a class="copyBtnEmail small" title="" data-action="copyInfo" data-clipboard-text="`+full.email+`" data-original-title="Copy to clipboard">
															<span class="la la-copy"></span>
														</a></span>`;
											}

											if(full.mobile != null){
												mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
														<a class="copyBtnPhone small" title="" data-action="copyInfo" data-clipboard-text="`+full.mobile+`" data-original-title="Copy to clipboard">
															<span class="la la-copy"></span>
														</a></span>`;
											}
											return `<p>`+email+`<br/>`+mobile+`</p>`;
										}

									},
									<?php if($this->session->userdata('role') == 1){ ?>
									{
										targets: 4,
										className: 'text-right'
									},
									{
										targets: 6,
										className: 'text-right'
									},
									{
										targets: 7,
										title: 'Handled By',
										render: function(data, type, full, meta){
											return 'Person Name';
										}
									}
									<?php } ?>
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#primary_leads_table").on('click', '.lead_connect', function(){
						var member_id = $(this).attr('member_id');
						$.ajax({
							type: 'POST',
							data: {'member_id': member_id},
							url: '<?php echo site_url('leads/getConnectDetailsDB2'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var tbody = '';
								Object.keys(resp).forEach(function(key) {
									tbody += '<tr><td>'+resp[key]['connected_on']+'</td><td>'+resp[key]['connect_mode']+'</td><td>'+resp[key]['email_sent']+'</td><td>'+resp[key]['comments']+'</td></tr>';
								});
								$("#connect_table tbody").html(tbody);
								$("#member-contact-popup #member_id").val(member_id);
								$('#member-contact-popup').modal('show');
							}	
						});
					});

					$("#primary_leads_table").on('change', '.stage_dropdown', function(){
						var stage = $(this).val();
						var lead_mst_id = $(this).attr('lead_mst_id');
						$.ajax({
							type: 'POST',
							data: {'stage': stage, 'lead_mst_id':lead_mst_id},
							url: '<?php echo site_url('leads/updatePrimaryLeadStage'); ?>',
							success: function(res){
								//$("#primary_leads_table").DataTable().ajax.reload(null, false);
							}
						});
					});

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'primary_leads_list'){ ?>

					// Radialize the colors
					Highcharts.setOptions({
					    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
					        return {
					            radialGradient: {
					                cx: 0.5,
					                cy: 0.3,
					                r: 0.7
					            },
					            stops: [
					                [0, color],
					                [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
					            ]
					        };
					    })
					});

					// Build the chart
					Highcharts.chart('import-stats-container', {
					    chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: ''
					    },
					    tooltip: {
					        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					    },
					    accessibility: {
					        point: {
					            valueSuffix: '%'
					        }
					    },
					    plotOptions: {
					        pie: {
					            allowPointSelect: true,
					            cursor: 'pointer',
					            dataLabels: {
					                enabled: true,
					                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					                connectorColor: 'silver'
					            }
					        }
					    },
					    series: [{
					        name: 'Share',
					        data: []
					    }],
					    exporting: {
							enabled: false
						},
						credits: {
						    enabled: false
						},
					});

					<?php if($this->session->userdata('role') == 1){?>

					// Build the chart
					Highcharts.chart('export-stats-container', {
					    chart: {
					        plotBackgroundColor: null,
					        plotBorderWidth: null,
					        plotShadow: false,
					        type: 'pie'
					    },
					    title: {
					        text: ''
					    },
					    tooltip: {
					        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					    },
					    accessibility: {
					        point: {
					            valueSuffix: '%'
					        }
					    },
					    plotOptions: {
					        pie: {
					            allowPointSelect: true,
					            cursor: 'pointer',
					            dataLabels: {
					                enabled: true,
					                format: '<b>{point.name}</b>: {point.percentage:.1f} % <br/> value: {point.y}',
					                connectorColor: 'silver'
					            }
					        }
					    },
					    series: [{
					        name: 'Share',
					        data: []
					    }],
					    exporting: {
							enabled: false
						},
						credits: {
						    enabled: false
						},
					});


					Highcharts.chart('export-stats-yearly-container', {
					    chart: {
					        type: 'column'
					    },
					    title: {
					        text: 'Import History'
					    },
					    xAxis: {
					        categories: []
					    },
					    yAxis: {
					        min: 0,
					        title: {
					            text: 'Exporter wise import values'
					        },
					        stackLabels: {
					            enabled: true,
					            style: {
					                fontWeight: 'bold',
					                color: ( // theme
					                    Highcharts.defaultOptions.title.style &&
					                    Highcharts.defaultOptions.title.style.color
					                ) || 'gray'
					            }
					        }
					    },
					    legend: {
					    	enabled: false,
					        /*align: 'right',
					        x: -30,
					        verticalAlign: 'top',
					        y: 25,
					        floating: true,
					        backgroundColor:
					            Highcharts.defaultOptions.legend.backgroundColor || 'white',
					        borderColor: '#CCC',
					        borderWidth: 1,
					        shadow: false*/
					    },
					    credits: {
					    	enabled: false
					    },
					    tooltip: {
					        headerFormat: '<b>{point.x}</b><br/>',
					        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
					    },
					    plotOptions: {
					        column: {
					            stacking: 'normal',
					            dataLabels: {
					                enabled: true
					            }
					        }
					    },
					    series: []
					});

					<?php } ?>

					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var imp_id_loop = 0;
							var table = $('#primary_leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('leads/primary_list_data/'.$lead_category); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								columns: [
									{data: 'RANK'},
									{data: ''},
									{data: 'lead_stage'},
									{data: ''},
									{data: ''},
									{data: ''},
									<?php if($this->session->userdata('role') == 1){?>{data: 'assigned_to_name'},<?php } ?>
									{data: 'comments'},
									{data: 'connect_mode'},
									/*{data: 'type_name'},
									{data: 'stage_name'},*/
									{data: 'Actions', responsivePriority: -1},
								],
								/*rowGroup: {
						            dataSrc: 'lead_name'
						        },*/
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										switch (column.title()) {
											case 'Lead Details':
												input = $(`<input type="text" id="company_name" title="Search Company" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Company Name">`);
												break;

											/*case 'Contact':
												input = $(`<input type="text" id="person_name" title="Search Person" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Member Name">`);
												break;*/

											case 'Lead Stage':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_type" title="Select" data-col-index="` + column.index() + `">
															<option value="">Lead Type</option></select>`);
												$(input).append('<?php echo $lead_type_str; ?>');
												break;

											case 'Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="` + column.index() + `">
															<option value="">Lead Stage</option></select>`);
												$(input).append('<?php echo $lead_stage_str; ?>');
												break;

											case 'Contact':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="` + column.index() + `">
															<option value="">Country</option></select>`);
												$(input).append('<?php echo $lead_country; ?>');
												break;

											<?php if($this->session->userdata('role') == 1){ ?>
												case 'Assigned To':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="` + column.index() + `">
																<option value="">Sales Person</option></select>`);
													$(input).append('<?php echo $user_str; ?>');
													break;
											<?php } ?>

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								createdRow: function(row, data, dataIndex){
									$('.stage_dropdown', row).select2({
										templateResult: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
										  	return $state;
										},
										templateSelection: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "7":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
											return $state;
										}
									});
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" >
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('leads/addPrimaryLeadDetails/'); ?>`+full.imp_id+`/`+full.data_category+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>`+connect_btn+
												`<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md viewImportStats" title="View Graph">
						                        	<i class="la la-bar-chart"></i>
						                        </button>
						                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md createTask" title="Create Task" lead_id="`+full.lead_mst_id+`">
						                        	<i class="la la-tasks"></i>
						                        </button>
					                        `;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.IMPORTER_NAME+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.lead_type+`</span>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.LAST_PURCHASED+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var disabled = '';
											if(full.lead_mst_id == null){
												disabled = 'disabled="disabled"';
											}
											var stage = '<select class="stage_dropdown" id="dropdown'+full.imp_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.lead_mst_id+'" '+disabled+'><option value=""></option>';
											if(full.lead_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.lead_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.lead_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.lead_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.lead_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.lead_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.lead_stage == 7){
												stage += '<option value="7" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="7" id="red" disabled="disabled">Stage 0</option>';
											}
											stage += '</select>';

											return stage+` <br/><span style="font-weight: lighter;" class="last_contacted">`+full.last_contacted+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Name',
										render: function(data, type, full, meta){
											var member_name = ''; var designation = '';
											if(full.member_name != null){
												member_name = full.member_name;
											}

											if(full.designation != null){
												designation = full.designation;
											}
											return `<p> <span class="member_name">`+member_name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
										}

									},
									{
										targets: 4,
										title: 'Contact',
										render: function(data, type, full, meta){
											var email = ''; var mobile = '';
											if(full.email != null){
												email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
														</span>`;
											}

											if(full.mobile != null){
												mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
														</span>`;
											}

											return `<p>`+email+`<br/>`+mobile+`</p>`;
										}

									},
									{
										targets: 5,
										title: '',
										render: function(data, type, full, meta){
											var counts = '';
											if(full.member_count > 0 || full.non_member_count > 0){
												counts = `<span style="cursor: pointer; color: #9583ce; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="mem" class="mem_count">`+full.member_count+`</span> / <span style="cursor: pointer; color: #ce8383; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="nonmem" class="mem_count">`+full.non_member_count+`</span>`;
											}

											return counts;
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#lead_connect").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#lead_connect").serialize();
								$.ajax({
									type: 'post',
									data: frm_data,
									url: '<?php echo site_url('leads/addCommentsPrimary'); ?>',
									success: function(res){
										$('#member-contact-popup').modal('hide');
									}
								});
							}
							return false;
						},
						promptPosition: "inline"
					});

					$("#primary_leads_table").on('click', '.mem_count', function(){
						$.ajax({
							type: 'POST',
							data: {'lead_id': $(this).attr('lead_id'), 'member_type': $(this).attr('member_type')},
							url: '<?php echo site_url('leads/getMembers'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var member_tbody = ''; var buyer_tbody = '';
								Object.keys(resp).forEach(function(key) {
									if(resp[key]['other_member'] == 'Y'){
										member_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}else{
										buyer_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}
								});
								$("#member-modal #buyer_table tbody").html(buyer_tbody);
								$("#member-modal #member_table tbody").html(member_tbody);
								$("#member-modal").modal('show');
							}
						});
					});

					$("#primary_leads_table").on('click', '.createTask', function(){
						$("#taskModal #task_lead_id").val($(this).attr('lead_id'));
						$("#taskModal").modal('show');
					});

					$("#primary_leads_table").on('click', '.lead_connect', function(){
						var member_id = $(this).attr('member_id');
						$.ajax({
							type: 'POST',
							data: {'member_id': member_id},
							url: '<?php echo site_url('leads/getConnectDetailsDB2'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var tbody = '';
								Object.keys(resp).forEach(function(key) {
									tbody += '<tr><td>'+resp[key]['member_name']+'</td><td>'+resp[key]['connected_on']+'</td><td>'+resp[key]['connect_mode']+'</td><td>'+resp[key]['email_sent']+'</td><td>'+resp[key]['comments']+'</td></tr>';
								});
								$("#connect_table tbody").html(tbody);
								$("#member-contact-popup #member_id").val(member_id);
								$('#member-contact-popup').modal('show');
							}	
						});
					});

					$("#primary_leads_table").on('change', '.stage_dropdown', function(){
						var stage = $(this).val();
						var lead_mst_id = $(this).attr('lead_mst_id');
						$.ajax({
							type: 'POST',
							data: {'stage': stage, 'lead_mst_id':lead_mst_id},
							url: '<?php echo site_url('leads/updatePrimaryLeadStage'); ?>',
							success: function(res){
								//$("#primary_leads_table").DataTable().ajax.reload(null, false);
							}
						});
					});

					$('[data-toggle="tooltip"]').tooltip();

					$("#primary_leads_table").on('click', '.viewImportStats', function(){
						var table = $("#primary_leads_table").DataTable();
						var tableData = table.row( $(this).parents('tr') ).data();
						var graph_data = [];
						Object.keys(tableData.hs_graph).forEach(function(key) {
							graph_data.push(tableData.hs_graph[key]);
						});
						var chart1 = $('#import-stats-container').highcharts();
						chart1.series[0].update({
							data: graph_data
						}, false);

						chart1.title.update({
							text: 'Item to pitch to client'
						}, false);
						chart1.redraw();

						if ('export_data' in tableData){
							var graph_data = [];
							var export_sum = 0;
							Object.keys(tableData.export_data).forEach(function(key) {
								graph_data.push(tableData.export_data[key]);
								export_sum += parseFloat(tableData.export_data[key].y);
							});

							export_sum = new Intl.NumberFormat('en-IN').format(export_sum);

							var chart2 = $('#export-stats-container').highcharts();
							chart2.series[0].update({
								data: graph_data
							}, false);

							chart2.title.update({
								text: 'Exporters Contributions - '+export_sum
							}, false);
							chart2.redraw();
						}

						$.ajax({
							type: 'POST',
							data: {'imp_name': tableData.IMPORTER_NAME, category: '<?php echo $lead_category; ?>'},
							url: '<?php echo site_url('leads/getYearWiseImport'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var chart3 = $('#export-stats-yearly-container').highcharts();
								//console.log(chart3.series);
								for (var i = 0; i < chart3.series.length; i++) {
							        chart3.series[i].remove();
							    }
							    
								Object.keys(resp[1]).forEach(function(key) {
									chart3.addSeries({                        
									    name: resp[1][key].name,
									    data: resp[1][key].data,
									});
								});

								chart3.xAxis[0].update({
									categories: resp[0]
								}, false);
								chart3.redraw();
							}
						})

						$("#stats-modal").modal('show');
					});

					$("#addTask").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addTask").serialize();
					        	$.ajax({
					        		type: 'POST',
					        		data: frm_data,
					        		url: '<?php echo site_url('tasks/add_task_ajax'); ?>',
					        		success: function(res){
					        			toastr.success('Task created successfully!');
					        		}
					        	});
					        	addTask.reset();
					        	$("#taskModal").modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
			        });

			        $("#deadline").datetimepicker({
			            format: "dd-mm-yyyy HH:ii P",
			            showMeridian: true,
			            todayHighlight: true,
			            autoclose: true,
			            pickerPosition: 'bottom-left'
			        });

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'fuzzy_imp_list'){ ?>

					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#leads_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('leads/fuzzy_imp_list_data'); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'],
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'NEW_IMPORTER_NAME'},
									{data: 'FOB_VALUE_INR'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;
										//console.log(column.title());
										switch (column.title()) {
											case 'New Importer Name':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="lead_nimporter_name" title="Select" data-col-index="` + column.index() + `" multiple>
															<option value="">Select</option></select>`);
												$(input).append('<?php echo $new_importer_name; ?>');
												break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									 var hideSearchColumnResponsive = function () {
					           thisTable.api().columns().every(function () {
						           var column = this
						           if(column.responsiveHidden()) {
							           $(rowFilter).find('th').eq(column.index()).show();
						           } else {
							           $(rowFilter).find('th').eq(column.index()).hide();
						           }
					           })
					         };

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<input type="checkbox" class="record" value="`+full.NEW_IMPORTER_NAME+`" title="Select to Merge">`;
										},
									},
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#merge_records").click(function(){
						var ids = '';
						$("#leads_table .record").each(function(){
							if($(this).is(':checked')){
								ids = ids + $(this).val() + ',';
							}
						});
						if(ids != ''){
							$.ajax({
								type: 'POST',
								data: {"record_ids": ids},
								url: "<?php echo site_url('leads/getImporterNames/3'); ?>",
								success: function(res){
									var resp = $.parseJSON(res);
									//console.log(resp);
									var html = '<div class="kt-portlet "><div class="row">';
									Object.keys(resp).forEach(function(key) {
										html += '<div class="col-md-6"><label class="imp_name" lead_id="'+resp[key].NEW_IMPORTER_NAME+'" style="cursor:pointer;">'+resp[key].NEW_IMPORTER_NAME+'</label></div>';
									});
									html += '</div><div class="row"><div class="col-md-6"><label>New Importer Name: <input class="form-control" id="new_imp_name"></div></div></div>';
									$("#popup .modal-body").html(html);
									$("#popup").modal('show');
								}
							});
						}
					});

					$("#popup").on("click", ".imp_name", function(){
						$("#new_imp_name").val($(this).html());
					});

					$("#update_imp_name").click(function(){
						if(confirm("Are you sure you want to update new Importer Name as `"+$("#new_imp_name").val()+"` ?")){
							var ids = "";
							$(".imp_name").each(function(){
								ids += $(this).attr('lead_id')+',';
							});
							$.ajax({
								type: 'POST',
								data: {"new_imp_name": $("#new_imp_name").val(), ids: ids},
								url: "<?php echo site_url('leads/updateImporterName/3'); ?>",
								success: function(res){
									alert('Importer Name updated successfully.');
									$("#popup").modal('hide');
									$("#leads_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});
				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'addLeadDetails'){ ?>
					$("#lead_country").change(function(){
						$("#lead_region").val($("#lead_country option:selected").attr('region'));
					});

					$("#lead_type").change(function(){
						var selected = $("#lead_type option:selected").val();
						if(selected == 3){
							$("#lead_industry").removeAttr('disabled');	
						}else{
							$("#lead_industry").attr('disabled', 'disabled');
						}
						/*$("#lead_industry option").each(function(){
							if($(this).attr('type_id') == selected){
								$(this).show();
							}else{
								$(this).hide();
							}
						});*/
					});

					$("#lead_stage").change(function(){
						var selected = $("#lead_stage option:selected").val();
						if(selected == 7){
							$("#stage_reason").removeAttr('disabled');	
						}else{
							$("#stage_reason").attr('disabled', 'disabled');
						}
						/*$("#stage_reason option").each(function(){
							if($(this).attr('stage_id') == selected){
								$(this).show();
							}else{
								$(this).hide();
							}
						});*/
					});

					$("#lead_type, #lead_stage").trigger('change');

					$("#lead_add_member").click(function(){
						var i=1;
						if($("#lead_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_member_grid tbody tr").length)+1;
						}
						$("#lead_member_grid tbody").append('<tr><td><input class="form-control validate[required]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[required]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td><select name="main_buyer[]" class="form-control validate[required]"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value=""><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});

					$("#lead_add_non_member").click(function(){
						var i=1;
						if($("#lead_non_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_non_member_grid tbody tr").length)+1;
						}
						$("#lead_non_member_grid tbody").append('<tr><td><input class="form-control validate[required]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[required]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value="Y"><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});

					$(".lead_connect").click(function(){
						var member_id = $(this).siblings('.member_id').val();
						$("#connect_table tbody tr").each(function(){
							if($(this).attr('member_id') == member_id){
								$(this).show();
							}else{
								$(this).hide();
							}
						});
						$("#member-contact-popup #member_id").val(member_id);
						$("#taskModal #task_member_id").val(member_id);
						$('#member-contact-popup').modal('show');
					});

					$("#lead_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$("#lead_non_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$(".lead_delBtn").click(function(){
						if(confirm('Are you sure?')){
							var member_id = $(this).siblings('.member_id').val();
							$.ajax({
								type: 'POST',
								url: '<?php echo site_url('leads/deleteMember'); ?>',
								data: {'member_id': member_id},
								success: function(res){
									location.reload();
								}
							});
						}
					});

					$("#lead_connect, #addLead").validationEngine({
						promptPosition: "inline"
					});

					$("#deadline").datetimepicker({
			            format: "dd-mm-yyyy HH:ii P",
			            showMeridian: true,
			            todayHighlight: true,
			            autoclose: true,
			            pickerPosition: 'bottom-left'
			        });

			        $("#addTask").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addTask").serialize();
					        	$.ajax({
					        		type: 'POST',
					        		data: frm_data,
					        		url: '<?php echo site_url('tasks/add_task_ajax'); ?>',
					        		success: function(res){
					        			toastr.success('Task created successfully!');
					        		}
					        	});
					        	addTask.reset();
					        	$("#taskModal").modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
			        });

				<?php } else if($this->router->fetch_class() == 'leads' && $this->router->fetch_method() == 'addPrimaryLeadDetails'){ ?>
					$("#lead_country").change(function(){
						$("#lead_region").val($("#lead_country option:selected").attr('region'));
					});

					$("#lead_type").change(function(){
						var selected = $("#lead_type option:selected").val();
						if(selected == 3){
							$("#lead_industry").removeAttr('disabled');	
						}else{
							$("#lead_industry").attr('disabled', 'disabled');
						}
						/*$("#lead_industry option").each(function(){
							if($(this).attr('type_id') == selected){
								$(this).show();
							}else{
								$(this).hide();
							}
						});*/
					});

					$("#lead_stage").change(function(){
						var selected = $("#lead_stage option:selected").val();
						if(selected == 7){
							$("#stage_reason").removeAttr('disabled');	
						}else{
							$("#stage_reason").attr('disabled', 'disabled');
						}
						/*$("#stage_reason option").each(function(){
							if($(this).attr('stage_id') == selected){
								$(this).show();
							}else{
								$(this).hide();
							}
						});*/
					});

					$("#lead_type, #lead_stage").trigger('change');

					$("#lead_add_member").click(function(){
						var i=1;
						if($("#lead_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_member_grid tbody tr").length)+1;
						}
						$("#lead_member_grid tbody").append('<tr><td><input class="form-control validate[required]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[required]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td><select name="main_buyer[]" class="form-control validate[required]"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value="" class="member_id"><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});

					$("#lead_add_non_member").click(function(){
						var i=1;
						if($("#lead_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_member_grid tbody tr").length)+1;
						}
						$("#lead_non_member_grid tbody").append('<tr><td><input class="form-control validate[required]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[required]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value="Y"><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});

					$(".lead_connect").click(function(){
						var member_id = $(this).siblings('.member_id').val();
						$("#connect_table tbody tr").each(function(){
							if($(this).attr('member_id') == member_id){
								$(this).show();
							}else{
								$(this).hide();
							}
						});
						$("#member-contact-popup #member_id").val(member_id);
						$("#taskModal #task_member_id").val(member_id);
						$('#member-contact-popup').modal('show');
					});

					$("#lead_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$("#lead_non_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$(".lead_delBtn").click(function(){
						if(confirm('Are you sure?')){
							var member_id = $(this).siblings('.member_id').val();
							$.ajax({
								type: 'POST',
								url: '<?php echo site_url('leads/deleteMemberDB2'); ?>',
								data: {'member_id': member_id},
								success: function(res){
									location.reload();
								}
							});
						}
					});

					$("#lead_connect, #addLead").validationEngine({
						promptPosition: "inline"
					});

					$("#deadline").datetimepicker({
			            format: "dd-mm-yyyy HH:ii P",
			            showMeridian: true,
			            todayHighlight: true,
			            autoclose: true,
			            pickerPosition: 'bottom-left'
			        });

			        $("#addTask").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addTask").serialize();
					        	$.ajax({
					        		type: 'POST',
					        		data: frm_data,
					        		url: '<?php echo site_url('tasks/add_task_ajax'); ?>',
					        		success: function(res){
					        			toastr.success('Task created successfully!');
					        		}
					        	});
					        	addTask.reset();
					        	$("#taskModal").modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
			        });

				<?php } else if($this->router->fetch_class() == 'client'){ ?>

					$("#country").change(function(){
						$("#region").val($("#country option:selected").attr('region'));
					});

					$("#add_member").click(function(){
						var i=1;
						if($("#member_grid tbody tr").length > 0){
							i = parseInt($("#member_grid tbody tr").length)+1;
						}
						$("#member_grid tbody").append('<tr><td><input class="form-control" type="text" name="name[]"></td><td><input class="form-control" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select class="form-control"><option value="Y">Yes</option><option value="N">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td><button type="button" class="btn btn-danger btn-sm delBtn">Remove</button></td></tr>');
					});

					$("#member_grid tbody").on("click", ".delBtn", function(){
						$(this).closest('tr').remove();
					});

					$("#member_grid tbody").on("click", ".removeBtn", function(){
						if(confirm('Are you sure?') == true){
							var member_id = $(this).siblings('.member_id').val();
							$.ajax({
								type: 'POST',
								data: {'member_id': member_id},
								url: '<?php echo site_url('client/deleteMember/'); ?>',
								success: function(res){
									$("#member_grid").DataTable().ajax.reload(null, false);
								}
							});
						}
					});

				<?php if($this->router->fetch_method() == 'client_list'){ ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#client_table');

							// begin first table
							table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: '<?php echo site_url('client/client_data'); ?>',
								columns: [
									{data: 'record_id'},
									{data: 'company_name'},
									{data: 'country'},
									{data: 'region'},
									{data: 'name'},
									{data: 'telephone'},
									{data: 'email'},
									{data: 'mobile'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<a href="<?php echo site_url('client/addClients/'); ?>`+full.client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
					                            <i class="la la-edit"></i>
					                        </a>
					                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md deleteClient" title="Delete" client_id="`+full.client_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>`;
										},
									},
									{
										targets: 0,
										orderable: false
									},
									{
										targets: 1,

									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					jQuery("#client_table").on('click', '.deleteClient', function(){
						if(confirm('Are you sure?') == true){
							jQuery.ajax({
								type: 'POST',
								data: {'client_id': jQuery(this).attr('client_id')},
								url: '<?php echo site_url('client/deleteClient/'); ?>',
								success: function(res){
									location.reload();
								}
							});
						}
					});
				<?php } else if($this->router->fetch_method() == 'member_list'){ ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#member_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: '<?php echo site_url('client/member_data'); ?>',
								columns: [
									{data: 'record_id'},
									{data: 'client_name'},
									{data: 'name'},
									{data: 'email'},
									{data: 'mobile'},
									{data: 'is_whatsapp'},
									{data: 'telephone'},
									{data: 'skype'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `
					                        <a href="<?php echo site_url('client/addClients/'); ?>`+full.client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
					                            <i class="la la-edit"></i>
					                        </a>
					                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md deleteMember" title="Delete" member_id="`+full.member_id+`">
					                        	<i class="la la-trash"></i>
					                        </button>`;
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					jQuery("#member_table").on('click', '.deleteMember', function(){
						if(confirm('Are you sure?') == true){
							jQuery.ajax({
								type: 'POST',
								data: {'member_id': jQuery(this).attr('member_id')},
								url: '<?php echo site_url('client/deleteMember/'); ?>',
								success: function(res){
									location.reload();
								}
							});
						}
					});
				<?php } else if($this->router->fetch_method() == 'touchpoint_list'){ ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#points_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('client/touchpoint_list_data'); ?>',
									data: function(data){
										var sales_person = $("#sales_person").val();
										data.searchBySalesPerson = sales_person;
									} 
								},
								columns: [
									{data: 'record_id'},
									{data: 'username'},
									{data: 'client_name'},
									{data: 'member_name'},
									{data: 'contact_mode'},
									{data: 'email_sent'},
									{data: 'comments'},
									{data: 'contacted_on'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `
					                        <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md viewPerformance" title="View Graph" user_id="`+full.user_id+`" username="`+full.username+`">
					                        	<i class="la la-bar-chart"></i>
					                        </button>`;
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$('#tp-performance-container').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Touch Points for last 30 Days'
						},
						xAxis: {
						  	categories: [],
						  	title: {
						  		text: 'Date'
						  	}
						},
						yAxis: {
							title: {
								text: 'No. of Touch Points'
							}
						},
						plotOptions: {
							line: {
								dataLabels: {
							    	enabled: true
								},
								enableMouseTracking: false
							},
							column: {
						        zones: [{
						            value: 1, // Values up to 10 (not including) ...
						            color: 'red' // ... have the color blue.
						        }]
						    },
						    series: {
						    	cursor: 'pointer',
						    	point: {
						    		events: {
						    			click: function(e){
						    				//this.series.options.reasonText[this.category]);
						    				hs.htmlExpand(null, {
					                            pageOrigin: {
					                                x: e.pageX || e.clientX,
					                                y: e.pageY || e.clientY
					                            },
					                            headingText: this.series.name,
					                            maincontentText: this.category+' - '+this.series.options.reasonText[this.category],
					                            width: 300
					                        });
						    			}
						    		}
						    	}
						    }
						},
						credits: {
						    enabled: false
						},
						series: [{
							showInLegend: false,
							name: 'Touchpoints Report',
						  	data: [],
						  	reasonText: []
						}]
					});

					var user_id = 0;
					var username = '';
					jQuery("#points_table").on('click', '.viewPerformance', function(){
						username = $(this).attr('username');
						user_id = $(this).attr('user_id');
						$.ajax({
							type: 'POST',
							data: {'user_id': $(this).attr('user_id')},
							url: '<?php echo site_url('client/getTPPerformance'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								qc_monthly_data = resp.monthly_count;
								var counts = resp.counts;

								$("#tp_performance #user_monthly_avg").html(counts.user_monthly_avg);
								$("#tp_performance #user_total_avg").html(counts.user_total_avg);
								$("#tp_performance #user_monthly_connects").html(counts.user_monthly_connects);
								$("#tp_performance #user_total_connects").html(counts.user_total_connects);
								$("#tp_performance #team_monthly_avg").html(counts.team_monthly_avg);
								$("#tp_performance #team_total_avg").html(counts.team_total_avg);
								/*$("#tp_performance #team_monthly_connects").html(counts.team_monthly_connects);*/

								var graph_data = [];
								var graph_key = [];
								var reason_obj = [];
								Object.keys(qc_monthly_data).forEach(function(key){
									var inner_key = qc_monthly_data[key].key;
									var inner_value = qc_monthly_data[key].value;
									var inner_reason = qc_monthly_data[key].reason;
									/*var inner_data = [];
									inner_data['"'+inner_key+'"'] = inner_value;*/
									graph_data.push(parseFloat(inner_value));
									graph_key.push(inner_key);
									if(inner_value == 0.5){
										reason_obj[inner_key] = inner_reason;
									}
								});
								var chart1 = $('#tp-performance-container').highcharts();
								chart1.series[0].update({
									data: graph_data,
									reasonText: reason_obj
								}, false);

								chart1.xAxis[0].update({
									categories: graph_key
								}, false);

								chart1.title.update({
									text: 'Touch Points for last 30 Days - '+username
								}, false);

								chart1.redraw();
								$("#tp_performance").modal('show');
							}
						});
					});


					$("#tp_updateChart").click(function(){
						var start_date = $("#tp_start_date").val();
						$.ajax({
							type: "POST",
							data: {'user_id': user_id, 'start_date': start_date},
							url: '<?php echo site_url('client/getTPPerformance'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								qc_monthly_data = resp.monthly_count;
								var graph_data = [];
								var graph_key = [];
								var reason_obj = [];
								Object.keys(qc_monthly_data).forEach(function(key){
									var inner_key = qc_monthly_data[key].key;
									var inner_value = qc_monthly_data[key].value;
									var inner_reason = qc_monthly_data[key].reason;
									/*var inner_data = [];
									inner_data['"'+inner_key+'"'] = inner_value;*/
									graph_data.push(parseFloat(inner_value));
									graph_key.push(inner_key);
									if(inner_value == 0.5){
										reason_obj[inner_key] = inner_reason;
									}
								});
								var chart1 = $('#tp-performance-container').highcharts();
								chart1.series[0].update({
									data: graph_data,
									reasonText: reason_obj
								}, false);

								chart1.xAxis[0].update({
									categories: graph_key
								}, false);

								chart1.title.update({
									text: 'Touch Points for last 30 Days - '+username
								}, false);

								chart1.redraw();
							}
						});
					});

					$("#sales_person").change(function(){
						var val = $(this).val();
						var dataTable = $('#points_table').DataTable();
						dataTable.draw();
					});
				<?php }
				} ?>

				<?php if($this->router->fetch_class() == 'reports' && $this->router->fetch_method() == 'daily_task_list') { ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#points_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('reports/daily_task_list_data'); ?>',
									data: function(data){
										var sales_person = $("#sales_person").val();
										data.searchBySalesPerson = sales_person;
									} 
								},
								columns: [
									{data: 'record_id'},
									{data: 'date'},
									{data: 'name'},
									{data: 'task_accomplished'},
									{data: 'work_in_progress'},
									{data: 'plan_for_tomorrow'},
									{data: 'touch_points'},
									{data: 'desktopTime'},
									{data: 'IdleTime'},
									{data: 'productivetime'},
									{data: 'productivity_percentage'},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `-`;
										},
									},
									{
										targets: 6,
										title: 'Touch Points',
										render: function(data, type, full, meta){
											var tp = full.touch_points;
											var wa = 0; var call = 0; var li = 0;
											Object.keys(tp).forEach(function(key){
												if(tp[key].contact_mode == 'whatsapp'){
													wa = tp[key].count;
												} else if(tp[key].contact_mode == 'call'){
													call = tp[key].count;
												} else if(tp[key].contact_mode == 'linkedin'){
													li = tp[key].count;
												}
											});
											return `<span><i class="la la-phone"></i> - `+call+`</span> <br/> <span><i class="la la-whatsapp"></i> - `+wa+`</span> <br/> <span><i class="la la-linkedin"></i> - `+li+`</span>`;
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$("#sales_person").change(function(){
						var val = $(this).val();
						var dataTable = $('#points_table').DataTable();
						dataTable.draw();
					});
				<?php } ?>

				<?php if($this->router->fetch_class() == 'home' && $this->router->fetch_method() == 'calendar') { ?>
					"use strict";

					var KTCalendarBackgroundEvents = function() {

					    return {
					        //main function to initiate the module
					        init: function() {
					            var todayDate = moment().startOf('day');
					            var YM = todayDate.format('YYYY-MM');
					            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
					            var TODAY = todayDate.format('YYYY-MM-DD');
					            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

					            var calendarEl = document.getElementById('kt_calendar');
					            var calendar = new FullCalendar.Calendar(calendarEl, {
					                plugins: [ 'interaction', 'dayGrid', 'list' ],

					                isRTL: KTUtil.isRTL(),
					                header: {
					                    left: 'prev,next today',
					                    center: 'title',
					                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
					                },

					                height: 800,
					                contentHeight: 780,
					                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

					                nowIndicator: true,
					                now: TODAY + 'T09:25:00', // just for demo

					                views: {
					                    dayGridMonth: { buttonText: 'month' },
					                    timeGridWeek: { buttonText: 'week' },
					                    timeGridDay: { buttonText: 'day' }
					                },

					                defaultView: 'dayGridMonth',
					                defaultDate: TODAY,

					                editable: true,
					                eventLimit: true, // allow "more" link when too many events
					                navLinks: true,
					                businessHours: true, // display business hours
					                events: [
					                    {
					                        title: 'Lunch',
					                        start: TODAY + 'T02:00:00',
					                        className: "fc-event-info",
					                        description: '1.Working on Caspian Data -Mailing. 2.Co-ordination with Nilesh 3.CRM TP updted Excel and System. 4.Co-ordination with OM for new follow up draft. 5. Preparation of new follow up draft 6.Co-ordination with RUpeshri and yash for publishing the quotations. 7.Submission of orbit star quotation.'
					                    },
					                    {
					                        title: 'Munch',
					                        start: TODAY + 'T08:00:00',
					                        className: "fc-event-info",
					                        description: '1.Working on Caspian Data -Mailing. 2.Co-ordination with Nilesh 3.CRM TP updted Excel and System. 4.Co-ordination with OM for new follow up draft. 5. Preparation of new follow up draft 6.Co-ordination with RUpeshri and yash for publishing the quotations. 7.Submission of orbit star quotation.'
					                    },
					                    {
					                        title: 'Crunch',
					                        start: TODAY + 'T14:00:00',
					                        className: "fc-event-info",
					                        description: '1.Working on Caspian Data -Mailing. 2.Co-ordination with Nilesh 3.CRM TP updted Excel and System. 4.Co-ordination with OM for new follow up draft. 5. Preparation of new follow up draft 6.Co-ordination with RUpeshri and yash for publishing the quotations. 7.Submission of orbit star quotation.'
					                    }


					                ],

					                eventRender: function(info) {
					                    var element = $(info.el);

					                    if (info.event.extendedProps && info.event.extendedProps.description) {
					                        if (element.hasClass('fc-day-grid-event')) {
					                            element.data('content', info.event.extendedProps.description);
					                            element.data('placement', 'top');
					                            KTApp.initPopover(element);
					                        } else if (element.hasClass('fc-time-grid-event')) {
					                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>'); 
					                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
					                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>'); 
					                        }
					                    } 
					                }
					            });

					            calendar.render();
					        }
					    };
					}();

					jQuery(document).ready(function() {
					    KTCalendarBackgroundEvents.init();
					});
				<?php } if($this->router->fetch_class() == 'pq' && $this->router->fetch_method() == 'add') { ?>

					$("#addPQClient #client_status").change(function(){
						if($(this).val() == 'approved'){
							$(".approved_fields").show();
						}else{
							$(".approved_fields").hide();
						}
					});

					$("#addPQClient").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								$("#addPQClient").submit();
							}else{
								return false;
							}
						},
						promptPosition: "inline"
					});

					$("#lead_add_member").click(function(){
						var i=1;
						if($("#lead_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_member_grid tbody tr").length)+1;
						}
						$("#lead_member_grid tbody").append('<tr><td><input class="form-control validate[]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td><select name="main_buyer[]" class="form-control validate[]"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value=""><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});

					$("#lead_add_non_member").click(function(){
						var i=1;
						if($("#lead_member_grid tbody tr").length > 0){
							i = parseInt($("#lead_member_grid tbody tr").length)+1;
						}
						$("#lead_non_member_grid tbody").append('<tr><td><input class="form-control validate[]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td>-</td><td>-</td><td><input type="hidden" name="other_member[]" value="Y"><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_removeBtn" title="Delete"><i class="la la-trash"></i></button></td></tr>');
					});
					
					$("#lead_non_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$("#lead_member_grid").on('click', '.lead_removeBtn', function(){
						$(this).closest('tr').remove();
					});

					$(".lead_delBtn").click(function(){
						if(confirm('Are you sure?')){
							var member_id = $(this).siblings('.member_id').val();
							$.ajax({
								type: 'POST',
								url: '<?php echo site_url('pq/deleteMember'); ?>',
								data: {'member_id': member_id},
								success: function(res){
									location.reload();
								}
							});
						}
					});

					$(".lead_connect").click(function(){
						var member_id = $(this).siblings('.member_id').val();
						$("#connect_table tbody tr").each(function(){
							if($(this).attr('member_id') == member_id){
								$(this).show();
							}else{
								$(this).hide();
							}
						});
						$("#member-contact-popup #member_id").val(member_id);
						$('#member-contact-popup').modal('show');
					});

					var prop_img_dzone = new Dropzone('#upload_document', {
			            url: "<?php echo site_url('pq/uploadDocument'); ?>", // Set the url for your upload script location
			            paramName: "file", // The name that will be used to transfer the file
			            params: {'pq_client_id': '<?php if(isset($client_details)){echo $client_details[0]['pq_client_id'];} ?>'},
			            maxFiles: 1,
			            maxFilesize: 5, // MB
			            addRemoveLinks: true,
			            acceptedFiles: ".pdf,image/*",
			        });

			        prop_img_dzone.on("success", function(file, response) {
			            let res = JSON.parse(response);
			            if(res.status == 'success'){
			            	$(file.previewElement).addClass("dz-success").find('.dz-success-message').text(res.msg);
			            }else{
			            	$(file.previewElement).addClass("dz-error").find('.dz-error-message').text(res.msg);
			            }
			        });

			        prop_img_dzone.on("removedfile", function(file) {
						$.ajax({
							url: "<?php echo site_url('pq/deleteDocument'); ?>",
							type: "POST",
							data: {"pq_client_id":"<?php if(isset($client_details)){echo $client_details[0]['pq_client_id'];} ?>"},
						});
					});

				<?php } if($this->router->fetch_class() == 'pq' && $this->router->fetch_method() == 'pending_list') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var imp_id_loop = 0;
							var table = $('#pq_client_list').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('pq/pending_list_data/'); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								/*columns: [
									{data: 'record_id'},
									{data: ''},
									{data: 'lead_stage'},
									{data: ''},
									{data: ''},
									<?php if($this->session->userdata('role') == 1){?>{data: 'name'},<?php } ?>
									{data: ''},
									{data: 'id_password'},
									{data: 'comments'},
									{data: 'connect_mode'},
									{data: 'Actions', responsivePriority: -1},
								],*/
								columns: [
									{data: 'record_id'},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: 'Actions', responsivePriority: -1},
								],
								/*rowGroup: {
						            dataSrc: 'lead_name'
						        },*/
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										switch (column.title()) {
											case 'Lead Details':
												input = $(`<input type="text" id="company_name" title="Search Company" data-col-index="1" class="form-control kt-input" placeholder="Company Name"><br/>
													<select class="form-control form-control-sm form-filter kt-input" id="country" title="Select" data-col-index="2">
													<option value="">Country</option><?php echo $lead_country; ?></select><br/>
													<select class="form-control form-control-sm form-filter kt-input" id="region" title="Select" data-col-index="3">
													<option value="">Region</option><?php echo $lead_region; ?></select>`);
												break;

											/*case 'Contact':
												input = $(`<input type="text" id="person_name" title="Search Person" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Member Name">`);
												break;*/

											case 'Lead Stage':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="client_stage" title="Select" data-col-index="4">
												<option value="">Client Stage</option><?php echo $lead_stage_str; ?></select><br/>
												<select class="form-control form-control-sm form-filter kt-input" id="client_category" title="Select" data-col-index="5">
												<option value="">Client Category</option><?php echo $lead_type_str; ?></select><br/>
												<select class="form-control form-control-sm form-filter kt-input" id="reg_method" title="Select" data-col-index="6"><option value="">Registration Method</option>
												<option value="online">Online</option><option value="offline">Offline</option>
												</select>`);
												break;

											/*case 'Name':
												input = $(`<input type="text" id="company_name" title="Search Member" data-col-index="7" class="form-control kt-input" placeholder="Member Name"><br/>`);
												$(input).append('<?php echo $lead_stage_str; ?>');
												break;*/

											case 'Contact':
												input = $(``);
												$(input).append('');
												break;

											case 'Lead Team':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="0">
																<option value="">Sales Person</option></select>`);
													$(input).append('<?php echo $user_str; ?>');
													break;

											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								createdRow: function(row, data, dataIndex){
									$('.stage_dropdown', row).select2({
										templateResult: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background-color: purple';
													break;

												case "7":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "8":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
										  	return $state;
										},
										templateSelection: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background-color: purple';
													break;

												case "7":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "8":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
											return $state;
										}
									});
								},
								/*columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" >
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('pq/add/'); ?>`+full.pq_client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>`+connect_btn+
												``;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.company_name+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.type_name+`</span>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.priority+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var stage = '<select class="stage_dropdown" id="dropdown'+full.pq_client_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.pq_client_id+'"><option value=""></option>';
											if(full.client_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.client_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.client_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.client_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.client_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.client_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.client_stage == 7){
												stage += '<option value="7" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="7" id="red" disabled="disabled">Stage 0</option>';
											}

											if(full.client_stage == 8){
												stage += '<option value="8" selected="selected" id="purple">Stage 7</option>';
											}else{
												stage += '<option value="8" id="purple">Stage 7</option>';
											}

											if(full.client_stage == 9){
												stage += '<option value="9" selected="selected" id="indigo">Stage 8</option>';
											}else{
												stage += '<option value="9" id="indigo">Stage 8</option>';
											}
											stage += '</select>';

											return stage+` <br/><span style="font-weight: lighter;" class="last_contacted">`+full.last_contacted+`</span> <span style="font-weight: lighter;" class="last_contacted">`+full.registration_method+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Name',
										render: function(data, type, full, meta){
											var member_name = ''; var designation = '';
											if(full.member_name != null){
												member_name = full.member_name;
											}

											if(full.designation != null){
												designation = full.designation;
											}
											return `<p> <span class="member_name">`+member_name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
										}

									},
									{
										targets: 4,
										title: 'Contact',
										render: function(data, type, full, meta){
											var email = ''; var mobile = '';
											if(full.email != null){
												email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
														</span>`;
											}

											if(full.mobile != null){
												mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
														</span>`;
											}

											return `<p>`+email+`<br/>`+mobile+`</p>`;
										}

									},
									{
										targets: 6,
										title: '',
										render: function(data, type, full, meta){
											var counts = '';
											if(full.member_count > 0 || full.non_member_count > 0){
												counts = `<span style="cursor: pointer; color: #9583ce; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="mem" class="mem_count">`+full.member_count+`</span> / <span style="cursor: pointer; color: #ce8383; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="nonmem" class="mem_count">`+full.non_member_count+`</span>`;
											}

											return counts;
										}
									}
								],*/
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" >
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('pq/add/'); ?>`+full.pq_client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>
												<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_activity pull-right" title="Contact" client_id="`+full.pq_client_id+`" >
													<i class="la la-list-alt"></i>
												</button>`;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.company_name+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.region+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var stage = '<select class="stage_dropdown" id="dropdown'+full.pq_client_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.pq_client_id+'"><option value=""></option>';
											if(full.client_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.client_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.client_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.client_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.client_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.client_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.client_stage == 7){
												stage += '<option value="7" selected="selected" id="purple" >Stage 7</option>';
											}else{
												stage += '<option value="7" id="purple">Stage 7</option>';
											}

											if(full.client_stage == 8){
												stage += '<option value="8" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="8" id="red" disabled="disabled">Stage 0</option>';
											}
											stage += '</select>';

											return stage+` <span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.type_name+`</span> <br/> <span style="font-weight: lighter;" class="last_contacted">`+full.registration_method+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Lead Team',
										render: function(data, type, full, meta){
											return full.name+`<br/><span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.priority+`</span>`;
										}
									},
									{
										targets: 4,
										title: 'ID & Password',
										render: function(data, type, full, meta){
											return full.id_password;
										}
									},
									{
										targets: 5,
										title: 'Vendor Code / Website',
										render: function(data, type, full, meta){
											var website = '';
											if(full.website != null){
												website = `<a href="`+full.website+`" target="_blank">`+full.website+`</a>`;
											}
											return website+`<br/>`+full.vendor_id;
										}
									}
								]
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#pq_client_list").on('click', '.mem_count', function(){
						$.ajax({
							type: 'POST',
							data: {'lead_id': $(this).attr('lead_id'), 'member_type': $(this).attr('member_type')},
							url: '<?php echo site_url('pq/getPQMembers'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var member_tbody = ''; var buyer_tbody = '';
								Object.keys(resp).forEach(function(key) {
									if(resp[key]['other_member'] == 'Y'){
										member_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}else{
										buyer_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}
								});
								$("#member-modal #buyer_table tbody").html(buyer_tbody);
								$("#member-modal #member_table tbody").html(member_tbody);
								$("#member-modal").modal('show');
							}
						});
					});

					$("#pq_client_list").on('click', '.lead_connect', function(){
						var member_id = $(this).attr('member_id');
						$.ajax({
							type: 'POST',
							data: {'member_id': member_id},
							url: '<?php echo site_url('pq/getConnectDetails'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var tbody = '';
								Object.keys(resp).forEach(function(key) {
									tbody += '<tr><td>'+resp[key]['connected_on']+'</td><td>'+resp[key]['connect_mode']+'</td><td>'+resp[key]['email_sent']+'</td><td>'+resp[key]['comments']+'</td></tr>';
								});
								$("#connect_table tbody").html(tbody);
								$("#member-contact-popup #member_id").val(member_id);
								$('#member-contact-popup').modal('show');
							}	
						});
					});


					$("#pq_client_list").on('click', '.lead_activity', function(){
						var client_id = $(this).attr('client_id');
						$.ajax({
							type: 'POST',
							url: '<?php echo site_url('pq/getActivities'); ?>',
							data: {'pq_client_id': client_id},
							success: function(res){
								$("#pq_client_id").val(client_id);
								var resp = $.parseJSON(res);
								$("#reg_id").html(resp.reg_id);
								$("#imp_links").html(resp.imp_links);
								$("#id_password").html(resp.id_password);
								var tr = '';
								Object.keys(resp.email_mobile).forEach(function(key) {
									tr += '<tr><td>'+resp.email_mobile[key].email+'</td><td>'+resp.email_mobile[key].mobile+'</td></tr>';
								});
								$("#contact_table").html(tr);
								var act_tr = '';
								if (0 in resp.activity){
									Object.keys(resp.activity).forEach(function(key) {
										var no = parseInt(key)+parseInt(1);
										act_tr += '<tr><td>'+no+'</td><td>'+resp.activity[key].activity_type+'</td><td>'+resp.activity[key].activity_description+'</td><td>'+resp.activity[key].activity_date+'</td><td>'+resp.activity[key].client_comments+'</td><td>'+resp.activity[key].comments_date+'</td><td>'+resp.activity[key].activity_notes+'</td><td><button class="btn btn-sm btn-danger delActivity" act_id="'+resp.activity[key].activity_id+'">Delete</td></tr>';
									});
									$("#activity_table").html(act_tr);
								}
								$("#contact_table").html(tr);
							}
						});
						$("#activity-modal").modal('show');
					});

					$("#addActivity").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addActivity").serialize();
								var client_id = $("#pq_client_id").val();
								$.ajax({
									data: frm_data,
									url: '<?php echo site_url('pq/pqAddActivity'); ?>',
									type: 'POST',
									success: function(res){
										$.ajax({
											type: 'POST',
											url: '<?php echo site_url('pq/getActivities'); ?>',
											data: {'pq_client_id': client_id},
											success: function(res){
												$("#pq_client_id").val(client_id);
												var resp = $.parseJSON(res);
												$("#reg_id").html(resp.reg_id);
												$("#imp_links").html(resp.imp_links);
												$("#id_password").html(resp.id_password);
												var tr = '';
												Object.keys(resp.email_mobile).forEach(function(key) {
													tr += '<tr><td>'+resp.email_mobile[key].email+'</td><td>'+resp.email_mobile[key].mobile+'</td></tr>';
												});
												$("#contact_table").html(tr);
												var act_tr = '';
												if (0 in resp.activity){
													Object.keys(resp.activity).forEach(function(key) {
														var no = parseInt(key)+parseInt(1);
														act_tr += '<tr><td>'+no+'</td><td>'+resp.activity[key].activity_type+'</td><td>'+resp.activity[key].activity_description+'</td><td>'+resp.activity[key].activity_date+'</td><td>'+resp.activity[key].client_comments+'</td><td>'+resp.activity[key].comments_date+'</td><td>'+resp.activity[key].activity_notes+'</td><td><button class="btn btn-sm btn-danger delActivity" act_id="'+resp.activity[key].activity_id+'">Delete</td></tr>';
													});
													$("#activity_table").html(act_tr);
												}
												$("#contact_table").html(tr);
											}
										});
									}
								});
							}
							return false;
						},
						promptPosition: "inline",
					});

					$("#activity_table").on('click', '.delActivity', function(){
						if(confirm('Are you sure?')){
							var act_id = $(this).attr('act_id');
							var btn = $(this);
							$.ajax({
								type: 'POST',
								data: {'act_id': act_id},
								url: '<?php echo site_url('pq/delActivity'); ?>',
								success: function(res){
									btn.closest('tr').remove();
								}
							});
						}
					});

				<?php } if($this->router->fetch_class() == 'pq' && $this->router->fetch_method() == 'approved_list') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var imp_id_loop = 0;
							var table = $('#pq_client_list').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('pq/approved_list_data/'); ?>',
									type: 'POST',
									data: {
										// parameters for custom backend script demo
										/*columnsDef: [
											'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
										],*/
									},
								},
								/*columns: [
									{data: 'record_id'},
									{data: ''},
									{data: 'lead_stage'},
									{data: ''},
									{data: ''},
									<?php if($this->session->userdata('role') == 1){?>{data: 'name'},<?php } ?>
									{data: ''},
									{data: ''},
									{data: 'id_password'},
									{data: 'comments'},
									{data: 'connect_mode'},
									{data: 'type_name'},
									{data: 'stage_name'},
									{data: 'Actions', responsivePriority: -1},
								],*/
								columns: [
									{data: 'record_id'},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: 'Actions', responsivePriority: -1},
								],
								/*rowGroup: {
						            dataSrc: 'lead_name'
						        },*/
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										switch (column.title()) {
											case 'Lead Details':
												input = $(`<input type="text" id="company_name" title="Search Company" data-col-index="1" class="form-control kt-input" placeholder="Company Name"><br/>
													<select class="form-control form-control-sm form-filter kt-input" id="country" title="Select" data-col-index="2">
													<option value="">Country</option><?php echo $lead_country; ?></select><br/>
													<select class="form-control form-control-sm form-filter kt-input" id="region" title="Select" data-col-index="3">
													<option value="">Region</option><?php echo $lead_region; ?></select>`);
												break;

											/*case 'Contact':
												input = $(`<input type="text" id="person_name" title="Search Person" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Member Name">`);
												break;*/

											case 'Lead Stage':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="client_stage" title="Select" data-col-index="4">
												<option value="">Client Stage</option><?php echo $lead_stage_str; ?></select><br/>
												<select class="form-control form-control-sm form-filter kt-input" id="client_category" title="Select" data-col-index="5">
												<option value="">Client Category</option><?php echo $lead_type_str; ?></select><br/>
												<select class="form-control form-control-sm form-filter kt-input" id="reg_method" title="Select" data-col-index="6"><option value="">Registration Method</option>
												<option value="online">Online</option><option value="offline">Offline</option>
												</select>`);
												break;

											/*case 'Name':
												input = $(`<input type="text" id="company_name" title="Search Member" data-col-index="7" class="form-control kt-input" placeholder="Member Name"><br/>`);
												$(input).append('<?php echo $lead_stage_str; ?>');
												break;*/

											case 'Contact':
												input = $(``);
												$(input).append('');
												break;

											case 'Lead Team':
												input = $(`<select class="form-control form-control-sm form-filter kt-input" id="company_stage" title="Select" data-col-index="0">
															<option value="">Sales Person</option></select>`);
												$(input).append('<?php echo $user_str; ?>');
												break;
											
											case 'Actions':
												var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-search"></i>
												    <span>Search</span>
												  </span>
												</button>`);

												var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
												  <span>
												    <i class="la la-close"></i>
												    <span>Reset</span>
												  </span>
												</button>`);

												$('<th>').append(search).append(reset).appendTo(rowFilter);

												$(search).on('click', function(e) {
													e.preventDefault();
													var params = {};
													$(rowFilter).find('.kt-input').each(function() {
														var i = $(this).data('col-index');
														if (params[i]) {
															params[i] += '|' + $(this).val();
														}
														else {
															params[i] = $(this).val();
														}
													});
													$.each(params, function(i, val) {
														// apply search params to datatable
														table.column(i).search(val ? val : '', false, false);
													});
													table.table().draw();
												});

												$(reset).on('click', function(e) {
													e.preventDefault();
													$(rowFilter).find('.kt-input').each(function(i) {
														$(this).val('');
														table.column($(this).data('col-index')).search('', false, false);
													});
													table.table().draw();
												});
												break;
										}

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								createdRow: function(row, data, dataIndex){
									$('.stage_dropdown', row).select2({
										templateResult: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background-color: purple';
													break;

												case "7":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "8":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
										  	return $state;
										},
										templateSelection: function(opt){
											var style = '';
											switch(opt.id){
												case "1":
													style = 'background-color: grey';
													break;

												case "2":
													style = 'background-color: yellow';
													break;

												case "3":
													style = 'background-color: orange';
													break;

												case "4":
													style = 'background-color: blue';
													break;

												case "5":
													style = 'background-color: green';
													break;

												case "6":
													style = 'background-color: purple';
													break;

												case "7":
													style = 'background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);';
													break;

												case "8":
													style = 'background-color: red';
													break;
											}
											var $state = $(
											    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
											);
											return $state;
										}
									});
								},
								/*columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" >
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('pq/add/'); ?>`+full.pq_client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>`+connect_btn+
												``;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.company_name+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.type_name+`</span>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.priority+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var stage = '<select class="stage_dropdown" id="dropdown'+full.pq_client_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.pq_client_id+'"><option value=""></option>';
											if(full.client_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.client_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.client_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.client_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.client_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.client_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.client_stage == 7){
												stage += '<option value="7" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="7" id="red" disabled="disabled">Stage 0</option>';
											}

											if(full.client_stage == 8){
												stage += '<option value="8" selected="selected" id="purple">Stage 7</option>';
											}else{
												stage += '<option value="8" id="purple">Stage 7</option>';
											}

											if(full.client_stage == 9){
												stage += '<option value="9" selected="selected" id="indigo">Stage 8</option>';
											}else{
												stage += '<option value="9" id="indigo">Stage 8</option>';
											}
											stage += '</select>';

											return stage+` <br/><span style="font-weight: lighter;" class="last_contacted">`+full.last_contacted+`</span> <span style="font-weight: lighter;" class="last_contacted">`+full.registration_method+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Name',
										render: function(data, type, full, meta){
											var member_name = ''; var designation = '';
											if(full.member_name != null){
												member_name = full.member_name;
											}

											if(full.designation != null){
												designation = full.designation;
											}
											return `<p> <span class="member_name">`+member_name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
										}

									},
									{
										targets: 4,
										title: 'Contact',
										render: function(data, type, full, meta){
											var email = ''; var mobile = '';
											if(full.email != null){
												email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
														</span>`;
											}

											if(full.mobile != null){
												mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
														</span>`;
											}

											return `<p>`+email+`<br/>`+mobile+`</p>`;
										}

									},
									{
										targets: 6,
										title: 'Order System',
										render: function(data, type, full, meta){
											var counts = '';
											return full.order_system+`<br/>`+full.vendor_id;
										}
									},
									{
										targets: 7,
										title: '',
										render: function(data, type, full, meta){
											var counts = '';
											if(full.member_count > 0 || full.non_member_count > 0){
												counts = `<span style="cursor: pointer; color: #9583ce; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="mem" class="mem_count">`+full.member_count+`</span> / <span style="cursor: pointer; color: #ce8383; font-weight: bold;" lead_id="`+full.lead_mst_id+`" member_type="nonmem" class="mem_count">`+full.non_member_count+`</span>`;
											}

											return counts;
										}
									}
								],*/
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var connect_btn = '';
											if(full.lead_dtl_id > 0){
												var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.lead_dtl_id+`" >
													<i class="la la-comment"></i>
												</button>`;
											}

											return `<a href="<?php echo site_url('pq/add/'); ?>`+full.pq_client_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>
												<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_activity pull-right" title="Contact" client_id="`+full.pq_client_id+`" >
													<i class="la la-list-alt"></i>
												</button>`;
										},
									},
									{
										targets: 1,
										title: 'Lead Details',
										render: function(data, type, full, meta){
											var img = '';

											if(full.flag_name){
												img = '<img src="/assets/media/flags/'+full.flag_name+'" class="img img-responsive rounded-circle" style="width: 30px">';
											}

											return `<p>`+img+` 
												<strong style="margin-left: 5px;" class="imported">`+full.company_name+`</strong>
											</p>
											<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.region+`</span>`;
										}
									},
									{
										targets: 2,
										title: 'Lead Stage',
										render: function(data, type, full, meta){
											var stage = '<select class="stage_dropdown" id="dropdown'+full.pq_client_id+'-'+full.lead_dtl_id+'" lead_mst_id="'+full.pq_client_id+'"><option value=""></option>';
											if(full.client_stage == 1){
												stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
											}else{
												stage += '<option value="1" id="grey">Stage 1</option>';
											}

											if(full.client_stage == 2){
												stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
											}else{
												stage += '<option value="2" id="yellow">Stage 2</option>';
											}

											if(full.client_stage == 3){
												stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
											}else{
												stage += '<option value="3" id="orange">Stage 3</option>';
											}

											if(full.client_stage == 4){
												stage += '<option value="4" selected="selected" id="blue">Stage 4</option>';
											}else{
												stage += '<option value="4" id="blue">Stage 4</option>';
											}

											if(full.client_stage == 5){
												stage += '<option value="5" selected="selected" id="green">Stage 5</option>';
											}else{
												stage += '<option value="5" id="green">Stage 5</option>';
											}

											if(full.client_stage == 6){
												stage += '<option value="6" selected="selected" id="multi">Stage 6</option>';
											}else{
												stage += '<option value="6" id="multi">Stage 6</option>';
											}

											if(full.client_stage == 7){
												stage += '<option value="7" selected="selected" id="purple" >Stage 7</option>';
											}else{
												stage += '<option value="7" id="purple">Stage 7</option>';
											}

											if(full.client_stage == 8){
												stage += '<option value="8" selected="selected" id="red" disabled="disabled">Stage 0</option>';
											}else{
												stage += '<option value="8" id="red" disabled="disabled">Stage 0</option>';
											}
											stage += '</select>';

											return stage+` <span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.type_name+`</span> <br/> <span style="font-weight: lighter;" class="last_contacted">`+full.registration_method+`</span>`;
										}
									},
									{
										targets: 3,
										title: 'Lead Team',
										render: function(data, type, full, meta){
											return full.name+`<br/><span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">`+full.priority+`</span>`;
										}
									},
									{
										targets: 4,
										title: 'Order Status',
										render: function(data, type, full, meta){
											return full.order_system;
										}
									},
									{
										targets: 5,
										title: 'Vendor Code / Website',
										render: function(data, type, full, meta){
											var website = '';
											if(full.website != null){
												website = `<a href="`+full.website+`" target="_blank">`+full.website+`</a>`;
											}
											return website+`<br/>`+full.vendor_id;
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#pq_client_list").on('click', '.mem_count', function(){
						$.ajax({
							type: 'POST',
							data: {'lead_id': $(this).attr('lead_id'), 'member_type': $(this).attr('member_type')},
							url: '<?php echo site_url('pq/getPQMembers'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var member_tbody = ''; var buyer_tbody = '';
								Object.keys(resp).forEach(function(key) {
									if(resp[key]['other_member'] == 'Y'){
										member_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}else{
										buyer_tbody += `<tr>
											<td>`+resp[key]['member_name']+`</td>
											<td>`+resp[key]['email']+`</td>
											<td>`+resp[key]['mobile']+`</td>
										</tr>`;
									}
								});
								$("#member-modal #buyer_table tbody").html(buyer_tbody);
								$("#member-modal #member_table tbody").html(member_tbody);
								$("#member-modal").modal('show');
							}
						});
					});

					$("#pq_client_list").on('click', '.lead_connect', function(){
						var member_id = $(this).attr('member_id');
						$.ajax({
							type: 'POST',
							data: {'member_id': member_id},
							url: '<?php echo site_url('pq/getConnectDetails'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var tbody = '';
								Object.keys(resp).forEach(function(key) {
									tbody += '<tr><td>'+resp[key]['connected_on']+'</td><td>'+resp[key]['connect_mode']+'</td><td>'+resp[key]['email_sent']+'</td><td>'+resp[key]['comments']+'</td></tr>';
								});
								$("#connect_table tbody").html(tbody);
								$("#member-contact-popup #member_id").val(member_id);
								$('#member-contact-popup').modal('show');
							}	
						});
					});

					$("#pq_client_list").on('click', '.lead_activity', function(){
						var client_id = $(this).attr('client_id');
						$.ajax({
							type: 'POST',
							url: '<?php echo site_url('pq/getActivities'); ?>',
							data: {'pq_client_id': client_id},
							success: function(res){
								$("#pq_client_id").val(client_id);
								var resp = $.parseJSON(res);
								$("#reg_id").html(resp.reg_id);
								$("#imp_links").html(resp.imp_links);
								$("#id_password").html(resp.id_password);
								var tr = '';
								Object.keys(resp.email_mobile).forEach(function(key) {
									tr += '<tr><td>'+resp.email_mobile[key].email+'</td><td>'+resp.email_mobile[key].mobile+'</td></tr>';
								});
								$("#contact_table").html(tr);
								var act_tr = '';
								if (0 in resp.activity){
									Object.keys(resp.activity).forEach(function(key) {
										var no = parseInt(key)+parseInt(1);
										act_tr += '<tr><td>'+no+'</td><td>'+resp.activity[key].activity_type+'</td><td>'+resp.activity[key].activity_description+'</td><td>'+resp.activity[key].activity_date+'</td><td>'+resp.activity[key].client_comments+'</td><td>'+resp.activity[key].comments_date+'</td><td>'+resp.activity[key].activity_notes+'</td><td><button class="btn btn-sm btn-danger delActivity" act_id="'+resp.activity[key].activity_id+'">Delete</td></tr>';
									});
									$("#activity_table").html(act_tr);
								}
								$("#contact_table").html(tr);
							}
						});
						$("#activity-modal").modal('show');
					});

					$("#addActivity").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#addActivity").serialize();
								var client_id = $("#pq_client_id").val();
								$.ajax({
									data: frm_data,
									url: '<?php echo site_url('pq/pqAddActivity'); ?>',
									type: 'POST',
									success: function(res){
										$.ajax({
											type: 'POST',
											url: '<?php echo site_url('pq/getActivities'); ?>',
											data: {'pq_client_id': client_id},
											success: function(res){
												$("#pq_client_id").val(client_id);
												var resp = $.parseJSON(res);
												$("#reg_id").html(resp.reg_id);
												$("#imp_links").html(resp.imp_links);
												$("#id_password").html(resp.id_password);
												var tr = '';
												Object.keys(resp.email_mobile).forEach(function(key) {
													tr += '<tr><td>'+resp.email_mobile[key].email+'</td><td>'+resp.email_mobile[key].mobile+'</td></tr>';
												});
												$("#contact_table").html(tr);
												var act_tr = '';
												if (0 in resp.activity){
													Object.keys(resp.activity).forEach(function(key) {
														var no = parseInt(key)+parseInt(1);
														act_tr += '<tr><td>'+no+'</td><td>'+resp.activity[key].activity_type+'</td><td>'+resp.activity[key].activity_description+'</td><td>'+resp.activity[key].activity_date+'</td><td>'+resp.activity[key].client_comments+'</td><td>'+resp.activity[key].comments_date+'</td><td>'+resp.activity[key].activity_notes+'</td><td><button class="btn btn-sm btn-danger delActivity" act_id="'+resp.activity[key].activity_id+'">Delete</td></tr>';
													});
													$("#activity_table").html(act_tr);
												}
												$("#contact_table").html(tr);
											}
										});
									}
								});
							}
							return false;
						},
						promptPosition: "inline",
					});

					$("#activity_table").on('click', '.delActivity', function(){
						if(confirm('Are you sure?')){
							var act_id = $(this).attr('act_id');
							var btn = $(this);
							$.ajax({
								type: 'POST',
								data: {'act_id': act_id},
								url: '<?php echo site_url('pq/delActivity'); ?>',
								success: function(res){
									btn.closest('tr').remove();
								}
							});
						}
					});

				<?php } if($this->router->fetch_class() == 'quality' && $this->router->fetch_method() == 'add_marking') { ?>

					$("#add_marking").validationEngine({promptPosition: "inline"});

					$("#marking_type").change(function(){
						var type = $(this).val();
						$(".marking_for").hide();
						$(".marking_for_field").attr('disabled', 'disabled');
						$(".marking_for_result").html('').hide();
						$("#assigned_to").val('');
						$("#marking_company").val('');
						$("#marking_company_id").val('');
						$("#marking_member").val('');
						$("#marking_member_id").val('');
						if(type == 'sample'){
							$("#quotation").show();
							$("#quotation_no").removeAttr('disabled');
							$("#quotation_no_hidden").removeAttr('disabled');
						} else if(type == 'proforma'){
							$("#proforma").show();
							$("#proforma_no").removeAttr('disabled');
							$("#proforma_no_hidden").removeAttr('disabled');
						}
					});

					$(".marking_for_field").keyup(function(){
						var search = $(this).val();
						var mtc_for = $(this).attr('id');
						$.ajax({
							type: 'POST',
							data: {'search': search, 'mtc_for': mtc_for},
							url: '<?php echo site_url('quality/getSuggestions'); ?>',
							success: function(res){
								try {
							        var resp = JSON.parse(res);
							        var html = '';
							        Object.keys(resp).forEach(function(key) {
							        	html += `<p style="cursor: pointer;" onclick="fillMarkingData('`+resp[key].client_id+`', '`+resp[key].client_name+`', '`+resp[key].member_id+`', '`+resp[key].name+`', '`+resp[key].assigned_to+`', `+resp[key].mtc_str_id+`, '`+resp[key].mtc_str+`', '`+mtc_for+`')">`+resp[key].mtc_str+`</p>`;
							        });
							        $("#"+mtc_for+"_res").html(html).show();
							    } catch (e) {
							        return false;
							    }
							    return true;
							}
						});
					});

					$("#add_marking").on('click', '.generateHeat', function(){
						var product_id = $(this).closest('tr').find('.product').val();
						var current_btn = $(this);
						$.ajax({
							type: 'POST',
							url: '<?php echo site_url('quality/generateHeat'); ?>',
							data: {'product_id': product_id},
							success: function(res){
								$(current_btn).siblings('.heat_number').val(res);
							}
						});
					});

					$("#mtc_type").trigger('change');

				<?php } if($this->router->fetch_class() == 'quality' && $this->router->fetch_method() == 'add_mtc') { ?>

					$("#addMTC").validationEngine({promptPosition: "inline"});

					$("#mtc_type").change(function(){
						var type = $(this).val();
						$(".mtc_for").hide();
						$(".mtc_for_field").attr('disabled', 'disabled');
						$(".mtc_for_result").html('').hide();
						if(type == 'sample'){
							$("#quotation").show();
							$("#quotation_no").removeAttr('disabled');
							$("#quotation_no_hidden").removeAttr('disabled');
						} else if(type == 'pending'){
							$("#proforma").show();
							$("#proforma_no").removeAttr('disabled');
							$("#proforma_no_hidden").removeAttr('disabled');
						} else if(type == 'dispatch'){
							$("#invoice").show();
							$("#invoice_no").removeAttr('disabled');
							$("#invoice_no_hidden").removeAttr('disabled');
						}
					});

					$(".mtc_for_field").keyup(function(){
						var search = $(this).val();
						var mtc_for = $(this).attr('id');
						$.ajax({
							type: 'POST',
							data: {'search': search, 'mtc_for': mtc_for},
							url: '<?php echo site_url('quality/getSuggestions'); ?>',
							success: function(res){
								try {
							        var resp = JSON.parse(res);
							        var html = '';
							        Object.keys(resp).forEach(function(key) {
							        	html += `<p style="cursor: pointer;" onclick="fillMTCData('`+resp[key].client_id+`', '`+resp[key].client_name+`', `+resp[key].mtc_str_id+`, '`+resp[key].mtc_str+`', '`+mtc_for+`')">`+resp[key].mtc_str+`</p>`;
							        });
							        $("#"+mtc_for+"_res").html(html).show();
							    } catch (e) {
							        return false;
							    }
							    return true;
							}
						});
					});

					$("#mtc_type").trigger('change');
					
					var mtc_file_dzone = new Dropzone('#mtc_file', {
			            url: "<?php echo site_url('quality/uploadDocument'); ?>", // Set the url for your upload script location
			            paramName: "file", // The name that will be used to transfer the file
			            params: {'mtc_mst_id': '<?php if(isset($mtc_details)){echo $mtc_details['mtc_mst_id'];} ?>'},
			            maxFiles: 1,
			            maxFilesize: 5, // MB
			            addRemoveLinks: false,
			            acceptedFiles: ".pdf",
			        });

			        mtc_file_dzone.on("success", function(file, response) {
			            let res = JSON.parse(response);
			            if(res.status == 'success'){
			            	$(file.previewElement).addClass("dz-success").find('.dz-success-message').text(res.msg);
			            }else{
			            	$(file.previewElement).addClass("dz-error").find('.dz-error-message').text(res.msg);
			            }
			        });

			        mtc_file_dzone.on("removedfile", function(file) {
						$.ajax({
							url: "<?php echo site_url('quality/deleteDocument'); ?>",
							type: "POST",
							data: {'mtc_for_id': '<?php if(isset($mtc_details)){echo $mtc_details['mtc_for_id'];} ?>'},
						});
					});

				<?php } if($this->router->fetch_class() == 'quality' && $this->router->fetch_method() == 'mtc_list') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#mtc_list').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('quality/mtc_list_data'); ?>',
									type: 'POST',
									data: function(data){
										/*var datewise = $("#datewise").val();
										data.searchByDatewise = datewise;*/
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'mtc_type'},
									{data: ''},
									{data: 'mtc_company'},
									{data: ''},
									{data: ''},
									{data: ''},
									{data: 'assigned_to'},
									{data: 'created_by'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											var alert = '';
											if((full.made_flag == '' || full.made_flag == null) && (<?php echo $this->session->userdata('role'); ?> == 9 || <?php echo $this->session->userdata('role'); ?> == 10)) {
												alert = '<span class="badge badge-danger">New</span>';
											} else if(full.made_flag == 'Y' && (full.checked_by_quality_admin == '' || full.checked_by_quality_admin == null) && <?php echo $this->session->userdata('role'); ?> == 10) {
												alert = '<span class="badge badge-danger">New</span>';
											} if(full.made_flag == 'Y' && full.made_flag == 'Y' && (full.checked_by_super_admin == '' || full.checked_by_super_admin == null) && <?php echo $this->session->userdata('role'); ?> == 1) {
												alert = '<span class="badge badge-danger">New</span>';
											}

											return alert+`<button class="btn btn-sm btn-clean btn-icon btn-icon-md editMTC" title="Update Status" mtc_id="`+full.mtc_mst_id+`" data-toggle="modal" data-target="#editMTC">
					                            <i class="la la-edit"></i>
					                        </button>
					                        <a href="<?php echo site_url('quality/add_mtc/'); ?>`+full.mtc_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit">
					                        	<i class="la la-info-circle"></i>
					                        </a>`;
										}
									},
									{
										targets: 2,
										title: 'MTC For',
										render: function(data, type, full, meta) {
											switch(full.mtc_type){
												case 'sample':
													return `<a href="<?php echo site_url('quotations/pdf/'); ?>`+full.mtc_for_id+`" target="_blank">`+full.mtc_for+`</a>`;
													break;

												case 'pending':
													return `<a href="<?php echo site_url('proforma/pdf/'); ?>`+full.mtc_for_id+`" target="_blank">`+full.mtc_for+`</a>`;
													break;

												case 'dispatch':
													if(full.mtc_for_id > 0){
														return `<a href="<?php echo site_url('invoices/invoice_pdf/'); ?>`+full.mtc_for_id+`" target="_blank">`+full.mtc_for+`</a>`;
													}else{
														return full.mtc_for;
													}
													break;
											}
										}
									},
									{
										targets: 4,
										render: function(data, type, full, meta) {
											if(full.made_flag != ''){
												return `N`;
											}else{
												return full.made_flag;
											}
										}
									},
									{
										targets: 5,
										render: function(data, type, full, meta) {
											if(full.checked_by_quality_admin != ''){
												return `N`;
											}else{
												return full.checked_by_quality_admin;
											}
										}
									},
									{
										targets: 6,
										render: function(data, type, full, meta) {
											if(full.checked_by_super_admin != ''){
												return `N`;
											}else{
												return full.checked_by_super_admin;
											}
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					$("#mtc_list").on('click', '.editMTC', function(){
						var table = $("#mtc_list").DataTable();
						var tableData = table.row( $(this).parents('tr') ).data();
						if(<?php echo $this->session->userdata('role'); ?> == 1){
							if(tableData.made_flag == 'Y'){
								$("#updateMTC #made_yes").attr('checked', 'checked');
								/*$("#updateMTC #mtc_file_name").attr('href', '<?php echo site_url('assets/mtc-document/'); ?>'+tableData.mtc_file_name).show();*/
								var file_html = '';
								Object.keys(tableData.files).forEach(function(key) {
									file_html += `<a href="<?php echo site_url('assets/mtc-document/'); ?>`+tableData.files[key].file_name+`">View Document</a><br/>`;
								});
								$("#updateMTC #mtc_files").html(file_html);
							}else{
								$("#updateMTC #made_no").attr('checked', 'checked');
								$("#updateMTC #mtc_file_name").removeAttr('href').hide();
							}

							if(tableData.checked_by_quality_admin == 'Y'){
								$("#updateMTC #qadmin_yes").attr('checked', 'checked');
							}else if(tableData.checked_by_quality_admin == 'N'){
								$("#updateMTC #qadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMTC #qadmin_pd").attr('checked', 'checked');
							}
							$("#updateMTC #qa_comment").val(tableData.qa_comment);

							if(tableData.checked_by_super_admin == 'Y'){
								$("#updateMTC #sadmin_yes").attr('checked', 'checked');
							}else if(tableData.checked_by_super_admin == 'N'){
								$("#updateMTC #sadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMTC #sadmin_pd").attr('checked', 'checked');
							}
							$("#updateMTC #sa_comment").val(tableData.sa_comment);
						} else if(<?php echo $this->session->userdata('role'); ?> == 9){
							if(tableData.made_flag == 'Y'){
								$("#updateMTC #made_yes").attr('checked', 'checked');
								$("#updateMTC #mtc_file_name").attr('href', '<?php echo site_url('assets/mtc-document/'); ?>'+tableData.mtc_file_name).show();
							}else{
								$("#updateMTC #made_no").attr('checked', 'checked');
								$("#updateMTC #mtc_file_name").removeAttr('href').hide();
							}

							if(tableData.checked_by_quality_admin == 'Y'){
								$("#updateMTC #qadmin_yes").attr('checked', 'checked');
							}else if(tableData.checked_by_quality_admin == 'N'){
								$("#updateMTC #qadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMTC #qadmin_pd").attr('checked', 'checked');
							}
							$("#updateMTC #qa_comment").val(tableData.qa_comment);
						} else if(<?php echo $this->session->userdata('role'); ?> == 10){
							if(tableData.made_flag == 'Y'){
								$("#updateMTC #made_yes").attr('checked', 'checked');
								$("#updateMTC #mtc_file_name").attr('href', '<?php echo site_url('assets/mtc-document/'); ?>'+tableData.mtc_file_name).show();
							}else{
								$("#updateMTC #made_no").attr('checked', 'checked');
								$("#updateMTC #mtc_file_name").removeAttr('href').hide();
							}
						}
						$("#mtc_mst_id").val(tableData.mtc_mst_id);
					});

					$("input[name='made_flag']").change(function(){
						if($("input[name='made_flag']:checked").val() == 'Y'){
							$("#mtc_file").show();
						}else if($("input[name='made_flag']:checked").val() == 'N'){
							$("#mtc_file").hide();
						}
					});

					$("#updateMTC").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#updateMTC").serialize();
								$.ajax({
									type: 'POST',
									data: frm_data,
									url: '<?php echo site_url('quality/updateMTC'); ?>',
									success: function(res){
										toastr.success('MTC updated successfully!');
									}
								});
								updateMTC.reset();
					        	$("#editMTC").modal('hide');
							}
							return false;
						}, promptPosition: 'inline'
					});

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});
				<?php } if($this->router->fetch_class() == 'quality' && $this->router->fetch_method() == 'marking_list' && $marking_type == 'sample') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#marking_list').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('quality/marking_list_data/'.$marking_type); ?>',
									type: 'POST',
									data: function(data){
										/*var datewise = $("#datewise").val();
										data.searchByDatewise = datewise;*/
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'marking_for'},
									{data: 'quote_date'},
									{data: 'client_name'},
									{data: 'assigned_to'},
									{data: 'created_by'},
									{data: 'made_status'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<a href="<?php echo site_url('quality/add_marking/'); ?>`+full.marking_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit" target="_blank">
					                        	<i class="la la-info-circle"></i>
					                        </a>
					                        <a href="<?php echo site_url('quality/viewMarking/'); ?>`+full.marking_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View PDF" target="_blank">
					                        	<i class="la la-eye"></i>
					                        </a>`;
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					$("#updateMTC").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#updateMTC").serialize();
								$.ajax({
									type: 'POST',
									data: frm_data,
									url: '<?php echo site_url('quality/updateMTC'); ?>',
									success: function(res){
										toastr.success('MTC updated successfully!');
									}
								});
								updateMTC.reset();
					        	$("#editMTC").modal('hide');
							}
							return false;
						}, promptPosition: 'inline'
					});

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});
				<?php } if($this->router->fetch_class() == 'quality' && $this->router->fetch_method() == 'marking_list' && $marking_type == 'proforma') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#marking_list').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('quality/marking_list_data/'.$marking_type); ?>',
									type: 'POST',
									data: function(data){
										/*var datewise = $("#datewise").val();
										data.searchByDatewise = datewise;*/
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'marking_for'},
									{data: 'quote_date'},
									{data: 'client_name'},
									{data: 'assigned_to'},
									{data: 'created_by'},
									{data: 'made_status'},
									{data: 'quality_admin_status'},
									{data: 'super_admin_status'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<button class="btn btn-sm btn-clean btn-icon btn-icon-md editMarking" title="Update Status" marking_id="`+full.marking_mst_id+`" data-toggle="modal" data-target="#editMarking">
					                            <i class="la la-edit"></i>
					                        </button>
					                        <a href="<?php echo site_url('quality/add_marking/'); ?>`+full.marking_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit" target="_blank">
					                        	<i class="la la-info-circle"></i>
					                        </a>
					                        <a href="<?php echo site_url('quality/viewMarking/'); ?>`+full.marking_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View PDF" target="_blank">
					                        	<i class="la la-eye"></i>
					                        </a>`;
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					$("#updateMarking").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#updateMarking").serialize();
								$.ajax({
									type: 'POST',
									data: frm_data,
									url: '<?php echo site_url('quality/updateMarking'); ?>',
									success: function(res){
										toastr.success('Marking updated successfully!');
									}
								});
								updateMarking.reset();
					        	$("#editMarking").modal('hide');
							}
							return false;
						}, promptPosition: 'inline'
					});

					$("#marking_list").on('click', '.editMarking', function(){
						var table = $("#marking_list").DataTable();
						var tableData = table.row( $(this).parents('tr') ).data();
						if(<?php echo $this->session->userdata('role'); ?> == 1){
							if(tableData.made_status == 'Y'){
								$("#updateMarking #made_yes").attr('checked', 'checked');
							}else{
								$("#updateMarking #made_no").attr('checked', 'checked');
							}

							if(tableData.quality_admin_status == 'Y'){
								$("#updateMarking #qadmin_yes").attr('checked', 'checked');
							}else if(tableData.checked_by_quality_admin == 'N'){
								$("#updateMarking #qadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMarking #qadmin_pd").attr('checked', 'checked');
							}
							$("#updateMarking #qa_comment").val(tableData.qa_comment);
							$("#updateMarking #quality_admin_status_on").val(tableData.quality_admin_status_on);

							if(tableData.super_admin_status == 'Y'){
								$("#updateMarking #sadmin_yes").attr('checked', 'checked');
							}else if(tableData.super_admin_status == 'N'){
								$("#updateMarking #sadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMarking #sadmin_pd").attr('checked', 'checked');
							}
							$("#updateMarking #sa_comment").val(tableData.sa_comment);
							$("#updateMarking #super_admin_status_on").val(tableData.super_admin_status_on);
						} else if(<?php echo $this->session->userdata('role'); ?> == 9){
							if(tableData.made_status == 'Y'){
								$("#updateMarking #made_yes").attr('checked', 'checked');
							}else{
								$("#updateMarking #made_no").attr('checked', 'checked');
							}

							if(tableData.quality_admin_status == 'Y'){
								$("#updateMarking #qadmin_yes").attr('checked', 'checked');
							}else if(tableData.quality_admin_status == 'N'){
								$("#updateMarking #qadmin_no").attr('checked', 'checked');
							}else{
								$("#updateMarking #qadmin_pd").attr('checked', 'checked');
							}
							$("#updateMarking #qa_comment").val(tableData.qa_comment);
						} else if(<?php echo $this->session->userdata('role'); ?> == 10){
							if(tableData.made_status == 'Y'){
								$("#updateMarking #made_yes").attr('checked', 'checked');
							}else{
								$("#updateMarking #made_no").attr('checked', 'checked');
							}
						}
						$("#marking_mst_id").val(tableData.marking_mst_id);
					});

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});
				<?php } if($this->router->fetch_class() == 'tasks' && $this->router->fetch_method() == 'list') { ?>
					"use strict";
					var KTDatatablesSearchOptionsColumnSearch = function() {

						$.fn.dataTable.Api.register('column().title()', function() {
							return $(this.header()).text().trim();
						});

						var initTable1 = function() {

							// begin first table
							var table = $('#task_table').DataTable({
								responsive: true,

								// Pagination settings
								dom: `<'row'<'col-sm-12'tr>>
								<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
								// read more: https://datatables.net/examples/basic_init/dom.html

								/*pagingType: 'input',*/

								lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

								pageLength: 10,

								language: {
									'lengthMenu': 'Display _MENU_',
								},

								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: {
									url: '<?php echo site_url('tasks/list_data/'); ?>',
									type: 'POST',
									data: function(data){
										var datewise = $("#datewise").val();
										data.searchByDatewise = datewise;
									},
								},
								columns: [
									{data: 'record_id'},
									{data: 'status'},
									{data: 'task_detail'},
									{data: 'client_name'},
									{data: 'member_name'},
									<?php if($this->session->userdata('role') == 1){?>
									{data: 'created_by_name'},
									<?php } ?>
									{data: 'deadline'},
									{data: 'Actions', responsivePriority: -1},
								],
								initComplete: function() {
									var thisTable = this;
									var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

									this.api().columns().every(function() {
										var column = this;
										var input;

										if (column.title() !== 'Actions') {
											$(input).appendTo($('<th>').appendTo(rowFilter));
										}
									});

									 // hide search column for responsive table
									var hideSearchColumnResponsive = function () {
						            	thisTable.api().columns().every(function () {
								           	var column = this
								           	if(column.responsiveHidden()) {
									        	$(rowFilter).find('th').eq(column.index()).show();
								           	} else {
									        	$(rowFilter).find('th').eq(column.index()).hide();
								           	}
							           	})
					        		};

									// init on datatable load
									hideSearchColumnResponsive();
									// recheck on window resize
									window.onresize = hideSearchColumnResponsive;

									/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
								},
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `<button class="btn btn-sm btn-clean btn-icon btn-icon-md updateTask" title="Edit" task_id="`+full.task_id+`" data-toggle="modal" data-target="#editTask">
					                            <i class="la la-edit"></i>
					                        </button>`;
										}
									}
								],
							});

						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},
						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesSearchOptionsColumnSearch.init();
					});

					$("#datewise").change(function(){
						var val = $(this).val();
						var dataTable = $('#task_table').DataTable();
						dataTable.draw();
					});

					$("#deadline").datetimepicker({
			            format: "dd-mm-yyyy HH:ii P",
			            showMeridian: true,
			            todayHighlight: true,
			            autoclose: true,
			            pickerPosition: 'bottom-left'
			        });

			        $("#task_table").on('click', '.updateTask', function(){
			        	var table = $("#task_table").DataTable();
						var tableData = table.row( $(this).parents('tr') ).data();
						$("#task_lead_id").val(tableData.lead_id);
						$("#task_member_id").val(tableData.member_id);
						$("#lead_source").val(tableData.lead_source);
						$("#task_id").val(tableData.task_id);
			        })

			        $("#task_status").change(function(){
			        	if($(this).val() == 'Open'){
			        		$("#deadlineDiv").show();
			        	}else{
			        		$("#deadlineDiv").hide();
			        	}
			        });

			        $("#updateTask").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#updateTask").serialize();
								$.ajax({
									type: 'POST',
									data: frm_data,
									url: '<?php echo site_url('tasks/updateTask'); ?>',
									success: function(res){
										toastr.success('Task updated successfully!');
									}
								});
								updateTask.reset();
					        	$("#editTask").modal('hide');
							}
						}, promptPosition: 'inline'
					});

				<?php } if($this->router->fetch_class() == 'procurement') { ?>
					<?php if($this->router->fetch_method() == 'addRFQ') { ?>
						$("#addrfq_form").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									$("#addrfq_form").submit();
								}else{
									return false;
								}
							},
							promptPosition: "inline"
						});

						//$("#addrfq_form #rfq_company").select2();

						$("#addrfq_form #rfq_company").keyup(function(){
							var search = $(this).val();
							if(search != ''){
								$.ajax({
									type: 'POST',
									data: {search: search},
									url: '<?php echo site_url('procurement/searchLead'); ?>',
									success: function(res){
										var resp = $.parseJSON(res);
										var leads = '';
										Object.keys(resp).forEach(function(key) {
											leads += `<div style="padding: 5px; width: 90%; cursor: pointer" onclick="filldata(`+resp[key].client_id+`, '`+resp[key].client_name+`', '`+resp[key].client_rank+`', '`+resp[key].last_purchased+`', '`+resp[key].client_source+`')">
												`+resp[key].client_name+`
											</div>`;
										});
										$("#company_result").html(leads).show();
									}
								});
							}
						});

						/*$("#addrfq_form #rfq_company").blur(function(){
							var client_id = $("#rfq_company_hidden").val();
							var client_source = $("#addrfq_form #rfq_company option:selected").attr('source');
							var last_purchased = $("#addrfq_form #rfq_company option:selected").attr('last_pur');
							var rank = $("#addrfq_form #rfq_company option:selected").attr('rank');
							$.ajax({
								type: 'post',
								data: {'client_id': client_id, 'source': client_source},
								url: '<?php echo site_url('procurement/getMembers'); ?>',
								success: function(res){
									var resp = $.parseJSON(res);
									var html = '<option value="">Choose Buyer</option>';
									var member_id = '<?php if(isset($rfq_details)){ echo $rfq_details[0]['rfq_buyer']; } ?>';
									var selected = '';
									Object.keys(resp).forEach(function(key) {
										selected = '';
										if(member_id == resp[key].member_id){
											selected = 'selected="selected"';
										}
										html += '<option value="'+resp[key].member_id+'" '+selected+'>'+resp[key].member_name+'</option>';
									});
									$("#rfq_buyer").html(html);
								}
							});

							$("#rfq_rank").val(rank);
							$("#client_source").val(client_source);
							$("#rfq_lastbuy").val(last_purchased);
						});*/

						$("#rfq_company").trigger('change');

						var product_str = '<?php if(isset($prd_str)) echo $prd_str; ?>';
						var material_str = '<?php if(isset($mat_str)) echo $mat_str; ?>';
						var vendor_str = '<?php if(isset($vendor_str)) echo $vendor_str; ?>';
						var unit_str = '<?php if(isset($unit_str)) echo $unit_str; ?>';

						$("#add_row").click(function(){
							$("#preview_div").show();
							var sr = parseInt($("#tbody tr").length)+1;
							$("#tbody").append('<tr><td>'+sr+'</td><td><select class="form-control products" name="product_id[]"><option value="">Select Product</option>'+product_str+'</select></td><td><select class="form-control materials" name="material_id[]"><option value="">Select Material</option>'+material_str+'</select></td><td><textarea class="form-control validate[required]" name="description[]"></textarea></td><td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] quantity" name="quantity[]"></td><td><select class="form-control products" name="unit[]"><option value="">Select Product</option>'+unit_str+'</select></td><td><button type="button" class="btn btn-sm btn-danger delRow">Delete</button></td></tr>');
						});

						$("#add_rfq_vendor").click(function(){
							var sr = parseInt($("#vendor_table tbody tr").length)+1;
							$("#vendor_table tbody").append('<tr><td>'+sr+'</td><td><select class="form-control vendor"><option value="">Select Vendor</option>'+vendor_str+'</select></td><td><select class="form-control vendor_status"><option value="pending">Pending</option><option value="query">Query</option><option value="regret">Regret</option><option value="done">Done</option></select></td><td><select class="form-control evaluate_price" style="width:30%; display: inline-block;"><option value="">Select Price</option><option value="high">High</option><option value="low">Low</option></select><select class="form-control evaluate_delivery" style="width:45%; display: inline-block; margin-left: 5%"><option value="">Select Delivery</option><option value="high">High</option><option value="low">Low</option></select></td><td><button type="button" class="btn btn-xl btn-icon btn-icon-md delVendor" title="Delete"><i class="la la-trash"></i></button> <button type="button" class="btn btn-xl btn-icon btn-icon-md saveVendor" title="Save"><i class="la la-save"></i></button></td></tr>');
							$(".vendor").select2();
						});

						$("#tbody").on('click', '.delRow', function(){
							$(this).closest('tr').remove();
						});

						$("#vendor_table").on('click', '.delVendor', function(){
							$(this).closest('tr').remove();
						});

						$("#vendor_table").on('click', '.saveVendor', function(){
							var rfq_id = '<?php if(isset($rfq_id)){ echo $rfq_id; }?>';
							var vendor_id = $(this).closest('tr').find('.vendor').val();
							var vendor_status = $(this).closest('tr').find('.vendor_status').val();
							var evaluate_price = $(this).closest('tr').find('.evaluate_price').val();
							var evaluate_delivery = $(this).closest('tr').find('.evaluate_delivery').val();
							$.ajax({
								type: 'POST',
								data: {'rfq_id': rfq_id, 'vendor_id': vendor_id, 'vendor_status': vendor_status, 'evaluate_price': evaluate_price, 'evaluate_delivery': evaluate_delivery },
								url: '<?php echo site_url('procurement/assignVendor'); ?>',
								success: function(res){
									//location.reload();
								}
							});
						});

						$("#rfq_query_frm").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									var frm_data = $("#rfq_query_frm").serialize();
									$.ajax({
										url: '<?php echo site_url('procurement/addQuery'); ?>',
										data: frm_data,
										type: 'post',
										success: function(res){
											var resp = $.parseJSON(res);
											var tbody = '';
											var align = '';
											Object.keys(resp).forEach(function(key) {
												align = 'left';
												if(resp[key].entered_by == '<?php echo $this->session->userdata('user_id'); ?>'){
													align = 'right';
												}
												tbody += `<tr>
													<td>
														<div style="text-align:`+align+`">
				                							`+resp[key].note+`<br/>
				                							<span style="font-size: 10px;">`+resp[key].entered_on+`</span>
				                						</div>
													</td>
												</tr>`;
											});
											$("#rfq_query_frm #notes").val('');
											$("#query_table tbody").html(tbody);
										}
									})
								}
								return false;
							},
							promptPosition: "inline",
						});

						$("#rfq_note_frm").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									var frm_data = $("#rfq_note_frm").serialize();
									$.ajax({
										url: '<?php echo site_url('procurement/addNotes'); ?>',
										data: frm_data,
										type: 'post',
										success: function(res){
											var resp = $.parseJSON(res);
											var tbody = '';
											var align = '';
											Object.keys(resp).forEach(function(key) {
												tbody += `<tr>
													<td>`+resp[key].note+`</td>
													<td>`+resp[key].entered_on+`</td>
												</tr>`;
											});
											$("#rfq_note_frm #notes").val('');
											$("#notes_table tbody").html(tbody);
										}
									})
								}
								return false;
							},
							promptPosition: "inline",
						});

						$("#add_company #addCompany").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									$.ajax({
										url: "<?php echo site_url('client/addClientAjax'); ?>",
										data: $("#add_company #addCompany").serialize(),
										type: "POST",
										success: function(res){
											var resp = $.parseJSON(res);
											var client_id = resp.client_id;
											var clients = resp.clients;
											var html = '<option value="" disabled>Select</option>';
											Object.keys(clients).forEach(function(key) {
												var selected = '';
												if(client_id == clients[key].client_id){
													selected = 'selected="selected"';
												}
												html += '<option value="'+clients[key].client_id+'" '+selected+'>'+clients[key].client_name+'</option>';
											});
											$("#rfq_company").html(html);
										}
									});
									$('#add_company').modal('hide');
								}
								return false;
							}, promptPosition: "inline"
						});

						$("#company").trigger('change');

						$("#add_member #addMember").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									var inputData = $("#add_member #addMember").serializeArray();
									inputData.push({name: 'client_id', value: $("#rfq_company_hidden").val()});
									$.ajax({
										url: "<?php echo site_url('client/addClientMemberAjax'); ?>",
										data: inputData,
										type: "POST",
										success: function(res){
											var resp = $.parseJSON(res);
											var member_id = resp.member_id;
											var members = resp.members;
											var html = '<option value="" disabled>Select</option>';
											Object.keys(members).forEach(function(key) {
												var selected = '';
												if(member_id == members[key].member_id){
													selected = 'selected="selected"';
												}
												html += '<option value="'+members[key].member_id+'" '+selected+'>'+members[key].name+'</option>';
											});
											$("#rfq_buyer").html(html);
										}
									});
									$('#add_member').modal('hide');
								}
								return false;
							},
							promptPosition: "inline"
						});

						$("#add_company #country").change(function(){
							$("#add_company #region").val($("#add_company #country option:selected").attr('region'));
						});

					<?php } if($this->router->fetch_method() == 'rfq_list') { ?>
						"use strict";
						var KTDatatablesSearchOptionsColumnSearch = function() {

							$.fn.dataTable.Api.register('column().title()', function() {
								return $(this.header()).text().trim();
							});

							var initTable1 = function() {

								// begin first table
								var imp_id_loop = 0;
								var table = $('#rfq_table').DataTable({
									responsive: true,

									// Pagination settings
									dom: `<'row'<'col-sm-12'tr>>
									<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
									// read more: https://datatables.net/examples/basic_init/dom.html

									/*pagingType: 'input',*/

									lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

									pageLength: 10,

									language: {
										'lengthMenu': 'Display _MENU_',
									},

									searchDelay: 500,
									processing: true,
									serverSide: true,
									ajax: {
										url: '<?php echo site_url('procurement/rfq_list_data/'); ?>',
										type: 'POST',
										data: {
											// parameters for custom backend script demo
											/*columnsDef: [
												'record_id', 'NEW_IMPORTER_NAME', 'FOB_VALUE_INR', 'Actions'
											],*/
										},
									},
									columns: [
										{data: 'record_id'},
										{data: 'rfq_no'},
										{data: 'company_name'},
										{data: 'member_name'},
										{data: 'rfq_subject'},
										{data: 'rfq_date'},
										{data: 'rfq_importance'},
										<?php if($this->session->userdata('role') != 5){?>
										{data: 'sentby_name'},
										<?php } ?>
										{data: 'assigned_to_name'},
										{data: 'rfq_status'},
										{data: 'quote_no'},
										{data: 'Actions', responsivePriority: -1},
									],
									initComplete: function() {
										var thisTable = this;
										var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

										this.api().columns().every(function() {
											var column = this;
											var input;

											switch (column.title()) {
												case 'RFQ #':
													input = $(`<input type="text" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="RFQ #">`);
													break;

												case 'Company':
													input = $(`<input type="text" data-col-index="` + column.index() + `" class="form-control kt-input" placeholder="Company Name">`);
													break;

												case 'Assigned To':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="assigned_to" title="Assigned To" data-col-index="` + column.index() + `">
														<option value="">Select</option><?php echo $purchase_person; ?></select>`);
													break;

												case 'Sent By':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="sent_by" title="Sent By" data-col-index="` + column.index() + `">
														<option value="">Select</option><?php echo $sales_person; ?></select>`);
													break;

												case 'Imp':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="sent_by" title="Importance" data-col-index="` + column.index() + `">
														<option value="">Select</option><option value="H">H</option><option value="M">M</option><option value="L">L</option></select>`);
													break;

												case 'RFQ Date':
													input = $(`<input type="text" data-col-index="` + column.index() + `" class="form-control kt-input hasdatepicker" placeholder="RFQ Date">`);
													break;

												case 'RFQ Status':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="country" title="RFQ Status" data-col-index="` + column.index() + `">
															<option value="">Select</option>
															<option value="waiting">Waiting</option>
															<option value="Pending">Pending</option>
															<option value="query">Query</option>
															<option value="regret">Regret</option>
															<option value="done">Done</option>
														</select>`);
													break;

												case 'Actions':
													var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
													  <span>
													    <i class="la la-search"></i>
													    <span>Search</span>
													  </span>
													</button>`);

													var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
													  <span>
													    <i class="la la-close"></i>
													    <span>Reset</span>
													  </span>
													</button>`);

													$('<th>').append(search).append(reset).appendTo(rowFilter);

													$(search).on('click', function(e) {
														e.preventDefault();
														var params = {};
														$(rowFilter).find('.kt-input').each(function() {
															var i = $(this).data('col-index');
															if (params[i]) {
																params[i] += '|' + $(this).val();
															}
															else {
																params[i] = $(this).val();
															}
														});
														$.each(params, function(i, val) {
															// apply search params to datatable
															table.column(i).search(val ? val : '', false, false);
														});
														table.table().draw();
													});

													$(reset).on('click', function(e) {
														e.preventDefault();
														$(rowFilter).find('.kt-input').each(function(i) {
															$(this).val('');
															table.column($(this).data('col-index')).search('', false, false);
														});
														table.table().draw();
													});
													break;
											}

											if (column.title() !== 'Actions') {
												$(input).appendTo($('<th>').appendTo(rowFilter));
											}

											$('.hasdatepicker').datepicker({
									            rtl: KTUtil.isRTL(),
									            todayHighlight: true,
									            orientation: "bottom left",
									            format: 'dd-mm-yyyy',
									            /*endDate: '+0d'*/
									        });
										});

										 // hide search column for responsive table
										var hideSearchColumnResponsive = function () {
							            	thisTable.api().columns().every(function () {
									           	var column = this
									           	if(column.responsiveHidden()) {
										        	$(rowFilter).find('th').eq(column.index()).show();
									           	} else {
										        	$(rowFilter).find('th').eq(column.index()).hide();
									           	}
								           	})
						        		};

										// init on datatable load
										hideSearchColumnResponsive();
										// recheck on window resize
										window.onresize = hideSearchColumnResponsive;

										/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
									},
									columnDefs: [
										{
											targets: -1,
											title: 'Actions',
											orderable: false,
											render: function(data, type, full, meta) {
												var view_quote = '';
												if(full.quote_id > 0){
													var view_quote = `<a href="<?php echo site_url('quotations/pdf/'); ?>`+full.quote_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation" target="_blank">
					                            		<i class="la la-eye"></i>
					                        		</a>`;
												}

												var highlight = '';
												if(full.is_new == true){
													highlight = `<span class="badge badge-danger" style="color: #fff; font-size: 8px;">New</span>`
												}

												<?php if($this->session->userdata('role') == 5){?>
													return `
														<a href="<?php echo site_url('procurement/addRFQ/'); ?>`+full.rfq_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="View RFQ"><i class="la la-info-circle"></i></a>`+highlight+`
														<button type="button" data-toggle="modal" data-target="#query-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md replyquery pull-right" title="View / Reply Query" member_id="`+full.rfq_mst_id+`" >
															<i class="la la-comment"></i>
														</button>
														<button type="button" data-toggle="modal" data-target="#notes-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md notes" title="View Notes" rfq_id="`+full.rfq_mst_id+`">
															<i class="la la-sticky-note"></i>
														</button>`+view_quote;
													
												<?php } else if($this->session->userdata('role') == 4){?>
													return `<a href="<?php echo site_url('procurement/addRFQ/'); ?>`+full.rfq_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="View RFQ"><i class="la la-info-circle"></i></a>
													<a href="<?php echo site_url('quotations/add/'); ?>`+full.quote_id+`/`+full.rfq_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="Make Quote"><i class="fa fa-file-invoice"></i></a>
													<button type="button" data-toggle="modal" data-target="#notes-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md notes" title="View Notes" rfq_id="`+full.rfq_mst_id+`">
														<i class="la la-sticky-note"></i>
													</button>`+view_quote;
												<?php } else if($this->session->userdata('role') == 6){?>
													return `<a href="<?php echo site_url('procurement/addRFQ/'); ?>`+full.rfq_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="View RFQ"><i class="la la-info-circle"></i></a>`+highlight+`
														<button type="button" data-toggle="modal" data-target="#query-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md replyquery pull-right" title="View / Reply Query" member_id="`+full.rfq_mst_id+`" >
															<i class="la la-comment"></i>
														</button>
														<button type="button" data-toggle="modal" data-target="#notes-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md notes" title="View Notes" rfq_id="`+full.rfq_mst_id+`">
															<i class="la la-sticky-note"></i>
														</button>`+view_quote+`
														<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md deleteRfq pull-right" title="Delete" rfq_id="`+full.rfq_mst_id+`" >
															<i class="la la-trash"></i>
														</button>
														`;
												<?php } else { ?>
													return `<a href="<?php echo site_url('procurement/addRFQ/'); ?>`+full.rfq_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="View RFQ"><i class="la la-info-circle"></i></a>`+highlight+`
														<button type="button" data-toggle="modal" data-target="#query-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md replyquery pull-right" title="View / Reply Query" member_id="`+full.rfq_mst_id+`" >
															<i class="la la-comment"></i>
														</button>
														<button type="button" data-toggle="modal" data-target="#notes-modal" class="btn btn-sm btn-clean btn-icon btn-icon-md notes" title="View Notes" rfq_id="`+full.rfq_mst_id+`">
															<i class="la la-sticky-note"></i>
														</button>`+view_quote;
												<?php } ?>
											},
										},
										{
											targets: 3,
											orderable: false
										},
										{
											targets: 6,
											orderable: false
										},
										{
											targets: 10,
											orderable: false
										}
									],
								});

							};

							return {

								//main function to initiate the module
								init: function() {
									initTable1();
								},
							};

						}();

						$("#rfq_table").on('click', '.replyquery', function(){
							var table = $("#rfq_table").DataTable();
							var tableData = table.row( $(this).parents('tr') ).data();
							$("#query_response #rfq_id").val(tableData.rfq_mst_id);
							$("#query_table tbody").html(tableData.query);
						});

						$("#rfq_table").on('click', '.notes', function(){
							var table = $("#rfq_table").DataTable();
							var tableData = table.row( $(this).parents('tr') ).data();
							$("#notes_table tbody").html(tableData.notes);
						});

						$("#rfq_table").on('click', '.deleteRfq', function(){
							if(confirm('Are you sure?')){
								$.ajax({
									type: 'POST',
									url: '<?php echo site_url('procurement/deleteRfq'); ?>',
									data: {'rfq_id': $(this).attr('rfq_id')},
									success: function(res){
										$("#rfq_table").DataTable().ajax.reload(null, false);
									}
								});
							}
						});

						$("#query_response").validationEngine('attach', {
							onValidationComplete: function(form, status){
								if(status == true){
									var frm_data = $("#query_response").serialize();
									$.ajax({
										url: '<?php echo site_url('procurement/addQuery'); ?>',
										data: frm_data,
										type: 'post',
										success: function(res){
											var resp = $.parseJSON(res);
											var tbody = '';
											var align = '';
											Object.keys(resp).forEach(function(key) {
												align = 'left';
												if(resp[key].entered_by == '<?php echo $this->session->userdata('user_id'); ?>'){
													align = 'right';
												}
												tbody += `<tr>
													<td>
														<div style="text-align:`+align+`">
				                							`+resp[key].note+`<br/>
				                							<span style="font-size: 10px;">`+resp[key].entered_on+`</span>
				                						</div>
													</td>
												</tr>`;
											});
											$("#notes").val('');
											$("#query_table tbody").html(tbody);
										}
									})
								}
								return false;
							},
							promptPosition: "inline",
						});

						jQuery(document).ready(function() {
							KTDatatablesSearchOptionsColumnSearch.init();
						});
					<?php } ?>
				<?php } if($this->router->fetch_class() == 'vendors') { ?>
					<?php if($this->router->fetch_method() == 'add_vendor') { ?>
						var product_str = '<?php if(isset($prd_str)) echo $prd_str; ?>';
						var material_str = '<?php if(isset($mat_str)) echo $mat_str; ?>';

						$("#add_row").click(function(){
							var sr = parseInt($("#tbody tr").length)+1;
							$("#tbody").append('<tr><td>'+sr+'</td><td><select class="form-control products" name="product_id[]"><option value="">Select Product</option>'+product_str+'</select></td><td><select class="form-control materials" name="material_id[]"><option value="">Select Material</option>'+material_str+'</select></td><td><select class="form-control type" name="vendor_type[]"><option value="">Select Type</option><option value="manufacturer">Manufacturer</option><option value="trader">Trader</option></select></td><td><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md delRow" title="Delete"><i class="la la-trash"></i></button></td></tr>');
						});

						$("#vendor_add_member").click(function(){
							var sr = parseInt($("#tbody_member tr").length)+1;
							$("#tbody_member tbody").append('<tr><td><input class="form-control validate[]" type="text" name="name[]"></td><td><input class="form-control" type="text" name="designation[]"></td><td><input class="form-control validate[]" type="text" name="email[]"></td><td><input class="form-control" type="text" name="mobile[]"></td><td><select name="is_whatsapp[]" class="form-control"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><input class="form-control" type="text" name="skype[]"></td><td><input class="form-control" type="text" name="telephone[]"></td><td><select name="main_seller[]" class="form-control validate[]"><option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option></select></td><td><select name="pmoc[]" class="form-control pmoc"><option value="select"></option><option value="email">Email</option><option value="call">Call</option><option value="whatsapp">Whatsapp</option></td><td>-</td><td><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md delRow" title="Delete"><i class="la la-trash"></i></button></td></tr>');
						});

						$("#tbody").on('click', '.delRow', function(){
							$(this).closest('tr').remove();
						});

						$("#tbody_member").on('click', '.delRow', function(){
							$(this).closest('tr').remove();
						});
					<?php } if($this->router->fetch_method() == 'list') { ?>
						"use strict";
						var KTDatatablesSearchOptionsColumnSearch = function() {

							$.fn.dataTable.Api.register('column().title()', function() {
								return $(this.header()).text().trim();
							});

							var initTable1 = function() {

								// begin first table
								var imp_id_loop = 0;
								var table = $('#vendors_list').DataTable({
									responsive: true,

									// Pagination settings
									dom: `<'row'<'col-sm-12'tr>>
									<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
									// read more: https://datatables.net/examples/basic_init/dom.html

									/*pagingType: 'input',*/

									lengthMenu: [10, 50, 100, 150, 200, 300, 500, 1000],

									pageLength: 10,

									language: {
										'lengthMenu': 'Display _MENU_',
									},

									searchDelay: 500,
									processing: true,
									serverSide: true,
									ajax: {
										url: '<?php echo site_url('vendors/list_data/'); ?>',
										type: 'POST',
										data: function(data){
											var product = $("#product").val();
											var material = $("#material").val();
											data.searchByProduct = product;
											data.searchByMaterial = material;
										}
									},
									columns: [
										{data: 'record_id'},
										{data: ''},
										{data: ''},
										{data: ''},
										{data: ''},
										{data: ''},
										{data: ''},
										{data: 'Actions', responsivePriority: -1},
									],
									createdRow: function(row, data, dataIndex){
										$('.stage_dropdown', row).select2({
											templateResult: function(opt){
												var style = '';
												switch(opt.id){
													case "1":
														style = 'background-color: grey';
														break;

													case "2":
														style = 'background-color: yellow';
														break;

													case "3":
														style = 'background-color: orange';
														break;

													case "4":
														style = 'background-color: green';
														break;

													case "5":
														style = 'background-color: red';
														break;
												}
												var $state = $(
												    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
												);
											  	return $state;
											},
											templateSelection: function(opt){
												var style = '';
												switch(opt.id){
													case "1":
														style = 'background-color: grey';
														break;

													case "2":
														style = 'background-color: yellow';
														break;

													case "3":
														style = 'background-color: orange';
														break;

													case "4":
														style = 'background-color: green';
														break;

													case "5":
														style = 'background-color: red';
														break;
												}
												var $state = $(
												    '<span class="roundedSpan" style="'+style+';"><span/> <span>' + opt.text + '</span>'
												);
												return $state;
											}
										});
									},
									initComplete: function() {
										var thisTable = this;
										var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

										this.api().columns().every(function() {
											var column = this;
											var input;
											switch (column.title()) {
												case 'Vendor':
													input = $(`<input type="text" data-col-index="1" class="form-control kt-input" placeholder="Company Name"><br/><select class="form-control form-control-sm form-filter kt-input" id="search_country" title="Country" data-col-index="2">
														<option value="">Select</option><?php echo $country_str; ?></select>`);
													break;

												case 'Stage / Source':
													input = $(`<select class="form-control form-control-sm form-filter kt-input" id="stage" title="Vendor Stage" data-col-index="3">
															<option value="">Select</option>
															<option value="1">Stage 1</option>
															<option value="2">Stage 2</option>
															<option value="3">Stage 3</option>
															<option value="4">Stage 4</option>
															<option value="5">Stage 0</option>
														</select><br/>
														<select class="form-control form-control-sm form-filter kt-input" id="vendor_source" title="Vendor Source" data-col-index="4">
															<option value="">Select</option>
															<option value="primary leads">Primary Leads</option>
															<option value="hetregenous leads">Hetregenous Leads</option>
														</select>`);
													break;

												case 'Actions':
													var search = $(`<button class="btn btn-brand kt-btn btn-sm kt-btn--icon">
													  <span>
													    <i class="la la-search"></i>
													    <span>Search</span>
													  </span>
													</button>`);

													var reset = $(`<button class="btn btn-secondary kt-btn btn-sm kt-btn--icon">
													  <span>
													    <i class="la la-close"></i>
													    <span>Reset</span>
													  </span>
													</button>`);

													$('<th>').append(search).append(reset).appendTo(rowFilter);

													$(search).on('click', function(e) {
														e.preventDefault();
														var params = {};
														$(rowFilter).find('.kt-input').each(function() {
															var i = $(this).data('col-index');
															if (params[i]) {
																params[i] += '|' + $(this).val();
															}
															else {
																params[i] = $(this).val();
															}
														});
														$.each(params, function(i, val) {
															// apply search params to datatable
															table.column(i).search(val ? val : '', false, false);
														});
														table.table().draw();
													});

													$(reset).on('click', function(e) {
														e.preventDefault();
														$(rowFilter).find('.kt-input').each(function(i) {
															$(this).val('');
															table.column($(this).data('col-index')).search('', false, false);
														});
														table.table().draw();
													});
													break;
											}

											if (column.title() !== 'Actions') {
												$(input).appendTo($('<th>').appendTo(rowFilter));
											}
											$("#search_country").select2();
										});

										 // hide search column for responsive table
										var hideSearchColumnResponsive = function () {
							            	thisTable.api().columns().every(function () {
									           	var column = this
									           	if(column.responsiveHidden()) {
										        	$(rowFilter).find('th').eq(column.index()).show();
									           	} else {
										        	$(rowFilter).find('th').eq(column.index()).hide();
									           	}
								           	})
						        		};

										// init on datatable load
										hideSearchColumnResponsive();
										// recheck on window resize
										window.onresize = hideSearchColumnResponsive;

										/*$('#lead_country, #lead_port, #lead_exporter_name, #lead_importer_name, #lead_nimporter_name').select2();*/
									},
									columnDefs: [
										{
											targets: -1,
											title: 'Actions',
											orderable: false,
											render: function(data, type, full, meta) {
												var connect_btn = '';
												if(full.vendor_dtl_id > 0){
													var connect_btn = `<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="`+full.vendor_dtl_id+`" >
														<i class="la la-comment"></i>
													</button>`;
												}

												return `<a href="<?php echo site_url('vendors/add_vendor/'); ?>`+full.vendor_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank"><i class="la la-info-circle"></i></a>`;
											},
										},
										{
											targets: 1,
											title: 'Vendor',
											orderable: true,
											render: function(data, type, full, meta){
												return `<img src="<?php echo site_url('assets/media/flags/'); ?>`+full.flag_name+`" class="img img-responsive rounded-circle" style="width: 30px"> `+full.vendor_name;
											}
										},
										{
											targets: 2,
											title: 'Stage / Source',
											orderable: true,
											render: function(data, type, full, meta){
												var stage = '<select class="stage_dropdown" id="dropdown'+full.vendor_id+'" vendor_id="'+full.vendor_id+'" ><option value=""></option>';
												if(full.stage == 1){
													stage += '<option value="1" selected="selected" id="grey">Stage 1</option>';
												}else{
													stage += '<option value="1" id="grey">Stage 1</option>';
												}

												if(full.stage == 2){
													stage += '<option value="2" selected="selected" id="yellow">Stage 2</option>';
												}else{
													stage += '<option value="2" id="yellow">Stage 2</option>';
												}

												if(full.stage == 3){
													stage += '<option value="3" selected="selected" id="orange">Stage 3</option>';
												}else{
													stage += '<option value="3" id="orange">Stage 3</option>';
												}

												if(full.stage == 4){
													stage += '<option value="4" selected="selected" id="green">Stage 4</option>';
												}else{
													stage += '<option value="4" id="green">Stage 4</option>';
												}

												if(full.stage == 5){
													stage += '<option value="5" disabled selected="selected" id="red">Stage 0</option>';
												}else{
													stage += '<option value="5" disabled id="red">Stage 0</option>';
												}
												
												stage += '</select>';

												return stage+` <br/><span style="font-weight: lighter; text-transform: capitalize;" class="source">`+full.source+`</span>`;
											}
										},
										{
											targets: 3,
											title: 'Name',
											orderable: true,
											render: function(data, type, full, meta){
												var name = ''; var designation = '';
												if(full.name != null){
													name = full.name;
												}

												if(full.designation != null){
													designation = full.designation;
												}
												return `<p> <span class="member_name">`+name+`</span> <br/> <span class="designation">`+designation+`</span></p>`;
											}
										},
										{
											targets: 4,
											title: 'Contact',
											render: function(data, type, full, meta){
												var email = ''; var mobile = '';
												if(full.email != null){
													email = `<span class="contact_span"><span class="email"><i class="la la-envelope"></i> `+full.email+`</span>
															</span>`;
												}

												if(full.mobile != null){
													mobile = `<span class="contact_span"><span class="mobile"><i class="la la-phone"></i> `+full.mobile+`</span>
															</span>`;
												}

												return `<p>`+email+`<br/>`+mobile+`</p>`;
											}
										},
										{
											targets: 5,
											title: 'Last Contact',
											render: function(data, type, full, meta){
												return `-`;
											}
										},
										{
											targets: 6,
											title: 'Comments',
											render: function(data, type, full, meta){
												return `-`;
											}
										},
									],
								});

							};

							return {

								//main function to initiate the module
								init: function() {
									initTable1();
								},
							};

						}();

						jQuery(document).ready(function() {
							KTDatatablesSearchOptionsColumnSearch.init();
						});

						$("#product").change(function(){
							var val = $(this).val();
							var dataTable = $('#vendors_list').DataTable();
							dataTable.draw();
						});

						$("#material").change(function(){
							var val = $(this).val();
							var dataTable = $('#vendors_list').DataTable();
							dataTable.draw();
						});
					<?php } ?>
				<?php } if($this->router->fetch_class() == 'proforma' && $this->router->fetch_method() == 'list') { ?>
					"use strict";
					var KTDatatablesDataSourceAjaxServer = function() {

						var initTable1 = function() {
							var table = $('#proforma_table');
							// begin first table
							var dt = table.DataTable({
								responsive: true,
								searchDelay: 500,
								processing: true,
								serverSide: true,
								ajax: '<?php echo site_url('proforma/list_data'); ?>',
								columns: [
									{data: 'record_id'},
									{data: 'proforma_no', responsivePriority: -1},
									{data: 'date', responsivePriority: -1},
									{data: 'month'},
									{data: 'week'},
									{data: 'client_name', responsivePriority: -1},
									{data: 'grand_total', responsivePriority: -1, render: $.fn.dataTable.render.number( ',', '.', 2 )},
									{data: 'country', responsivePriority: -1},
									{data: 'region', responsivePriority: -1},
									{data: 'WApp', responsivePriority: -1},
									{data: 'Actions', responsivePriority: -1},
								],
								columnDefs: [
									{
										targets: -1,
										title: 'Actions',
										orderable: false,
										render: function(data, type, full, meta) {
											return `
					                        <a href="<?php echo site_url('proforma/pdf/'); ?>`+full.quotation_mst_id+`" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md deleteOrder" title="Delete" quote_id="`+full.quotation_mst_id+`">
				                        		<i class="la la-trash"></i>
				                        	</button>`;
										},
									},
									{
										targets: 9,
										title: 'WApp',
										orderable: false,
										render: function(data, type, full, meta) {
											if(full.is_whatsapp == 'Y')
											{
												return `<a href="https://web.whatsapp.com/send?phone=`+full.mobile+`&text=" class="btn btn-xs btn-clean btn-icon btn-icon-sm" title="View Quotation Details" target="_blank" >
						                            <i class="la la-whatsapp"></i>
						                        </a>`;
											}else{
												return ``;
											}
										},
									},
									{
										targets: 0,
										orderable: false
									}
								],
							});
						};

						return {

							//main function to initiate the module
							init: function() {
								initTable1();
							},

						};

					}();

					jQuery(document).ready(function() {
						KTDatatablesDataSourceAjaxServer.init();
					});

					$("#proforma_table").on('click', '.deleteOrder', function(){
						if(confirm('Are you sure?') == true){
							var quote_id = $(this).attr('quote_id');
							$.ajax({
								type: "POST",
								data: {"quote_id": quote_id},
								url: "<?php echo site_url('proforma/deleteOrder');?>",
								success: function(){
									$("#proforma_table").DataTable().ajax.reload(null, false);
								}
							});
						}
					});
				<?php } if($this->router->fetch_class() == 'home' && $this->router->fetch_method() == 'dashboard' && $this->session->userdata('role') == 5) { ?>
					/*Target vs Achieved*/
					var opts = {
						angle: -0.2,
						lineWidth: 0.25,
						limitMax: 'true', 
						strokeColor: 'red',
						radiusScale: 1,
						generateGradient: true,
						pointer: {
							length: 0.5, // // Relative to gauge radius
							strokeWidth: 0.03, // The thickness
							color: 'orange' // Fill color
						},
						staticLabels: {
							font: "90% sans-serif",  // Specifies font
							labels: [],  // Print labels at these values
							color: "black",  // Optional: Label text color
							fractionDigits: 2  // Optional: Numerical precision. 0=round off.
						},  // just experiment with them
						strokeColor: 'red',   // to see which ones work best for you
						staticZones: [
							{strokeStyle: "#ff0000", min: 0, max: 30}, // Yellow
							{strokeStyle: "#FFFF00", min: 30, max: 70}, // Green
							{strokeStyle: "#228B22", min: 70, max: 100}, // Yellow
						],
						generateGradient: true
					};
					var target = document.getElementById('foo'); // your canvas element
					var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
					gauge.maxValue = 100; // set max gauge value
					gauge.animationSpeed = 32; // set animation speed (32 is default value)
					var x = 4;
					setInterval(gauge.set(x + 3),500);
					var target = document.getElementById('foo'); // your canvas element
					gauge.set(0);

					// randomly change value
					var randomize = function(){
						gauge.set(Math.floor(Math.random() * (100 - 1))); 
					};
					setTimeout(randomize, 1000);
					gauge.setTextField(document.getElementById("gauge1-txt"));
					/*Target vs Achieved End*/

					/*Sales Growth*/
					var seriesData = [['Jan', 256], ['Feb', 512], ['Mar', 1024], ['Apr', 2048], ['May', 600], ['Jun', 2100], ['Jul', 2300], ['Aug', 1600], ['Sep', 1800], ['Oct', 2300], ['Nov', 1500], ['Dec', 1024]];
					Highcharts.chart('container-sales-growth', {
					    chart: {
				        },

				        title: {
				        	text: 'Sales Growth'	
				        },

				        xAxis: {
				            tickInterval: 1,
				            labels: {
				                enabled: true,
				                formatter: function() { return seriesData[this.value][0];},
				            }
				        },

				        credits: {
						    enabled: false
						},
				        
				        series: [{
				        	showInLegend: false,
				            data: seriesData,
				            name: 'Month wise sales growth'    
				        }]
					});
					/*Sales Growth End*/

				<?php } if($this->session->userdata('role') == 5){ ?>
					$('#container-touch-points').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Touch Points for last 30 Days'
						},
						xAxis: {
						  	categories: [],
						  	title: {
						  		text: 'Date'
						  	}
						},
						yAxis: {
							title: {
								text: 'No. of Touch Points'
							}
						},
						plotOptions: {
							line: {
								dataLabels: {
							    	enabled: true
								},
								enableMouseTracking: false
							},
							column: {
						        zones: [{
						            value: 1, // Values up to 10 (not including) ...
						            color: 'red' // ... have the color blue.
						        }]
						    },
						    series: {
						    	cursor: 'pointer',
						    	point: {
						    		events: {
						    			click: function(e){
						    				//this.series.options.reasonText[this.category]);
						    				hs.htmlExpand(null, {
					                            pageOrigin: {
					                                x: e.pageX || e.clientX,
					                                y: e.pageY || e.clientY
					                            },
					                            headingText: this.series.name,
					                            maincontentText: this.category+' - '+this.series.options.reasonText[this.category],
					                            width: 300
					                        });
						    			}
						    		}
						    	}
						    }
						},
						credits: {
						    enabled: false
						},
						series: [{
							showInLegend: false,
							name: 'Touchpoints Report',
						  	data: [],
						  	reasonText: []
						}]
					});

					var qc_monthly_data = [];
					$.ajax({
						url: '<?php echo site_url('client/clientListJson'); ?>',
						success: function(res){
							var resp = $.parseJSON(res);
							var clients = resp.clients;
							var connects = resp.connect_list;
							var country = resp.country;
							var region = resp.region;
							qc_monthly_data = resp.monthly_count;
							var counts = resp.counts;
							var no_entry = resp.no_entry;

							$("#qc_performance #user_monthly_avg").html(counts.user_monthly_avg);
							$("#qc_performance #user_total_avg").html(counts.user_total_avg);
							$("#qc_performance #user_monthly_connects").html(counts.user_monthly_connects);
							$("#qc_performance #user_total_connects").html(counts.user_total_connects);
							$("#qc_performance #team_monthly_avg").html(counts.team_monthly_avg);
							$("#qc_performance #team_total_avg").html(counts.team_total_avg);

							var html = '';
							Object.keys(clients).forEach(function(key) {
								html += '<option value="'+clients[key].client_id+'">'+clients[key].client_name+'</option>';
							});
							$("#qc_client").append(html);

							var connect_tbl = ''; var i=1;
							Object.keys(connects).forEach(function(key){
								connect_tbl += '<tr><td>'+i+'</td><td>'+connects[key].connected_on+'</td><td>'+connects[key].client_name+'</td><td>'+connects[key].person_name+'</td><td>'+connects[key].contact_mode+'</td><td>'+connects[key].email_sent+'</td><td>'+connects[key].comments+'</td><td><button type="button" class="btn btn-icon btn-icon-md editConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem"><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem"><i class="la la-trash"></i></button></td></tr>';
								i++;
							});
							$("#qc_table tbody").html(connect_tbl);

							var country_option = '';
							Object.keys(country).forEach(function(key) {
								country_option += '<option value="'+country[key].lookup_id+'" region="'+country[key].parent+'">'+country[key].lookup_value+'</option>';
							});
							$("#qc_add_company #country").append(country_option);

							var region_option = '';
							Object.keys(region).forEach(function(key) {
								region_option += '<option value="'+region[key].lookup_id+'">'+region[key].lookup_value+'</option>';
							});
							$("#qc_add_company #region").append(region_option);
							//$("#quick_connect").validatonEngine({promptPosition: "inline"});
							
							var graph_data = [];
							var graph_key = [];
							var reason_obj = [];
							Object.keys(qc_monthly_data).forEach(function(key){
								var inner_key = qc_monthly_data[key].key;
								var inner_value = qc_monthly_data[key].value;
								var inner_reason = qc_monthly_data[key].reason;
								/*var inner_data = [];
								inner_data['"'+inner_key+'"'] = inner_value;*/
								graph_data.push(parseFloat(inner_value));
								graph_key.push(inner_key);
								if(inner_value == 0.5){
									reason_obj[inner_key] = inner_reason;
								}
							});

							var chart1 = $('#container-touch-points').highcharts();
							chart1.series[0].update({
								data: graph_data,
								reasonText: reason_obj
							}, false);

							chart1.xAxis[0].update({
								categories: graph_key
							}, false);

							chart1.redraw();

							var no_entry_html = ''; var sr = 1;
							Object.keys(no_entry).forEach(function(key){
								no_entry_html += '<tr><td>'+sr+'</td><td>'+no_entry[key]+'</td></tr>';
								sr++;
							});
							$("#qc_no_points #pendingUpdate tbody").html(no_entry_html);
						}
					});

					$("#qc_client").select2();

					$("#qc_frm").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var frm_data = $("#qc_frm").serialize();
								$("#qc_submit").attr('disabled', 'disabled');
								toastr.warning('Saving details');
								$.ajax({
									type: 'POST',
									data: frm_data,
									url: '<?php echo site_url('client/clientConnect'); ?>',
									success: function(res){
										toastr.clear();
										var resp = $.parseJSON(res);
										if(resp.status == 'cc_success'){
											var connects = resp.connect_list;
											var connect_tbl = ''; var i=1;
											Object.keys(connects).forEach(function(key){
												connect_tbl += '<tr><td>'+i+'</td><td>'+connects[key].connected_on+'</td><td>'+connects[key].client_name+'</td><td>'+connects[key].person_name+'</td><td>'+connects[key].contact_mode+'</td><td>'+connects[key].email_sent+'</td><td>'+connects[key].comments+'</td><td><button type="button" class="btn btn-icon btn-icon-md editConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem" ><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem"><i class="la la-trash"></i></button></td></tr>';
												i++;
											});
											$("#qc_table tbody").html(connect_tbl);
											$('.nav-tabs a[href="#connect_list"]').tab('show');
											$("#qc_member").html('');
											$("#qc_client").val('').trigger('change');
											$("#qc_connect_id").val('');
											$("#qc_frm").trigger("reset");
											$("#qc_submit").removeAttr('disabled');
											toastr.success('Saved successfully');
										}else {
											toastr.error('Something went wrong. Please try again.');
										}
									}
								});
							}
							return false;
						},
						promptPosition: "inline",
					});

					$("#qc_client").change(function(){
						if($(this).val() == ''){
							$("#qc_member, #qc_add_member").attr("disabled", "disabled");
						}else{
							$("#qc_member, #qc_add_member").removeAttr("disabled");
							$.ajax({
								type: 'POST',
								data: {'client_id': $(this).val()},
								url: '<?php echo site_url('client/getClientMembers'); ?>',
								success: function(res){
									var resp = $.parseJSON(res);
									var members = resp.members;
									var html = '<option value="" disabled>Select</option>';
									Object.keys(members).forEach(function(key) {
										html += '<option value="'+members[key].member_id+'" >'+members[key].name+'</option>';
									});
									$("#qc_member").html(html);
								}
							});
							$('#qc_add_company').modal('hide');
						}
					});

					$("#qc_add_company #addCompany").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								$.ajax({
									url: "<?php echo site_url('client/addClientAjax'); ?>",
									data: $("#qc_add_company #addCompany").serialize(),
									type: "POST",
									success: function(res){
										var resp = $.parseJSON(res);
										var client_id = resp.client_id;
										var clients = resp.clients;
										var html = '<option value="" disabled>Select</option>';
										Object.keys(clients).forEach(function(key) {
											var selected = '';
											if(client_id == clients[key].client_id){
												selected = 'selected="selected"';
											}
											html += '<option value="'+clients[key].client_id+'" '+selected+'>'+clients[key].client_name+'</option>';
										});
										$("#qc_client").html(html);
									}
								});
								$('#qc_add_company').modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
					});

					$("#qc_add_member #addMember").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var inputData = $("#qc_add_member #addMember").serializeArray();
								inputData.push({name: 'client_id', value: $("#qc_client").val()});
								$.ajax({
									url: "<?php echo site_url('client/addClientMemberAjax'); ?>",
									data: inputData,
									type: "POST",
									success: function(res){
										var resp = $.parseJSON(res);
										var member_id = resp.member_id;
										var members = resp.members;
										var html = '<option value="" disabled>Select</option>';
										Object.keys(members).forEach(function(key) {
											var selected = '';
											if(member_id == members[key].member_id){
												selected = 'selected="selected"';
											}
											html += '<option value="'+members[key].member_id+'" '+selected+'>'+members[key].name+'</option>';
										});
										$("#qc_member").html(html);
									}
								});
								$('#qc_add_member').modal('hide');
							}
							return false;
						},
						promptPosition: "inline"
					});

					$("#qc_frm").on('click', '.editConnect', function(){
						$("#qc_tabs a[href='#add_connect']").tab('show');
						var connect_id = $(this).attr('connect_id');
						toastr.warning('Fetching Details');
						$.ajax({
							type: 'POST',
							data: {'connect_id': connect_id},
							url: '<?php echo site_url('client/getConnectDetails'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								if(resp.hasOwnProperty('connect_id')){
									$("#qc_contacted_on").val(resp.contacted_on);
									$("#qc_client").val(resp.client_id).trigger('change');
									$("#qc_member").val(resp.member_id).trigger('change');
									$("#qc_contact_via").val(resp.contact_mode);
									$("#qc_email_sent").val(resp.email_sent);
									$("#qc_comments").val(resp.comments);
									$("#qc_connect_id").val(resp.connect_id);
								}
							}
						});
					});

					$("#qc_frm").on('click', '.deleteConnect', function(){
						if(confirm('Are you sure?')){
							toastr.warning('Deleting record');	
							var connect_id = $(this).attr('connect_id');
							$.ajax({
								type: 'POST',
								data: {'connect_id': connect_id},
								url: '<?php echo site_url('client/deleteConnect'); ?>',
								success: function(res){
									var resp = $.parseJSON(res);
									var connects = resp.connect_list;
									var connect_tbl = ''; var i=1;
									Object.keys(connects).forEach(function(key){
										connect_tbl += '<tr><td>'+i+'</td><td>'+connects[key].connected_on+'</td><td>'+connects[key].client_name+'</td><td>'+connects[key].person_name+'</td><td>'+connects[key].contact_mode+'</td><td>'+connects[key].email_sent+'</td><td>'+connects[key].comments+'</td><td><button type="button" class="btn btn-icon btn-icon-md editConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem" ><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteConnect" connect_id='+connects[key].connect_id+' style="font-size: 1rem"><i class="la la-trash"></i></button></td></tr>';
										i++;
									});
									$("#qc_table tbody").html(connect_tbl);
									toastr.success('Record deleted successfully');	
								}
							});
						}
					});

					$("#qc_cancel").click(function(){
						$("#qc_member").html('');
						$("#qc_client").val('').trigger('change');
						$("#qc_connect_id").val('');
						$("#qc_frm").trigger("reset");
					});

					$("#qc_add_company #country").change(function(){
						$("#qc_add_company #region").val($("#qc_add_company #country option:selected").attr('region'));
					});

					$("#qc_updateReason").click(function(){
						var qc_no_date = $("#qc_no_date").val();
						var qc_no_reason = $("#qc_no_reason").val();

						if(qc_no_date != '' && qc_no_reason != ''){
							$("#qc_updateReason").attr('disabled', 'disabled');
							toastr.warning('Updating details');
							$.ajax({
								type: "POST",
								data: {"qc_no_reason": qc_no_reason, "qc_no_date": qc_no_date},
								url: '<?php echo site_url('client/updateNoReason'); ?>',
								success: function(res){
									var resp = $.parseJSON(res);
									var no_entry = resp.no_entry;
									var no_entry_html = '';  var sr = 1;
									Object.keys(no_entry).forEach(function(key){
										no_entry_html += '<tr><td>'+sr+'</td><td>'+no_entry[key]+'</td></tr>';
										sr++;
									});
									$("#qc_no_points #pendingUpdate tbody").html(no_entry_html);
									$("#qc_updateReason").removeAttr('disabled');
									toastr.success('Details updated successfully');
								}
							});
						}else{
							toastr.warning('Please specify values for date and reason');
						}
					});

					$("#task_update_btn").click(function(){
						$.ajax({
							url: '<?php echo site_url('client/getTouchPointCounts'); ?>',
							success: function(res){
								var html = '';
								var resp = $.parseJSON(res);
								html = '<span><i class="la la-phone"></i> '+resp.call+'</span> / <span><i class="la la-whatsapp"></i> '+resp.whatsapp+'</span> / <span><i class="la la-linkedin"></i> '+resp.linkedIn+'</span>';
								$("#touch_points_count").html(html);
							}
						});

						$.ajax({
							url: '<?php echo site_url('home/getDailyUpdates'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								var list = resp.list;
								task_table = '';
								var i = 1;
								Object.keys(list).forEach(function(key){
									task_table += '<tr><td>'+i+'</td><td>'+list[key].date+'</td><td>'+list[key].task_accomplished+'</td><td>'+list[key].work_in_progress+'</td><td>'+list[key].plan_for_tomorrow+'</td><td><button type="button" class="btn btn-icon btn-icon-md editTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-trash"></i></button></td></tr>';
									i++;
								});
								$("#view_previous tbody").html(task_table);
							}
						});
					});

					$("#taskUpdate").validationEngine('attach', {
						onValidationComplete: function(form, status){
							if(status == true){
								var inputData = $("#taskUpdate").serializeArray();
								$.ajax({
									url: "<?php echo site_url('home/updateTask'); ?>",
									data: inputData,
									type: "POST",
									success: function(res){
										var resp = $.parseJSON(res);
										var list = resp.list;
										var status = resp.status;
										var msg = resp.msg;
										task_table = '';
										var i = 1;
										Object.keys(list).forEach(function(key){
											task_table += '<tr><td>'+i+'</td><td>'+list[key].date+'</td><td>'+list[key].task_accomplished+'</td><td>'+list[key].work_in_progress+'</td><td>'+list[key].plan_for_tomorrow+'</td><td><button type="button" class="btn btn-icon btn-icon-md editTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-trash"></i></button></td></tr>';
											i++;
										});
										$("#view_previous tbody").html(task_table);
										$("#taskUpdate input, #taskUpdate textarea, #taskUpdate hidden").each(function(){
											$(this).val('');
										});

										if(status == 'success')
										{
											toastr.success(msg);
										}else{
											toastr.warning(msg);
										}
									}
								});
							}
							return false;
						},
						promptPosition: "inline"
					});

					$("#view_previous").on('click', '.deleteTask', function(){
						if(confirm('Are you sure?')){
							var master_id = $(this).attr('master_id');
							$.ajax({
								type: 'POST',
								data: {'master_id' : master_id},
								url: '<?php echo site_url('home/deleteTask'); ?>',
								success: function(res){
									var resp = $.parseJSON(res);
									var list = resp.list;
									task_table = '';
									var i = 1;
									Object.keys(list).forEach(function(key){
										task_table += '<tr><td>'+i+'</td><td>'+list[key].date+'</td><td>'+list[key].task_accomplished+'</td><td>'+list[key].work_in_progress+'</td><td>'+list[key].plan_for_tomorrow+'</td><td><button type="button" class="btn btn-icon btn-icon-md editTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-edit"></i></button> <button type="button" class="btn btn-icon btn-icon-md deleteTask" master_id='+list[key].master_id+' style="font-size: 1rem" ><i class="la la-trash"></i></button></td></tr>';
										i++;
									});
									$("#view_previous tbody").html(task_table);
								}
							});
						}
					});

					$("#view_previous").on('click', '.editTask', function(){
						var master_id = $(this).attr('master_id');
						$.ajax({
							type: 'POST',
							data: {'master_id': master_id},
							url: '<?php echo site_url('home/getTaskDetails'); ?>',
							success: function(res){
								var resp = $.parseJSON(res);
								$("#add_new #date").val(resp.date);
								$("#add_new #task_accomplished").val(resp.task_accomplished);
								$("#add_new #work_in_progress").val(resp.work_in_progress);
								$("#add_new #plan_for_tomorrow").val(resp.plan_for_tomorrow);
								$("#add_new #master_id").val(resp.master_id);
								$('.nav-tabs a[href="#add_new"]').tab('show');
							}
						});
					});

					$("#taskUpdate #reset").click(function(){
						$("#taskUpdate input, #taskUpdate textarea, #taskUpdate hidden").each(function(){
							$(this).val('');
						});
					});

				<?php } ?>





				$("#pwd_change").validationEngine({promptPosition: "inline"});

				/*$("#quick_connect").validatonEngine('attach', {
					onValidationComplete: function(form, status){
						if(status == true){
							alert("here");
						}
						return false;
					},
					promptPosition: "inline"
				});*/


				// Class definition

				var KTBootstrapDatepicker = function () {

				    var arrows;
				    if (KTUtil.isRTL()) {
				        arrows = {
				            leftArrow: '<i class="la la-angle-right"></i>',
				            rightArrow: '<i class="la la-angle-left"></i>'
				        }
				    } else {
				        arrows = {
				            leftArrow: '<i class="la la-angle-left"></i>',
				            rightArrow: '<i class="la la-angle-right"></i>'
				        }
				    }
				    
				    // Private functions
				    var demos = function () {
				        // minimum setup
				        $('.hasdatepicker').datepicker({
				            rtl: KTUtil.isRTL(),
				            todayHighlight: true,
				            orientation: "bottom left",
				            templates: arrows,
				            format: 'dd-mm-yyyy',
				            /*endDate: '+0d'*/
				        });
				    }

				    return {
				        // public functions
				        init: function() {
				            demos(); 
				        }
				    };
				}();

				jQuery(document).ready(function() {    
				    KTBootstrapDatepicker.init();
				});
			});

			function filldata(client_id, client_name, client_rank, last_purchased, client_source){
				$("#rfq_company").val(client_name);
				$("#rfq_company_hidden").val(client_id);client_source
				$("#client_source").val(client_source);
				$("#rfq_rank").val(client_rank);
				$("#rfq_lastbuy").val(last_purchased);
				$("#company_result").html('').hide();

				var client_id = $("#rfq_company_hidden").val();
				var client_source = $("#client_source").val();
				$.ajax({
					type: 'post',
					data: {'client_id': client_id, 'source': client_source},
					url: '<?php echo site_url('procurement/getMembers'); ?>',
					success: function(res){
						var resp = $.parseJSON(res);
						var html = '<option value="">Choose Buyer</option>';
						var member_id = '<?php if(isset($rfq_details)){ echo $rfq_details[0]['rfq_buyer']; } ?>';
						var selected = '';
						Object.keys(resp).forEach(function(key) {
							selected = '';
							if(member_id == resp[key].member_id){
								selected = 'selected="selected"';
							}
							html += '<option value="'+resp[key].member_id+'" '+selected+'>'+resp[key].member_name+'</option>';
						});
						$("#rfq_buyer").html(html);
					}
				});
			}

			function fillMTCData(client_id, client_name, mtc_str_id, mtc_str, mtc_for){
				$("#"+mtc_for).val(mtc_str);
				$("#"+mtc_for+"_hidden").val(mtc_str_id);
				$("#mtc_company").val(client_name);
				$("#mtc_company_id").val(client_id);
				$("#"+mtc_for+"_res").html('').hide();
			}

			function fillMarkingData(client_id, client_name, member_id, member_name, assigned_to, mtc_str_id, mtc_str, mtc_for){
				$("#"+mtc_for).val(mtc_str);
				$("#"+mtc_for+"_hidden").val(mtc_str_id);
				$("#marking_company").val(client_name);
				$("#marking_company_id").val(client_id);
				$("#marking_member").val(member_name);
				$("#marking_member_id").val(member_id);
				$("#assigned_to").val(assigned_to);
				$("#"+mtc_for+"_res").html('').hide();
				var product = <?php if(isset($product)){ echo json_encode($product); } else { echo "''"; } ?>;
				var material = <?php if(isset($material)){ echo json_encode($material); } else { echo "''"; } ?>;
				$.ajax({
					type: 'POST',
					data: {quotation_mst_id: mtc_str_id},
					url: '<?php echo site_url('quality/getLineItems'); ?>',
					success: function(res){
						var resp = $.parseJSON(res);
						var html = '';var i=1;
						Object.keys(resp).forEach(function(key) {
							product_dd = `<select class="form-control product" name="product[]">
								<option value="">Select</option>
							`;
							Object.keys(product).forEach(function(key1){
								var selected = '';
								if(resp[key].product_id == product[key1].lookup_id){
									selected = 'selected="selected"';
								}
								product_dd += `<option value="`+product[key1].lookup_id+`" `+selected+`>`+product[key1].lookup_value+`</option>`;
							});
							product_dd += `</select>`;

							material_dd = `<select class="form-control material" name="material[]">
								<option value="">Select</option>
							`;
							Object.keys(material).forEach(function(key2){
								var selected = '';
								if(resp[key].material_id == material[key2].lookup_id){
									selected = 'selected="selected"';
								}
								material_dd += `<option value="`+material[key2].lookup_id+`" `+selected+`>`+material[key2].lookup_value+`</option>`;
							});
							material_dd += `</select>`;

							html += `
								<tr>
									<td>`+i+`</td>
									<td>`+resp[key].description+`</td>
									<td>`+resp[key].quantity+`</td>
									<td>`+resp[key].unit+`</td>
									<td>`+product_dd+`</td>
									<td>`+material_dd+`</td>
									<td><input class="form-control heat_number" name="heat_number[]" type="text" placeholder="Heat Number"> <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md generateHeat" title="Generate Heat Number" quote_dtl_id="`+resp[key].quotation_dtl_id+`"><i class="la la-download"></i></button><input type="hidden" name="quote_dtl_id[]" value="`+resp[key].quotation_dtl_id+`"></td>
									<td><input class="form-control" type="text" placeholder="Specifications" name="specification[]"></td>
									<td><textarea class="form-control" name="marking[]"></textarea></td>
									<td><button type="button" class="btn btn-sm btn-danger delRow">Delete</button></td>
								</tr>
							`;
							i++;
						});
						$("#marking_tbody").html(html);
					}
				});
			}
		</script>

		<?php /*<!-- 3. AddChat JS -->
        <!-- Modern browsers -->
        <script  type="module" src="<?php echo base_url('assets/addchat/js/addchat.min.js') ?>"></script>
        <!-- Fallback support for Older browsers -->
        <script nomodule src="<?php echo base_url('assets/addchat/js/addchat-legacy.min.js') ?>"></script>*/?>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>