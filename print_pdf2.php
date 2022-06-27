<?php

include_once('connection.php');
$sql = "SELECT * FROM members";

//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf_include.php');
require_once('tcpdf/tcpdf.php');  


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = '1.png';

        $html = <<<EOD
            <table style="align:center;">
                <tr>
                    <td rowspan="4" width="10%" style="text-align:right;">
                      <img src="1.png" width="73px" height="75px" />
                    </td>
                     <td style="text-align:center;" width="75%"><h2>SAINT MICHAEL COLLEGE OF CARAGA</h2>
                     </td>
                    <td rowspan="4" width="15%" style="text-align:left;">
                      <img src="2.jpg" width="95x" height="75px" />
                    </td>
                </tr>
                <tr>
                     <td style="text-align:center"><p>Brgy. 4, Atupan St. Nasipit, Agusan del Norte</p>
                     </td>
                </tr>
                <tr>
                     <td style="text-align:center; font-weight: bold;"><p>COLLEGE OF COMPUTING AND INFORMATION SCIENCES</p>
                     </td>
                </tr>
                <tr>
                     <td style="text-align:center; font-weight: bold;"><br><h3>EVALUATION RESULTS</h3>
                     </td>
                </tr>
            </table>
        EOD;

        $details = <<<EOD
           <table>
                <tr>
                    <td width="150px">Name: </td>
                    <td style="text-decoration:underline;">Marlon Juhn M. Timogan</td>
                </tr>
                <tr>
                    <td>Year Level and Course: </td>
                    <td style="text-decoration:underline">BSIT-IV</td>
                </tr>
                <tr>
                    <td>School Year and Semester: </td>
                    <td style="text-decoration:underline">2021-2022 2nd Sem</td>
                </tr>
           </table>
        EOD;

        $tableheads = <<<EOD
            <style>
                table {
                    width : 100%;
                }
                th {
                    border-top : 1px solid black;
                    border-bottom : 1px solid black;
                    font-weight : bold;
                }
            </style>
            <table>
                <thead>
                    <tr>
                        <th style="width:20%">ID</th>
                        <th style="width:20%">First Name</th>
                        <th style="width:20%">Last Name</th>
                        <th style="width:40%" align="center">Address</th>
                    </tr>
                </thead>
            </table>
        EOD;

            $this->writeHTML($html, true, 0, true, 0);
            $this->writeHTML($details, true, 0, true, 0);
            $this->writeHTML($tableheads, true, 0, true, 0);



        // $this->Cell(0, 0, 'Saint Michael College of Caraga', 1, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);

        $this->Line(5, $this->y, $this->w - 5, $this->y);
        // Page number
        $this->Cell(0, 10, 'www.smccnasipit.edu.ph', 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
// custom into short bond-paper size
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', Array(215.9, 279.4), true, 'UTF-8', false);

// set document information
$pdf->SetCreator('MJ Timogan');
$pdf->SetAuthor('MJ Timogan');
$pdf->SetTitle('Evaluation Results');
$pdf->SetSubject('Evaluation Results');
$pdf->SetKeywords('evaluation, results');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 65, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();

$html = "<table><tbody>";

//use for MySQLi OOP
$query = $conn->query($sql);
while($row = $query->fetch_assoc()){ 
   $html .= '<tr>
                    <td style="width:20%">'.$row['id'].'</td>
                    <td style="width:20%">'.$row['firstname'].'</td>
                    <td style="width:20%">'.$row['lastname'].'</td>
                    <td style="width:40%;">'.$row['address'].'</td>
            </tr>';
}

// for ($i=0; $i < 60; $i++) { 
//        $html .= '<tr>
//                     <td style="width:20%">'. ($i+1) .'</td>
//                     <td style="width:20%">Marlon Juhn</td>
//                     <td style="width:20%">Timogan</td>
//                     <td style="width:40%;">Brgy. 7, Nasipit, Agusan del Norte</td>
//             </tr>';
// }



$html .= "</tbody></table>";

$pdf->writeHTML($html);  

$end = <<<EOD
    <p align="center" style="font-weight:bold; font-style:italic">****** Nothing Follows ******</p><br>
EOD;

$pdf->writeHTML($end);  

$signatories = <<<EOD
    <table>
        <tr>
            <td>
                Prepared by: <br><br>
                <b style="text-decoration:underline;">MARLON JUHN M. TIMOGAN, MIT</b> <br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Instructor
                <br><br>
                Date: <br><br>
                ___________________________
            </td>

            <td>
                Approved by: <br><br>
                <b style="text-decoration:underline;">&nbsp; &nbsp;DAISA O. GUPIT, MIT</b> <br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Dean
                <br><br>
                Date: <br><br>
                ___________________________
            </td>
        </tr>

    </table>
EOD;

// $pdf->writeHTML($signatories);  

$pdf->writeHTMLCell(0, 0, 15, 210, $signatories, 0, 0, false,true, "L", true);

// reset pointer to the last page
$pdf->lastPage();



// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('eval-results.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+