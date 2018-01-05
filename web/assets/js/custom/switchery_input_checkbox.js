	$(document).ready(function() {
	    $('span.switchery').click(function() {
	    	console.log('span');
	    	var input_affected = $(this).prev('input');
	    	console.log(input_affected);
	    	if (input_affected.prop('checked') && input_affected.attr('value',1)){
	    		console.log('tiene');
				input_affected.attr('value',0);
	    	}else{
				console.log('no tiene');	    		
				input_affected.attr('value',1);
	    	}
	        });
	});