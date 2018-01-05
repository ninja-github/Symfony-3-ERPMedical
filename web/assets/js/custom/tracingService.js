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

function send_tracing_service(id){
	// id hace referencia al id del tracing	
	var sendRequest = null;
	var row = document.getElementById('send_tracing_service('+id+')');
	var indexService = document.getElementsByName('tracing[service][service]')[0].selectedIndex;
	var valueService = document.getElementsByTagName("option")[indexService].value;
	var textService = document.getElementsByTagName("option")[indexService].text;
	var valueDescription = document.getElementsByName('tracing[service][description]')[0].value;
	var valuePrice = document.getElementsByName('tracing[service][price]')[0].value;
	sendRequest = $.ajax({
		type: "POST",			// Método de envío
		url: "/sendnewtracingservice",		// Url del controlador
		data: {
			'id' : id,
			'valueService' : valueService,
			'valueDescription' : valueDescription,
			'valuePrice' : valuePrice
		},
		success: function(response){
			var obj = JSON.parse(response);
			console.log(obj);
			document.getElementById('send_tracing_service('+id+')').remove();
			var row = document.createElement('tr');
			row.setAttribute('class', 'even pointer');
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
				'<td class=" " style="text-align: center;" id="remove_tracing_service_'+obj.idTracingService+'">'+
					'<i class="fa fa-minus-square m-right-xs" onclick="remove_line_tracing_service('+obj.idTracingService+');"></i>'+
				'</td>';
			var table = document.getElementById('add_line_tracing_service('+id+')');
			table.appendChild(row);
		}
	});
};

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
							'<th class="column-title" style="display: table-cell; table-layout: fixed;">'+
								'Servicio'+
							'</th>'+
							'<th class="column-title" style="display: table-cell;">'+
								'Descripción'+
							'</th>'+
							'<th class="column-title" style="display: table-cell; width: 75px;">'+
								'Precio'+
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