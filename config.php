<?php
require_once __DIR__ . '/includes/PHPMailerAutoload.php';

$base_url="https://".$_SERVER['SERVER_NAME'];
define('BASE_URL', $base_url);

define ('DBPATH','localhost');
define ('DBUSER','root');
define ('DBPASS','UTS@2011IND');
define ('DBNAME','heidelberg_ncompas');
//define ('DBNAME','cs_fertilizer_backup');

try{
	$con=@mysqli_connect(DBPATH,DBUSER,DBPASS,DBNAME);
	//mysql_select_db(DBNAME,$con)or die(mysql_error());
}
catch (Exception $e){
	throw new Exception( 'Something really gone wrong', 0, $e);
}


defined('LOGO_IMG') ? null : define('LOGO_IMG', "public/images/heidelberg.png");
defined('LOGO_IMG_PDF') ? null : define('LOGO_IMG_PDF', "public/images/heidelberg.png");
defined('LOGO_IMG_PDF_FOOTER') ? null : define('LOGO_IMG_PDF_FOOTER', "public/images/head_north_logo.png");
defined('LOGO_IMG_PDF2') ? null : define('LOGO_IMG_PDF2', "public/home/images/acme.png");
defined('PDF_NAME') ? null : define('PDF_NAME', "www.N-Compas.com");
defined('EXOTEL_SID') ? null : define('EXOTEL_SID', "potentia");
defined('EXOTEL_TOKEN') ? null : define('EXOTEL_TOKEN',
    "849cff25991da146a1bd0040dec81b1fe3af7b73");

defined('MSG91_AUTH_KEY') ? null : define('MSG91_AUTH_KEY', "191925Auo0rD40Q1cy5a52393e");
// sender id should 6 character long
defined('MSG91_SENDER_ID') ? null : define('MSG91_SENDER_ID', 'ADANIP');

// setting this value to 'true' is recommended
define('LIMIT_PRODUCT_WIDTH',     true);

// maximum width for all product image
define('MAX_PRODUCT_IMAGE_WIDTH', 1280);
defined('SECRET') ? null : define('SECRET', "lms3oct2013");
// the width for product thumbnail
define('THUMBNAIL_WIDTH',300);

define ('PER_PAGE',12);

class Config {
    // ------------------------------------------------------------------------
    // General Settings
    // ------------------------------------------------------------------------
    const BASE_URL      = BASE_URL;
    const LANGUAGE      = 'english';
    const DEBUG_MODE    = FALSE;

    // ------------------------------------------------------------------------
    // Database Settings
    // ------------------------------------------------------------------------
    const DB_HOST       = DBPATH;
    const DB_NAME       = DBNAME;
    const DB_USERNAME   = DBUSER;
    const DB_PASSWORD   = DBPASS;

    // ------------------------------------------------------------------------
    // Google Calendar Sync
    // ------------------------------------------------------------------------
    const GOOGLE_SYNC_FEATURE   = TRUE; // Enter TRUE or FALSE
    const GOOGLE_PRODUCT_NAME   = 'LCIC SPA';
    const GOOGLE_CLIENT_ID      = '696728556641-68c0a81p342cgpdms3p3djui7uui5s7j.apps.googleusercontent.com';
    const GOOGLE_CLIENT_SECRET  = 'oCqRVUFev5Hx1m0MmNcgsy9z';
    const GOOGLE_API_KEY        = '';


    static function readTemplateFile($FileName) {
        $fp = fopen($FileName,"r") or exit("Unable to open File ".$FileName);
        $str = "";
        while(!feof($fp)) {
            $str .= fread($fp,1024);
        }
        return $str;
    }

    static function phpmailer($to,$subject,$body,$recipient1=array()){

        $content =Config::readTemplateFile("public/mailnew.html");
        $content = str_replace(array("#Server#","#BASE_URL#","#message#","#subject#"),array($_SERVER['SERVER_NAME'],BASE_URL,$body,$subject),$content);
        $from_name = "TeleiDial";
        $from_mail="mail@telewebs.in";
        $smtp_server="mail.teleidial.com";
        $smtp_password="Asdasd@34";
        $smtp_port=25;
        $smtp_encrypt="TLS";

        $mail = new PHPMailer;
        //$mail->SMTPDebug =2;                              // Enable verbose debug output
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = $smtp_server;                         // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = $from_mail;                       // SMTP username
        $mail->Password = $smtp_password;                   // SMTP password
        $mail->SMTPSecure = $smtp_encrypt;                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $smtp_port;                           // TCP port to connect to

        $mail->From = $from_mail;
        $mail->FromName = $from_name;
        $mail->addAddress($to);
        /*  foreach($recipient1 as $rep){
        $mail->addCC($rep);
        } */
        foreach($recipient1 as $rep){
        $mail->addBCC($rep);
        }
        $mail->isHTML(true);                                // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body= $content;
        $mail->send();
    }

    static function perpage(){
        return array(10,25,50,100,200);
    }

