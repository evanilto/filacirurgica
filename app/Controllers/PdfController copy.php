<?php

namespace App\Controllers;

require_once FCPATH . 'assets/dompdf/autoload.inc.php'; 

use Dompdf\Dompdf;

class PdfController extends BaseController
{
    public function gerar()
    {
        $dados = $this->request->getPost();

        $dompdf = new Dompdf();
        $html = view('transfusao/pdf_template', ['dados' => $dados]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('guia_requisicao_transfusional.pdf', ['Attachment' => false]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function testar()
    {

        return view('layouts/sub_content', ['view' => 'transfusao/form_pdfteste']);

    }
}