/* GENERA EL PRIMER INPUT para UN NUEVO SERVICIO EN EL SEGUIMIENTO (TRACING SERVICE) ***************************************************/
	function frist_tracing_service(id){
		// id hace referencia al id del tracing
		var fristRequest = null;
		var exist_frist_tracing = document.getElementById('add_line_tracing_service('+id+')');
		if( exist_frist_tracing === null ){
			fristRequest = $.ajax({
				type: "POST",			// Método de envío
				url: "/generateformtracingservice",		// Url del controlador
				data: {
					'id' : id
				},
				success: function(response){
					var table = document.createElement('table');
					table.setAttribute('class', 'table table-striped jambo_table bulk_action');
					table.setAttribute('style', 'margin-bottom: 0px;');
					var tableinside = 
						'<thead>'+
							'<tr class="headings">'+
								'<th class="column-title" style="display: table-cell; table-layout: fixed; width:270px;">'+
									'Servicio'+
								'</th>'+
								'<th class="column-title" style="display: table-cell;">'+
									'Descripción'+
								'</th>'+
								'<th class="column-title" style="display: table-cell; width: 50px; text-align:right;">'+
									'Precio'+
								'</th>'+
								'<th class="column-title" style="display: table-cell; width: 50px; text-align:right;">'+
									'Pago'+
								'</th>'+
								'<th class="column-title" style="display: table-cell; width: 95px; text-align:right;">'+
									'Forma'+
								'</th>'+
								'<th class="column-title" style="display: table-cell; width:60px;">'+
									'<i class="fa fa-minus-square m-right-xs"></i> / '+
									'<i class="fa fa-plus-square m-right-xs" onclick="add_line_tracing_service('+id+');" style="cursor: pointer; cursor: hand; margin:5px;"></i>'+
								'</th>'+
							'</tr>'+
						'</thead>'+
						'<tbody id="add_line_tracing_service('+id+')">'+
							'<tr class="even pointer" id="send_tracing_service('+id+')">'+
							response+
							'</tr>'+
						'</tbody>';
					table.innerHTML= tableinside;
					var tracing = document.getElementById('tracing_'+id).lastElementChild;
					tracing.appendChild(table);
				}
			});	

		}else{
			var status = document.getElementById('status');
			status.innerHTML = 	
				'<div class="alert alert-danger fade in" role="alert">'+
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
						'<span aria-hidden="true">×</span>'+
					'</button>'+
					'Completa primero la entrada actual.&nbsp;&nbsp;'+
				'</div>';
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 3000);
		};
	};
/***************************************************************************************************************************************/
/* AÑADE UNA LÍNEA DE SERVICIOS (TRACING SERVICE) **************************************************************************************/
	function add_line_tracing_service(id) {
		// id hace referencia al id del tracing
		var addRequest = null;
		var exist_row = document.getElementById('send_tracing_service('+id+')');
		if(exist_row === null ){
			var addRequest = null;
			addRequest = $.ajax({
				type: "POST",			// Método de envío
				url: "/generateformtracingservice",		// Url del controlador
				data: {
					'id' : id
				},
				success: function(response){
					var row = document.createElement('tr');
					row.setAttribute('class', 'even pointer');
					row.setAttribute('id', 'send_tracing_service('+id+')');
					row.innerHTML = response;
					var table = document.getElementById('add_line_tracing_service('+id+')');
					table.appendChild(row);

				}
			});
		}else{
			var status = document.getElementById('status');
			status.innerHTML = 	
				'<div class="alert alert-danger fade in" role="alert">'+
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
						'<span aria-hidden="true">×</span>'+
					'</button>'+
					'Completa primero la entrada actual.&nbsp;&nbsp;'+
				'</div>';
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 3000);
		};
	};
/***************************************************************************************************************************************/
/* ELIMINA UNA LÍNEA DE SERVICIOS (TRACING SERVICE) ************************************************************************************/
	function remove_line_tracing_service(id) {
		// id hace referencia al id del treacing service
		var removeRequest = null;
		removeRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/removetracingservice",		// Url del controlador
			data: {
				'id' : id
			},
			success: function(response){
				document.getElementById('remove_tracing_service_'+id).parentNode.remove();
				var status = document.getElementById('status');
				status.innerHTML = response;
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);
			}
		});
	};
