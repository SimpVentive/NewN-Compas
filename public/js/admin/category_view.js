function cat_name(){
    var catid=document.getElementById('cattype').value;
    if(catid=='PC'){ 
		document.getElementById('parent_cat').style.display="none";
		document.getElementById('parent_subcat').style.display="none";
		}else if(catid=='C'){
		document.getElementById('parent_cat').style.display="block";
		document.getElementById('parent_subcat').style.display="none";
			}else if(catid=='SC'){
			document.getElementById('parent_subcat').style.display="block";
			document.getElementById('parent_cat').style.display="none";
				}
}
	
function create_cat(){
        window.location=BASE_URL+"/admin/create_category";		
        }	



        function update_category(id,hash){
                var id=id;		
                window.location=BASE_URL+"/admin/update_catgory?id="+id+"&hash="+hash;	

                }	

        function alert_msg(){ 
                $(document).ready(function() {
var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
$('.lightbox_close').hide()
$('#subcat').append(lclose);
var myval = "subcat";
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
$('.lightbox_bg').show()
$("#" + myval+' .lightbox_close_rel').add();

                $("#" + myval).animate({
                opacity: 1,
                left: "155.5px",
                top: "87px"
        }, 10);


});
$('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({
                opacity: 0,
                top: "-1200px"
        },0,function(){
                $('.lightbox_bg').hide()

        });

});

                }

function alert_catmsg(){ 
$(document).ready(function() {
var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
$('.lightbox_close').hide()
$('#cat').append(lclose);
var myval = "cat";
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
$('.lightbox_bg').show()
$("#" + myval+' .lightbox_close_rel').add();

                $("#" + myval).animate({
                opacity: 1,
                left: "155.5px",
                top: "87px"
        }, 10);


});
$('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({
                opacity: 0,
                top: "-1200px"
        },0,function(){
                $('.lightbox_bg').hide()

        });

});

                }


function alert_parentmsg(){ 
$(document).ready(function() {
var lclose = $("<a class='lightbox_close_rel'>Close This</a>");
$('.lightbox_close').hide()
$('#parentcat').append(lclose);
var myval = "parentcat";
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
$('.lightbox_bg').show()
$("#" + myval+' .lightbox_close_rel').add();

                $("#" + myval).animate({
                opacity: 1,
                left: "155.5px",
                top: "87px"
        }, 10);


});
$('a.lightbox_close_rel').click(function(){
        var myval2 =$(this).parent().attr('id');
        $("#" + myval2).animate({
                opacity: 0,
                top: "-1200px"
        },0,function(){
                $('.lightbox_bg').hide()

        });

});

                }



        function delete_subcategoryalert(id){  	
        var id=id; 
        var xmlhttp;
         if (window.XMLHttpRequest){
                 // code for IE7+, Firefox, Chrome, Opera, Safari
                 xmlhttp=new XMLHttpRequest();
         }
         else{
                 // code for IE6, IE5
                 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
         }	

        //alert_msg();		
         alertify.alert("You cannot delete a sub-category that contains additional-categories. Delete additional-categories first.");
        }

        function delete_parentcategoryalert(id){  	
        var id=id; 
        var xmlhttp;
         if (window.XMLHttpRequest){
                 // code for IE7+, Firefox, Chrome, Opera, Safari
                 xmlhttp=new XMLHttpRequest();
         }
         else{
                 // code for IE6, IE5
                 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
         }	

        //alert_parentmsg();
        alertify.alert("You cannot delete a parent-category that contains categories. Delete categories first.");

        }

        function delete_categoryalert(id){  	
        var id=id; 
        var xmlhttp;
         if (window.XMLHttpRequest){
                 // code for IE7+, Firefox, Chrome, Opera, Safari
                 xmlhttp=new XMLHttpRequest();
         }
         else{
                 // code for IE6, IE5
                 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
         }	
         //document.getElementById("subcat").innerHTML=xmlhttp.responseText;
        //alert_catmsg();
        alertify.alert("You cannot delete a category that contains sub-categories. Delete sub-categories first.");
        }

        function delete_addcategory(id){ 	
        var id=id; 
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
                 if (xmlhttp.readyState==4 && xmlhttp.status==200){		
                 document.getElementById('addcatg_'+id).style.display='none';
                 //window.location=BASE_URL+"/admin/category";	
                        //alert(xmlhttp.responseText);

                         }
         }
         xmlhttp.open("GET",BASE_URL+"/admin/delete_subcategorys?id="+id,true);
         xmlhttp.send();		

        }

        function delete_parentcategory(id){ 	
        var id=id; 
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
                 if (xmlhttp.readyState==4 && xmlhttp.status==200){		
                 document.getElementById('parent_'+id).style.display='none';

                         }
         }
         xmlhttp.open("GET",BASE_URL+"/admin/delete_parentcategorys?id="+id,true);
         xmlhttp.send();		

        }


        function delete_category(id){ 	
        var id=id; 
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
                 if (xmlhttp.readyState==4 && xmlhttp.status==200){		
                 document.getElementById('catg_'+id).style.display='none';
                 window.location=BASE_URL+"/admin/category";

                         }
         }
         xmlhttp.open("GET",BASE_URL+"/admin/delete_subcategorys?id="+id,true);
         xmlhttp.send();		

        }


        function delete_subcategory(id){ 	
        var id=id; 
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
                 if (xmlhttp.readyState==4 && xmlhttp.status==200){		
                 document.getElementById('subcatg_'+id).style.display='none';
                 window.location=BASE_URL+"/admin/category";
                        //alert(xmlhttp.responseText);

                         }
         }
         xmlhttp.open("GET",BASE_URL+"/admin/delete_subcategorys?id="+id,true);
         xmlhttp.send();		

        }
  

      $("#example-advanced").treetable({ expandable: true });
      jQuery('#example-advanced').treetable('expandAll');
       //jQuery('#example-advanced').treetable('folder ui-draggable ui-droppable selected branch expanded');
      // Highlight selected row
      $("#example-advanced tbody").on("mousedown", "tr", function() {
        $(".selected").not(this).removeClass("selected");
        $(this).toggleClass("selected");
      });

