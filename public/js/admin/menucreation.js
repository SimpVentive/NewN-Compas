function childmenu(){    
    var menu=document.getElementById("page_type").value;
    //toastr.error(menu);
    var xmlhttp;
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{
        // code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            //toastr.error(xmlhttp.responseText);
            document.getElementById("submenus").style.display='none';
            document.getElementById("submenu").style.display='block';
            document.getElementById("submenu").innerHTML=xmlhttp.responseText;	
            //toastr.error(xmlhttp.responseText)
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/childmenupage?id="+menu,true);
    xmlhttp.send();
    }		

function actortype(){
    var type=document.getElementById("menu_type").value;
    //toastr.error(type);
    var xmlhttp;
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else{
        // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            //document.getElementById("table_menu1").style.display='none';
			document.getElementById("parenttree").innerHTML="";
			document.getElementById("nestable-output").value="";
			document.getElementById("nestable-output2").value="";
            document.getElementById("optselect").innerHTML=xmlhttp.responseText;
			
            //toastr.error(xmlhttp.responseText)
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/actorpage?id="+type,true);
    xmlhttp.send();
}

function childvalue(divv,menuid,type){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }
    else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            document.getElementById('msg_box33').style.display='block';
            document.getElementById("msg_box33").innerHTML=xmlhttp.responseText;
            //new nicEditor().panelInstance('competency');
            popup_text();
            //$('.button').click(function() {	var data = $('#peter').find('.nicEdit-main').text();
            //document.getElementById('comp_'+id).value=data;
            //});
        }
    };
    var as="c_menu["+divv+"]";
    var e = document.getElementById(as);
    var len=document.getElementById(as).length;
    var ss="";
    for(var i=0;i<len;i++){
        if(e.options[i].selected){
            if(ss===""){
                ss=e.options[i].value;
            }
            else{
                ss=ss+","+e.options[i].value;
            }
        }
    }			
    xmlhttp.open("GET",BASE_URL+"/admin/menu_details?divv="+divv+"&id="+menuid+"&type="+type+"&sel="+ss,true);
    xmlhttp.send(); 
}
	   
function popup_datac(divv,menuid,type){
    var tab = document.getElementById('multiselect');
    /*var lastRow = tab.rows.length; */
    var s=document.getElementById("addusers").value;
    var remove=Array();
    var spli=s.split(","); 
    var len=spli.length;
    var submenuid='';
    for(var i=len-1; i>=0; i--){ 
        k=i; 
        var row = tab.rows[k]; 
        var chkbox = row.cells[0].childNodes[0];  
        if(null !== chkbox && true === chkbox.checked) {
            var cc=chkbox.value;
            if(submenuid===''){
                submenuid=cc;
            }
            else{
                submenuid=submenuid+','+cc;
            }
        }
    }
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }
    else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            var ccmenu="ccmenu_"+divv;
            document.getElementById(ccmenu).innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/submenuselect?divv="+divv+"&submenuid="+submenuid+"&id="+type+"&menuid="+menuid,true);
    xmlhttp.send(); 
    $('.lightbox_bg').hide();
    document.getElementById('msg_box33').style.display='none';
}

function popup_text(){
    $(document).ready(function(){
        var myval = "msg_box33";
        var moniter_wdith = screen.width;
        var moniter_height = screen.height;
        var lightboxinfo_wdith = $("#" + myval).width();
        var lightboxinfo_height= $("#" + myval).height();
        var remain_wdith =  moniter_wdith - lightboxinfo_wdith;	
        var remain_height =  moniter_height - lightboxinfo_height;
        var byremain_wdith = remain_wdith/2;
        var byremain_height = remain_height/2;
        var byremain_height2 = byremain_height-10;
        $("#" + myval).css({left:byremain_wdith});
        $("#" + myval).css({top:byremain_height2});
        $('.lightbox_bg').show();
        $("#" + myval+' .lightbox_close_rel').add();
        $("#" + myval).animate({
            opacity: 1,
            left: "420px",
            top: "180px"
        }, 10);
    });
    $('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({
            opacity: 0,
            top: "-1200px"
        },0,
        function(){
            $('.lightbox_bg').hide();
        });
    });
}