/***************************************************************************************************************************************/
/* ELIMINA UNA PAYMENT *****************************************************************************************************************/
	function remove_line_payment(id) {
		// id hace referencia al id del treacing service
		var removeRequest = null;
		removeRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/removepayment",		// Url del controlador
			data: {
				'id' : id
			},
			success: function(response){
				document.getElementById('remove_payment_'+id).parentNode.remove();
				var status = document.getElementById('status');
				status.innerHTML = response;
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);
			}
		});
	};
/***************************************************************************************************************************************/
/* ENVÍA UNA LÍNEA DE SERVICIOS (TRACING SERVICE) **************************************************************************************/
	function send_tracing_service(tracingDay){
		// id hace referencia al id del tracing	
		var sendRequest = null;
		var row = document.getElementById('send_tracing_service('+tracingDay+')');
		var indexService = document.getElementById('tracing_service['+tracingDay+'][service][service]');
		var textService = indexService.options[indexService.selectedIndex].text;
		var valueService = indexService.options[indexService.selectedIndex].value;
		var valueDescription = document.getElementById('tracing_service['+tracingDay+'][service][description]').value;
		var valuePrice = document.getElementById('tracing_service['+tracingDay+'][service][price]').value;
		var valuePayment = document.getElementById('tracing_service['+tracingDay+'][service][payment]').value;
		var indexPaymentType = document.getElementById('tracing_service['+tracingDay+'][service][paymentType]');
		var valuePaymentType = indexPaymentType.options[indexPaymentType.selectedIndex].value;
		var textPaymentType = indexPaymentType.options[indexPaymentType.selectedIndex].text;
		console.log('servicio seleccionado: '+indexService
			+', con texto: '+textService
			+' y valor del servicio: '+valueService
			+'servicio valor de Descripción: '+valueDescription 
			+', precio: '+valuePrice
			+' y pago: '+ valuePayment);
		sendRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/sendnewtracingservice",		// Url del controlador
			data: {
				'id' : tracingDay,
				'valueService' : valueService,
				'valueDescription' : valueDescription,
				'valuePrice' : valuePrice,
				'valuePayment' : valuePayment,
				'valuePaymentType' : valuePaymentType,			
			},
			success: function(response){
				var obj = JSON.parse(response);
				//console.log(obj);
				document.getElementById('send_tracing_service('+tracingDay+')').remove();
				var row = document.createElement('tr');
				row.setAttribute('class', 'even pointer');
				console.log(valuePaymentType);
				row.innerHTML = 
					'<td class=" ">'
						+textService+
					'</td>'+
					'<td class=" ">'
						+valueDescription+
					'</td>'+
					'<td class=" ">'
						+valuePrice+
					'</td>'+
					'<td class=" ">'
						+valuePayment+
					'</td>'+
					'<td class=" ">'
						+textPaymentType+
					'</td>'+				
					'<td class=" " style="text-align: center;" id="remove_tracing_service_'+obj.idTracingService+'">'+
						'<i class="fa fa-minus-square m-right-xs" onclick="remove_line_tracing_service('+obj.idTracingService+');"></i>'+
					'</td>';
				var table = document.getElementById('add_line_tracing_service('+tracingDay+')');
				table.appendChild(row);
				var status = document.getElementById('status');
				status.innerHTML = obj['alert'];
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);				
			}
		});
	};
