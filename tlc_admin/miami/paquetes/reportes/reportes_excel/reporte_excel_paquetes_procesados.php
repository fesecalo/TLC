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
            paquete.status,
			historial.fecha,
			paquete.pieza,
            paquete.proveedor,
            currier.nombre_currier,
            paquete.tracking_eu,
            paquete.tracking_garve,
            valija.cincho,
            usuario.nombre,
			usuario.apellidos,
            paquete.id_usuario,
            paquete.descripcion_producto,
            paquete.peso,
            paquete.largo,
            paquete.ancho,
            paquete.alto,
            paquete.valor,

            paquete.id_proveedor,

			proveedor.nombre_proveedor,
			tipo_paquete.nombre_tipo_paquete

		FROM paquete AS paquete
		LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
        INNER JOIN status_log AS historial ON historial.id_paquete=paquete.id_paquete
        INNER JOIN data_currier AS currier ON currier.id_currier=paquete.currier
        LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
        LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
		LEFT JOIN data_tipo_paquete AS tipo_paquete ON tipo_paquete.id_tipo_paquete=paquete.id_tipo_paquete
		WHERE historial.id_tipo_status=2
        AND date(historial.fecha) BETWEEN :inicio AND :fin
        AND paquete.eliminado=0
        GROUP BY paquete.id_paquete
		ORDER BY historial.fecha DESC
	");
	$db->execute(array(
		':inicio' => $fecha_inicio, 
		':fin' => $fecha_fin
	));
	$sql_paquete=$db->get_results();

	//CABECERA
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Procesados en Miami')
				->setCellValue('A2', 'Fecha de informe: '.date('d/m/Y'))
				->setCellValue('A3', $conf['path_company_name'])
				->setCellValue('A4', 'Desde: '.date("d/m/Y", strtotime($fecha_inicio)).'         Hasta:'.date("d/m/Y", strtotime($fecha_fin)));

	//TITULOS
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A7', 'Procesados en Miami')
				->setCellValue('A8', 'Date Rcvd.')
				->setCellValue('B8', 'Pcs #')
				->setCellValue('C8', 'Shipper Name:')
				->setCellValue('D8', 'Delivery Company')
				->setCellValue('E8', 'Tracking Number')
				->setCellValue('F8', 'Tracking '.$conf['path_company_name'])
				->setCellValue('G8', 'BAG No.')
				->setCellValue('H8', 'Nombre del Cliente')
				->setCellValue('I8', 'TLC Number')
				->setCellValue('J8', 'Tipo de paquete')
				->setCellValue('K8', 'Description/Invoice/Amount')
				->setCellValue('L8', 'Weight')
				->setCellValue('M8', 'Length')
				->setCellValue('N8', 'Width')
				->setCellValue('O8', 'Height')
				->setCellValue('P8', 'Valor');
				

	//FORMATO DE LOS TITULOS
			$objPHPExcel->getActiveSheet()->mergeCells('A7:P7');
			$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->applyFromArray($styleheaders);
			$objPHPExcel->getActiveSheet()->getStyle('A8:P8')->applyFromArray($styleheaders);
			cellColor("A7:P8", '374E79');

			$y=9;

			foreach ($sql_paquete as $paquete){
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$y, date("d/m/Y H:i:s",strtotime($paquete->fecha)))
							->setCellValue('B'.$y, $paquete->pieza);

							if($paquete->id_proveedor==0){
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$y, $paquete->proveedor);
							}else{
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$y, $paquete->nombre_proveedor);
							}

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('D'.$y, $paquete->nombre_currier)
							->setCellValue('E'.$y, $paquete->tracking_eu)
							->setCellValue('F'.$y, $paquete->tracking_garve)
							->setCellValue('G'.$y, $paquete->cincho)
							->setCellValue('H'.$y, $paquete->nombre.' '.$paquete->apellidos)
							->setCellValue('I'.$y, $paquete->id_usuario)
							->setCellValue('J'.$y, $paquete->nombre_tipo_paquete)
							->setCellValue('K'.$y, $paquete->descripcion_producto)
							->setCellValue('L'.$y, $paquete->peso)
							->setCellValue('M'.$y, $paquete->largo)
							->setCellValue('N'.$y, $paquete->ancho)
							->setCellValue('O'.$y, $paquete->alto)
							->setCellValue('P'.$y, $paquete->valor);
				

				$y=$y+1;
			}

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($y+1),"Total de registros: ".count($sql_paquete));

			$objPHPExcel->getActiveSheet()->getStyle('A9:P'.($y-1))->applyFromArray($styleText4);
			$objPHPExcel->getActiveSheet()->getStyle('A9:P'.($y-1))->getAlignment()->setWrapText(true);

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
header('Content-Disposition: attachment;filename="Paquetes_procesados.xlsx"');
header('Cache-Control: max-age=0');
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
