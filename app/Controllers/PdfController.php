<?php

namespace App\Controllers;

use App\Models\TransfusaoModel;


require_once FCPATH . 'assets/dompdf/autoload.inc.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{

    private $transfusaoModel;

    public function gerar($id)
    {
        $this->transfusaoModel = new TransfusaoModel();

        #$dados = $this->request->getPost();
        $requisicao = $this->transfusaoModel->find($id);

        //dd($requisicao);

        $html = view('transfusao/pdf_template_completo', ['dados' => $requisicao]);

        // Configuração moderna
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', FCPATH); // Limita a leitura de arquivos a /public
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("requisicao_transfusional.pdf", ['Attachment' => false]);
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