/***************************************************************************************************************************************/
/* ENVÍA UNA NUEVO PAGO DE SERVICIO (TRACING SERVICE) **********************************************************************************/
	function send_payment_tracing_service(tracingDay,tracingService){
		// id hace referencia al id del tracing	
		var sendRequest = null;
		var row = document.getElementById('send_payment_tracing_service('+tracingDay+')');
		var valuePayment = document.getElementById('tracing_service['+tracingDay+'][service][payment]').value;
		var serviceData = document.getElementById('service_data('+tracingService+')').innerHTML;
		var indexPaymentType = document.getElementById('tracing_service['+tracingDay+'][service][paymentType]');
		var valuePaymentType = indexPaymentType.options[indexPaymentType.selectedIndex].value;
		var textPaymentType = indexPaymentType.options[indexPaymentType.selectedIndex].text;	
		console.log(serviceData);
		console.log(tracingService);
		sendRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/sendnewpaymenttracingservice",		// Url del controlador
			data: {
				'id' : tracingDay,
				'tracingService': tracingService,
				'valuePayment' : valuePayment,
				'valuePaymentType' : valuePaymentType,			
			},
			success: function(response){
				var obj = JSON.parse(response);
				console.log(obj);
				document.getElementById('send_payment_tracing_service('+tracingDay+','+tracingService+')').remove();
				var row = document.createElement('tr');
				row.setAttribute('class', 'even pointer');
				row.innerHTML = 
					'<td class=" " colspan="3">'
						+serviceData+
					'<td class=" ">'
						+valuePayment+
					'€ </td>'+
					'<td class=" ">'
						+textPaymentType+
					'</td>'+				
					'<td class=" " style="text-align: center;" id="remove_payment_'+obj.idPayment+'">'+
						'<i class="fa fa-minus-square m-right-xs" onclick="remove_line_payment('+obj.idPayment+');"></i>'+
					'</td>';
				var table = document.getElementById('add_line_tracing_service('+tracingDay+')');
				table.appendChild(row);
				var status = document.getElementById('status');
				status.innerHTML = obj['status'];
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);
			}
		});
	};
/***************************************************************************************************************************************/
/* CAMBIA EL ESTADO CONTABLE DE UN PAGO DE CONTABLE A NO CONTABLE (TRACING SERVICE) ****************************************************/
	function change_countable_state(id){
	sendRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/changecountablepayment",		// Url del controlador
			data: {
				'id' : id			
			},
			success: function(response){
				//document.getElementById('send_tracing_service('+id+')').remove();
				var arrayResponse = JSON.parse(response);
				/* Comentarios consola con información *********************************************************************************/
					console.log('Cambio de estado realizado al servicio con id: '+ id);;
					console.log('Mes y año: ' + arrayResponse['monthYear']);
					console.log('Nuevo Valor: ' + arrayResponse['countable']);
				/***********************************************************************************************************************/
				var countableData = document.getElementById('countable_'+arrayResponse['monthYear']);
				countableData.innerHTML = parseFloat(arrayResponse['countable']).toFixed(2).toString().replace(".",",");
				var status = document.getElementById('status');
				status.innerHTML = arrayResponse['status'];
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);
			}
		});
	};
/***************************************************************************************************************************************/
/* CAMBIA EL ESTADO CONSOLIDADO DE UN PAGO DE CONSOLIDADO A NO CONSOLIDADO (TRACING SERVICE) *******************************************/
	function change_consolidated_state(id){
		sendRequest = $.ajax({
			type: "POST",			// Método de envío
			url: "/changeconsolidatedpayment",		// Url del controlador
			data: {
				'id' : id			
			},
			success: function(response){
				var arrayResponse = JSON.parse(response);
				var permission = arrayResponse['permission'];
				console.log(permission);
				if(permission == true){
					/* Comentarios consola con información *********************************************************************************/
						console.log('Cambio de estado consolidade realizado al servicio con id: '+ id);
					/***********************************************************************************************************************/
						var consolidatedStateTracingService = document.getElementById('consolidatedState_'+id);
						var countableStateTracingService = document.getElementById('countableState_'+id);
						var paymentRow = document.getElementById('payment_'+id);
						var attribute = consolidatedStateTracingService.getAttribute('class');
						if(attribute == 'fa fa-times m-right-xs'){
							consolidatedStateTracingService.removeAttribute('class');
							consolidatedStateTracingService.setAttribute('class','fa fa-check m-right-xs');
							countableStateTracingService.removeAttribute('disabled');
							paymentRow.style.backgroundColor='';
						}else if(attribute == 'fa fa-check m-right-xs'){
							consolidatedStateTracingService.removeAttribute('class');
							consolidatedStateTracingService.setAttribute('class','fa fa-times m-right-xs');
							countableStateTracingService.setAttribute('disabled','');
							paymentRow.style.backgroundColor='rgba(63,83,103, 0.2)';
						}
						console.log(attribute);
				}
				/* Cargo el mensaje flash ********************************************************************************************/
				var status = document.getElementById('status');
				status.innerHTML = arrayResponse['status'];
				window.setTimeout(function() {
					$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();
					});
				}, 3000);
			}
		});
	};
/***************************************************************************************************************************************/
