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
		url: "/searchmedicalhistory",		// Url del controlador
		data:{
			'medicalhistory' : value
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
			 console.log(response);
			$("#medicalHistoryDataComplete").easyAutocomplete(options);
			// eliminamos el atributo style que genera automáticamente el plugin
			$('div.easy-autocomplete').removeAttr('style');
		}

	});
});
/***************************************************************************/