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
   public function getCIDs(array $cids = null) {
       $sql = "SELECT * FROM agh.agh_cids WHERE ind_situacao = 'A'";
   
       if ($cids) {
           $placeholders = array_fill(0, count($cids), '?');
           $placeholders = implode(',', $placeholders);
   
           $sql .= " AND codigo IN ($placeholders) ORDER BY descricao";
       } else {
           $sql .= " ORDER BY descricao";
       }
   
       $query = $this->db->query($sql);
   
       $result = $query->getResult();
   
       return $result;
   }
   /**
    * Retorna o prontuario cadastrado no aghu
    *
    * @return mixed
    */
    public function getItensProcedimentosHospitalares(array $itensproc = null) {
        $sql = "SELECT * FROM agh.fat_itens_proced_hospitalar WHERE ind_situacao = 'A' AND ind_internacao = 'S'";
    
        if ($itensproc) {
            $placeholders = array_fill(0, count($itensproc), '?');
            $placeholders = implode(',', $placeholders);
    
            $sql .= " AND cod_tabela IN ($placeholders) ORDER BY descricao";
        } else {
            $sql .= " ORDER BY descricao";
        }
    
        $query = $this->db->query($sql);
    
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
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getProfEspecialidades(array $esp_seq = null) {

        $sql = "
                select 
                pessoas.nome,
                especialidade.seq as esp_seq,
                especialidade.sigla as esp_sigla, 
                especialidade.nome_reduzido as esp_nome_reduzido,
                especialidade.nome_especialidade as esp_nome,
                servidores.pes_codigo,
                servidores.ser_vin_codigo,
                servidores.ser_matricula,
                conselho_profissional.sigla||'-'||qualificacao.nro_reg_conselho as conselho
                from 
                agh.rap_pessoas_fisicas pessoas
                inner join agh.rap_servidores servidores on pessoas.codigo = servidores.pes_codigo
                inner join agh.agh_prof_especialidades as profissional_especialidade on profissional_especialidade.ser_matricula = servidores.matricula and profissional_especialidade.ser_vin_codigo = servidores.vin_codigo
                inner Join agh.agh_especialidades as especialidade on especialidade.seq = profissional_especialidade.esp_seq
                left join agh.rap_pessoa_tipo_informacoes as pessoa_tipo_informacao on pessoa_tipo_informacao.pes_codigo = servidores.pes_codigo
                left Join agh.rap_qualificacoes as qualificacao on qualificacao.pes_codigo = pessoas.codigo
                left Join agh.rap_tipos_qualificacao as tipo_qualificacao on tipo_qualificacao.codigo = qualificacao.tql_codigo
                left Join agh.rap_conselhos_profissionais as conselho_profissional on conselho_profissional.codigo = tipo_qualificacao.cpr_codigo
                where 
                ((servidores.ind_situacao = 'A') or (servidores.ind_situacao = 'P' and (servidores.dt_fim_vinculo isnull or servidores.dt_fim_vinculo >= current_date)))
                AND pessoas.nome NOT like 'AGHU%' 
                AND (profissional_especialidade.ind_atua_internacao = 'S' OR profissional_especialidade.ind_cirurgiao_bloco = 'S') 
                AND qualificacao.nro_reg_conselho is not null
            "; 

        if ($esp_seq) {
            $placeholders = array_fill(0, count($esp_seq), '?');
            $placeholders = implode(',', $placeholders);
    
            $sql .= " AND especialidade.seq IN ($placeholders) ";
        }

        $sql .= " group by 
                    pessoas.nome,
                    especialidade.seq,
                    especialidade.sigla, 
                    especialidade.nome_reduzido,
                    especialidade.nome_especialidade,
                    servidores.pes_codigo,
                    servidores.ser_vin_codigo,
                    servidores.ser_matricula, 
                    conselho_profissional.sigla,
                    qualificacao.nro_reg_conselho
                    order by
                    pessoas.nome asc
                ";
    
        $query = $this->db->query($sql, $esp_seq);
    
        $result = $query->getResult();
    
        return $result;
        
    }
     /**
    * Retorna o prontuario cadastrado no aghu
    *
    * @return mixed
    */
   public function getCentroCirurgico(array $cc = null) {
        $sql = "
                select * 
                from AGH.AGH_UNIDADES_FUNCIONAIS uf
                inner join AGH.AGH_CARACT_UNID_FUNCIONAIS cuf on cuf.unf_seq = uf.seq 
                where uf.ind_sit_unid_func = 'A'
                and cuf.caracteristica = 'Unid Executora Cirurgias'    
            ";

        if ($cc) {
            $placeholders = array_fill(0, count($cc), '?');
            $placeholders = implode(',', $placeholders);

            $sql .= " AND seq IN ($placeholders) ORDER BY descricao";
        } else {
            $sql .= " ORDER BY descricao";
        }

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;
    }
    /**
    * Retorna o prontuario cadastrado no aghu
    *
    * @return mixed
    */
   public function getSalasCirurgicas(array $salas = null) {
        $sql = "
                select 
                seqp AS seq,
                *
                from AGH.mbc_sala_cirurgicas MSC
                where MSC.situacao = 'A'
              ";

        if ($salas) {
            $placeholders = array_fill(0, count($salas), '?');
            $placeholders = implode(',', $placeholders);

            $sql .= " AND seqp IN ($placeholders) ORDER BY descricao";
        } else {
            $sql .= " ORDER BY nome";
        }

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;
    }

}