function checkall(id){
    var ids=parseInt(id);
    var chk_id=document.getElementById('acess['+ids+']').checked;
    if(chk_id===true){
        $('#c_menu['+ids+'] option').attr('selected','selected');
    }
    else{
        $('#c_menu['+ids+'] option').attr('selected','');
    }
}

/*  function sample(){
	var chk_id=document.getElementById('chek').checked;
		if(chk_id==true){
			$('#samp option').attr('selected','selected')
			//getEmployee();
		}else{
			$('#samp option').removeAttr('selected')
		}
}*/

function validation(id){
    var tbl = document.getElementById('menu_table');
    var lastRow = tbl.rows.length;
    var lastRow1=lastRow-1; 
    if(lastRow1>0){
        var check=1;
        for(var i=0;i<lastRow1;i++){
            var chk_id=document.getElementById('acess['+i+']').checked;
            if(chk_id===true){
                var check=0;
            }
        }
        if(check===1){
            toastr.error("Please Select Atleast One Checkbox");
            return false;
        }
    }
    else{
        toastr.error("Please Change System Menu Type");
        return false;
    }
}

jQuery(document).ready(function(){
	jQuery("#menucreationform").validationEngine();	
});

$(window).load(function(){
	var vv=$("#nestable-output").val();
	//var vv=$("#sel_menu_id").val();
	vv=vv.replace(/"/gi,'');
	vv=vv.replace(/{/gi,'');
	vv=vv.replace(/}/gi,'');
	vv=vv.replace(/:/gi,'');
	vv=vv.replace(/id/gi,'');
	vv=vv.replace(/children/gi,'');
	vv=vv.replace(/\[/gi,'');
	vv=vv.replace(/]/gi,'');
	$("#sel_menu_id").val(vv);
});

$(document).ready(function(){	
    var updateOutput = function(e){var list   = e.length ? e : $(e.target),output = list.data('output');
        if(window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
        }
    	else {
            output.val('JSON browser support required for this demo.');
        }
    };
    
    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1,
        expandBtnHTML   : '<button data-action="expand" type="button">+</button>',
        collapseBtnHTML : '<button data-action="collapse" type="button">-</button>'
    }).on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));
    var vv=$("#nestable-output").val();
        vv=vv.replace(/"/gi,'');
        vv=vv.replace(/{/gi,'');
        vv=vv.replace(/}/gi,'');
        vv=vv.replace(/:/gi,'');
        vv=vv.replace(/id/gi,'');
        vv=vv.replace(/children/gi,'');
        vv=vv.replace(/\[/gi,'');
        vv=vv.replace(/]/gi,'');
        $("#nestable-output2").val(vv);
        var menuId=$("#nestable-output2").val();
        var type=$("#menu_type").val();                            
        var request = $.ajax({
            url: BASE_URL+"/admin/selectlist",
            type: "POST",
            data: { id : menuId, type :type },
            dataType: "html"
        });
        request.done(function( msg ) {
            $("#optselect").html(msg);
        }); 

    $('#nestable-menu').on('click', function(e){
        var target = $(e.target);
        action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });
    
    $('.chk').on('click', function(){
        var childiv=$(this).parent().children('.dd-handle-child');
    	childiv.toggle();	
    });
    
    $('.remove').on('click', function(){
        var childiv=$(this).parent().parent().remove();
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        var vv=$("#nestable-output").val();
        vv=vv.replace(/"/gi,'');
        vv=vv.replace(/{/gi,'');
        vv=vv.replace(/}/gi,'');
        vv=vv.replace(/:/gi,'');
        vv=vv.replace(/id/gi,'');
        vv=vv.replace(/children/gi,'');
        vv=vv.replace(/\[/gi,'');
        vv=vv.replace(/]/gi,'');
        $("#nestable-output2").val(vv);
		$("#sel_menu_id").val(vv);
        var creationId=$("#Menu_Creation_id").val();
        var menuId=$("#nestable-output2").val();
        var type=$("#menu_type").val();                            
        var request = $.ajax({
            url: BASE_URL+"/admin/selectlist",
            type: "POST",
            data: { id : menuId, type :type, creationid:creationId },
            dataType: "html"
        });
        request.done(function( msg ) {
            $("#optselect").html(msg);
        }); 
    });
	
    $('#nestable-menu').on('click', function(e){
        var target = $(e.target),
        action = target.data('action');
        //if (action === 'expand-all'){
            //$('.dd-handle-child').toggle();	
            if($(e.target).html()==='Expand All'){
                $('.dd-handle-child').show();	
                $(e.target).html("Collapse All");
            }
            else if($(e.target).html()==='Collapse All'){
                $('.dd-handle-child').hide();
                $(e.target).html("Expand All");
            }
        //}
    });
        
    $('#addrow').on('click',function(){
		var selid=$("#sel_menu_id").val();
		var menid=$("#optselect").val();
		/* if(selid!=''){
			menu=menid+','+selid;
		}else{
			menu=menid
		}
		$("#sel_menu_id").val(menu); */
        $('#optselect').find('option:disabled').removeAttr('disabled').attr('selected','selected').prop("selected", true);
		menuId=$("#optselect").val();
		var menu_cre_id=$('#menu_creation_id').val();
		var menu_type=$('#menu_type').val();
        var request = $.ajax({
            url: BASE_URL+"/admin/menulist?menucreationid="+menu_cre_id+"&menutype="+menu_type,
            type: "POST",
            data: { id : menuId, ch_id : selid },
            dataType: "html"
        });
        request.done(function( msg ) {
       $('#optselect').find('option:selected').prop("disabled", true).attr('selected',false);
            $("#nestable #parenttree").html( msg );
            $('.chk').unbind('click');
            $('.remove').unbind('click');
            $('.chk').bind('click', function(){ $(this).parent().children('.dd-handle-child').toggle();	});
            updateOutput($('#nestable').data('output', $('#nestable-output')));
            var vv=$("#nestable-output").val();
			//var vv=$("#sel_menu_id").val();
            vv=vv.replace(/"/gi,'');
            vv=vv.replace(/{/gi,'');
            vv=vv.replace(/}/gi,'');
            vv=vv.replace(/:/gi,'');
            vv=vv.replace(/id/gi,'');
            vv=vv.replace(/children/gi,'');
            vv=vv.replace(/\[/gi,'');
            vv=vv.replace(/]/gi,'');
            $("#nestable-output2").val(vv);
			$("#sel_menu_id").val(vv);
            $('.remove').bind('click', function(){
                var childiv=$(this).parent().parent().remove();
                updateOutput($('#nestable').data('output', $('#nestable-output')));
                var vv=$("#nestable-output").val();
                vv=vv.replace(/"/gi,'');
                vv=vv.replace(/{/gi,'');
                vv=vv.replace(/}/gi,'');
                vv=vv.replace(/:/gi,'');
                vv=vv.replace(/id/gi,'');
                vv=vv.replace(/children/gi,'');
                vv=vv.replace(/\[/gi,'');
                vv=vv.replace(/]/gi,'');
                $("#nestable-output2").val(vv);
				$("#sel_menu_id").val(vv);
                var creationId=$("#Menu_Creation_id").val();
                var menuId=$("#nestable-output2").val();
                var type=$("#menu_type").val();
                var request = $.ajax({
                    url: BASE_URL+"/admin/selectlist",
                    type: "POST",
                    data: { id : menuId, type :type,creation: creationId},
                    dataType: "html"
                });
                request.done(function( msg ) {
                    $("#optselect").html(msg);
                });
            });
        });
        request.fail(function( jqXHR, textStatus ) {
            toastr.error( "Request failed: " + textStatus );
        });
    });
    });