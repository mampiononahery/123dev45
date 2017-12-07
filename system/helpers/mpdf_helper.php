<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('generate_pdf')) {
	function generate_pdf($html,$filename,$mode='',$format='A4',$default_font_size=0,$default_font='',$margin_left=15,$margin_right=15,$margin_top=16,$margin_bottom=16,$margin_header=9,$margin_footer=9, $orientation='P', $download=true, $save_folder='assets/uploads/'){
		require_once("mpdf/mpdf.php");
		$CI =& get_instance();
		/*$pdfFilePath = $CI->config->item('dir_pdf').$filename.".pdf";
        var_dump($CI->config->item('dir_pdf')); die;
		if (!file_exists($CI->config->item('dir_pdf'))) {
		    mkdir('test2', 0777, true);
		}*/
        $pdfFilePath = $save_folder.$filename.".pdf";
       	if (!file_exists($save_folder)) {
		    mkdir($save_folder, 0777, true);
		}
		//var_dump($CI->config->item('dir_pdf'));die;
		if (file_exists($pdfFilePath)) {
			unlink($pdfFilePath);
		}
		ini_set('memory_limit','1500M');
		ini_set('max_execution_time','-1');
		if($orientation=='L'){
			$pdf=new mPDF();
			$pdf->AddPage('L', // L - landscape, P - portrait
            '', '', '', '',
            $margin_left, // margin_left
            $margin_right, // margin right
            $margin_top, // margin top
            $margin_bottom, // margin bottom
            $margin_header, // margin header
            $margin_footer); // margin footer
		}
		else $pdf = new mPDF($mode,$format,$default_font_size,$default_font,$margin_left,$margin_right,$margin_top,$margin_bottom,$margin_header,$margin_footer, $orientation);
	    //$pdf->SetFooter('|{PAGENO}|');
	    $pdf->WriteHTML($html);
	    if(!$download){
	    	$pdf->setFooter('{PAGENO}/{nbpg}');
	    	$pdf->Output($save_folder.$filename.".pdf", 'F');
	    	//exit();
	    }
	    else{
	    	//	redirect(base_url().$pdfFilePath);
	    	$pdf->setFooter('{PAGENO}/{nbpg}');
			$pdf->Output("".$filename.".pdf","I"); exit();
	    }
		//redirect(base_url().$pdfFilePath);
	    /*$pdf->setFooter('{PAGENO}/{nbpg}');
		$pdf->Output("".$filename,"I"); exit();*/
	}
}
