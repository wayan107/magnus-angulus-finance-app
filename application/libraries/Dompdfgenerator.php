<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('dompdf/dompdf_config.inc.php');
class Dompdfgenerator{
	function generate($html,$filename){
		$pdf = new DOMPDF();
		$pdf->load_html($html);
		$pdf->render();
		$pdf->stream($filename.".pdf",array('Attachment'=>0));
	}
}