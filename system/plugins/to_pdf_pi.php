<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename, $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    spl_autoload_register('DOMPDF_autoload');
    
    $dompdf = new DOMPDF();

    $dompdf->load_html(utf8_decode($html));
    $dompdf->render();

    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        $CI =& get_instance();
        $CI->load->helper('file');
		$file_path = BASEPATH."tmp/bill_".$filename.".pdf";
        write_file($file_path, $dompdf->output());
		return $file_path;
    }

}
?>