<?php
    require_once './config/fpdf/fpdf.php';
    define('FPDF_FONTPATH', './config/fpdf/font/');    
    include "./config/db/conecta.php";
    
    $sql = "SELECT REUNION.id as 'id', TYPEREUNION2.tipo_reuniao as 'tipo_reuniao',
            DATE_FORMAT(REUNION.data_reuniao, '%d/%c/%Y') as 'data_reuniao', REUNION.participantes as 'participantes',
            REUNION.local as 'local', STATUSMORE.status as 'status_ata', REUNION.relator_ata as 'relator_ata',
            PROBLEMS.id as 'id', PROBLEMS.id_atas as 'id_atas',  PROBLEMS.grupo as 'grupo', PROBLEMS.cidade as 'cidade',
            PROBLEMS.problema as 'problema', PROBLEMS.acao as 'acao', STATUSMORE2.status as 'status',
            DATE_FORMAT(PROBLEMS.data_conclusao, '%d/%c/%Y') as 'data_conclusao', PROBLEMS.responsavel as 'responsavel'
            FROM Atas REUNION
            INNER JOIN Atas_Problemas PROBLEMS ON PROBLEMS.id_atas = REUNION.id
            INNER JOIN Atas_Tipo_Reuniao TYPEREUNION ON TYPEREUNION.id = PROBLEMS.status
            INNER JOIN Atas_Tipo_Reuniao TYPEREUNION2 ON TYPEREUNION2.id = REUNION.status_ata
            INNER JOIN Status STATUSMORE ON STATUSMORE.id = REUNION.status_ata
            INNER JOIN Status STATUSMORE2 ON STATUSMORE2.id = PROBLEMS.status
            WHERE REUNION.id = $id ";
    $query = mysql_query($sql) or die;
    $linha = mysql_fetch_array($query);
    
    $pdf = new FPDF("P","pt","A4");
    $pdf->AddPage();
    $pdf->Image('images/logosimersweb_big.jpg',50,15,35);
    $pdf->SetFont('arial', 'B', 14);
    $pdf->Cell(0,5,"Atas - SIMERSWEB",0,1,'C');
    $pdf->Cell(0,5,"","B",1,'C');
    $pdf->Ln(5);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(109,30,utf8_decode('Tipo de Reunião:'),0,0,"L");    
    $pdf->Cell(109,30,$linha['tipo_reuniao'],0,1,"L");
    $pdf->Cell(109,30,utf8_decode("Data da Reunião:"),0,0,"L");      
    $pdf->Cell(109,30,$linha['data_reuniao'],0,1,"L");
    $pdf->Cell(109,30,utf8_decode("Participantes:"),0,0,"J");    
    $pdf->MultiCell(450,30,$linha['participantes'],0,1,"J");
    $pdf->Cell(109,30,utf8_decode("Cidade:"),0,0,"L");   
    $pdf->Cell(109,30,$linha['cidade'],0,1,"L");    
    $pdf->Cell(109,30,utf8_decode("Local:"),0,0,"L");    
    $pdf->Cell(109,30,$linha['local'],0,1,"L");
    $pdf->Cell(109,30,utf8_decode("Relator:"),0,0,"L");    
    $pdf->Cell(109,30,$linha['relator_ata'],0,1,"J");
    $pdf->Ln(10);
    /*$pdf->Cell(170,20,utf8_decode("Problema"),1,0,"C");
    $pdf->Cell(170,20,utf8_decode("Ação"),1,0,"C");
    $pdf->Cell(95,20,utf8_decode("Data de Conclusão"),1,0,"C");
    $pdf->Cell(60,20,utf8_decode("Status"),1,0,"C");
    $pdf->Cell(65,20,utf8_decode("Responsável"),1,0,"C");
    $pdf->Ln();    */
     
    $sqldoforeach = "SELECT REUNION.id as 'id', TYPEREUNION2.tipo_reuniao as 'tipo_reuniao',
            REUNION.data_reuniao as 'data_reuniao', REUNION.participantes as 'participantes',
            REUNION.local as 'local', STATUSMORE.status as 'status_ata', REUNION.relator_ata as 'relator_ata',
            PROBLEMS.id as 'id', PROBLEMS.id_atas as 'id_atas', PROBLEMS.grupo as 'grupo', PROBLEMS.cidade as 'cidade',
            PROBLEMS.problema as 'problema', PROBLEMS.acao as 'acao', STATUSMORE2.status as 'status',
            DATE_FORMAT(PROBLEMS.data_conclusao, '%d/%c/%Y') as 'data_conclusao', PROBLEMS.responsavel as 'responsavel'
            FROM Atas REUNION
            INNER JOIN Atas_Problemas PROBLEMS ON PROBLEMS.id_atas = REUNION.id
            INNER JOIN Atas_Tipo_Reuniao TYPEREUNION ON TYPEREUNION.id = PROBLEMS.status
            INNER JOIN Atas_Tipo_Reuniao TYPEREUNION2 ON TYPEREUNION2.id = REUNION.status_ata
            INNER JOIN Status STATUSMORE ON STATUSMORE.id = REUNION.status_ata
            INNER JOIN Status STATUSMORE2 ON STATUSMORE2.id = PROBLEMS.status
            WHERE REUNION.id = $id ";
    $result = mysql_query($sqldoforeach);
    
    while ($row = mysql_fetch_array($result))
    {   
        $pdf->SetFillColor(168,168,168);
        $pdf->Cell(500,10,utf8_decode("Problema"),1,1,"C",1);
        /*$pdf->MultiCell(170,20,utf8_decode($row['problema']),1,0,"J");		*/
        $pdf->MultiCell(500,30,utf8_decode($row['problema']),1,1,"R");
        $pdf->Cell(500,10,utf8_decode("Ação"),1,1,"C",1);
        /*$pdf->MultiCell(170,20,utf8_decode($row['acao']),1,0,"J");*/
        $pdf->MultiCell(500,30,utf8_decode($row['acao']),1,1,"R");
        $pdf->Cell(50,10,utf8_decode("Cidade"),1,0,"C",1);
        $pdf->Cell(50,10,utf8_decode("Grupo"),1,0,"C",1);
        $pdf->Cell(100,10,utf8_decode("Data de Conclusão"),1,0,"C",1);
        $pdf->Cell(100,10,utf8_decode("Status"),1,0,"C",1);
        $pdf->Cell(200,10,utf8_decode("Responsável"),1,1,"C",1);        
        $pdf->Cell(50,20,utf8_decode($row['cidade']),1,0,"C");
        $pdf->Cell(50,20,utf8_decode($row['grupo']),1,0,"C");
        $pdf->Cell(100,20,$row['data_conclusao'],1,0,"C");
        $pdf->Cell(100,20,utf8_decode($row['status']),1,0,"C");
        $pdf->Cell(200,20,utf8_decode($row['responsavel']),1,0,"C");
        /*$pdf->Cell(95,20,utf8_decode("Data de Conclusão"),1,0,"C");
        $pdf->Cell(60,20,utf8_decode("Status"),1,0,"C");
        $pdf->Cell(65,20,utf8_decode("Responsável"),1,1,"C");
        $pdf->Cell(95,20,$row['data_conclusao'],1,0,"C");
        $pdf->Cell(60,20,utf8_decode($row['status']),1,0,"C");
        $pdf->Cell(65,20,utf8_decode($row['responsavel']),1,0,"C");*/
        $pdf->Ln();   
        $pdf->Ln();  
    } 
        /*
    foreach ($result as $row)
    {   
        $pdf->Cell(170,20,$row['problema'],1,0,"J");		
        $pdf->Cell(170,20,$row['acao'],1,0,"J");
        $pdf->Cell(95,20,$row['data_conclusao'],1,0,"C");
        $pdf->Cell(60,20,$row['status'],1,0,"C");
        $pdf->Cell(65,20,$row['responsavel'],1,0,"C");
        $pdf->Ln();
    } */
		
    $pdf->SetY("735");
    $dia = date("d/m/Y");
    $contenido = "Ata impressa em ".$dia;
    $texto = "SIMERS";
    $pdf->Cell(0,5,$texto,0,0,'L');
    $pdf->Ln(9);
    $pdf->Cell(0,5,$contenido,0,0,'L');
    $pdf->SetAutoPageBreak(1,20);
    $pdf->Output("teste.pdf","D");    
    mysql_close($db);    
?>