<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransfusaoModel;
use App\Models\LocalFatItensProcedHospitalarModel;
use App\Models\HemocomponentesModel;

class Transfusao extends BaseController
{
    protected $transfusaoModel;

    private $hemocomponentesmodel;
    private $selecthemocomponentes;
    private $selectitensprocedhospitativos;
    private $localfatitensprocedhospitalarmodel;

    public function __construct()
    {
        $this->transfusaoModel = new TransfusaoModel();
        $this->hemocomponentesmodel = new HemocomponentesModel();
        $this->localfatitensprocedhospitalarmodel = new LocalFatItensProcedHospitalarModel();
              
        $this->selecthemocomponentes = $this->hemocomponentesmodel->orderBy('id', 'ASC')->findAll();
        $this->selectitensprocedhospitativos = $this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();        //$this->selectsalascirurgicasaghu = $this->vwsalascirurgicasmodel->findAll();

    }

    public function index()
    {
        $dados['registros'] = $this->transfusaoModel->findAll();
        return view('transfusao/listar', $dados);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function RequisitarTransfusao()
    {
        //HUAP_Functions::limpa_msgs_flash();

       //dd($data);

       $data = [];
        //$data['listaespera'] = $this->vwlistaesperamodel->Where('prontuario', $prontuario)->findAll();
       $data['listaesperas'] = [];
        $data['listapaciente'] = '0';
        $data['candidatos'] = null;
        $data['ordem'] = null;
        $data['dtcirurgia'] = date('d/m/Y');
        $data['hrcirurgia'] = '';
        $data['tempoprevisto'] = '';
        $data['especialidade'] = null;
        $data['risco'] = '';
        $data['dtrisco'] = '';
        $data['cid'] = '';
        $data['complexidade'] = '';
        $data['fila'] = null;
        $data['origem'] = '';
        $data['unidadeorigem'] = '';
        $data['congelacao'] = '';
        $data['procedimento'] = '';
        $data['proced_adic'] = [];
        $data['lateralidade'] = '';
        $data['posoperatorio'] = null;
        $data['info'] = '';
        $data['nec_proced'] = '';
        $data['sala'] =  '';
        $data['centrocirurgico'] =  '';
        $data['profissional'] = [];
        $data['filas'] = '';
        $data['riscos'] = '';
        $data['origens'] = '';
        $data['lateralidades'] = '';
        $data['posoperatorios'] = '';
        $data['especialidades'] = '';
        $data['cids'] = '';
        $data['procedimentos'] = '';
        $data['especialidades_med'] = '';
        $data['prof_especialidades'] = '';
        $data['procedimentos_adicionais'] = '';
        $data['centros_cirurgicos'] = '';
        $data['salas_cirurgicas'] = '';
        $data['usarEquipamentos'] = '';
        $data['equipamentos'] ='';
        $data['eqpts'] = [];
        $data['usarHomponentes'] = [];
        $data['hemocomponentes'] = '';
        $data['hemocomps'] = [];
        $data['tipo_sanguineo'] = '';
        $data['unidades'] = '';
        $data['hemocomponentes'] = $this->selecthemocomponentes;
        $data['procedimentos'] = $this->selectitensprocedhospitativos;

        $data['listapacienteSelect'] = [];

       return view('layouts/sub_content', ['view' => 'transfusao/form_req_transfusao',
                                           'data' => $data]);

    }

    public function salvar()
    {
        $dados = $this->request->getPost();

        $this->transfusaoModel->save($dados);

        return redirect()->to('/transfusao')->with('success', 'Registro salvo com sucesso!');
    }

    public function editar($id)
    {
        $dados['registro'] = $this->transfusaoModel->find($id);
        return view('transfusao/form', $dados);
    }

    public function excluir($id)
    {
        $this->transfusaoModel->delete($id);
        return redirect()->to('/transfusao')->with('success', 'Registro excluído com sucesso!');
    }
}
