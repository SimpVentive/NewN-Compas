	jQuery(document).ready(function($) {
	
		  jQuery("#blue" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/blue.css");
              jQuery(".logo img" ).attr("src", "images/logo-blue.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-blue.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-blue.png");
			  return false;
		  });
		  
		  jQuery("#pink" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/pink.css");
              jQuery(".logo img" ).attr("src", "images/logo-pink.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-pink.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-pink.png");
			  return false;
		  });
		  
		  jQuery("#orange" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/orange.css");
              jQuery(".logo img" ).attr("src", "images/logo-fullorange.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-orange.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-orange.png");
			  return false;
		  });
        
            jQuery("#purple" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/purple.css");
                jQuery(".logo img" ).attr("src", "images/logo-purple.svg");
                jQuery(".sec-title img" ).attr("src", "images/separator-purple.png");
                jQuery(".sec-title-4 img" ).attr("src", "images/separator-purple.png");
			  return false;
		  });
		  
		  
		  jQuery("#green" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/green.css");
              jQuery(".logo img" ).attr("src", "images/logo-fullgreen.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator.png");
			  return false;
		  });
        
          jQuery("#red" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/red.css");
              jQuery(".logo img" ).attr("src", "images/logo-red.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-red.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-red.png");
			  return false;
		  });
        
          jQuery("#cyan" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/cyan.css");
              jQuery(".logo img" ).attr("src", "images/logo-cyan.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-cyan.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-cyan.png");
			  return false;
		  });
        
          jQuery("#sky-blue" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/sky-blue.css");
              jQuery(".logo img" ).attr("src", "images/logo-skyblue.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-skyblue.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-skyblue.png");
			  return false;
		  });
        
          jQuery("#gray" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/gray.css");
              jQuery(".logo img" ).attr("src", "images/logo-gray.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-gray.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-gray.png");
			  return false;
		  });
		  
		  jQuery("#brown" ).click(function(){
			  jQuery("#color" ).attr("href", "css/colors/brown.css");
              jQuery(".logo img" ).attr("src", "images/logo-brown.svg");
              jQuery(".sec-title img" ).attr("src", "images/separator-brown.png");
              jQuery(".sec-title-4 img" ).attr("src", "images/separator-brown.png");
			  return false;
		  });		  
		  
		  //add backgrounds
		  jQuery("#bg-one" ).click(function(){
			  jQuery("body" ).addClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-two" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).addClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-three" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).addClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-four" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).addClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-five" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).addClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-six" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).addClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-seven" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).addClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-eight" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).addClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-nine" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).addClass("bg9");
			  jQuery("body" ).removeClass("bg10");
		  });
		  
		  jQuery("#bg-ten" ).click(function(){
			  jQuery("body" ).removeClass("bg1");
			  jQuery("body" ).removeClass("bg2");
			  jQuery("body" ).removeClass("bg3");
			  jQuery("body" ).removeClass("bg4");
			  jQuery("body" ).removeClass("bg5");
			  jQuery("body" ).removeClass("bg6");
			  jQuery("body" ).removeClass("bg7");
			  jQuery("body" ).removeClass("bg8");
			  jQuery("body" ).removeClass("bg9");
			  jQuery("body" ).addClass("bg10");
		  });
		  jQuery("#bg-one, #bg-two, #bg-three, #bg-four, #bg-five, #bg-six, #bg-seven, #bg-eight, #bg-nine, #bg-ten").click(function(){
			  jQuery("#wrapper").addClass("boxed-layout");
		  });
		  jQuery("#wide").click(function(){
			  jQuery("body").removeClass("bg1 bg2 bg3 bg4 bg5 bg6 bg7 bg8 bg9 bg10");
		  });
		  
		  
		  jQuery("#light").click(function(){
			  	jQuery("#footer").addClass("light");
				jQuery("#footer").removeClass("dark");
				jQuery("#footer img" ).attr("src", "images/footer-logo.jpg");
		   });
		   jQuery("#dark").click(function(){
			  	jQuery("#footer").addClass("dark");
				jQuery("#footer").removeClass("light");
				jQuery("#footer img" ).attr("src", "images/footer-logo-dark.jpg");
		   });
		   
		   jQuery("#header-n").click(function(){
			  	jQuery("body").removeClass("fixed-header");
		   });
		   jQuery("#header-f").click(function(){
				jQuery("body").addClass("fixed-header");
		   });
		  
		  
		  
		  // picker buttton
		  jQuery(".picker_close").click(function(){
			  
			  	jQuery("#choose_color").toggleClass("position");
			  
		   });
		   
		   //header
			
			//stickey header
			jQuery(window).scroll(function() {    
				var scroll = jQuery(window).scrollTop();	
				if (scroll >= 40) {
					jQuery(".fixed-header").addClass("small-header");
				}
				else {
					jQuery(".fixed-header").removeClass("small-header");
				}
			});
		   
		  
		  
	});