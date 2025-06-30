<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransfusaoModel;
use App\Models\LocalFatItensProcedHospitalarModel;
use App\Models\HemocomponentesModel;
use App\Models\LocalProfEspecialidadesModel;
use App\Models\HistoricoModel;

use DateTime;



class Transfusao extends BaseController
{
    protected $transfusaoModel;

    private $hemocomponentesmodel;
    private $selecthemocomponentes;
    private $selectitensprocedhospitativos;
    private $selectprofespecialidadeaghu;
    private $localfatitensprocedhospitalarmodel;
    private $localprofespecialidadesmodel;
    private $transfusaomodel;
    private $historicomodel;
    private $data;

    public function __construct()
    {
        $this->transfusaoModel = new TransfusaoModel();
        $this->hemocomponentesmodel = new HemocomponentesModel();
        $this->localfatitensprocedhospitalarmodel = new LocalFatItensProcedHospitalarModel();
        $this->localprofespecialidadesmodel = new LocalProfEspecialidadesModel();
        $this->transfusaomodel = new TransfusaoModel();
        $this->historicomodel = new HistoricoModel();
              
        $this->selecthemocomponentes = $this->hemocomponentesmodel->orderBy('id', 'ASC')->findAll();
        $this->selectitensprocedhospitativos = $this->localfatitensprocedhospitalarmodel->Where('ind_situacao', 'A')->orderBy('descricao', 'ASC')->findAll();        //$this->selectsalascirurgicasaghu = $this->vwsalascirurgicasmodel->findAll();
        $this->selectprofespecialidadeaghu = $this->localprofespecialidadesmodel->orderBy('nome', 'ASC')->findAll(); // disable for migration

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
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;

        $data['listapacienteSelect'] = [];

       return view('layouts/sub_content', ['view' => 'transfusao/form_req_transfusao',
                                           'data' => $data]);

    }
    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function AtenderRequisicao()
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
        $data['prof_especialidades'] = $this->selectprofespecialidadeaghu;

        $data['listapacienteSelect'] = [];

       return view('layouts/sub_content', ['view' => 'transfusao/form_atender_req_transfusao',
                                           'data' => $data]);

    }

    public function incluir()
    {
        //ini_set('memory_limit', '1024M');

        \Config\Services::session();

        helper(['form', 'url', 'session']);

        $prontuario = null;

        $this->data = [];

        $this->data = $this->request->getVar();

        dd($this->data);

        $rules = [
            'prontuario' => 'required|min_length[1]|max_length[12]|equals['.$prontuario.']',
            'diagnostico' => 'required|max_length[250]|min_length[3]',
            'indicacao' => 'required|max_length[250]|min_length[3]',
            //'listapaciente' => string (0) ""
            'peso' => 'required',
            'sangramento' => 'required',
            'transfant' => 'required',
            'reacaotransf' => 'required',
            'ch' => 'required|number',
            'cp' => 'required|number',
            'pfc' => 'required|number',
            'crio' => 'required|number',
            'hematocrito' => 'required|number',
            'dt_hematocrito' => 'required|valid_date[d/m/Y]',
            'hemoglobina' => 'required|number',
            'dt_hemoglobina' => 'required|valid_date[d/m/Y]',
            'plaquetas' => 'required|number',
            'dt_plaquetas' => 'required|valid_date[d/m/Y]',
            'tap' => 'required|number',
            'dt_tap' => 'required|valid_date[d/m/Y]',
            'inr' => 'required|number',
            'dt_inr' => 'required|valid_date[d/m/Y]',
            'ptt' => 'required|number',
            'dt_ptt' => 'required|valid_date[d/m/Y]',
            'fibrinogenio' => 'required|number',
            'dt_fibrinogenio' => 'required|valid_date[d/m/Y]',
            'procedimento_filtrado' => 'required|number',
            'justificativa_procedimentos' => 'required|max_length[250]|min_length[3]',
            //'tipo_transfusao' => string (6) "rotina"
            'dt_programada' => 'permit_empty|valid_date[d/m/Y]',
            //'nome_coletor' => string (8) "eeeeeeee"
            'dt_coleta' => 'required|valid_date[d/m/Y]',
            'hr_coleta' => 'required|valid_time[H:i]',
            'profissional' => 'required|number',
            'dt_solicitacao' => 'required|valid_date[d/m/Y]',
            'hr_solicitacao' => 'required|valid_time[H:i]',
            'observacoes' => 'required|max_length[250]|min_length[3]',
        ];

        $dthr_coleta = $this->data['dt_coleta'].' '.$this->data['hr_coleta'];
        $dthr_solicitacao = $this->data['dt_solicitacao'].' '.$this->data['hr_solicitacao'];

        //$this->data['procedimento'] = $this->data['procedimento'] ?? $this->data['procedimento_hidden'];
        $this->data['dthr_coleta'] = DateTime::createFromFormat('Y-m-d H:i:s', $dthr_coleta)->format('d/m/Y H:i');
        $this->data['dthr_solicitacao'] = DateTime::createFromFormat('Y-m-d H:i:s', $dthr_solicitacao)->format('d/m/Y H:i');

        $this->data['idmapacirurgico'] = $this->data['cirurgia'];

        //dd($this->data);

        if ($this->data['cirurgia'] == 0 || is_null($this->data['listapaciente'])) {
        }

        //die(var_dump($this->data));

        if ($this->validate($rules)) {

            $db = \Config\Database::connect('default');

            $this->validator->reset();

            $db->transStart();
    
            try {
                
                $idreq = $this->transfusaomodel->insert($this->data);

                if ($db->transStatus() === false) {
                    $error = $db->error();
                    $errorMessage = !empty($error['message']) ? $error['message'] : 'Erro desconhecido';
                    $errorCode = !empty($error['code']) ? $error['code'] : 0;

                    throw new \CodeIgniter\Database\Exceptions\DatabaseException(
                        sprintf('Erro ao incluir paciente na Fila Cirúrgica [%d] %s', $errorCode, $errorMessage)
                    );
                }

                $db->transComplete();

                session()->setFlashdata('success', 'Requerimento incluído com sucesso!');

                $this->validator->reset();

            } catch (\Throwable $e) {
                $db->transRollback();
                $msg = sprintf('Exception - Falha na requisição - prontuário: %d - cod: (%d) msg: %s', (int) $this->data['prontuario'], (int) $e->getCode(), $e->getMessage());
                log_message('error', 'Exception: ' . $msg);
                session()->setFlashdata('exception', $msg);

                return view('layouts/sub_content', ['view' => 'mapacirurgico/form_req_transfusao',
                                'validation' => $this->validator,
                                'data' => $this->data]);
            }

        }
        session()->setFlashdata('error', $this->validator);

        //dd($this->data);
        return view('layouts/sub_content', ['view' => 'mapacirurgico/form_req_transfusao',
                                            /* 'validation' => $this->validator, */
                                            'data' => $this->data]);
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
