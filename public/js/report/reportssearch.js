  jQuery(document).ready(function(){
               jQuery("#reportForm").validationEngine();
               //alert('haiii');
       });

 function getgroupdata(){
     var gid=document.getElementById('groupname').value;
     
         var  xmlhttp2;
            if (window.XMLHttpRequest){
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp2=new XMLHttpRequest();
            }
            else{
                    xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp2.onreadystatechange=function(){
                    if (xmlhttp2.readyState==4 && xmlhttp2.status==200){
                       //  document.getElementById('div_reports1').style.display='block';
                         document.getElementById('div_data').innerHTML=xmlhttp2.responseText;;
                     }
             }
	//?org="+org+"&grad="+grad+"&loc="+loc+"&post= 
        // var prog,eve,enrol,enumber,orgname,fromdate,todate;
	xmlhttp2.open("GET",BASE_URL+"/report/getgroupreportdetails?id="+gid,true);
	xmlhttp2.send();
              
    }   
        