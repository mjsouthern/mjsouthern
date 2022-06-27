<?php
	function generateRow(){
		$contents = '';
		include_once('connection.php');
		$sql = "SELECT * FROM members";

		//use for MySQLi OOP
		$query = $conn->query($sql);
		while($row = $query->fetch_assoc()){
			$contents .= "
			<tr>
				<td>".$row['id']."</td>
				<td>".$row['firstname']."</td>
				<td>".$row['lastname']."</td>
				<td>".$row['address']."</td>
			</tr>
			";
		}
		////////////////

		//use for MySQLi Procedural
		// $query = mysqli_query($conn, $sql);
		// while($row = mysqli_fetch_assoc($query)){
		// 	$contents .= "
		// 	<tr>
		// 		<td>".$row['id']."</td>
		// 		<td>".$row['firstname']."</td>
		// 		<td>".$row['lastname']."</td>
		// 		<td>".$row['address']."</td>
		// 	</tr>
		// 	";
		// }
		////////////////
		
		return $contents;
	}

	require_once('tcpdf/tcpdf.php');  
    // $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf = new TCPDF('P', 'mm', array(215.9, 279.4), true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle("Print Members Information");  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->AddPage();  
    $content = '';  
    $content .= '
      	<h2 align="center">Print Members Information</h2>
      	<h4>Members Table</h4>
      	<table border="1" cellspacing="0" cellpadding="3">  
           <tr>  
                <th width="5%">ID</th>
				<th width="20%">Firstname</th>
				<th width="20%">Lastname</th>
				<th width="55%">Address</th> 
           </tr>  
      ';  
    $content .= generateRow();  
    $content .= '</table>';  
    $content .= <<<EOD
    <p><u>MARLON JUHN M. TIMOGAN, MIT<u></p>
    EOD;
    $pdf->writeHTML($content);  
    $pdf->Output('members.pdf', 'I');
	

?>