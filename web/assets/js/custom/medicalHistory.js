function changeUpdated(id){
	sendRequest = $.ajax({
		type: "POST",			// Método de envío
		url: "/changeUpdatedMedicalHistory",		// Url del controlador
		data: {
			'id' : id			
		},
		success: function(response){
			//document.getElementById('send_tracing_service('+id+')').remove();
			var arrayResponse = JSON.parse(response);
			var status = document.getElementById('status');
			status.innerHTML = arrayResponse['status'];
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 3000);
		}
	});		
}
function add_late(id){
	sendRequest = $.ajax({
		type: "POST",			// Método de envío
		url: "/addLateMedicalHistory",		// Url del controlador
		data: {
			'id' : id			
		},
		success: function(response){
			//document.getElementById('send_tracing_service('+id+')').remove();
			var arrayResponse = JSON.parse(response);
			var late = document.getElementById('medical_history_late');
			late.innerHTML = ' '+arrayResponse['late'];
			var status = document.getElementById('status');
			status.innerHTML = arrayResponse['alert'];
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 3000);
		}
	});		
}
function remove_late(id){
	sendRequest = $.ajax({
		type: "POST",			// Método de envío
		url: "/removeLateMedicalHistory",		// Url del controlador
		data: {
			'id' : id			
		},
		success: function(response){
			//document.getElementById('send_tracing_service('+id+')').remove();
			var arrayResponse = JSON.parse(response);
			var late = document.getElementById('medical_history_late');
			late.innerHTML = ' '+arrayResponse['late'];
			var status = document.getElementById('status');
			status.innerHTML = arrayResponse['alert'];
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 3000);
		}
	});		
}