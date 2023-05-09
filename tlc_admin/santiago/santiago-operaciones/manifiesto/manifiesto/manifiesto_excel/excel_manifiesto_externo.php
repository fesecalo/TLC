<?php
// CONEXION A LA BD
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
// header para solucionar problemas con caracteres especiales
header('Content-Type: text/html; charset=iso-8859-1');
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
require $conf['path_host'].'/PHPExcel-1.8/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

//PARAMENTROS	
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

	//TITULOS
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'N° DE GUIA')
				->setCellValue('B1', 'CLIENTE')
				->setCellValue('C1', 'DESTINO')
				->setCellValue('D1', 'PIEZAS')
				->setCellValue('E1', 'PESO')
				->setCellValue('F1', 'DESCRIPCION')
				->setCellValue('G1', 'VALOR')
				->setCellValue('H1', 'PROVEEDOR')
				->setCellValue('I1', 'ORIGEN')
				->setCellValue('J1', 'FECHA')
				->setCellValue('K1', 'VUELO')
				->setCellValue('L1', 'MASTER')
				->setCellValue('M1', 'FECHA MASTER')
				->setCellValue('N1', 'ESTADO')
				->setCellValue('O1', 'RUT')
				->setCellValue('P1', 'DIRECCION')
				->setCellValue('Q1', 'COMUNA')
				->setCellValue('R1', 'SEGURO')
				->setCellValue('S1', 'FLETE')
				->setCellValue('T1', 'EMPRESA')
				->setCellValue('U1', 'TIPO DE ENVIO')
				->setCellValue('V1', 'TIPO FLETE');
			
	//FORMATO DE LOS TITULOS

				$id=$_GET["id"];

				$db->prepare("SELECT
						tracking_garve,
						tracking_eu,
						consignatario,
						pieza,
						peso,
						descripcion_producto,
						valor,
						proveedor,
					    
					    vuelo.fecha_creacion,
					    vuelo.num_vuelo,
					    vuelo.codigo_vuelo,
					    vuelo.fecha_salida,
					    
						rut,
						direccion,
						comuna,
						flete,
						tipo_flete
					    
					FROM paquete AS paquete
					INNER JOIN vuelos AS vuelo ON vuelo.id_vuelos=paquete.id_vuelo
					WHERE paquete.id_vuelo=:id
					ORDER BY id_paquete ASC
				");
				$db->execute(array(':id' => $id));
				$sql_paquete=$db->get_results();

				$y=2;
				foreach ($sql_paquete as $key => $paquete) {

					$trackingUSA="=\"".$paquete->tracking_eu."\"";

					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$y, $trackingUSA)
						->setCellValue('B'.$y, $paquete->consignatario)
						->setCellValue('C'.$y, 'SCL')
						->setCellValue('D'.$y, $paquete->pieza)
						->setCellValue('E'.$y, $paquete->peso)
						->setCellValue('F'.$y, $paquete->descripcion_producto)
						->setCellValue('G'.$y, $paquete->valor)
						->setCellValue('H'.$y, $paquete->proveedor)
						->setCellValue('I'.$y, 'MIA')
						->setCellValue('J'.$y, date("d/m/Y H:i:s",strtotime($paquete->fecha_creacion)))
						->setCellValue('K'.$y, $paquete->num_vuelo)
						->setCellValue('L'.$y, $paquete->codigo_vuelo)
						->setCellValue('M'.$y, date("d/m/Y H:i:s",strtotime($paquete->fecha_salida)))
						->setCellValue('N'.$y, '-')
						->setCellValue('O'.$y, $paquete->rut)
						->setCellValue('P'.$y, $paquete->direccion)
						->setCellValue('Q'.$y, $paquete->comuna)
						->setCellValue('R'.$y, '0')
						->setCellValue('S'.$y, $paquete->flete)
						->setCellValue('T'.$y, 'TLC')
						->setCellValue('U'.$y, '1')
						->setCellValue('V'.$y, $paquete->tipo_flete);
					$y=$y+1;
				} 
				
				// $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($y+1),"Total de paquetes: ".count($sql_paquete));

			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setWidth(10);
			$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setWidth(10);
		

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
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));


// Echo memory peak usage
//echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
//echo date('H:i:s') . " Done writing file.\r\n";

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="manifiesto.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
