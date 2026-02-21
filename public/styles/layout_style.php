<?php 
	ob_start ("ob_gzhandler");
	header ("content-type: text/css; charset: UTF-8");
	header ("cache-control: must-revalidate");
	$offset = 3600 *60 * 60;
	$expire = "expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
	header ($expire);

	function compress($buffer) {
		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
		/* remove tabs, spaces, newlines, etc. */
		$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), array('','','','','','',''), $buffer);
		return $buffer;
	}
	
	/* your css files */
	/* default css File */
	$defaultcss=array("validationEngine.jquery.css","chosen.css");
	foreach($defaultcss as $css){
            is_file($css) ? include $css: "";
	}
        
	/* custom css file to load when page is called */ 
	$id=$_REQUEST['id'];
	if(!empty($id)){
            $csss=explode(",",$id);
            foreach($csss as $css){
                if(!in_array($css,$defaultcss)){
                    is_file($css) ? include $css: "";
                }
            }
        }  


ob_end_flush();