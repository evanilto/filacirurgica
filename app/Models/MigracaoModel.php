<?php

namespace App\Models;

use CodeIgniter\Model;

class MigracaoModel extends Model
{
    protected $DBGroup              = 'default';


    ################################################################################
    # ATUALIZAÇÃO DA TABELA, COMPLEMENTO DOS DADOS
    ################################################################################

    /**
    * Atualiza a tabela Prescricao_Medicamento, completando com os dados faltantes da tabela TabPreschuap_Protocolo_Medicamento
    *
    * @return array
    */
    public function update_pm($data)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('Preschuap_Prescricao_Medicamento');

        return $builder->updateBatch($data, 'idPreschuap_Prescricao_Medicamento');

    }

    /**
    * Lista todos os medicamentos cadastrados na tabela TabPreschuap_Protocolo_Medicamento
    *
    * @return array
    */
    public function list_tab_protocolo_medicamento()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                idTabPreschuap_Protocolo_Medicamento
                , idTabPreschuap_Protocolo
                , OrdemInfusao
                , idTabPreschuap_EtapaTerapia
                , idTabPreschuap_Medicamento
                , Dose
                , idTabPreschuap_UnidadeMedida
                , idTabPreschuap_ViaAdministracao
                , idTabPreschuap_Diluente
                , Volume
                , TempoInfusao
                , idTabPreschuap_Posologia
            FROM
                TabPreschuap_Protocolo_Medicamento
            ORDER BY
                idTabPreschuap_Protocolo_Medicamento ASC
        ');
        $q = $q->getResultArray();

        $a = array();
        foreach ($q as $v) {
            #echo $k.' <> '.$v['OrdemInfusao'].'<br /><br />';
            $a[$v['idTabPreschuap_Protocolo_Medicamento']] = $v;
        }

        /*
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        #*/

        return $a;

    }

    /**
    * Lista todos os medicamentos cadastrados na tabela Prescricao_Medicamento
    *
    * @return array
    */
    public function list_prescricao_medicamento()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                *
            FROM
                Preschuap_Prescricao_Medicamento
            ORDER BY
                idPreschuap_Prescricao_Medicamento ASC
        ');

        /*
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        #*/

        return $q->getResultArray();

    }

    ################################################################################
    # CÁLCULO DAS DOSES AJUSTADAS
    ################################################################################

    /**
    * Lista todos os prontuários únicos existentes na aplicação
    *
    * @return array
    */
    public function list_prontuario()
    {

        $db = \Config\Database::connect();

        $q = $db->query('
            SELECT
                Prontuario
            FROM
                Preschuap_Prescricao
            GROUP BY Prontuario
            ORDER BY Prontuario ASC;
        ');
        $q = $q->getResultArray();

        $i=0;
        $r = '(';
        foreach ($q as $v) {
            #echo $k.' <> '.$v['OrdemInfusao'].'<br /><br />';
            $r .= $v['Prontuario'].', ';
            if(($i%100)==0) {
                $r = substr($r, 0, -2);
                $r .= ') <br /> OR Prontuario IN (';
            }
            $i++;
        }
        $r = substr($r, 0, -2);
        $r .= ')';

        return $r;

    }

    /**
    * Captura Idade e Sexo dos prontuários listados
    *
    * @return void
    */
    public function get_aghux($data)
    {

        $db = \Config\Database::connect('aghux');
        $q = $db->query('
            SELECT
                codigo
                , nome
                , to_char(dt_nascimento, \'DD/MM/YYYY\') as dt_nascimento
                , extract(year from age(dt_nascimento)) as idade
                , sexo
                , prontuario
            FROM
                aip_pacientes
            WHERE
                prontuario IN (14002)
 OR Prontuario IN (23450, 32008, 32494, 36850, 43695, 45093, 49127, 58036, 66168, 71440, 72650, 73797, 77822, 80217, 89817, 92980, 94717, 96098, 99104, 108171, 111319, 114050, 116450, 117726, 123096, 127662, 129488, 131998, 134305, 136306, 138311, 138618, 146703, 146720, 150637, 152653, 152836, 165077, 168904, 169920, 172426, 177220, 183372, 187036, 199690, 201141, 202359, 207354, 207359, 208285, 210207, 210218, 213886, 216395, 218687, 220686, 221488, 222717, 229152, 231480, 232988, 233822, 236418, 242652, 246006, 253903, 255810, 258730, 265515, 277741, 278737, 279292, 279378, 280105, 281778, 284401, 288863, 291326, 291443, 292706, 293642, 297252, 300435, 301366, 301885, 309971, 314933, 316272, 316643, 317202, 318807, 323014, 323168, 323391, 325579, 331827, 332792, 340787, 340971, 353134) 
 OR Prontuario IN (358244, 366813, 368213, 369825, 376733, 384996, 388443, 393509, 394415, 396999, 399070, 399082, 406175, 417821, 422636, 427329, 428109, 441837, 451534, 452349, 452554, 452621, 456344, 459108, 460211, 462870, 466825, 469666, 469723, 470823, 479547, 480583, 491565, 492337, 497721, 497937, 501066, 502968, 504056, 506674, 517942, 518139, 518457, 520309, 523759, 525473, 526725, 527391, 528337, 528541, 529014, 529225, 529358, 530496, 535993, 541245, 545388, 547808, 548027, 548239, 552944, 554139, 556670, 558013, 560570, 563189, 566322, 566789, 568958, 571471, 571642, 574408, 575886, 576658, 589287, 597340, 600954, 601020, 601146, 603223, 603700, 604841, 606046, 612056, 615243, 615427, 615833, 628137, 631700, 635353, 636398, 638196, 641598, 641933, 650326, 650437, 652409, 653912, 654292, 656721)
        ');
        $q = $q->getResultArray();

        #/*
        #echo $db->getLastQuery(); prontuario IN (14002, 23450, 32008, 32494, 36850)
        echo "<pre>";
        print_r($q);
        echo "</pre>";
        exit('<hr />oi');
        #*/

        return $q;

    }

}
