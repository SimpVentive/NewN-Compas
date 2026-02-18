function create_menu(){
    window.location=BASE_URL+"/admin/create_menus";
}
function search_menu(){
    var name=document.getElementById('menu_name').value;
    var type=document.getElementById('menu_type').value;
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
            document.getElementById('search').style.display='none';
            document.getElementById('search1').style.display='block';
            document.getElementById('search1').innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/search_menu?name="+name+"&type="+type,true);
    xmlhttp.send();
}
function update_menu(name,mid){ 
    $name=name;
    $mid=mid;
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
            document.getElementById("view_menu").style.display='none';
            document.getElementById("update_menu").style.display='block';
            document.getElementById("update_menu").innerHTML=xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET",BASE_URL+"/admin/lms_updatemenu?name="+name+"&mid="+mid,true);
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
            popup_text();
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
        $("#" + myval).animate({opacity: 1, left: "420px", top: "180px"}, 10);
    });
    $('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({opacity: 0,top: "-1200px"},0,function(){$('.lightbox_bg').hide();});
    });
}

function popup_datac(divv,menuid,type){
    var tab = document.getElementById('multiselect');
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

function cancelmenu(){
    window.location="<?php echo BASE_URL;?>/admin/menucreation";
}