    static function make_pages($page,$limit,$total,$filePath,$url){
        //$counter=0;
        $targetpage=$filePath; $stages = 2;
        $page= $page == 0 ? 1:$page;
        $prev = $page - 1; $next = $page + 1;
        $lastpage = ceil($total/$limit);
        $LastPagem1 = $lastpage - 1;
        $paginate = '';
        $pp1=($page*$limit);
        $cou=$pp1-$limit+1;
        $pp=$pp1>$total? $total:$pp1;
        if($pp==0){$cou=$pp1-$limit+0;}else{$cou=$pp1-$limit+1;}
        //$counter=0;
        $paginate .= "<div><ul class='pagination'>";
        //if($lastpage > 1){
            // Previous
            if ($page > 1){
                $paginate.= "<li><a href='$targetpage?page=$prev&$url'>&laquo;</a></li>";
            }
            else{
                $paginate.= "<li class='disabled'><a href='#' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
            }
            // Pages
            if ($lastpage <= 7 + ($stages * 2)){
                // Not enough pages to breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++){
                    if ($counter == $page){
                        $paginate.= "<li class='active'><a href='#'>$counter</a></li>";
                    }
                    else{
                        $paginate.= "<li><a href='$targetpage?page=$counter&$url'>$counter</a></li>";
                    }
                }
            }
            elseif($lastpage > 5 + ($stages * 2)){
                if($page < 1 + ($stages * 2)){
                    for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
                        if ($counter == $page){
                            $paginate.= "<li class='active'><a href='#'>$counter</a></li>";
                        }
                        else{
                            $paginate.= "<li><a href='$targetpage?page=$counter&$url'>$counter</a></li>";
                        }
                    }
                    //$paginate.= "...";
                    $paginate.= "<li><a href='$targetpage?page=$LastPagem1&$url'>$LastPagem1</a></li>";
                    $paginate.= "<li><a href='$targetpage?page=$lastpage&$url'>$lastpage</a></li>";
                }
                // Middle hide some front and some back
                elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
                    $paginate.= "<li><a href='$targetpage?page=1&$url'>1</a></li>";
                    $paginate.= "<li><a href='$targetpage?page=2&$url'>2</a></li>";
                    //$paginate.= "...";
                    $counter = $page - $stages;
                    for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
                        if ($counter == $page){
                            $paginate.= "<li class='active'><a href='#'>$counter</a></li>";
                        }
                        else{
                            $paginate.= "<li><a href='$targetpage?page=$counter&$url'>$counter</a></li>";
                        }
                    }
                    //$paginate.= "...";
                    $paginate.= "<li><a href='$targetpage?page=$LastPagem1&$url'>$LastPagem1</a></li>";
                    $paginate.= "<li><a href='$targetpage?page=$lastpage&$url'>$lastpage</a></li>";
                }
                // End only hide early pages
                else{
                    $paginate.= "<li><a href='$targetpage?page=1&$url'>1</a></li>";
                    $paginate.= "<li><a href='$targetpage?page=2&$url'>2</a></li>";
                    //$paginate.= "...";
                    for($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
                        if ($counter == $page){
                            $paginate.= "<li class='active'><a href='#'>$counter</a></li>";
                        }
                        else{
                            $paginate.= "<li><a href='$targetpage?page=$counter&$url'>$counter</a></li>";
                        }
                    }
                }
            }
            // Next

            if ($page < $counter - 1){
                $paginate.= "<li><a href='$targetpage?page=$next&$url'>&raquo;</a></li>";
            }
            else{
                $paginate.= "<li class='disabled'><a href='#'>&raquo;</a></li>";
            }
        //}
        $paginate.= "</ul></div>";
        return $paginate;
    }
}
/* End of file config.php */
/* Location: ./config.php */


function createThumbnail($srcFile, $destFile, $width, $quality = 80)
{
    $thumbnail = '';

    if (file_exists($srcFile)  && isset($destFile))
    {
        $size        = getimagesize($srcFile);
        $w           = number_format($width, 0, ',', '');
        $h           = number_format(($size[1] / $size[0]) * $width, 0, ',', '');

        $thumbnail =  copyImage($srcFile, $destFile, $w, $h, $quality);
    }

    // return the thumbnail file name on sucess or blank on fail
    return basename($thumbnail);
}

/*
    Copy an image to a destination file. The destination
    image size will be $w X $h pixels
*/
function copyImage($srcFile, $destFile, $w, $h, $quality = 80)
{
    $tmpSrc     = pathinfo(strtolower($srcFile));
    $tmpDest    = pathinfo(strtolower($destFile));
    $size       = getimagesize($srcFile);

    if ($tmpDest['extension'] == "gif" || $tmpDest['extension'] == "jpg")
    {
       $destFile  = substr_replace($destFile, 'jpg', -3);
       $dest      = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } elseif ($tmpDest['extension'] == "png") {
       $dest = imagecreatetruecolor($w, $h);
       imageantialias($dest, TRUE);
    } else {
      return false;
    }

    switch($size[2])
    {
       case 1:       //GIF
           $src = imagecreatefromgif($srcFile);
           break;
       case 2:       //JPEG
           $src = imagecreatefromjpeg($srcFile);
           break;
       case 3:       //PNG
           $src = imagecreatefrompng($srcFile);
           break;
       default:
           return false;
           break;
    }

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);

    switch($size[2])
    {
       case 1:
       case 2:
           imagejpeg($dest,$destFile, $quality);
           break;
       case 3:
           imagepng($dest,$destFile);
    }
    return $destFile;

}
