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
        #$dados = $this->request->getPost();

        #$this->transfusaoModel = new TransfusaoModel();
        #$requisicao = $this->transfusaoModel->find($id);

        $db = \Config\Database::connect('default');

        $builder = $db->table('vw_transfusoes');

        $requisicao = $builder->select('vw_transfusoes.*')->where('vw_transfusoes.idreq', $id)->get()->getResult();

        $dados = isset($requisicao[0]) ? (array) $requisicao[0] : [];

        //dd($dados);

        $html = view('transfusao/pdf_template_completo', ['dados' => $dados]);

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