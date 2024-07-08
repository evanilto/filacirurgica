<?php

namespace App\Controllers;

use App\Libraries\HUAP_Functions;
use CodeIgniter\RESTful\ResourceController;

class Aghu extends ResourceController
{
    private $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect('aghux');

    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
    }

    /**
     * Retorna todos os Aghus cadastrados
     *
     * @return mixed
     */
    public function getSetores() {

        $sql = "SELECT seq, descricao FROM  AGH.AGH_UNIDADES_FUNCIONAIS uf WHERE ind_sit_unid_func = 'A'";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna todos os Aghus cadastrados
     *
     * @return mixed
     */
    public function getSetor(string $setor = null) {

        $sql = "SELECT * FROM  AGH.AGH_UNIDADES_FUNCIONAIS uf WHERE upper(descricao) = upper('$setor')";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPaciente(int $prontuario) {

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario = $prontuario";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorCodigo(int $codigo) {

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND codigo = $codigo";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorNome(string $nome) {

        $nome =  strtoupper(HUAP_Functions::remove_accents($nome));

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND nome like '$nome'";

        //var_dump($sql);die();

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorNomeMae(string $nome) {

        $nome =  strtoupper(HUAP_Functions::remove_accents($nome));

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND nome_mae like '$nome'";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getEspecialidades(array $especialidades = null) {
        $sql = "SELECT * FROM agh.agh_especialidades WHERE ind_situacao = 'A'";
    
        if ($especialidades) {
            $placeholders = array_fill(0, count($especialidades), '?');
            $placeholders = implode(',', $placeholders);
    
            $sql .= " AND seq IN ($placeholders) ORDER BY nome_especialidade";
        } else {
            $sql .= " ORDER BY nome_especialidade";
        }
    
        $query = $this->db->query($sql, $especialidades);
    
        $result = $query->getResult();
    
        return $result;
    }
   
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getDetalhesPaciente(int $prontuario) {

        $sql = "
            select
                pac.codigo,
                pac.prontuario,
                pac.nome,
                pac.nome_mae nm_mae,
                pac.email,
                resp.nome nm_resp,
                to_char(pac.dt_nascimento, 'dd/mm/yyyy') dt_nascimento,
                EXTRACT (YEAR FROM AGE(CURRENT_DATE, pac.dt_nascimento)) idade,
                nac.descricao,
                cid.uf_sigla uf,
                case
                when pac.cor = 'B' then 'Branca'
                when pac.cor = 'P' then 'Preta'
                when pac.cor = 'M' then 'Parda'
                when pac.cor = 'A' then 'Amarela'
                when pac.cor = 'I' then 'Indígena'
                when pac.cor = 'O' then 'Sem Declaração'
                end cor,
                case
                when pac.sexo =  'M' then 'Masculino'
                when pac.sexo =  'F' then 'Feminino'
                when pac.sexo =  'I' then 'Ignorado'
                end sexo,
                nac.descricao nacionalidade,
                coalesce('(' || pac.ddd_fone_residencial || ')' || pac.fone_residencial, to_char(pac.fone_residencial, '9999999')) tel_1,
                coalesce('(' || pac.ddd_fone_recado || ')' || pac.fone_recado, pac.fone_recado) tel_2,
                tipolog.descricao || ' ' || lograd.nome logradouro,
                ender.nro_logradouro num_logr,
                ender.compl_logradouro compl_logr,
                bai.descricao bairro,
                cid.nome cidade,
                bcl.CLO_CEP::text cep,
                pac.cpf,
                pac.rg,
                pac.orgao_emis_rg,
                oed.descricao, 
                to_char(pac_dados.data_emissao_docto, 'dd/mm/yyyy') data_emissao_docto, 
                pac_dados.uf_sigla_emitiu_docto, 
                coalesce('CPF ' || REGEXP_REPLACE(pac.cpf::text,'([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})','\\1.\\2.\\3-\\4') || ' ', '') || ' RG ' || pac.rg || ' ' || coalesce(pac.orgao_emis_rg, '') || coalesce(' - ' || pac_dados.uf_sigla_emitiu_docto, '') || coalesce(' Emissão: ' || to_char(pac_dados.data_emissao_docto, 'dd/mm/yyyy'), '') as doc,
                pac.nro_cartao_saude cns,
                pac.id_sistema_legado be
            from agh.aip_pacientes pac
            left join agh.aip_cidades cidade on cidade.codigo = pac.cdd_codigo
            left join agh.aip_nacionalidades nac on nac.codigo = pac.nac_codigo
            left join agh.aip_enderecos_pacientes ender on ender.pac_codigo = pac.codigo
            left join agh.aip_bairros_cep_logradouro bcl on bcl.clo_lgr_codigo = ender.bcl_clo_lgr_codigo and bcl.clo_cep = ender.bcl_clo_cep and bcl.bai_codigo = ender.bcl_bai_codigo
            left join agh.aip_bairros bai on bai.codigo = bcl.bai_codigo
            left join AGH.AIP_LOGRADOUROS lograd on lograd.CODIGO = bcl.CLO_LGR_CODIGO
            left join AGH.AIP_TIPO_LOGRADOUROS tipolog on lograd.TLG_CODIGO=tipolog.CODIGO
            left join agh.aip_cidades cid on cid.CODIGO = lograd.CDD_CODIGO
            left join agh.aip_ufs uf on uf.sigla = cid.uf_sigla
            left join AGH.AGH_RESPONSAVEIS resp on resp.pac_codigo = pac.codigo
            left join AGH.AIP_PACIENTES_DADOS_CNS pac_dados on pac_dados.pac_codigo = pac.codigo
            left join AGH.AIP_orgaos_emissores oed on oed.codigo = pac_dados.oed_codigo where pac.prontuario = ?";

        $query = $this->db->query($sql, [$prontuario]);

        $result = $query->getResult();

        return $result;

    }
}
