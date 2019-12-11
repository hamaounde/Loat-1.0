<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
class PdfController extends Controller
{
    //
    public function generatePDF()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html());
        return $pdf->stream();
    }

    function convert_customer_data_to_html(){
        $customer_data = '<p> this is a paragraphe </p>
        <h1> this is a Title</h1>';
        return $customer_data;
    }
}
