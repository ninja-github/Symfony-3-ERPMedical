/* Guía http://easyautocomplete.com/guide */
/*
 * Funciones del Plugin JavaScript EASYAUTOCOMPLETE
 * Más información en http://easyautocomplete.com
 */
$(document).ready(function(){
	var searchRequest = null;
	var value = null ;
	searchRequest = $.ajax({
		type: "POST",			// Método de envío
		url: "/searchcity",		// Url del controlador
		data:{
			'cityInformation' : value
		},		// variable que enviaremos
		dataType:"json",
		success: function(response){
			var options = {
				data: response,
				requestDelay: 500,
				placeholder: "",
				list: {
					maxNumberOfElements: 6,
					match: {
						enabled: true
					}
				}
			};
//			console.log(response);
			$("#medical_history_city").easyAutocomplete(options);
			// eliminamos el atributo style que genera automáticamente el plugin
			$('div.easy-autocomplete').removeAttr('style');
		}

	});
});
/***************************************************************************/
/*
$(document).ready(function(){
	var searchRequest = null;
	$("#medical_history_idAddressCity").keydown(function(){
		var minlength = 0;
		var that = this;
		var value = $(this).val();
		if (value.length >= minlength ) {
			console.log('busqueda activada para' + value);
			if (searchRequest != null)
				searchRequest.abort();
				searchRequest = $.ajax({
				type: "POST",						// Método de envío
				url: "/searchcity",					// Url del controlador
				data:{ 'cityInformation' : value},	// variable que enviaremos
				dataType:"json",
				success: function(response){
					var options = {
						data: response,
						requestDelay: 500,
						placeholder: "Introduzca Código Postal",
						list: {
							maxNumberOfElements: 6,
							match: {
								enabled: true
							}
						}
					};
					optionsGlobal = options;
					console.log(response);
					$("#medical_history_idAddressCity").easyAutocomplete(options);
					//  Funciones del Plugin JavaScript EASYAUTOCOMPLETE, Más información en http://easyautocomplete.com
					// eliminamos el atributo style que genera automáticamente el plugin
					$('div.easy-autocomplete').removeAttr('style');
				}

			});
		}
	});
});
*/
