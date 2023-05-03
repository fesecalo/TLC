<?php
function Paginacion($b, $npag, $total_paginas, $tp, $obj, $pagina) {
	$prevlabel = "&lsaquo; Anterior";
	$nextlabel = "Siguiente &rsaquo;";
	$out = '<ul class="pagination">';

	if ($total_paginas > 0) {
		if ($npag != 1){
			$out.= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onClick="abreLink('."'".URL_SITIO.$pagina.'/'.$pagina.'.php?p='.$tp.'&pag='.($npag-1).'&b='.$b."'".','."'page-inner'".');">'.$prevlabel.'</a></li>';
		}else{
			$out.= '<li class="page-item disabled"><a class="page-link">'.$prevlabel.'</a></li>';
		}
		for ($i=1;$i<=$total_paginas;$i++) {
			if ($npag == $i)
				//si muestro el �ndice de la p�gina actual, no coloco enlace
				$out.= '<li class="page-item active">  <a class="page-link">'.$npag.'</a>  </li>';
			else
				//si el �ndice no corresponde con la p�gina mostrada actualmente,
				//coloco el enlace para ir a esa p�gina
				$out.= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onClick="abreLink('."'".URL_SITIO.$pagina.'/'.$pagina.'.php?p='.$tp.'&pag='.$i.'&b='.$b."'".','."'page-inner'".');">'.$i.'</a></li>';
		}
		if ($npag != $total_paginas){
			$out.= '<li class="page-item"><a class="page-link" href="javascript:void(0);" onClick="abreLink('."'".URL_SITIO.$pagina.'/'.$pagina.'.php?p='.$tp.'&pag='.($npag+1).'&b='.$b."'".','."'page-inner'".');">'.$nextlabel.'</a></li>';
		}else {
		$out.= '<li class="page-item disabled"><a class="page-link">'.$nextlabel.'</a></li>';
		}
	}
	$out.= "</ul>";
	return $out;
}
?>