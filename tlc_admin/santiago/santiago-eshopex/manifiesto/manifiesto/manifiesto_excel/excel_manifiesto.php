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
				->setCellValue('A1', 'N° USUARIO')
				->setCellValue('B1', 'CONSIGNATARIO')
				->setCellValue('C1', 'RUT')
				->setCellValue('D1', 'DIRECCION')
				->setCellValue('E1', 'COURRIER')
				->setCellValue('F1', 'DESCRIPCION')
				->setCellValue('G1', 'TIENDA')
				->setCellValue('H1', 'VALOR USD')
				->setCellValue('I1', 'PESO KG')
				->setCellValue('J1', 'CANTIDAD')
				->setCellValue('K1', 'GUIA');
			
	//FORMATO DE LOS TITULOS

				$id=$_GET["id"];

				$db->prepare("SELECT
						usuario.id_usuario,
						paquete.consignatario,
						paquete.rut,
						paquete.direccion,
						currier.nombre_currier,
						paquete.descripcion_producto,
						paquete.proveedor,
						paquete.valor,
						paquete.peso,
						paquete.pieza,
						paquete.tracking_eu

					FROM paquete as paquete
					LEFT JOIN gar_usuarios AS usuario ON usuario.id_usuario=paquete.id_usuario
					LEFT JOIN data_currier AS currier ON currier.id_currier=paquete.currier
					LEFT JOIN comunas AS comuna ON comuna.id_comuna=usuario.id_comuna
					LEFT JOIN valijas AS valija ON valija.id_valija=paquete.id_valija
					LEFT JOIN data_proveedor AS proveedor ON proveedor.id_proveedor=paquete.id_proveedor
					WHERE paquete.id_vuelo=:id AND paquete.envio_entregado=0
					ORDER BY id_paquete DESC
				");
				$db->execute(array(':id' => $id));

				$sql_paquete=$db->get_results();

				$y=2;
				foreach ($sql_paquete as $key => $paquete) {

					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$y, $paquete->id_usuario)
								->setCellValue('B'.$y, $paquete->consignatario)
								->setCellValue('C'.$y, $paquete->rut)
								->setCellValue('D'.$y, $paquete->direccion)
								->setCellValue('E'.$y, $paquete->nombre_currier)
								->setCellValue('F'.$y, $paquete->descripcion_producto)
								->setCellValue('G'.$y, $paquete->proveedor)
								->setCellValue('H'.$y, $paquete->valor)
								->setCellValue('I'.$y, $paquete->peso)
								->setCellValue('J'.$y, $paquete->pieza)
								->setCellValue('K'.$y, $paquete->tracking_eu);
					$y=$y+1;
				} 
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($y+1),"Total de paquetes: ".count($sql_paquete));

			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setWidth(10);
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
header('Content-Disposition: attachment;filename="reporte_excel.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
