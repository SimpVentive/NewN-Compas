jQuery(document).ready(function(){
	jQuery("#materialform").validationEngine();
});
$(document).ready(function(){
	var date1 = new Date();
	var date2 = new Date(2039,0,19);
	var timeDiff = Math.abs(date2.getTime() - date1.getTime());
	var difDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
	
	var dates = $( "#start_date, #end_date" ).datepicker({dateFormat:"dd-mm-yy",
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 1,
	//minDate:0,
	maxDate:difDays,
	//showOn: "button", buttonImage: BASE_URL+"/public/images/calendar.jpg", 
	//buttonImageOnly: true,
	onSelect: function( selectedDate ) { 
	var option = this.id === "start_date" ? "minDate" : "maxDate",
	instance = $( this ).data( "datepicker" ),
	date = $.datepicker.parseDate(
	instance.settings.dateFormat ||
	$.datepicker._defaults.dateFormat,
	selectedDate, instance.settings );
	dates.not( this ).datepicker( "option", option, date );
	}
	});				   
});

function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}

function isFiletype(filename) {
    var ext = getExtension(filename);
    switch (ext.toLowerCase()) {
    //case 'pdf':
    //case 'webm':
    //case 'mp4':
    case 'zip':
        //etc
        return true;
    }
    return false;
}

 function isFiletypenon(filename,material_type) {
    var ext = getExtension(filename);
	
	material_type=material_type.trim();
	
	if(material_type==""){
		if (ext.toLowerCase()=='pdf' || ext.toLowerCase()=='webm' || ext.toLowerCase()=='mp4' || ext.toLowerCase()=='ppt' || ext.toLowerCase()=='pptx') {
			return true;
		}
		else{
			return false;
		}
	}
	else{
		if(material_type=="PDF" || material_type=="PPT" || material_type=="PPTX"){
			if (ext.toLowerCase()=='pdf' || ext.toLowerCase()=='ppt' || ext.toLowerCase()=='pptx') {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			if (ext.toLowerCase()=='webm' || ext.toLowerCase()=='mp4') {
				return true;
			}
			else{
				return false;
			}
		}
	}
} 

 function checkfiletype(field, rules, i, options){
    var check=isFiletype(field.val());
    if(!check){
        return options.allrules.materialformat.alertText;
    }
}

function checkfiletypenon(field, rules, i, options){
	if(document.getElementById("material_type")){
		var material_type=document.getElementById("material_type").value;
		//alertify.alert(material_type);
		var check=isFiletypenon(field.val(),material_type);
		if(!check){
			return options.allrules.materialformat2.alertText;
		}
	}
} 

function open_link(){
	var upload=document.getElementById('material_type').value;
	
	if(upload=="LINK"){
		document.getElementById('course').style.display='block';
		document.getElementById('import').style.display='none';
	}
	else{
		document.getElementById('import').style.display='block';
		document.getElementById('course').style.display='none';
	}
	
}