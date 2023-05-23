<?php
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';

// header para solucionar problemas con caracteres especiales
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.6, 2011-02-27
 */

/** Error reporting */
//error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
//require_once '../Classes/PHPExcel.php';
require $conf['path_host'].'/PHPExcel-1.8/Classes/PHPExcel.php';


// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
/*$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");*/


// Add some data
//echo date('H:i:s') . " Add some data\n";
/*$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');*/
//PARAMENTROS	
	$meses=array('1'=>"Enero",'2'=>"Febrero",'3'=>"Marzo",'4'=>"Abril",'5'=>"Mayo",'6'=>"Junio",'7'=>"Julio",'8'=>"Agosto",'9'=>"Septiembre",'10'=>"Octubre",'11'=>"Noviembre",'12'=>"Diciembre");
	$letras=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$x="ñ";


	//FUNCIONES PARA FORMATO
	$styleArray = array(
		'alignment' => array(
                'wrapText' => true,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

            ),
	  'borders' => array(
	    'allborders' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN

	    )
	  )
	);
	$styleText = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
    ));

	

	function cellColor($cells,$color){
        global $objPHPExcel;
        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()
        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => $color)
        ));
    }
	$styleheaders = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
    ),
    'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

            ),
    'borders' => array(
	    'allborders' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN

	    )
	  )
	);

	$styleText4 = array(
    'font'  => array(
        'color' => array('rgb' => '000000'),
    ),
    'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER

            ),
    'borders' => array(
	    'allborders' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN

	    )
	  )
	);

	$fecha_inicio=$_GET['fecha_inicio'];
    $fecha_fin=$_GET['fecha_termino'];
    
	$db->prepare("SELECT 
			paquete.id_paquete,
			historial.fecha,
            paquete.proveedor,
            currier.nombre_currier,
            paquete.tracking_eu,
            paquete.tracking_garve,
            usuario.nombre,
			usuario.apellidos,
            paquete.id_usuario,
            paquete.descripcion_producto,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,

			estado.nombre_status,

			cargo.aduana,
			cargo.flete,
			cargo.manejo,
			cargo.proteccion,
			cargo.total

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON (historial.id_paquete=paquete.id_paquete AND historial.id_tipo_status=23)
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
        INNER JOIN data_status AS estado ON estado.id_status=paquete.status
        INNER JOIN cargos AS cargo ON cargo.id_cargo=paquete.id_cargo
        
		WHERE date(historial.fecha) BETWEEN :inicio AND :fin
        GROUP BY paquete.id_paquete
		ORDER BY historial.fecha ASC
	");
	$db->execute(array( 
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_paquete=$db->get_results();

	//CABECERA
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Paquetes pagados sin entrega')
				->setCellValue('A2', 'Fecha de informe: '.date('d/m/Y'))
				->setCellValue('A3', $conf['path_company_name'])
				->setCellValue('A4', 'Desde: '.date("d/m/Y", strtotime($fecha_inicio)).'         Hasta:'.date("d/m/Y", strtotime($fecha_fin)));

	//TITULOS
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A7', 'Paquetes pagados sin entrega')
				->setCellValue('A8', 'Fecha')
				->setCellValue('B8', 'Shipper Name')
				->setCellValue('C8', 'Delivery Company')
				->setCellValue('D8', 'Tracking Number')
				->setCellValue('E8', 'Tracking '.$conf['path_company_name'])
				->setCellValue('F8', 'Nombre del Cliente')
				->setCellValue('G8', 'CHI Number')
				->setCellValue('H8', 'Description/Invoice/Amount')
				->setCellValue('I8', 'Aduana')
				->setCellValue('J8', 'Flete')
				->setCellValue('K8', 'Manejo')
				->setCellValue('L8', 'Protección')
				->setCellValue('M8', 'Total');
				

	//FORMATO DE LOS TITULOS
			$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
			$objPHPExcel->getActiveSheet()->getStyle('A7:M7')->applyFromArray($styleheaders);
			$objPHPExcel->getActiveSheet()->getStyle('A8:M8')->applyFromArray($styleheaders);
			cellColor("A7:M8", '374E79');

			$y=9;

			foreach ($sql_paquete as $paquete){
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$y, date("d/m/Y H:i:s",strtotime($paquete->fecha)));

							if($paquete->id_proveedor==0){
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$y, $paquete->proveedor);
							}else{
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$y, $paquete->nombre_proveedor);
							}

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('C'.$y, $paquete->nombre_currier)
							->setCellValue('D'.$y, $paquete->tracking_eu)
							->setCellValue('E'.$y, $paquete->tracking_garve)
							->setCellValue('F'.$y, $paquete->nombre.' '.$paquete->apellidos)
							->setCellValue('G'.$y, $paquete->id_usuario)
							->setCellValue('H'.$y, $paquete->descripcion_producto)
							->setCellValue('I'.$y, $paquete->aduana)
							->setCellValue('J'.$y, $paquete->flete)
							->setCellValue('K'.$y, $paquete->manejo)
							->setCellValue('L'.$y, $paquete->proteccion)
							->setCellValue('M'.$y, $paquete->total);

				$y=$y+1;
			}

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($y+1),"Total de registros: ".count($sql_paquete));

			$objPHPExcel->getActiveSheet()->getStyle('A9:M'.($y-1))->applyFromArray($styleText4);
			$objPHPExcel->getActiveSheet()->getStyle('A9:M'.($y-1))->getAlignment()->setWrapText(true);

			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("R")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("S")->setWidth(25);
		

//orienracion
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
//bordes


// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Paquetes_pagados_sin_entrega.xls"');
header('Cache-Control: max-age=0');
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
