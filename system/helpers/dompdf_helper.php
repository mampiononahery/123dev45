<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('pdf_create')) {
	function pdf_create($html, $filename='', $stream=TRUE, $size=false, $orientation="portrait") {
		require_once("dompdf/dompdf_config.inc.php");

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		if($size){
			$dompdf->set_paper($size, $orientation);
		}
		$dompdf->render();
		if ($stream) {
			$dompdf->stream($filename.".pdf");
		} else {
			return $dompdf->output();
		}
	}
}
