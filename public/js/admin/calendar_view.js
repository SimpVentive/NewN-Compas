$(document).ready(function(){
//$( "#msg_box33" ).draggable();
//$("#yearly_calendar_table").css("display","none");
$("#yearly_calendar_table").css("display","block");
$('#calendar').css('display','none');
});    
function calendar_popup(prg_id,mon_id,calend_id){
//document.getElementById("msg_box33").style.display='block';
var xmlhttp;
if (window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
}
else{
    // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
                document.getElementById("calendarpopup").style.display='block';
                document.getElementById("calendarpopup").innerHTML=xmlhttp.responseText;					
               // popup_text();   
        }
}
xmlhttp.open("GET",BASE_URL+"/admin/calendar_program_event_view?prg_id="+prg_id+"&mon_id="+mon_id+"&cal_id="+calend_id,true);
xmlhttp.send(); 
}

function popup_text(){
    $(document).ready(function(){
        var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
        $('#msg_box33').append(lclose);
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
            left: "150px",
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
            $('.lightbox_bg').hide()
        });
    });
} 

function update_calender(id){
    window.location=BASE_URL+"/admin/calender_edit?cal_id="+id;
}

function prg_show(){
    document.getElementById('program_detail').style.display='block';
    document.getElementById('show').style.display='none';
    document.getElementById('Hide').style.display='block';
}
 function prg_hide(){
    document.getElementById('program_detail').style.display='none';
    document.getElementById('show').style.display='block';
    document.getElementById('Hide').style.display='none';
}  


function search_calender(){
    window.location=BASE_URL+"/admin/calender_search";
}

function display_yearly(){
    document.getElementById("yearly_calendar_table").style.display="block";
    document.getElementById("calendar").style.display="none";
    mmenu();
}

function display_monthly(){
    document.getElementById("yearly_calendar_table").style.display="none";
    document.getElementById("calendar").style.display="block"; 
    mmenu();
    
    
}

function mmenu(){    

}