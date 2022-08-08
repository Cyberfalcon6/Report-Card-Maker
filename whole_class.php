<?php
if(isset($_POST['class']))
{
require_once("fpdf/fpdf.php");
$pdf = new FPDF();
$conn = mysqli_connect("localhost","root","");
mysqli_select_db($conn, "temp");
$class = $_POST['class'];
$results = mysqli_query($conn, "SELECT `Names` FROM $class WHERE 1");
foreach($results as $res)
{
$student = $res['Names'];
$first_name = substr($student,0,strpos($student," "));
$second_name = substr($student,strpos($student," ")+1);
$pdf->AddPage("l");
$pdf->SetFont("Arial","B",8);

$class_size = 0;
$general_rank = "";
$size = mysqli_query($conn,"SELECT `Names` FROM $class WHERE 1");
foreach($size as $s)
{
      $class_size = $class_size + 1;
}
if(substr($class,0,6)=="senior")
{
    $class_exam = $class."_exam";
    $class_rank = $class."_rank";
    $class_maximum = $class."_maximum";
    $class_total = $class."_total";
}
else {
    $class_exam = (substr($class,0,(strlen($class)-3))).("_exam").(substr($class,(strlen($class)-3),3));
    $class_rank = (substr($class,0,(strlen($class)-3))).("_rank").(substr($class,(strlen($class)-3),3));
    $class_maximum = (substr($class,0,(strlen($class)-3))).("_maximum").(substr($class,(strlen($class)-3),3));
    $class_total = (substr($class,0,(strlen($class)-3))).("_total").(substr($class,(strlen($class)-3),3));
}
$dob = "";
$id = "";
$place_of_birth = "";
$personal_details = mysqli_query($conn,"SELECT `dob`,`place_of_birth`,`id` FROM `students` WHERE `First Name`='$first_name' and `Second Name`='$second_name' and `class`='$class'");
foreach($personal_details as $p)
{
    $dob = $p['dob'];
    $id = $p['id'];
    $place_of_birth = $p['place_of_birth'];
}
//THE CODE TO START DRAWING THE REPORT CARD

$pdf->cell(40,5,"REPUBLIC OF RWANDA",0,0);                                                                   
$pdf->SetX(100);
$pdf->cell(40,5,"MINISTRY OF EDUCATION",0,1);
$pdf->SetX(10);
$pdf->SetFont("Arial","",8);
$pdf->cell(40,5,"GS BWENDA ",0,0); 
$pdf->SetX(100);                                                                                            
$pdf->cell(40,5,"2022-2023",0,1);
$pdf->SetX(10);
$pdf->cell(40,5,"GAKENKE/MUHONDO",0,0); 
$pdf->SetX(100);                                                                                    
$pdf->cell(40,5,"2nd TERM",0,1);
$pdf->SetFont("Arial","B",15);
$pdf->cell(140,7,"Report Card","TB",1,"C");
$pdf->SetFont("Arial","",12);
$pdf->SetX(10);
$pdf->cell(40,5,"Student Name: $student",0,1); 
$pdf->cell(40,5,"born: $dob",0,0); 
$pdf->SetX(45);
$pdf->cell(40,5,"at: $place_of_birth ",0,0);
$pdf->SetX(100);
$pdf->cell(40,5,"class: $class ",0,1);
$pdf->SetX(10); 
$pdf->cell(40,5,"ID: $id ",0,0);
$pdf->SetX(45);
$pdf->cell(40,5,"N. Students: $class_size  ",0,0);
$pdf->SetX(100);
$pdf->cell(40,5,"conduct: 30  out of  40 ",0,1);
$subjects = $conn->query("DESCRIBE $class");
$row_counter = 0;
$pdf->cell(45,7,"SUBJECTS","TLR",0);
$pdf->cell(40,7,"MAX",1,0);
$pdf->cell(40,7,"O.P",1,0);
$pdf->cell(15,7,"RANK","TLR",1);
$pdf->cell(45,7," ","BLR",0);
$pdf->cell(13.333,7,"TEST",1,0);
$pdf->cell(13.333,7,"EX",1,0);
$pdf->cell(13.333,7,"TOT",1,0);
$pdf->cell(13.333,7,"TEST",1,0);
$pdf->cell(13.333,7,"EX",1,0);
$pdf->cell(13.333,7,"TOT",1,0);
$pdf->cell(15,7,"","BLR",1);
foreach($subjects as $sub)
{
    $test = 0;
    $exam = 0;
    if($row_counter==0)                   //skipping the first column which is names
    {
        $row_counter++;               
        continue;
    }
    $current = $sub['Field'];
    $pdf->cell(45,7,$current,1,0);
    $maximum = $conn->query("SELECT `".$sub['Field']."` FROM $class_maximum WHERE 1");
    
    foreach($maximum as $m)
    { 
        foreach($m as $n)
        {
            $pdf->cell(13.333,7,$n,1,0);
            $pdf->cell(13.333,7,$n,1,0);

            $pdf->cell(13.333,7,$n*2,1,0);
        }}
        $op_test = $conn->query("SELECT `".$current."` FROM $class WHERE Names='$student'");
        
        foreach($op_test as $sub_op){
            foreach($sub_op as $sub_sub_op)
            {
                if($sub_sub_op<($n/2))
                {
                    $pdf->SetFont("Arial","u",12);
                }
                else
                {
                    $pdf->SetFont("Arial","",12);
                }
                $pdf->cell(13.333,7,$sub_sub_op,1,0);
                $test = $sub_sub_op;
                $pdf->SetFont("Arial","",12);
            }
        }
        $op_exam = $conn->query("SELECT `$current` FROM $class_exam WHERE Names='$student'");
        foreach($op_exam as $sub_op){
            foreach($sub_op as $sub_sub_op)
            {
                if($sub_sub_op<($n/2))
                {
                    $pdf->SetFont("Arial","u",12);
                    $pdf->cell(13.333,7,$sub_sub_op,1,0);
                }
                else
                {
                    $pdf->SetFont("Arial","",12);
                    $pdf->cell(13.333,7,$sub_sub_op,1,0);
                }
                
                $exam = $sub_sub_op;
                $total = $exam + $test;
                if($total<($n))
                {
                    $pdf->SetFont("Arial","u",12);
                    $pdf->cell(13.333,7,$total,1,0);
                }
                else
                {
                    $pdf->SetFont("Arial","",12);
                    $pdf->cell(13.333,7,$total,1,0);
                }
                $pdf->SetFont("Arial","",12);
    
            }
        }
         $reserved = $current;
        if($reserved=="Total")
        {
            $reserved = "General Rank";
            $rank = mysqli_query($conn, "SELECT `$reserved` FROM `$class_rank` WHERE `Names`='$student'");
            foreach($rank as $r)
        {
            $pdf->cell(15,7,"$r[$reserved]",1,1);
            $general_rank = $r[$reserved];
        }
        }
        else{
        $rank = mysqli_query($conn, "SELECT `$reserved` FROM `$class_rank` WHERE `Names`='$student'");
        foreach($rank as $r)
        {
            $pdf->cell(15,7,"$r[$reserved]",1,1);
        }
    }
        }
    

$max = 1;
$optimum = 1;
$coum = 0;
$cou = 0;
$tot_max = mysqli_query($conn,"SELECT `Total` FROM $class_maximum WHERE 1");
foreach($tot_max as $tot)
{
    if($coum==0)
    {
        $max = $tot['Total'];
        $coum = $coum + 1;
    }
}
$tot_op = mysqli_query($conn,"SELECT `Total` FROM $class_total WHERE `Names`='$student'");
foreach($tot_op as $top)
{ 
    if($cou==0)
    {
        $optimum = $top['Total'];
        $cou = $cou + 1;
    }
}
$max = $max * 2;
$pdf->cell(45,7,"Average ",1,0);
$avg = ($optimum/$max)*100;
$avg=round($avg,2);
$pdf->cell(40,7,$avg."%",1,0);
$pdf->cell(26.777777777,7,"Rank ",1,0);
$pdf->cell(28.333333333,7,$general_rank." out of ".$class_size,1,1);
$pdf->cell(70,20,"Observations","TLR",0);
$pdf->cell(70,20,"Teacher Signature",1,1);
$pdf->cell(70,20," ","BLR",0);
$pdf->cell(70,20,"Parent Signature",1,0);

}
}
$pdf->output("$student _report_card.pdf","I");
?>