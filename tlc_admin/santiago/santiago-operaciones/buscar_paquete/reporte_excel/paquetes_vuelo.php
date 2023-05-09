<?php
	require $_SERVER['DOCUMENT_ROOT'].'/config-btrace-admin-tlc.php';
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

	$idVuelo=$_GET['vuelo'];
	$codigoVuelo=$_GET['codigo'];

	$db->prepare("SELECT
			vuelo.id_vuelos,
		    paquete.id_paquete,
		    vuelo.codigo_vuelo,
		    
		    paquete.tracking_eu,
		    paquete.tracking_garve,
		    
		    usuario.nombre,
		    usuario.apellidos,
		    usuario.rut,
		    usuario.email,
		    usuario.telefono,
		    region.nombre_region,
		    comuna.nombre_comuna,
		    usuario.direccion,
		    
		    valija.cincho,
		    paquete.consignatario,
		    courrier.nombre_currier,
		    paquete.proveedor,
		    paquete.pieza,
		    paquete.descripcion_producto,
			estado.nombre_status
		    
		FROM vuelos AS vuelo
		INNER JOIN paquete AS paquete ON paquete.id_vuelo=vuelo.id_vuelos
		INNER JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
		INNER JOIN comunas AS comuna ON comuna.id_comuna=usuario.id_comuna
		INNER JOIN region AS region ON region.id_region=usuario.id_region
		INNER JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
		INNER JOIN data_currier AS courrier ON courrier.id_currier=paquete.currier
		INNER JOIN data_status AS estado ON estado.id_status=paquete.status

		WHERE vuelo.id_vuelos=:idVuelo
	");
	$db->execute(array(':idVuelo' => $idVuelo));
	$sqlPaquete=$db->get_results();

	//CABECERA
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'Paquetes master '.$codigoVuelo)
				->setCellValue('A2', 'Fecha de informe: '.date('d/m/Y'))
				->setCellValue('A3', 'TLC Courier');

	//TITULOS
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A7', 'Paquetes master '.$codigoVuelo)
				->setCellValue('A8', 'Guia USA')
				->setCellValue('B8', 'Guia TLC')
				->setCellValue('C8', 'Cliente')
				->setCellValue('D8', 'Rut')	
				->setCellValue('E8', 'Email')
				->setCellValue('F8', 'Contacto')
				->setCellValue('G8', 'Región')
				->setCellValue('H8', 'Comuna')
				->setCellValue('I8', 'Dirección')
				->setCellValue('J8', 'Valija')
				->setCellValue('K8', 'Consignatario')
				->setCellValue('L8', 'Courier')
				->setCellValue('M8', 'Proveedor')
				->setCellValue('N8', 'Cantidad paquetes')
				->setCellValue('O8', 'Descripcion producto')
				->setCellValue('P8', 'Estado');

	//FORMATO DE LOS TITULOS
			$objPHPExcel->getActiveSheet()->mergeCells('A7:P7');
			$objPHPExcel->getActiveSheet()->getStyle('A7:P7')->applyFromArray($styleheaders);
			$objPHPExcel->getActiveSheet()->getStyle('A8:P8')->applyFromArray($styleheaders);
			cellColor("A7:P8", '374E79');

			$y=9;

			foreach ($sqlPaquete as $paquete){
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$y, "'".$paquete->tracking_eu)
							->setCellValue('B'.$y, $paquete->tracking_garve)
							->setCellValue('C'.$y, $paquete->nombre.' '.$paquete->apellidos)
							->setCellValue('D'.$y, $paquete->rut)
							->setCellValue('E'.$y, $paquete->email)
							->setCellValue('F'.$y, $paquete->telefono)
							->setCellValue('G'.$y, $paquete->nombre_region)
							->setCellValue('H'.$y, $paquete->nombre_comuna)
							->setCellValue('I'.$y, $paquete->direccion)
							->setCellValue('J'.$y, $paquete->cincho)
							->setCellValue('K'.$y, $paquete->consignatario)
							->setCellValue('L'.$y, $paquete->nombre_currier)
							->setCellValue('M'.$y, $paquete->proveedor)
							->setCellValue('N'.$y, $paquete->pieza)
							->setCellValue('O'.$y, $paquete->descripcion_producto)
							->setCellValue('P'.$y, $paquete->nombre_status);
				$y=$y+1;
			}

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($y+1),"Total de registros: ".count($sqlPaquete));

			$objPHPExcel->getActiveSheet()->getStyle('A9:P'.($y-1))->applyFromArray($styleText4);
			$objPHPExcel->getActiveSheet()->getStyle('A9:P'.($y-1))->getAlignment()->setWrapText(true);
		

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
header('Content-Disposition: attachment;filename="master_'.$codigoVuelo.'.xls"');
header('Cache-Control: max-age=0');
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
