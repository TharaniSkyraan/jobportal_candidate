<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use CV;

class CVParserController extends Controller
{
    
    public function index()
    {
        // echo phpinfo();
        // exit;
        $fil= 'https://mugaam.com/public/site_assets_1/tmp_pdf/resume.pdf';
        
        $fil ='./public/site_assets_1/tmp_pdf/resume.docx';
        
        $response = CV::parse($fil);
        var_dump($response);
        exit;
        
        
//         // Parse PDF file and build necessary objects.
// $parser = new \Smalot\PdfParser\Parser();
// $pdf = $parser->parseFile('./public/site_assets_1/tmp_pdf/resume.docx');

// $text = $pdf->getText();
// echo $text;

        
    }
}
