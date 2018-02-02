$("[id ^= datepicker]").daterangepicker({
    "showDropdowns": true,
    "timePicker": true,
    "timePicker24Hour": true,
    "locale": {
		        "format": "DD/MM/YY hh:mm",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    }
}, function(start, end, label) {
	var range = start.format('DD/MM/YY hh:mm') + ' - ' + end.format('DD/MM/YY hh:mm');
	$("[id ^= editDateTimeRange]").val(range);
});


