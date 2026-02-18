<?php
 
defined('FDF_PATH') ? null : define('FDF_PATH', __SITE_PATH.DS.'library'.DS.'includes'.DS.'pdf');  
require(FDF_PATH.DS.'fpdf_certification.php');
$mysqltime = date ("d-m-Y");

$userid=Doctrine::getTable('UlsEmployeeMaster')->findOneByEmployee_id($_REQUEST['id']);
$empworkinfo=Doctrine::getTable('UlsEmployeeWorkInfo')->findOneByEmployee_id($_REQUEST['id']);
$orgdetails=Doctrine::getTable('UlsOrganizationMaster')->findOneByOrganization_id($empworkinfo->org_id);
$evename=Doctrine::getTable('UlsEventCreation')->find($_REQUEST['eveid']);
$test=Doctrine::getTable('UlsUtestAttempts')->findOneByEmployee_idAndEvent_idAndAttempt_statusAndTest_type($_REQUEST['id'],$_REQUEST['eveid'],'PAS','POST');
 $gender=($userid->gender)=='M'?'Mr':'Ms'; 

class PDF extends FPDF
{
	var $B;
	var $I;
	var $U;
	var $HREF;
	 var $ALIGN;
     function SetDash($black=null, $white=null)
	{
		if($black!==null)
	 $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
		else
			$s='[] 0 d';
		$this->_out($s);
	}
	function PDF($orientation='P',$unit='mm',$format='A4')
	{
		//Call parent constructor
		$this->FPDF($orientation,$unit,$format);
		//Initialization
		$this->B=0;
		$this->I=0;
		$this->U=0;
		$this->HREF='';
		//$this->$ALIGN='';
	}
	
	function WriteHTML($html)
	{
		//HTML parser
		$html=str_replace("\n",' ',$html);
		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='center')
                    $this->Cell(0,5,$e,0,1,'C');
				else
					$this->Write(5,$e);
			}
			else
			{
				//Tag
				if($e{0}=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					//Extract attributes
					$a2=explode(' ',$e);
					$tag=strtoupper(array_shift($a2));
					$attr=array();
					foreach($a2 as $v)
						if(preg_match('/^([^=]*)=["\']?([^"\']*)["\']?$/',$v,$a3))
							$attr[strtoupper($a3[1])]=$a3[2];
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}
	
	function OpenTag($tag,$attr)
	{
		//Opening tag
		if($tag=='B' or $tag=='I' or $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF=$attr['HREF'];
		 if($tag=='P')
            $this->ALIGN=$attr['ALIGN'];	
		if($tag=='BR')
			$this->Ln(5);
	}
	
	function CloseTag($tag)
	{
		//Closing tag
		if($tag=='B' or $tag=='I' or $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
		if($tag=='P')
            $this->ALIGN='';
	}
	
	function SetStyle($tag,$enable)
	{
		//Modify style and select corresponding font
		$this->$tag+=($enable ? 1 : -1);
		$style='';
		foreach(array('B','I','U') as $s)
			if($this->$s>0)
				$style.=$s;
		$this->SetFont('',$style);
	}
	
	function PutLink($URL,$txt)
	{
		//Put a hyperlink
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
}


//create a FPDF object
$pdf=new PDF();

//set document properties
$pdf->SetAuthor('Lana Kovacevic');
/*$pdf->SetTitle('Unitol Training Solutions Pvt Ltd');
*/
/*$text='Circular Text';
$pdf->CircularText(105, 50, 30, $text, 'top');
$pdf->CircularText(105, 50, 30, $text, 'bottom');
*/
//set font for the entire document
$pdf->SetFont('Helvetica','B',20);
//$pdf->SetFont('Brushscript','B',20);
$pdf->SetTextColor(50,50,100);

//set up a page
$pdf->AddPage('L');
//$pdf->SetDisplayMode('real','default');
$pdf->SetDisplayMode('fullpage');
//insert an image and make it a link
//$pdf->Image('signup_lightbg.png',30,20,33);
$image_height = 300;
$image_width = 200;
//$pdf->Image('free-certificate-border8.jpg', 0, 0, $image_height, $image_width); 
//$image_path=BASE_URL.'/public/images/Certificate-Completion_02.png';
$image_path=BASE_URL.'/public/images/polycert.png';
//$image_path=BASE_URL.'/public/images/free-certificate-border8.jpg';
$pdf->Image($image_path, 0, 0, $image_height, $image_width); 
//display the title with a border around it
$pdf->SetXY(50,20);
$pdf->SetDrawColor(70,60,100);
$pdf->SetFillColor(0,255,255);
//$pdf->SetTextColor('yellow');
//$pdf->SetXY (120,50);
//$pdf->SetFontSize(20);
// $pdf->Write(50,'Presented to');
 $pdf->SetXY (50,90);
 $pdf->SetFontSize(20);
//$this->SetFont('courier','I',10); 
$pdf->SetFont('times','B',18);
//$pdf->SetLineWidth(1);
 $pdf->WriteHTML('<div>Dear '.$gender.'<u style="color:"> <b>'.$userid->full_name.'</b></u>  Employee ID: <u> <b>'.$userid->	employee_number.'</b></u>'); 
 $pdf->SetXY (50,105);
 $pdf->SetFontSize(20);
//$pdf->SetLineHeight(1);
$pdf->SetFont('times','B',18);                                                                                  
$pdf->WriteHTML('Of <b><u>'.$orgdetails->org_name.'</u></b> department for successfully completing the training Program');
$pdf->SetXY (50,120);
 $pdf->SetFontSize(20);
//$pdf->SetLineHeight(1);
$pdf->SetFont('times','B',18);                                                                                  
$pdf->WriteHTML('On <u><b>'.@$evename->event_name.'</b></u> </div>');
//Set x and y position for the main text, reduce font size and write content


//$pdf->WriteHTML('<p align="center"><b>This is to certify that</b></p><br><p align="center" style="color:blue;"><b>'.$userid->full_name.'</b></p><br><br><p align="center"><I>has successfully completed the online training in <br><B>'.$evename->event_name.'</B></I></p><br><p align="center"></p><br><br><br><b>Date:</b>                                                                                                   <I>The DCM HR PORTAL,'.date('Y').'</I>');
//$pdf->SetLineWidth(0.2);
//$pdf->SetDash(1,2); //5mm on, 5mm off
//$pdf->Line(48,75,250,75);


//$pdf->SetLineWidth(0.2);
//$pdf->SetDash(1,2); //5mm on, 5mm off
//$pdf->Line(68,90,250,90);

/*$pdf->SetLineWidth(0.2);
$pdf->SetDash(1,2); //5mm on, 5mm  off
$pdf->Line(43,150,73,150);*/

/*$pdf->SetLineWidth(0.2);
$pdf->SetDash(5,5); //5mm on, 5mm off
$pdf->Line(350,120,20,120);
*/
//Output the document
$pdf->Output(''.$userid->full_name.' Report.pdf','D');
$pdf->Output();

?> 
<?php /*?><?php require('fpdf.php'); 
class PDF extends FPDF {  
function Header()   
{     
 $this->Image('signup_lightbg.png',10,8,33);   
$this->SetFont('Helvetica','B',15);  
$this->SetXY(50, 10);     
$this->Cell(0,10,'This is a header',1,0,'C'); 
}   
function Footer() 
{       $this->SetXY(100,-15);   
$this->SetFont('Helvetica','I',10);     
$this->Write (5, 'This is a footer'); 
}
}  
$pdf=new PDF(); 
$pdf->AddPage();
$pdf->Output('example2.pdf','D'); ?> <?php */?>