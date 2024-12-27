<?php
require('fpdf.php');
session_start();
include("../connect.php");
include("../config.php");
date_default_timezone_set("Asia/Colombo");

$date = date("Y-m-d");
$time = date("H.i");
$path="../";

class PDF extends FPDF
{
    // Basic table



    // Improved table
    function ImprovedTable($header, $data)
    {
        $w = array(40, 35, 40, 45);
        for($i=0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();
        for ($i = 0; $row = $data->fetch(); $i++)
        {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Fancy table with colors and formatting
    function sales_list($header, $data)
    {
        $this->SetFillColor(49, 115, 168);
        $this->SetTextColor(255);
        $this->SetDrawColor(37, 87, 123);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        $w = array(15,100, 25, 20, 30);
        for($i=0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        
        $fill = false;
        for ($i = 0; $row = $data->fetch(); $i++) 
        {
            $this->SetFont('','',12);
            if($row['product_id']==4){$name=$row['about'];}else{$name=$row['name'];}
            $this->Cell($w[0], 6, $i+1, 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $name, 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, ''.number_format($row['price'],2), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row['qty']), 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, ''.number_format($row['amount'],2), 'LR', 0, 'R', $fill);
            $this->Ln();
            $this->SetFont('','',8);

            $job_id=$row['job_no'];
            $product_id=$row['product_id'];
            $data2=select("sales_list_task","*","job_no='$job_id' AND product_id='$product_id' ",'../');
            for ($i2 = 0; $row2 = $data2->fetch(); $i2++){
            $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row2['name'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, '', 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, '', 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
            $this->Ln();
            }

            if($_GET['type']==2){
            $this->Cell($w[0], 6, '', 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, 'Basically provide a thorough and high-quality cleaning for every job', 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, '', 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, '', 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, '', 'LR', 0, 'R', $fill);
            $this->Ln();
            }
           $fill = !$fill;



        }
        $this->SetFont('','',12);
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    function total($total,$discount)
    {
        $w = array( 140, 50);

        
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('Arial','B');
        $fill = false;
        
        
        $this->Cell($w[0], 6, 'Sub Total', 'LR', 0, 'R', $fill);
        $this->Cell($w[1], 6, 'Rs '.number_format($total,2), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;


        $this->Cell($w[0], 6, 'Discount', 'LR', 0, 'R', $fill);
        $this->Cell($w[1], 6, 'Rs '.number_format($discount,2), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;


        $this->Cell($w[0], 6, 'Net Total', 'LR', 0, 'R', $fill);
        $this->Cell($w[1], 6, 'Rs '.number_format($total-$discount,2), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill = !$fill;
        
        $this->Cell(array_sum($w), 0, '', 'T');
    }

protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
}

$job_id=$_GET['id'];
$action=$_GET['type'];

$result = query("SELECT * FROM info ",$path);
for ($i = 0; $row = $result->fetch(); $i++) {
    $info_name = $row['name'];
    $info_add = $row['address'];
    $info_vat = $row['vat_no'];
    $info_con = $row['phone_no'];
}



$result = $db->prepare("SELECT * FROM sales WHERE   job_no='$job_id'");
$result->bindParam(':userid', $date);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
	$name = $row['customer_name'];
    $cus_id=$row['customer_id'];
    $address='';
    $invo=$row['invoice_number'];
    $total=$row['amount'];
    $discount=$row['discount'];
}

$contact=select_item('customer','contact','id='.$cus_id,$path);



    if ($action == 2) {
        $in_type = "QUOTATION";
    } else {
        $in_type = "INVOICE";
    }


$data=select("sales_list","*","job_no='$job_id' ",$path);

$pdf = new PDF();
$header = array('ID','Name', 'Price', 'Qty', 'Amount');

$html = '

                        <img src="../img/logo/logo.jpg" alt="Logo" style="max-width:10px;"><br>
                         <b style="font-family: Poppins; font-size:19px">' . $info_name . '</b><br>
                         <i> Leave it to the professionals</i> <br>
                         ' . $info_add . '<br>
                         ' . $info_con . '
                    
            
 ';






$pdf->AddPage();
$pdf->Image('../img/logo/logo.jpg',10,7,32,0,'','#');
$pdf->SetFont('Arial', 'I', 12);
$pdf->WriteHTML($html);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',20);
$pdf->Cell(190,9,$in_type,0,0,'R');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190,9,'#'.$invo,0,1,'R');
$pdf->Ln(-4);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190,9,'JOB No.'.$job_id,0,1,'R');
$pdf->Ln(-3);
$pdf->Cell(190,9,$name,0,1,'R');
$pdf->Ln(-3);
$pdf->Cell(190,9,$address,0,1,'R');
$pdf->Ln(0);
$pdf->Cell(190,9,'Date: ' . date('Y-M-d') . ' Time:' . date('H:m'),0,1,'R');
                        
$pdf->sales_list($header, $data);
$pdf->Ln(0);
$pdf->total($total+$discount,$discount);
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190,7,'Make all Cheques payable to "Advanced Cleaners"',0,1,'C');
$pdf->Ln(-2);
$pdf->Cell(190,7,'024010046919 HNB Bank Negombo',0,1,'C');
$pdf->Ln(-2);
$pdf->Cell(190,7,' FOR ENQUIRIES Negombo -031228645 COLOMBO BRANCH - 112690944',0,1,'C');
$pdf->Ln(1);
$pdf->Cell(190,9,'Thank you for your business!',0,1,'C');
$pdf->Output();
