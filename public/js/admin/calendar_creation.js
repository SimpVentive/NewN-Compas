jQuery(document).ready(function(){
	jQuery("#calendar_creation").validationEngine();
	
	
});

$(document).ready(function(){
		   var dates = $( "#from_date, #to_date" ).datepicker({dateFormat:"dd-mm-yy",
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		/*minDate:" date('d-m-Y');",
		maxDate:"<?php //echo $futureDate;?>",*/
		//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
		//buttonImageOnly: true,
		onSelect: function( selectedDate ) { 
			var option = this.id == "from_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
											}
									});

});
      
