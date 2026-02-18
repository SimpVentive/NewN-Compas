$('.scrollable').each(function () {
	var $this = $(this);
	$(this).ace_scroll({
		size: $this.data('height') || 480,
		//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
	});
});
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'glyphicon-folder-open', closedClass:'glyphicon-folder-close'});

$('#tree3').treed({openedClass:'glyphicon-chevron-right', closedClass:'glyphicon-chevron-down'});

function search_program(){
	var cat_ids=document.getElementById('default_cat').value;
	var cat_id="";
	var program_name=document.getElementById('program_name').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	document.getElementById('program_search_one').innerHTML="<img style='padding-left:350px;' src='"+BASE_URL+"/public/images/outsell_loading.gif'/>";
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("program_search_one").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 500,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_programs_emp_add?cat_id="+cat_id+"&program_name="+program_name+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&cat_ids="+cat_ids,true);
	xmlhttp.send();

}
function open_cat_programs_search(id){
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
	var program_name="";
	var cat_ids="";
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("program_search_one").innerHTML=xmlhttp.responseText;
			$('.scrollable').each(function () {
		var $this = $(this);
		$(this).ace_scroll({
			size: $this.data('height') || 500,
			//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
		});
	});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_programs_emp_add?cat_id="+id+"&program_name="+program_name+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&cat_ids="+cat_ids,true);
	xmlhttp.send();

}

function open_program_info(id){
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("program_info").innerHTML=xmlhttp.responseText;
			
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/manager_program_info?pro_id="+id,true);
	xmlhttp.send();

}

function open_program_info_emp(id){
	document.getElementById("program_info_emp").innerHTML="";
	var tna_admin_id=document.getElementById('tna_admin_id').value;
	var tna_id=document.getElementById('tna_id').value;
	var status_n=document.getElementById('status').value;
	var cat_id=document.getElementById('cat_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("program_info_emp").innerHTML=xmlhttp.responseText;
			$('#scrollable').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 400,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/admin_program_addemp?pro_id="+id+"&status="+status_n+"&tna_id="+tna_id+"&tna_admin_id="+tna_admin_id+"&cat_id="+cat_id,true);
	xmlhttp.send();

}


function open_employee_data(){
	document.getElementById("info_emp").innerHTML="";
	var org_id=document.getElementById('organisation_id').value;
	var zones_id=document.getElementById('zones').value;
	var state_id=document.getElementById('states').value;
	var loc_id=document.getElementById('location_id').value;
	var pro_id=document.getElementById('pro_id').value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("info_emp").innerHTML=xmlhttp.responseText;
			document.getElementById("submit_action").style.display="block";
			$('.scrollable').each(function () {
				var $this = $(this);
				$(this).ace_scroll({
					size: $this.data('height') || 300,
					//styleClass: 'scroll-left scroll-margin scroll-thin scroll-dark scroll-light no-track scroll-visible'
				});
			});
		}
	}
	xmlhttp.open("GET",BASE_URL+"/admin/emp_details_tna?org_id="+org_id+"&zones_id="+zones_id+"&state_id="+state_id+"&loc_id="+loc_id+"&pro_id="+pro_id,true);
	xmlhttp.send();

}

function selectAll(source) {
	checkboxes = document.getElementsByName('emp_id[]');
	for(var i in checkboxes)
	checkboxes[i].checked = source.checked;
}

function open_zones(){    
     var zone_id=document.getElementById('zones').value;
     var xmlhttp;
     if (window.XMLHttpRequest)
     {// code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp=new XMLHttpRequest();
     }
     else
     {// code for IE6, IE5
         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.onreadystatechange=function()
     {
         if (xmlhttp.readyState==4 && xmlhttp.status==200)
         {
             $('#states').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/zone_states_tna?zone_id="+zone_id,true);
     xmlhttp.send();
}

function open_location_state(){  
	var zone_id=document.getElementById('zones').value;
     var state_id=document.getElementById('states').value;
     var xmlhttp;
     if (window.XMLHttpRequest)
     {// code for IE7+, Firefox, Chrome, Opera, Safari
         xmlhttp=new XMLHttpRequest();
     }
     else
     {// code for IE6, IE5
         xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.onreadystatechange=function()
     {
         if (xmlhttp.readyState==4 && xmlhttp.status==200)
         {
             $('#location_id').html(xmlhttp.responseText);
         }
     }
     xmlhttp.open("GET",BASE_URL+"/admin/states_emp_tna?zone_id="+zone_id+"&state_id="+state_id,true);
     xmlhttp.send();
}